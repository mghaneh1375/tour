<?php

namespace App\Http\Controllers\LocalShop;

use App\Http\Requests\StoreLocalShopInfos;
use App\models\Activity;
use App\models\BookMark;
use App\models\localShops\LocalShopFeatures;
use App\models\localShops\LocalShops;
use App\models\localShops\LocalShopsCategory;
use App\models\localShops\LocalShopsPictures;
use App\models\localShops\LocalShopsUserAction;
use App\models\LogModel;
use App\models\places\Place;
use App\models\places\PlaceTag;
use App\models\Reviews\ReviewPic;
use App\models\Reviews\ReviewUserAssigned;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Flysystem\Adapter\Local;

class LocalShopController extends Controller
{
    public function showLocalShops($id = 0){
        $localShop = LocalShops::find($id);
        if($localShop == null)
            dd('not found');

        $localShop->user = User::select(['id', 'username'])->find($localShop->userId);
        $localShop->ownerPic = getUserPic($localShop->user != null ? $localShop->user->id : 0);
        $localShop->ownerUsername = $localShop->user != null ? $localShop->user->username : '';

        $localShop->telephone = explode('-', $localShop->phone);
        $localShop->pics = $localShop->getPictures();
        $localShop->mainPic = $localShop->getMainPicture();
        if($localShop->description == '')
            $localShop->description = null;


        $localShop->tags = PlaceTag::join('tag', 'tag.id', 'placeTags.tagId')
                                ->where('placeTags.kindPlaceId', 13)
                                ->where('placeTags.placeId', $localShop->id)
                                ->pluck('tag.name')->toArray();

        $codeForReview = null;
        $localShop->bookMark = 0;
        if(auth()->check()) {
            $user = auth()->user();
            $localShop->iAmHere = LocalShopsUserAction::where(['localShopId' => $localShop->id, 'userId' => $user->id, 'iAmHere' => 1])->count();
            $codeForReview = $user->id . '_' . random_int(100000, 999999);
            $localShop->bookMark = BookMark::join('bookMarkReferences', 'bookMarkReferences.id', 'bookMarks.bookMarkReferenceId')
                ->where('bookMarkReferences.tableName', 'localShops')
                ->where('bookMarks.referenceId', $localShop->id)
                ->where('bookMarks.userId', $user->id)->count();
        }

        $localShop->features = LocalShopFeatures::where('categoryId', $localShop->categoryId)->where('parentId', 0)->get();
        foreach($localShop->features as $feat){
            $feat->subs = LocalShopFeatures::join('local_shop_features_relations', 'local_shop_features_relations.featureId', 'local_shop_features.id')
                            ->where('local_shop_features.parentId', $feat->id)
                            ->where('local_shop_features_relations.localShopId', $localShop->id)
                            ->select(['local_shop_features.*'])
                            ->get();
        }

        return view('pages.localShops.showLocalShops', compact(['localShop', 'codeForReview']));
    }

    public function getFeatures(){
        $id = $_GET['id'];
        $features = LocalShopFeatures::where('categoryId', $id)->where('parentId', 0)->get();
        foreach ($features as $item)
            $item->sub = LocalShopFeatures::where('parentId', $item->id)->get();

        return response()->json(['status' => 'ok', 'result' => $features]);
    }

    public function addImAmHereLocalShop(Request $request)
    {
        $localShopId = $request->localShopId;
        if($localShopId != null){
            $localShop = LocalShops::find($localShopId);
            if($localShop != null){
                $user = auth()->user();
                $iAmHere = LocalShopsUserAction::where(['localShopId' => $localShop->id, 'userId' => $user->id])->first();
                if($iAmHere == null){
                    $iAmHere = new LocalShopsUserAction();
                    $iAmHere->localShopId = $localShop->id;
                    $iAmHere->userId = $user->id;
                    $iAmHere->iAmHere = 1;
                }
                else
                    $iAmHere->iAmHere = $iAmHere->iAmHere == 1 ? 0 : 1;

                $iAmHere->save();
                return response()->json(['status' => 'ok', 'result' => $iAmHere->iAmHere]);
            }
            else
                return response()->json(['status' => 'error1']);
        }
        else
            return response()->json(['status' => 'error']);
    }
}
