<?php

namespace App\Http\Controllers;

use App\models\Activity;
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
        return view('pages.placeList.myLocation');
    }

    public function getPlacesWithLocation()
    {
        // Latitude: 1 deg = 110.574 km
        // Longitude: 1 deg = 111.320*cos(latitude) km
        $places = [];
        $lat = (float)$_GET['lat'];
        $lng = (float)$_GET['lng'];

        $radius = 2;
        $latDeg = $radius/110.574;
        $lngDeg = $radius/(111.320*cos(deg2rad($lat)));

        $latBetween = [$lat+$latDeg, $lat-$latDeg];
        $lngBetween = [$lng+$lngDeg, $lng-$lngDeg];
        $kindPlaceIds = [1, 3, 4, 6, 12, 13];

        foreach ($kindPlaceIds as $kId){
            $kindPlace = Place::find($kId);
            if($kindPlace != null) {
                if($kindPlace->id == 13)
                    $DBPlace = DB::select("SELECT `id`, `name`, `reviewCount`, `fullRate`, `slug`, `cityId`, `lat`, `lng` FROM ".$kindPlace->tableName." WHERE `lat` > ".$latBetween[1]." AND `lat` < ".$latBetween[0]." AND `lng` > ".$lngBetween[1]." AND `lng` < ".$lngBetween[0]);
                else
                    $DBPlace = DB::select("SELECT `id`, `name`, `reviewCount`, `fullRate`, `slug`, `cityId`, `C`, `D` FROM ".$kindPlace->tableName." WHERE `C` > ".$latBetween[1]." AND `C` < ".$latBetween[0]." AND `D` > ".$lngBetween[1]." AND `D` < ".$lngBetween[0] );

                foreach ($DBPlace as $place) {
                    $place->kindPlaceId = $kindPlace->id;
                    $place->pic = getPlacePic($place->id, $kindPlace->id);
                    $place->review = $place->reviewCount;
                    $place->rate = floor($place->fullRate);
                    $place->url =  createUrl($kindPlace->id, $place->id, 0, 0, 0);
                    if($kindPlace->id == 13) {
                        $place->C = $place->lat;
                        $place->D = $place->lng;
                    }
                    $place->distance = distanceBetweenCoordination($lat, $lng, $place->C, $place->D);

                    if($kindPlace->id == 6)
                        $place->address = DB::table($kindPlace->tableName)->find($place->id)->dastresi;
                    else
                        $place->address = DB::table($kindPlace->tableName)->find($place->id)->address;

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

        return response()->json(['status' => 'ok', 'result' => $places]);
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
            $item->pic = URL::asset('_images/sliderPic/' . $item->pic);
            if($item->backgroundPic != null)
                $item->backgroundPic = URL::asset('_images/sliderPic/' . $item->backgroundPic);
        }

        $middleBan = [];

        $middleBan1 = BannerPics::where('page', 'mainPage')->where('section', 1)->get();
        foreach ($middleBan1 as $item){
            $item->pic = URL::asset('_images/bannerPic/' . $item->page . '/' . $item->pic);
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

    public function getTrip()
    {
//        $user = Auth::user();
//        $trips = [];
//
//        function convertStringToDate2($date) {
//            if($date == "")
//                return $date;
//            return $date[0] . $date[1] . $date[2] . $date[3] . '/' . $date[4] . $date[5] . '/' . $date[6] . $date[7];
//        }
//
//        if(Auth::check()) {
//
//            $uId = Auth::user()->id;
//            $trips = Trip::where('uId',$uId)->get();
//
//            $condition = ['uId' => $uId, 'status' => 1];
//            $invitedTrips = TripMember::where($condition)->select('tripId')->get();
//
//            foreach ($invitedTrips as $invitedTrip) {
//                $trips[count($trips)] = Trip::find($invitedTrip->tripId);
//            }
//
//            if($trips != null && count($trips) != 0) {
//                foreach ($trips as $trip) {
//                    $trip->placeCount = TripPlace::where('tripId',$trip->id)->count();
//                    $limit = ($trip->placeCount > 4) ? 4 : $trip->placeCount;
//                    $tripPlaces = TripPlace::where('tripId',$trip->id)->take($limit)->get();
//                    if($trip->placeCount > 0) {
//                        $kindPlaceId = $tripPlaces[0]->kindPlaceId;
//                        switch ($kindPlaceId) {
//                            case 1:
//                                $amaken = Amaken::whereId($tripPlaces[0]->placeId);
//                                try{
//                                    if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
//                                        $trip->pic1 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 3:
//                                $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
//                                        $trip->pic1 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 4:
//                                $hotel = Hotel::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
//                                        $trip->pic1 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 6:
//                                $majara = Majara::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
//                                        $trip->pic1 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 8:
//                                $adab = Adab::whereId($tripPlaces[0]->placeId);
//                                if($adab->category == 3) {
//                                    try {
//                                        if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
//                                            $trip->pic1 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
//                                    }
//                                    catch (Exception $x) {
//                                        $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
//                                    }
//                                }
//                                else {
//                                    try{
//                                        if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
//                                            $trip->pic1 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
//                                    }
//                                    catch (Exception $x) {
//                                        $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
//                                    }
//                                }
//                                break;
//                        }
//                    }
//                    if($trip->placeCount > 1) {
//                        $kindPlaceId = $tripPlaces[1]->kindPlaceId;
//                        switch ($kindPlaceId) {
//                            case 1:
//                                $amaken = Amaken::whereId($tripPlaces[0]->placeId);
//                                try{
//                                    if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
//                                        $trip->pic2 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 3:
//                                $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
//                                        $trip->pic2 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 4:
//                                $hotel = Hotel::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
//                                        $trip->pic2 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 6:
//                                $majara = Majara::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
//                                        $trip->pic2 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 8:
//                                $adab = Adab::whereId($tripPlaces[0]->placeId);
//                                if($adab->category == 3) {
//                                    try {
//                                        if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
//                                            $trip->pic2 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
//                                    }
//                                    catch (Exception $x) {
//                                        $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
//                                    }
//                                }
//                                else {
//                                    try{
//                                        if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
//                                            $trip->pic2 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
//                                    }
//                                    catch (Exception $x) {
//                                        $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
//                                    }
//                                }
//                                break;
//                        }
//                    }
//                    if($trip->placeCount > 2) {
//                        $kindPlaceId = $tripPlaces[2]->kindPlaceId;
//                        switch ($kindPlaceId) {
//                            case 1:
//                                $amaken = Amaken::whereId($tripPlaces[0]->placeId);
//                                try{
//                                    if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
//                                        $trip->pic3 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 3:
//                                $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
//                                        $trip->pic3 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 4:
//                                $hotel = Hotel::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
//                                        $trip->pic3 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 6:
//                                $majara = Majara::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
//                                        $trip->pic3 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 8:
//                                $adab = Adab::whereId($tripPlaces[0]->placeId);
//                                if($adab->category == 3) {
//                                    try {
//                                        if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
//                                            $trip->pic3 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
//                                    }
//                                    catch (Exception $x) {
//                                        $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
//                                    }
//                                }
//                                else {
//                                    try{
//                                        if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
//                                            $trip->pic3 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
//                                    }
//                                    catch (Exception $x) {
//                                        $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
//                                    }
//                                }
//                                break;
//                        }
//                    }
//                    if($trip->placeCount > 3) {
//                        $kindPlaceId = $tripPlaces[3]->kindPlaceId;
//                        switch ($kindPlaceId) {
//                            case 1:
//                                $amaken = Amaken::whereId($tripPlaces[0]->placeId);
//                                try{
//                                    if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
//                                        $trip->pic4 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 3:
//                                $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
//                                        $trip->pic4 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 4:
//                                $hotel = Hotel::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
//                                        $trip->pic4 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                            case 6:
//                                $majara = Majara::whereId($tripPlaces[0]->placeId);
//                                try {
//                                    if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
//                                        $trip->pic4 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
//                                }
//                                catch (Exception $x) {
//                                    $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
//                                }
//                                break;
//                        }
//                    }
//                }
//            }
//        }
    }

    public function seenLogExport($num)
    {
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
}
