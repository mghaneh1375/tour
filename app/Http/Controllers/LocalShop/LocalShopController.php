<?php

namespace App\Http\Controllers\LocalShop;

use App\Http\Requests\StoreLocalShopInfos;
use App\models\Activity;
use App\models\BookMark;
use App\models\Cities;
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
use Illuminate\Support\Facades\DB;
use League\Flysystem\Adapter\Local;

class LocalShopController extends Controller
{
    public function showLocalShops($id = 0){
        $localShop = LocalShops::find($id);
        if($localShop == null)
            abort(404);

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
        $stateAndCity = Cities::join('state', 'state.id', 'cities.stateId')->where('cities.id', $localShop->cityId)
                            ->select(['cities.id AS cityId', 'state.id AS stateId', 'state.name AS stateName', 'cities.name AS cityName', 'state.isCountry AS isCountry'])->first();

        $locationName = ['name' => $localShop->name, 'state' => $stateAndCity->stateName, 'stateNameUrl' => $stateAndCity->stateName,
                        'stateIsCountry' => $stateAndCity->isCountry, 'articleUrl' => '#',
                        'cityName' => $stateAndCity->cityName, 'cityNameUrl' => $stateAndCity->cityName,
                        'kindState' => 'city', 'kindPage' => 'place'];

        $localShop->category = LocalShopsCategory::find($localShop->categoryId);

        return view('pages.localShops.showLocalShops', compact(['localShop', 'codeForReview', 'locationName']));
    }

    public function getNears($id)
    {
        $cities = [];
        $localShop = LocalShops::find($id);
        if($localShop != null){


            $mainLat = $localShop->lat;
            $mainLng = $localShop->lng;

            $lat = (float)$mainLat * 3.14 / 180;
            $lng = (float)$mainLng * 3.14 / 180;
            $radius = 2;

            $places = [];
            $kindPlaces = Place::whereIn('id', [1, 3, 4, 6, 12, 13])->get();

            foreach ($kindPlaces as $kindPlace){
                if($kindPlace != null) {
                    if($kindPlace->id == 13){
                        $latRow = 'lat';
                        $lngRow = 'lng';
                        $selectRows = '`id`, `name`, `reviewCount`, `fullRate`, `slug`, `cityId`, `lat`, `lng`, `categoryId`, `address` AS address';
                        $onlyOnMapCategories = LocalShopsCategory::where('onlyOnMap', 1)->pluck('id')->toArray();
                        $allLocalShopCategoryIcons = [];
                        $ai = LocalShopsCategory::select(['icon', 'id', 'server', 'mapIcon'])->get()->groupBy('id')->toArray();
                        foreach($ai as $index => $cat)
                            $allLocalShopCategoryIcons[$index] = $cat[0];
                    }
                    else{
                        $latRow = 'C';
                        $lngRow = 'D';
                        $address = $kindPlace->id == 6 ? 'dastresi' : 'address';
                        $selectRows = "`id`, `name`, `reviewCount`, `fullRate`, `slug`, `cityId`, `C`, `D`, `{$address}` AS address";
                    }

                    $formula = "(acos(" . sin($lng) . " * sin({$lngRow} / 180 * 3.14) + " . cos($lng) . " * cos({$lngRow} / 180 * 3.14) * cos(({$latRow} / 180 * 3.14) - {$lat})) * 6371) as distance";
                    $DBPlace = DB::select("SELECT {$formula}, {$selectRows} FROM {$kindPlace->tableName} HAVING distance <= {$radius} OR (`{$latRow}` = {$mainLat} AND `{$lngRow}` = {$mainLng}) order by distance ASC");

                    foreach ($DBPlace as $place) {
                        if(isset($cities[$place->cityId])){
                            $place->city = $cities[$place->cityId]->cityName;
                            $place->state = $cities[$place->cityId]->stateName;
                        }
                        else{
                            $cit = Cities::join('state', 'state.id', 'cities.stateId')->where('cities.id', $place->cityId)->select(['cities.name AS cityName', 'state.name AS stateName'])->first();
                            if($cit != null) {
                                $cities[$place->cityId] = $cit;
                                $place->city = $cities[$place->cityId]->cityName;
                                $place->state = $cities[$place->cityId]->stateName;
                            }
                        }
                        $place->kindPlaceId = $kindPlace->id;
                        $place->review = $place->reviewCount;
                        $place->rate = floor($place->fullRate);
                        $place->url =  createUrl($kindPlace->id, $place->id, 0, 0, 0);
                        if($kindPlace->id == 13) {
                            $place->C = $place->lat;
                            $place->D = $place->lng;
                            if(in_array($place->categoryId, $onlyOnMapCategories)) {
                                $place->onlyOnMap = 1;
                                $place->pic = URL::asset("_images/localShops/mapIcon/big-{$allLocalShopCategoryIcons[$place->categoryId]['mapIcon']}", null, $allLocalShopCategoryIcons[$place->categoryId]['server']);
                                $place->minPic = URL::asset("_images/localShops/mapIcon/small-{$allLocalShopCategoryIcons[$place->categoryId]['mapIcon']}", null, $allLocalShopCategoryIcons[$place->categoryId]['server']);
                            }
                            else{
                                $placeMainPic = getPlacePic($place->id, $kindPlace->id, ['f', 't']);
                                $place->pic = $placeMainPic[0];
                                $place->minPic = $placeMainPic[1];
                            }
                        }
                        else {
                            $placeMainPic = getPlacePic($place->id, $kindPlace->id, ['f', 't']);
                            $place->pic = $placeMainPic[0];
                            $place->minPic = $placeMainPic[1];
                        }

                        array_push($places, $place);
                    }
                }
            }

            return response()->json(['status' => 'ok', 'result' => $places]);
        }
        else
            return response()->json(['status' => 'error1']);
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
