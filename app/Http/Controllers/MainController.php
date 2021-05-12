<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\CityPic;
use App\models\localShops\LocalShopsCategory;
use App\models\places\Amaken;
use App\models\BannerPics;
use App\models\places\Boomgardy;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\logs\UserSeenLog;
use App\models\places\MahaliFood;
use App\models\MainSliderPic;
use App\models\places\Place;
use App\models\places\Restaurant;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\safarnameh\SafarnamehComments;
use App\models\SectionPage;
use App\models\places\SogatSanaie;
use App\models\State;
use App\models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MainController extends Controller
{
    public function myLocation()
    {
        $selected = [];
        if(isset($_GET['place']) && isset($_GET['kindPlace'])) {
            $kindPlace = Place::where('tableName', $_GET['kindPlace'])->first();
            $place = \DB::table($_GET['kindPlace'])->find($_GET['place']);

            if($place != null) {
                if($kindPlace->id == 13)
                    $selected = ['lat' => $place->lat, 'lng' => $place->lng, 'name' => $place->name, 'id' => $place->id, 'kindPlaceId' => $kindPlace->id];
                else
                    $selected = ['lat' => $place->C, 'lng' => $place->D, 'name' => $place->name, 'id' => $place->id, 'kindPlaceId' => $kindPlace->id];
            }
        }

        $localShopCategories = LocalShopsCategory::where('parentId', 0)->get();
        foreach ($localShopCategories as $category)
            $category->sub = LocalShopsCategory::where('parentId', $category->id)->get();


        $allLocalShopCategoryIcons = [];
        $ai = LocalShopsCategory::select(['icon', 'id'])->get()->groupBy('id')->toArray();
        foreach($ai as $index => $cat)
            $allLocalShopCategoryIcons[$index] = $cat[0]['icon'];

        return view('pages.placeList.myLocation', compact(['localShopCategories', 'allLocalShopCategoryIcons']))->with(['selectedPlaceName' => $selected]);
    }

    public function getPlacesWithLocation()
    {
        // Latitude: 1 deg = 110.574 km
        // Longitude: 1 deg = 111.320*cos(latitude) km
        $selectPlace = null;
        $places = [];
        $mainLat = $_GET['lat'];
        $mainLng = $_GET['lng'];
        $lat = (float)$_GET['lat'] * 3.14 / 180;
        $lng = (float)$_GET['lng'] * 3.14 / 180;
        $radius = (float)$_GET['radius'];

        $radius = ($radius == 0 ? 2 : $radius) + 1;

        if(isset($_GET['specific'])){
            $specificData = $_GET['specific'];
            $specificData = explode('_', $specificData);
            if($specificData[0] != 0 && $specificData[1] != 0) {
                $selectKindPlace = Place::find($specificData[0]);
                if($selectKindPlace != null){
                    $selectRows = "`id`, `name`, `reviewCount` AS `review`, `fullRate`, `slug`, `cityId`";
                    if($selectKindPlace->id == 13){
                        $selectRows .= ", `lat`, `lng`, `categoryId`, `address` AS address";
                    }
                    else{
                        $address = $selectKindPlace->id == 6 ? 'dastresi' : 'address';
                        $selectRows .= ", `C`, `D`, `{$address}` AS address";
                    }

                    $selectPlace = \DB::table($selectKindPlace->tableName)->selectRaw($selectRows)->find($specificData[1]);
                    if($selectPlace != null){

                        $selectPlace->kindPlaceId = $selectKindPlace->id;
                        $selectPlace->rate = floor($selectPlace->fullRate);
                        $selectPlace->pic = getPlacePic($selectPlace->id, $selectKindPlace->id);
                        $selectPlace->minPic = getPlacePic($selectPlace->id, $selectKindPlace->id, 't');
                        $selectPlace->url =  createUrl($selectKindPlace->id, $selectPlace->id, 0, 0, 0);
                        if($selectKindPlace->id == 13) {
                            $selectPlace->C = $selectPlace->lat;
                            $selectPlace->D = $selectPlace->lng;
                        }

                    }
                }
            }
        }


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

        for ($i = 0; $i < count($places); $i++){
            for ($j = $i+1; $j < count($places); $j++){
                if($places[$i]->distance > $places[$j]->distance){
                    $dd = $places[$i];
                    $places[$i] = $places[$j];
                    $places[$j] = $dd;
                }
            }
        }

        return response()->json(['status' => 'ok', 'result' => $places, 'selectPlace' => $selectPlace]);
    }

    public function landingPage()
    {
        return view('landing.landingPage');
    }

    public function showMainPage($mode = "mainPage") {

        $kindPlaceId= 0;
//        $articleBannerId = DB::table('bannerPosts')->pluck('postId')->toArray();
//        $articleBanner = Safarnameh::whereIn('id', $articleBannerId)->get();
//        foreach ($articleBanner as $item){
//            $item->url = route('safarnameh.show', ['id' => $item->id]);
//            $item->pic = \URL::asset('_images/posts/' . $item->id . '/' . $item->pic);
//        }

        $sliderPic = MainSliderPic::all();
        foreach ($sliderPic as $item) {
            $item->pic = URL::asset("_images/sliderPic/{$item->pic}");
            if($item->backgroundPic != null)
                $item->backgroundPic = URL::asset("_images/sliderPic/{$item->backgroundPic}");
        }

        $middleBan = [];

        $middleBan1 = BannerPics::where('page', 'mainPage')->where('section', 1)->get();
        foreach ($middleBan1 as $item){
            $item->pic = URL::asset("_images/bannerPic/{$item->page}/{$item->pic}");
            if($item->text == null)
                $item->text = '';
            if($item->link == 'https://')
                $item->link = '';
        }
        $middleBan['1']  = $middleBan1;

        $middleBan2 = BannerPics::where('page', 'mainPage')->where('section', 2)->first();
        if($middleBan2 != null) {
            $middleBan2->pic = URL::asset('_images/bannerPic/' . $middleBan2->page . '/' . $middleBan2->pic);
            if ($middleBan2->text == null)
                $middleBan2->text = '';
            if ($middleBan2->link == 'https://')
                $middleBan2->link = '';
        }
        $middleBan['2'] = $middleBan2;

        $middleBan4 = BannerPics::where('page', 'mainPage')->where('section', 4)->get();
        foreach ($middleBan4 as $item){
            $item->pic = URL::asset('_images/bannerPic/' . $item->page . '/' . $item->pic);
            if($item->text == null)
                $item->text = '';
            if($item->link == 'https://')
                $item->link = '';
        }
        $middleBan['4']  = $middleBan4;

        $middleBan5 = BannerPics::where('page', 'mainPage')->where('section', 5)->get();
        foreach ($middleBan5 as $item){
            $item->pic = URL::asset('_images/bannerPic/' . $item->page . '/' . $item->pic);
            if($item->text == null)
                $item->text = '';
            if($item->link == 'https://')
                $item->link = '';
        }
        $middleBan['5']  = $middleBan5;

        $middleBan6 = BannerPics::where('page', 'mainPage')->where('section', 6)->first();
        if($middleBan6 != null){
            $middleBan6->pic = URL::asset('_images/bannerPic/' . $middleBan6->page . '/' . $middleBan6->pic);
            if($middleBan6->text == null)
                $middleBan6->text = '';
            if($middleBan6->link == 'https://')
                $middleBan6->link = '';
        }
        $middleBan['6']  = $middleBan6;

        return view('pages.main', ['placeMode' => $mode, 'kindPlaceId' => $kindPlaceId,
                                    'sliderPic' => $sliderPic,
                                    'middleBan' => $middleBan,
//                                    'sections' => SectionPage::wherePage(getValueInfo('hotel-detail'))->get(),
//                                    'articleBanner' => $articleBanner,
                                     ]);
    }

    public function exampleExportCode($num)
    {
        dd('bakkkkkk');
        if($num == 1)
            $log = UserSeenLog::where('relatedId', 0)
                                ->where('url', '/placeList/1/country')
                                ->whereBetween('created_at', ['2020-10-29 00:00:00.000000', '2020-10-29 02:00:00.000000'])
                                ->get();
        else
            $log = UserSeenLog::where('relatedId', 0)
                                ->where('seenTime', 0)
                                ->where('url', '/placeList/1/country')
                                ->whereBetween('created_at', ['2020-10-29 00:00:00.000000', '2020-10-29 02:00:00.000000'])
                                ->get();

        $rowNum = 2;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1','user_code');
        $sheet->setCellValue('B1', 'in_page_time');
        $sheet->setCellValue('C1', 'enter_time');

        foreach ($log as $key => $item){
            $sheet->setCellValue('A'.$rowNum, $item->userCode);
            $sheet->setCellValue('B'.$rowNum, $item->seenTime);
            $sheet->setCellValue('C'.$rowNum, $item->created_at);
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('seenLogExport.xlsx');

        dd('finniish');
    }

    public function whereCityIsFullyNull()
    {
        $acceptedCity = [];
        $cities = Cities::where('isVillage', 0)->get();
        $kindPlaces = Place::whereNotNull('tableName')->get();
        foreach ($cities as $city){
            $count = 0;
            foreach ($kindPlaces as $kindPlace)
                $count += \DB::table($kindPlace->tableName)->where('cityId', $city->id)->count();

            $count += SafarnamehCityRelations::where('cityId', $city->id)->count();

            if($count > 0){
                $city->stateName = $city->getState->name;
                array_push($acceptedCity, $city);
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1','نام شهر');
        $sheet->setCellValue('B1', 'نام استان');

        $rowNum = 2;
        foreach($acceptedCity as $city){
            $sheet->setCellValue('A'.$rowNum, $city->name);
            $sheet->setCellValue('B'.$rowNum, $city->stateName);
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('citiesPlaceCount.xlsx');

        dd('finniish');
    }

    public function exportDistanceFromCityCenter(){
        $folderName = [];
        $kindPlaces = Place::whereIn('id', [1, 3, 4, 6, 12, 13])->get();
        foreach($kindPlaces as $kindPlace){

            if($kindPlace->id == 13){
                $latRow = 'lat';
                $lngRow = 'lng';
                $selectRows = 'placeTable.name AS placeName, placeTable.lat AS placeLat, placeTable.lng AS placeLng, cityTable.name AS cityName, cityTable.x AS cityLat, cityTable.y AS cityLng';
            }
            else{
                $latRow = 'C';
                $lngRow = 'D';
                $selectRows = "placeTable.name AS placeName, placeTable.C AS placeLat, placeTable.D AS placeLng, cityTable.name AS cityName, cityTable.x AS cityLat, cityTable.y AS cityLng";
            }

            $formula = "(acos(sin(cityTable.y *3.14/180) * sin({$lngRow} / 180 * 3.14) + cos(cityTable.y * 3.14 / 180) * cos({$lngRow} / 180 * 3.14) * cos(({$latRow} / 180 * 3.14) - (cityTable.x * 3.14 / 180))) * 6371) as distance";
            $DBPlace = DB::select("SELECT {$formula}, {$selectRows} FROM {$kindPlace->tableName} AS `placeTable`, cities as `cityTable` WHERE placeTable.cityId = cityTable.id order by distance DESC ");


            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1','نام مکان');
            $sheet->setCellValue('B1', 'نام شهر');
            $sheet->setCellValue('C1', 'فاصله');

            $rowNum = 2;
            foreach($DBPlace as $place){
                $sheet->setCellValue('A'.$rowNum, $place->placeName);
                $sheet->setCellValue('B'.$rowNum, $place->cityName);
                $sheet->setCellValue('C'.$rowNum, $place->distance);
                $rowNum++;
            }

            $writer = new Xlsx($spreadsheet);
            $file = "exportExecls/placeDistance_{$kindPlace->tableName}.xlsx";
            array_push($folderName, $file);
            $writer->save($file);
        }

        foreach ($folderName as $file){
            $url = URL::asset($file);
            echo "<a href='{$url}'>{$file}</a>";
            echo "<br>";
        }

    }

}
