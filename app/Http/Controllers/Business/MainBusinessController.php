<?php

namespace App\Http\Controllers\Business;

use App\models\localShops\LocalShops;
use App\models\places\Restaurant;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainBusinessController extends Controller
{
    public function showBusiness($id = 0)
    {

        $localShop = LocalShops::find($id);
        if($localShop == null)
            dd('not found');

        $localShop->user = User::select(['id', 'username'])->find($localShop->userId);
        $localShop->user->userPic = getUserPic($localShop->user->id);

        $localShop->review = $localShop->getReviews();
        $localShop->pics = $localShop->getPictures();
        $localShop->telephone = explode('-', $localShop->phone);
        $localShop->mainPic = $localShop->getMainPicture();
        if($localShop->description == '')
            $localShop->description = null;

        if(auth()->check())
            $codeForReview = auth()->user()->id.'_'.random_int(100000, 999999);
        else
            $codeForReview = null;

        return view('pages.Business.showBusiness', compact(['localShop', 'codeForReview']));
    }
}
