<?php

namespace App\Http\Controllers\Business;

use App\models\BookMark;
use App\models\localShops\LocalShops;
use App\models\places\Restaurant;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainBusinessController extends Controller
{
    public function showBusiness($id = 0){
        $localShop = LocalShops::find($id);
        if($localShop == null)
            dd('not found');

        $localShop->user = User::select(['id', 'username'])->find($localShop->userId);
        $localShop->ownerPic = getUserPic($localShop->user != null ? $localShop->user->id : 0);
        $localShop->ownerUsername = $localShop->user != null ? $localShop->user->username : '';

        $localShop->pics = $localShop->getPictures();
        $localShop->review = $localShop->getReviews();
        $localShop->telephone = explode('-', $localShop->phone);
        $localShop->mainPic = $localShop->getMainPicture();
        if($localShop->description == '')
            $localShop->description = null;


        $codeForReview = null;
        $localShop->bookMark = 0;
        if(auth()->check()) {
            $user = auth()->user();
            $codeForReview = $user->id . '_' . random_int(100000, 999999);
            $localShop->bookMark = BookMark::join('bookMarkReferences', 'bookMarkReferences.id', 'bookMarks.bookMarkReferenceId')
                                            ->where('bookMarkReferences.tableName', 'localShops')
                                            ->where('bookMarks.referenceId', $localShop->id)
                                            ->where('bookMarks.userId', $user->id)->count();
        }

        return view('pages.Business.showBusiness', compact(['localShop', 'codeForReview']));
    }
}
