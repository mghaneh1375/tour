<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\CountryCode;
use App\models\places\Hotel;
use App\models\places\HotelApi;
use App\models\places\HotelPassengerInfo;
use App\models\LogModel;
use App\models\NoticesHotel;
use App\models\places\Place;
use App\models\saveApiInfo;
use App\models\State;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HotelReservationController extends Controller {

    public function getHotelListElems($city, $mode, $kind = "")
    {
        if (isset($_POST["pageNum"]))
            $currPage = makeValidInput($_POST["pageNum"]);
        else {
            echo \GuzzleHttp\json_encode([]);
            return;
        }

        if ($kind == 'reserve') {

            $sort = "price";
            if (isset($_POST["sort"]))
                $sort = makeValidInput($_POST["sort"]);

            $z = "1 = 1 ";
            $r = 'avgRate > 0';
            $kindId = array();

            if (isset($_POST["kind_id"])) {
                $name = $_POST["kind_id"];

                $y = count($name);
                $allow = false;

                $x = "and ( ";

                for($i = 0; $i < $y; $i++){
                    if ($name[$i] == -1) {
                        $kindId = [1,2,3,4,5,6,7,8];
                        $allow = true;
                        break;
                    }
                    elseif($name[$i] > 0){
                        array_push($kindId, $name[$i]);
                        $x .= 'kind_id = ' . $name[$i] .' OR ';
                    }
                }
                if(!$allow){
                    $x .= 'kind_id = 0 )';
                    $z .= $x;
                }
            }

            if(isset($_POST['rate']) && $_POST['rate'] != 0) {
                switch ($_POST['rate']) {
                    case 1:
                        $r = ' avgRate >= 1';
                        break;
                    case 2:
                        $r = ' avgRate >= 2';
                        break;
                    case 3:
                        $r = ' avgRate >= 3';
                        break;
                    case 4:
                        $r = ' avgRate >= 4';
                        break;
                    case 5:
                        $r = ' avgRate >= 5';
                        break;
                }

//                while ($i < $y) {
//                    $t = makeValidInput($name[$i]);
//                    if ($t == -1)
//                        $allow = true;
//                    if (!$allow)
//                        $x .= '`kind_id` = ' . $t . ' OR ';
//                    $i++;
//                }
//                $n = strlen($x);
//                if ($n > 5 && !$allow)
//                    $z .= substr($x, 0, $n - 4) . ') ';
            }

            $z .= " and ";
            if (isset($_POST['color'])) {
                $condition = array();
                $name = $_POST['color'];
                $i = 0;
                $y = count($name);
                $x = "";
                while ($i < $y) {
                    $t = makeValidInput($name[$i]);
                    $x = $x . '`' . $t . '`=1 AND ';

                    if(($t != 1 || $t != '1')) {
                        $array = array($name[$i] => 1);
                        $condition = array_merge($condition, $array);
                    }
                    $i++;
                }

                $n = strlen($x);
                $z .= substr($x, 0, $n - 4);
                $z .= ' and ';
            }

            $activityId = Activity::whereName('نظر')->first()->id;
            $kindPlaceId = Place::whereName('هتل')->first()->id;
            $placeName = '';

            if ($mode == "city") {
                $city = Cities::whereName($city)->first();
                if ($city == null)
                    return "نتیجه ای یافت نشد";
                //اول در این قسمت هتل هایی که قابلیت رزور و شامل فیلتر های اولیه همچون نوع مکان(هتل ، مسافرهونه و ...) و دارایی ها(همچون حومه بودن و نوع غذا و ...) را پیدا می کنیم)
                if(isset($condition))
                    $MainHotel = Hotel::whereNotNull('reserveId')->where('cityId', $city->id)->whereIn('kind_id',$kindId)->where($condition)->pluck('reserveId', 'id')->toArray();
                else
                    $MainHotel = Hotel::whereNotNull('reserveId')->where('cityId', $city->id)->whereIn('kind_id',$kindId)->pluck('reserveId', 'id')->toArray();

                //چک می کند که ایا نوع مرتب سازی براساس مکان است
                $checkSort = explode('-',$sort);
                if(count($checkSort) > 1){
                    $place = Amaken::whereId($checkSort[1]);
                    $D = $place->D;
                    $C = $place->C;
                    $placeName = $place->name;
                    $hotels = DB::select("SELECT hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1, hotels.C, hotels.D, acos(" . sin($D/ 180 * 3.14) . " * sin(D / 180 * 3.14) + " . cos($D/ 180 * 3.14) . " * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - " . $C/ 180 * 3.14 . ")) * 6371 as distance FROM hotels WHERE " . $z . " cityId = " . $city->id . " and reserveId is NOT null order by distance ASC limit 4 offset " . (($currPage - 1) * 4));
                }
                else {
                    if ($sort == "review") {
                        $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, reserveId, address, hotels.kind_id, COUNT(*) as matches from hotels, log, activity WHERE reserveId is NOT null AND " . $z . " cityId = " . $city->id . " and activity.id = " . $activityId . " and log.activityId = activity.id and  log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 4 offset " . (($currPage - 1) * 4));
                    }
//                    else
//                        $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, reserveId, address from hotels WHERE reserveId is NOT null AND  " . $z . " cityId = " . $city->id . " AND ORDER by hotels.name ASC limit 4 offset " . (($currPage - 1) * 4));
                }
                if ($sort == "review") {
                    $reminder = 4 - count($hotels);
                    if ($reminder > 0)
                        $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, hotels.pic_1, address from hotels where reserveId is NOT null and " . $z . " not exists (Select * from log WHERE " . $z . " cityId = " . $city->id . " and log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . ") and  cityId = " . $city->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                }
            }
            else{
                $state = State::whereName($city)->first();
                $citiesId = Cities::whereStateId($state->id)->pluck('id')->toArray();
                if ($state == null)
                    return "نتیجه ای یافت نشد";

                if(isset($condition))
                    $MainHotel = Hotel::whereNotNull('reserveId')->whereIn('cityId', $citiesId)->whereIn('kind_id',$kindId)->where($condition)->pluck('reserveId', 'id')->toArray();
                else
                    $MainHotel = Hotel::whereNotNull('reserveId')->whereIn('cityId', $citiesId)->whereIn('kind_id',$kindId)->pluck('reserveId', 'id')->toArray();

                $checkSort = explode('-',$sort);
                if(count($checkSort) > 1){
                    $place = Amaken::whereId($checkSort[1]);
                    $D = $place->D;
                    $C = $place->C;
                    $placeName = $place->name;
                    $hotels = DB::select("SELECT hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1, hotels.C, hotels.D, acos(" . sin($D/ 180 * 3.14) . " * sin(hotels.D / 180 * 3.14) + " . cos($D/ 180 * 3.14) . " * cos(hotels.D / 180 * 3.14) * cos(hotels.C / 180 * 3.14 - " . $C/ 180 * 3.14 . ")) * 6371 as distance FROM hotels, cities, state WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " and reserveId is NOT null order by distance ASC limit 4 offset " . (($currPage - 1) * 4));
                }
                else {
                    if ($sort == "review") {
                        $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1, COUNT(*) as matches from hotels, cities, state, log, activity WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " and  reserveId is NOT null AND activity.id = " . $activityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 4 offset " . (($currPage - 1) * 4));
                    }
//                    else {
//                        $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1 from hotels, cities, state WHERE " . $z . " cityId = cities.id and state.id = stateId and  reserveId is NOT null AND state.id = " . $state->id . " ORDER by hotels.name ASC limit 4 offset " . (($currPage - 1) * 4));
//                    }
                }
                if ($sort == "review") {
                    $reminder = 4 - count($hotels);
                    if ($reminder > 0) {
                        $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, reserveId, address, hotels.file, hotels.pic_1 from hotels, cities, state where " . $z . " not exists (Select * from log WHERE " . $z . " cityId = cities.id and stateId = " . $state->id . " and  log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . ") and reserveId is NOT null and cityId = cities.id and state.id = stateId and state.id = " . $state->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                    }
                }
            }

            if($sort == 'offer'){
                $hotels = $this->getOfferHotels($MainHotel, $currPage);
            }
            elseif ($sort == "rate"){
                $hotels = $this->getRateHotels($MainHotel, $currPage);
            }
            elseif ($sort == 'price') {
                $hotels = $this->getPriceHotels($MainHotel, $currPage);
            }

            $this->getAccessTokenHotel(0);

            foreach ($hotels as $hotel) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $hotel->file . '/f-1.jpg')))
                    $hotel->pic = URL::asset('_images/hotels/' . $hotel->file . '/f-1.jpg');
                else
                    $hotel->pic = URL::asset('_images/nopic/blank.jpg');

                $condition = ['placeId' => $hotel->id, 'kindPlaceId' => $kindPlaceId,
                    'activityId' => $activityId];
                $hotel->reviews = LogModel::where($condition)->count();
                $cityObj = Cities::whereId($hotel->cityId);
                $hotel->city = $cityObj->name;
                $hotel->state = State::whereId($cityObj->stateId)->name;
                $hotel->avgRate = getRate($hotel->id, $kindPlaceId)[1];
                $hotel->Rate = $hotel->avgRate;

                $reserveId = explode('-', $hotel->reserveId);
                $min = 0;
                for($i = 0; $i < count($reserveId); $i++){
                    $HMA = HotelApi::whereId($reserveId[$i]);
                    if($HMA->money != null && $HMA->money != 0){
                        if($min == 0)
                            $min = $HMA->money;
                        else if($min > $HMA->money) {
                            $min = $HMA->money;
                        }
                    }
                }

                $hotel->otherRoom = count($reserveId)-1;
                $hotel->savePercent = 0;
                $hotel->minPrice = $min;
                $hotel->money = $min;

                if(isset($hotel->distance)) {
                    $hotel->distance *= 1000;
                    if($hotel->distance >= 1000) {
                        $hotel->distance = floor($hotel->distance/100)/10;
                        $hotel->distance = 'فاصله از ' . $placeName . ' حدود ' . $hotel->distance . ' کیلومتر';
                    }
                    else {
                        $hotel->distance = floor($hotel->distance);
                        $hotel->distance = 'فاصله از ' . $placeName . ' حدود ' . $hotel->distance . ' متر';
                    }
                }
                else
                    $hotel->distance = '';
            }

//            $goDate = jalaliToGregorian(session('goDate'));
//            $backDate = jalaliToGregorian(session('backDate'));
//            $go = $goDate[0] . '-' . $goDate[1] . '-' . $goDate[2];
//            $back = $backDate[0] . '-' . $backDate[1] . '-' . $backDate[2];

            if($sort == 'rate') {
                for($i = 1; $i < count($hotels); $i++){
                    for($j = 0; $j < count($hotels)-$i ; $j++){
                        if($hotels[$j]->avgRate < $hotels[$j+1]->avgRate){
                            $min = $hotels[$j+1];
                            $hotels[$j+1] = $hotels[$j];
                            $hotels[$j] = $min;
                        }
                    }
                }
            }
            elseif($sort == 'price') {
                for($i = 1; $i < count($hotels); $i++){
                    for($j = 0; $j < count($hotels)-$i ; $j++){
                        if($hotels[$j]->minPrice > $hotels[$j+1]->minPrice){
                            $min = $hotels[$j+1];
                            $hotels[$j+1] = $hotels[$j];
                            $hotels[$j] = $min;
                        }
                    }
                }
            }
            elseif($sort == 'offer'){
                for($i = 1; $i < count($hotels); $i++){
                    for($j = 0; $j < count($hotels)-$i ; $j++){
                        if($hotels[$j]->offer < $hotels[$j+1]->offer){
                            $min = $hotels[$j+1];
                            $hotels[$j+1] = $hotels[$j];
                            $hotels[$j] = $min;
                        }
                    }
                }
            }

            foreach ($hotels as $hotel) {
                $hotel->minPrice = dotNumber($hotel->minPrice);
            }
        }
        else {
            $sort = "rate";
            if (isset($_POST["sort"]))
                $sort = makeValidInput($_POST["sort"]);

            $z = "1 = 1 ";

            if (isset($_POST["kind_id"])) {

                $name = $_POST["kind_id"];

                $i = 0;
                $y = count($name);
                $allow = false;

                $x = "and (";
                while ($i < $y) {

                    $t = makeValidInput($name[$i]);

                    if ($t == -1)
                        $allow = true;

                    if (!$allow)
                        $x .= '`kind_id` = ' . $t . ' OR ';

                    $i++;
                }

                $n = strlen($x);
                if ($n > 5 && !$allow)
                    $z .= substr($x, 0, $n - 4) . ') ';
            }

            $z .= "and ";

            $activityId = Activity::whereName('نظر')->first()->id;
            $rateActivityId = Activity::whereName('امتیاز')->first()->id;
            $kindPlaceId = Place::whereName('هتل')->first()->id;

            if ($mode == "city") {

                $city = Cities::whereName($city)->first();
                if ($city == null)
                    return "نتیجه ای یافت نشد";

                if (isset($_POST['color'])) {

                    $name = $_POST['color'];

                    $i = 0;
                    $y = count($name);

                    $x = "";
                    while ($i < $y) {

                        $t = makeValidInput($name[$i]);
                        $x = $x . '`' . $t . '`=1 AND ';

                        $i++;
                    }
                    $n = strlen($x);
                    $z .= substr($x, 0, $n - 4);
                    $z .= ' and ';
                }

                if ($sort == "review")
                    $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, reserveId, address, COUNT(*) as matches from hotels, log, activity WHERE " . $z . " cityId = " . $city->id . " and activity.id = " . $activityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 4 offset " . (($currPage - 1) * 4));
                elseif ($sort == "rate")
                    $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1,reserveId, address, AVG(userOpinions.rate) as avgRate from hotels, log, activity, userOpinions WHERE " . $z . " cityId = " . $city->id . " and activity.id = " . $rateActivityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id GROUP BY(log.placeId) HAVING avgRate > 2 ORDER by avgRate DESC limit 4 offset " . (($currPage - 1) * 4));
                else
                    $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, reserveId, address from hotels WHERE " . $z . " cityId = " . $city->id . " ORDER by hotels.name ASC limit 4 offset " . (($currPage - 1) * 4));

                $reminder = 4 - count($hotels);

                if ($reminder > 0) {
                    if ($sort == "review")
                        $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, hotels.pic_1, address from hotels where " . $z . " not exists (Select * from log WHERE " . $z . " cityId = " . $city->id . " and log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . ") and cityId = " . $city->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                    else if ($sort == "rate")
                        $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, hotels.pic_1, address from hotels where " . $z . " not exists (Select * from log, userOpinions WHERE " . $z . " cityId = " . $city->id . " and log.activityId = " . $rateActivityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id) and cityId = " . $city->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                }
            } else {
                if (isset($_POST['color'])) {

                    $name = $_POST['color'];

                    $i = 0;
                    $y = count($name);

                    $x = "";
                    while ($i < $y) {

                        $t = makeValidInput($name[$i]);
                        $x = $x . '`' . $t . '`=1 AND ';

                        $i++;
                    }

                    $n = strlen($x);
                    $z .= substr($x, 0, $n - 4);
                    $z .= ' and ';
                }

                $state = State::whereName($city)->first();
                if ($state == null)
                    return "نتیجه ای یافت نشد";

                if ($sort == "review")
                    $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1, COUNT(*) as matches from hotels, cities, state, log, activity WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " and activity.id = " . $activityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 4 offset " . (($currPage - 1) * 4));
                elseif ($sort == "rate")
                    $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1, AVG(userOpinions.rate) as avgRate from hotels, cities, state, log, activity, userOpinions WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " and activity.id = " . $rateActivityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id GROUP BY(log.placeId) HAVING avgRate > 2 ORDER by avgRate DESC limit 4 offset " . (($currPage - 1) * 4));
                else
                    $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, reserveId, address, hotels.pic_1 from hotels, cities, state WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " ORDER by hotels.name ASC limit 4 offset " . (($currPage - 1) * 4));

                $reminder = 4 - count($hotels);
                if ($reminder > 0) {
                    if ($sort == "review")
                        $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, reserveId, address, hotels.file, hotels.pic_1 from hotels, cities, state where " . $z . " not exists (Select * from log WHERE " . $z . " cityId = cities.id and stateId = " . $state->id . " and log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . ") and cityId = cities.id and state.id = stateId and state.id = " . $state->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                    else if ($sort == "rate") {
                        $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, reserveId, address, hotels.file, hotels.pic_1 from hotels, cities, state where " . $z . " not exists (Select * from log, userOpinions WHERE " . $z . " cityId = cities.id and stateId = " . $state->id . " and log.activityId = " . $rateActivityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id) and cityId = cities.id and state.id = stateId and state.id = " . $state->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                    }
                }
            }


            foreach ($hotels as $hotel) {

                if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $hotel->file . '/f-1.jpg')))
                    $hotel->pic = URL::asset('_images/hotels/' . $hotel->file . '/f-1.jpg');
                else
                    $hotel->pic = URL::asset('_images/nopic/blank.jpg');

                $condition = ['placeId' => $hotel->id, 'kindPlaceId' => $kindPlaceId,
                    'activityId' => $activityId];
                $hotel->reviews = LogModel::where($condition)->count();
                $cityObj = Cities::whereId($hotel->cityId);
                $hotel->city = $cityObj->name;
                $hotel->state = State::whereId($cityObj->stateId)->name;
                $hotel->avgRate = getRate($hotel->id, $kindPlaceId)[1];

                if ($kind == 'reserve' && $hotel->reserveId != null)
                    array_push($hotel_reserve, $hotel);
            }

            if ($sort == "rate") {
                usort($hotels, function ($a, $b) {
                    return $b->avgRate - $a->avgRate;
                });
            }
        }

        echo \GuzzleHttp\json_encode(['places' => $hotels]);
    }

    private function getOfferHotels($MainHotel, $currPage){
        $ApiHotelId = array();
        $ApiHotelId2 = array();
        foreach ($MainHotel as $id => $value) {
            $seperate = explode('-', $value);
            for ($j = 0; $j < count($seperate); $j++) {
                $ApiHotelId[$seperate[$j]] = $id;
                array_push($ApiHotelId2, $seperate[$j]);
            }
        }
        $offerHotels = HotelApi::whereIn('id', $ApiHotelId2)->orderBy('offer', 'desc')->orderBy('money', 'asc')->pluck('id')->toArray();
        $startPage = ($currPage - 1) * 4;
        $currentId = array();

        for ($i = $startPage; $i < $startPage + 4; $i++) {
            if ($i < count($offerHotels))
                array_push($currentId, $ApiHotelId[$offerHotels[$i]]);
        }
        $hotels = Hotel::whereIn('id', $currentId)->select('id', 'name', 'cityId', 'file', 'pic_1', 'reserveId', 'address')->get();
        return $hotels;
    }

    private function getRateHotels($MainHotel, $currPage){
        $kindPlaceId = Place::whereName('هتل')->first()->id;
        $hotelsRate = array();
        foreach ($MainHotel as $id => $reserveId) {
            $rate =  getRate($id, $kindPlaceId)[1];
            if(isset($_POST['rate']) && $_POST['rate'] != 0){
                if($rate < $_POST['rate'])
                    continue;
            }
            $array = array(
                'id' => $id,
                'rate' => $rate
            );
            array_push($hotelsRate, $array);
        }
        for($i = 1; $i < count($hotelsRate); $i++){
            for($j = 0; $j < count($hotelsRate)-$i; $j++){
                if($hotelsRate[$j]['rate'] < $hotelsRate[$j+1]['rate']){
                    $min = $hotelsRate[$j+1];
                    $hotelsRate[$j+1] = $hotelsRate[$j];
                    $hotelsRate[$j] = $min;
                }
            }
        }

        $startPage = ($currPage - 1) * 4;
        $currentId = array();

        for ($i = $startPage; $i < $startPage + 4; $i++) {
            if ($i < count($hotelsRate))
                array_push($currentId, $hotelsRate[$i]['id']);
        }
        $hotels = Hotel::whereIn('id', $currentId)->select('id', 'name', 'cityId', 'file', 'pic_1', 'reserveId', 'address')->get();
        return $hotels;
    }

    private function getPriceHotels($MainHotel, $currPage){
        $ApiHotelId = array();
        $ApiHotelId2 = array();
        foreach ($MainHotel as $id => $value) {
            $seperate = explode('-', $value);
            $min = 0;
            $minId = 0;
            for ($j = 0; $j < count($seperate); $j++) {
                $money = HotelApi::whereId($seperate[$j])->money;
                if($j == 0) {
                    $min = $money;
                    $minId = $seperate[$j];
                }
                else{
                    if($min > $money) {
                        $min = $money;
                        $minId = $seperate[$j];
                    }
                }
            }
            $ApiHotelId[$minId] = $id;
            array_push($ApiHotelId2, $minId);
        }
        $minHotels = HotelApi::whereIn('id', $ApiHotelId2)->orderBy('money', 'asc')->pluck('id')->toArray();
        $startPage = ($currPage - 1) * 4;
        $currentId = array();

        for ($i = $startPage; $i < $startPage + 4; $i++) {
            if ($i < count($minHotels))
                array_push($currentId, $ApiHotelId[$minHotels[$i]]);
        }
        $hotels = Hotel::whereIn('id', $currentId)->select('id', 'name', 'cityId', 'file', 'pic_1', 'reserveId', 'address')->get();
        return $hotels;
    }

    public function makeSessionHotel()
    {
        $city = request('city');
        $mode = request('mode');

        session([
            'goDate' => request('goDate'),
            'backDate' => request('backDate'),
            'adult' => request('adult'),
            'room' => request('room'),
            'children' => request('children'),
            'ageOfChild' => request('ageOfChild')
        ]);
        if(request('id') != null){
            return \redirect(\url('hotel-details/'.request('id') .'/'.request('name') .'/'));
        }
        else{
            return \redirect(route('hotelList2', ['city' => $city, 'mode' => $mode]));
        }
    }

    public function showHotelList2($city, $mode)
    {
//        dd($city);
//        $this->getAccessTokenHotel(0);
        if ($mode == "state") {

            $state = State::whereName($city)->first();
            if ($state == null)
                return "نتیجه ای یافت نشد";

            $stateName = $state->name;
        } else {
            $tmp = Cities::whereName($city)->first();
            if ($tmp == null)
                return "نتیجه ای یافت نشد";

            $state = State::whereId($tmp->stateId);
            if ($state == null)
                return "نتیجه ای یافت نشد";

            $stateName = $state->name;
        }

        return view('hotel-list2', array('mode' => $mode, 'placeMode' => 'hotel', 'city' => $city, 'state' => $stateName));
    }

    public function getAccessTokenHotel($return){
        $access_token_save = saveApiInfo::whereName('access_token_ali_baba')->first();
        $userName = saveApiInfo::whereName('register_ali_baba')->first();
        if($userName == null)
            dd('username and password not found....');

        $array = array(
            'username' => $userName->array['userName'],
            'password' => $userName->array['password'],
            'client_id' => '00000',
            'grant_type' => 'password'
        );
        $POSTFIELDS = http_build_query($array);

        if($access_token_save == null){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.altrabo.com/api/v1/token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $POSTFIELDS,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "Postman-Token: 30f7d799-43cc-4f98-bc59-74e794acb868",
                    "cache-control: no-cache"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $newAPI = new saveApiInfo();
            $newAPI->name = 'access_token_ali_baba';
            $newAPI->array = $response;
            $newAPI->save();

            if ($err) {
                dd('err  = ' . $err);
            } else {
                $access_token = json_decode($response)->access_token;
                if($return != 1)
                    $this->updateHotelDeatils($access_token);
            }
        }
        else if($access_token_save->updated_at->addHour() < Carbon::now()) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.altrabo.com/api/v1/token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $POSTFIELDS,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "Postman-Token: 30f7d799-43cc-4f98-bc59-74e794acb868",
                    "cache-control: no-cache"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $newSave = saveApiInfo::whereName('access_token_ali_baba')->first();
            $newSave->array = $response;
            $newSave->save();

            if ($err) {
                dd('err  = ' . $err);
            } else {
                $access_token = json_decode($response)->access_token;
                if($return != 1)
                    $this->updateHotelDeatils($access_token);
            }
        }
        else{
            $access_token = json_decode($access_token_save->array)->access_token;
        }

        if($return == 1) {
            return $access_token;
        }
    }

    private function getRoomDetails($input, $access_token){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/GetRoomsOption",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $input,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 8e3ed865-e819-4fcc-85c2-ad26ea0d7f98",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo $err;
        } else {
            return (json_decode($response));
        }
    }

    private function updateHotelDeatils($access_token){
        $city = $this->getCityCodeApi($access_token);

        for($i = 0; $i < count($city); $i++){
            do{
                $check = $this->getHotelCity($city[$i]->id, $access_token, $city[$i]->persinaTitle);
            }while(!$check);
        }
        return true;
    }

    private function getCityCodeApi($access_token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/AutoComplete?isDomestic=true&query=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 226a3dda-b179-4c96-8bee-38bb92be81c9",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $city = $response->data;
        }

        return $city;
    }

    private function getHotelCity($city_id, $access_token, $city_name){

        $nowDate = date("Y-m-d");
        $tomorrowDate = date("Y-m-d", strtotime("tomorrow"));

        $hotel_input = array('CheckIn' => $nowDate,
            'CheckOut' => $tomorrowDate,
            'CityIdOrHotelId' => $city_id,
            'Nationality' => 'IR',
            'IsDomestic' => 'true'
        );
        $hotel_input = json_encode($hotel_input);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/Get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $hotel_input,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: ef3adb7f-0566-4267-b6ba-9ed839d7e91f",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if(json_decode($response)->data != null) {
            $response = json_decode($response)->data;
            for ($i = 0; $i < count($response); $i++) {

                $hotel = HotelApi::whereUserName($response[$i]->userName)->first();
                if ($hotel == null) {
                    $newHotel = new HotelApi;
                    $newHotel->name = $response[$i]->hotelName;
                    $newHotel->rph = $response[$i]->rph;
                    $newHotel->userName = $response[$i]->userName;
                    $newHotel->facility = $response[$i]->hotelFacility;
                    $newHotel->cityName = $city_name;
                    $newHotel->money = $response[$i]->startPrice;
                    $newHotel->provider = 'علی بابا';

                    $newHotel->save();
                } else {
                    $hotel->money = $response[$i]->startPrice;
                    $hotel->save();
                }
            }
        }
        else{
            return false;
        }
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return true;
        }
    }

    private function getHotelInfo($hotelName, $access_token, $in, $out, $rph){

        $hotel_input = array('CheckIn' => $in,
            'CheckOut' => $out,
            'CityIdOrHotelId' => $hotelName,
            'Nationality' => 'IR',
            'rph' => $rph,
            'Type' => 1,
            'Categorykey' => 'hotel',
            'IsDomestic' => true
        );

        $hotel_input = json_encode($hotel_input);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/GetInfo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $hotel_input,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 3f4ae4f0-7cf6-4a3a-a29c-598cf2d7f8ee",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response)->data[0]->policy;
        }
    }

    private function hotelReservationAPI($query)
    {
        $query = json_encode($query);
        $access_token = $this->getAccessTokenHotel(1);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelReserve/Reserve",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "X-ZUMO-AUTH: ".$access_token
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if($err)
            dd($err);
        return json_decode($response);
    }

    public function sendReserveRequest()
    {
        $selected_room = json_decode(session('reserve_room'));
        $request = request()->all();

        // this section we save passenger information
        if(isset($request['savedInformation'])){
            for($i = 0; $i < count($request['room_code']); $i++){
                if($request['savedInformation'][$i] == 'ok'){
                    $passenger = HotelPassengerInfo::whereNID($request['NID'][$i])->first();
                    if($passenger == null){

                        //this section for make date format
                        //1399/1/2 go to 13990102 to save in data base
                        $birthDate = $request['birthDayY'][$i] ;
                        if($request['birthDayM'][$i] < 10)
                            $birthDate .= '0';
                        $birthDate .= $request['birthDayM'][$i];
                        if($request['birthDayD'][$i] < 10)
                            $birthDate .= '0';
                        $birthDate .= $request['birthDayD'][$i];

                        $newPassenger = new HotelPassengerInfo();
                        $newPassenger->nameFa = $request['nameFa'][$i];
                        $newPassenger->nameEn = $request['nameEn'][$i];
                        $newPassenger->familyFa = $request['familyFa'][$i];
                        $newPassenger->familyEn = $request['familyEn'][$i];
                        $newPassenger->birthDay = $birthDate;
                        $newPassenger->phone = $request['phoneNum'];
                        $newPassenger->email = $request['email'];
                        $newPassenger->NID = $request['NID'][$i];

                        if($request['expireD'][$i] != null && $request['expireM'][$i] != null && $request['expireY'][$i] != null && $request['countryCode'][$i] != null ){
                            //this section for make date format
                            //1399/1/2 go to 13990102 to save in data base
                            $expireDate = $request['expireY'][$i] ;
                            if($request['expireM'][$i] < 10)
                                $expireDate .= '0';
                            $expireDate .= $request['expireM'][$i];
                            if($request['expireD'][$i] < 10)
                                $expireDate .= '0';
                            $expireDate .= $request['expireD'][$i];

                            $newPassenger->expire = $expireDate;
                            $newPassenger->NIDType = 1;
                            $newPassenger->countryCodeId = CountryCode::whereCode($request['countryCode'][$i])->first()->id;
                        }
                        else{
                            $newPassenger->countryCodeId = 0;
                            $newPassenger->NIDType = 0;
                        }
                        if($request['sex'][$i] == 'female')
                            $newPassenger->sex = 0;
                        else
                            $newPassenger->sex = 1;

                        if(Auth::check()){
                            $newPassenger->uId = Auth::user()->id;
                        }
                        else{
                            $newPassenger->uId = $request['user_id'];
                        }
                        $newPassenger->save();
                    }
                    else{
                        //this section for make date format
                        //1399/1/2 go to 13990102 to save in data base
                        $birthDate = $request['birthDayY'][$i] ;
                        if($request['birthDayM'][$i] < 10)
                            $birthDate .= '0';
                        $birthDate .= $request['birthDayM'][$i];
                        if($request['birthDayD'][$i] < 10)
                            $birthDate .= '0';
                        $birthDate .= $request['birthDayD'][$i];

                        $passenger->nameFa = $request['nameFa'][$i];
                        $passenger->nameEn = $request['nameEn'][$i];
                        $passenger->familyFa = $request['familyFa'][$i];
                        $passenger->familyEn = $request['familyEn'][$i];
                        $passenger->birthDay = $birthDate;
                        $passenger->phone = $request['phoneNum'];
                        $passenger->email = $request['email'];
                        $passenger->NID = $request['NID'][$i];

                        if($request['expireD'][$i] != null && $request['expireM'][$i] != null && $request['expireY'][$i] != null && $request['countryCode'][$i] != null ){

                            //this section for make date format
                            //1399/1/2 go to 13990102 to save in data base
                            $expireDate = $request['expireY'][$i] ;
                            if($request['expireM'][$i] < 10)
                                $expireDate .= '0';
                            $expireDate .= $request['expireM'][$i];
                            if($request['expireD'][$i] < 10)
                                $expireDate .= '0';
                            $expireDate .= $request['expireD'][$i];

                            $passenger->expire = $expireDate;
                            $passenger->NIDType = 1;
                            $passenger->countryCodeId = CountryCode::whereCode($request['countryCode'][$i])->first()->id;
                        }
                        else{
                            $passenger->countryCodeId = 0;
                            $passenger->NIDType = 0;
                        }
                        if($request['sex'][$i] == 'female')
                            $passenger->sex = 0;
                        else
                            $passenger->sex = 1;
                        $passenger->save();
                    }
                }
            }
        }

        if($request['newsMe'] == 'ok' || $request['informMe'] == 'ok'){
            $noticHotel = NoticesHotel::whereEmail($request['email'])->first();
            if($noticHotel == null){
                $new_noticHotel = new NoticesHotel();
                $new_noticHotel->email =$request['email'];
                $new_noticHotel->phone =$request['phoneNum'];
                if($request['newsMe'] == 'ok')
                    $new_noticHotel->news = true;
                if($request['informMe'] == 'ok')
                    $new_noticHotel->importantInfo = true;
                $new_noticHotel->save();
            }
            else{
                if($request['newsMe'] == 'ok')
                    $noticHotel->news = true;
                if($request['informMe'] == 'ok')
                    $noticHotel->importantInfo = true;

                $noticHotel->save();
            }
        }

        // this section we create body query for hotel reservation
        $travelers = array();
        for($i = 0; $i < count($request['room_code']); $i++){
            $room_index = $request['room_code'][$i];

            if($request['expireD'][$i] != null && $request['expireM'][$i] != null &&
                $request['expireY'][$i] != null && $request['countryCode'][$i] != null ){

                $expireDate = $request['expireY'][$i] .'/'. $request['expireM'][$i] . '/' . $request['expireD'][$i];
                $expireDate = jalaliToGregorian($expireDate);

                $document = array(
                    'DocId' => $request['NID'][$i],
                    'ExpireDate' => $expireDate[0].'-'.$expireDate[1].'-'.$expireDate[2],
                    'DocType' => 'Passport',
                    'DocIssuedCountry' => "IR",
                    'BirthCountry' => "IR",
                );
            }
            else{

                $document = array(
                    'DocId' => $request['NID'][$i],
                    'ExpireDate' => null,
                    'DocType' => 'NationalId',
                    'DocIssuedCountry' => null,
                    'BirthCountry' => null,
                );
            }

            $personEn = array(
                'GivenName' => $request['nameEn'][$i],
                'Surname' => $request['familyEn'][$i],
                'NamePrefix' => null,
            );
            $personFa = array(
                'GivenName' => $request['nameFa'][$i],
                'Surname' => $request['familyFa'][$i],
                'NamePrefix' => null,
            );
            if($request['sex'][$i] == 'female')
                $gender = 2;
            else
                $gender = 1;

            $birthDate = $request['birthDayY'][$i] .'/'. $request['birthDayM'][$i] . '/' . $request['birthDayD'][$i];
            $birthDate = jalaliToGregorian($birthDate);
            $birthDate = $birthDate[0].'-'.$birthDate[1].'-'.$birthDate[2];

            if($request['answers'][$i][3])
                $infant = true;
            else
                $infant = false;

            $airTraveler = array(
                'Address' => null,
                'Document' => $document,
                'PersonName' => $personEn,
                'PersianPersonName' => $personFa,
                'BirthDate' => $birthDate,
                'Telephone' => null,
                'Email' => null,
                'Gender' => $gender,
                'AccompaniedByInfantInd' => $infant,
                'PassengerType' => 1,
                'TravelerRefNumber' => 0,
                'FlightSequence' => 0,
            );
            $airTravelers = array();
            array_push($airTravelers, $airTraveler);

            $travelerss = array(
                'RoomIndex' => $room_index,
                'AirTravelers' => $airTravelers
            );
            array_push($travelers, $travelerss);
        }
        $telephone = array(
            'AreaCityCode' => null,
            'CountryAccessCode' => null,
            'PhoneNumber' => $request['phoneNum']
        );
        $TravelerInfo = array(
            'Travelers' => $travelers,
            'Telephone' => $telephone,
            'Email' => $request['email']
        );
        $check_in = jalaliToGregorian(session('goDate'));
        $check_in = $check_in[0].'-'.$check_in[1].'-'.$check_in[2];
        $check_out = jalaliToGregorian(session('backDate'));
        $check_out = $check_out[0].'-'.$check_out[1].'-'.$check_out[2];
        $GuestRoomInfos = array();
        for($i = 0; $i < count($selected_room->num_room_code); $i++){
            $guestRoomInfo = array(
                'AdultCount' => $selected_room->adult_count[$i],
                'ChildCount' => session('children'),
                'ChildAge' => [],
                'BedNumber' => $selected_room->adult_count[$i],
                'RoomCount' => $selected_room->num_room_code[$i],
                'RoomId' => $selected_room->room_code[$i],
            );
            array_push($GuestRoomInfos, $guestRoomInfo);
        }
        $AvailableRequest = array(
            'CheckIn' => $check_in,
            'CheckOut' => $check_out,
            'CityIdOrHotelId' => $selected_room->hotel_name,
            'Nationality' => "IR",
            'Type' => 1,
            'NumberOfRoom' => count($request['room_code']),
            'GuestRoomInfos' => $GuestRoomInfos,
            'Rph' => $selected_room->rph,
            'CategoryKey' => 'hotel',
            'IsDomestic' => true,
        );
        $query = array(
            'TravelerInfo' => $TravelerInfo,
            'AvailableRequest' => $AvailableRequest,
            'OptionId' => null
        );
        $result = $this->hotelReservationAPI($query);

//        for($i = 0; $i < count($selected_room->num_room_code); $i++) {
//            $passenger = HotelPassengerInfo::whereNID($request['NID'][$i])->first();
//            if($passenger == null){
//
//                $birthDate = $request['birthDayY'][$i] ;
//                if($request['birthDayM'][$i] < 10)
//                    $birthDate .= '0';
//                $birthDate .= $request['birthDayM'][$i];
//                if($request['birthDayD'][$i] < 10)
//                    $birthDate .= '0';
//                $birthDate .= $request['birthDayD'][$i];
//
//                $newPassenger = new HotelPassengerInfo();
//                $newPassenger->nameFa = $request['nameFa'][$i];
//                $newPassenger->nameEn = $request['nameEn'][$i];
//                $newPassenger->familyFa = $request['familyFa'][$i];
//                $newPassenger->familyEn = $request['familyEn'][$i];
//                $newPassenger->birthDay = $birthDate;
//                $newPassenger->phone = $request['phoneNum'];
//                $newPassenger->email = $request['email'];
//                $newPassenger->NID = $request['NID'][$i];
//
//                if($request['expireD'][$i] != null && $request['expireM'][$i] != null && $request['expireY'][$i] != null && $request['countryCode'][$i] != null ){
//
//                    $expireDate = $request['expireY'][$i] ;
//                    if($request['expireM'][$i] < 10)
//                        $expireDate .= '0';
//                    $expireDate .= $request['expireM'][$i];
//                    if($request['expireD'][$i] < 10)
//                        $expireDate .= '0';
//                    $expireDate .= $request['expireD'][$i];
//
//                    $newPassenger->expire = $expireDate;
//                    $newPassenger->NIDType = 0;
//                    $newPassenger->countryCodeId = CountryCode::whereCode($request['countryCode'][$i])->first()->id;
//                }
//                else{
//                    $newPassenger->countryCodeId = 0;
//                }
//                if($request['sex'][$i] == 'female')
//                    $newPassenger->sex = 1;
//                else
//                    $newPassenger->sex = 0;
//                $newPassenger->save();
//            }
//        }

        if($result->response->successful) {
            if(!($result->data->isFloat)){
                echo 'paymentPage';
            }
            else {
                $now = Carbon::now()->timestamp;

                session(['orderId' => $result->data->orderId]);
                session(['reserveRequestId' => $result->data->reserveRequestId]);
                session(['expiryDateTime' => $result->data->expiryDateTime]);

                $expireTime = Carbon::createFromTimeString($result->data->expiryDateTime)->timestamp;
                $result->data->expiryDateTime = $expireTime - $now;
                echo json_encode($result);
            }
        }
        else{
            echo json_encode($result);
            return;

            echo 'nok';
        }
        return;
    }

    public function GetReserveStatus(){

        $curl = curl_init();
        $order = array('OrderId' => session('orderId'));
        $order = json_encode($order);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelReserve/GetReserveStatus",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $order,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 216903de-7c56-439f-97df-5f3309e38084",
                "X-ZUMO-AUTH:" . $this->getAccessTokenHotel(1),
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'nok';
        } else {
            $result = json_decode($response);
            if(!($result->response->successful)){
                echo 'nok';
                return;
            }
            switch ($result->data->statusCode){
                case 'ReserveRequest':
                    echo $response;
                    break;
                case 'Vouchered':
                    echo 'voucher';
                    break;
                case 'FakeReserve':
                    session()->forget(['orderId', 'reserveRequestId', 'expiryDateTime', 'remain']);
                    echo 'fake';
                    break;
                case 'WaitingForPayment':
                    echo 'payment';
                    break;
                case 'PaymentTimeout':
                    session()->forget(['orderId', 'reserveRequestId', 'expiryDateTime', 'remain']);
                    echo 'timeOut';
                    break;
                default:
                    echo json_encode($result);
                    break;
            };
        }
        return;
    }

    public function checkUserNameAndPassHotelReserve(){
        if (isset($_POST["username"]) && isset($_POST["pass"]) && isset($_POST["rPass"])) {

            $username = makeValidInput($_POST["username"]);
            $pass = makeValidInput($_POST["pass"]);
            $rPass = makeValidInput($_POST["rPass"]);

            if (User::whereUserName($username)->count() > 0) {
                echo "nok1";
                return;
            }

            if ($pass != $rPass) {
                echo "nok2";
                return;
            }

            $user = new User();
            $user->username = $username;
            $user->password = Hash::make($pass);
            $user->cityId = Cities::first()->id;
            if(request('email') != null && request('phone') != null){
                $user->email = request('email');
                $user->phone = request('phone');
            }
            if(request('firstName') != null && request('lastName') != null){
                $user->first_name = request('firstName');
                $user-> last_name  = request('lastName');
            }

            try {
                $user->save();
                echo json_encode($user->id);
            } catch (\Exception $x) {
                dd($x);
            }
        }
    }

    public function getHotelPassengerInfo(){
        $passengers = HotelPassengerInfo::where('uId',Auth::user()->id)->get();
        foreach ($passengers as $passenger) {
            if($passenger->countryCodeId != 0)
                $passenger->countryCodeId = CountryCode::whereId($passenger->countryCodeId)->code;
        }

        echo json_encode($passengers);
    }

    public function getHotelWarning()
    {
        if(request('email') != null && request('city')){

            $noticsHotel = NoticesHotel::whereEmail(request('email'))->first();
            $cityId = Cities::whereName(request('city'))->first();
            if($cityId == null){
                echo 'nokCity';
                return;
            }
            if($noticsHotel == null){
                $newNotic = new NoticesHotel();
                $newNotic->email = request('email');
                $newNotic->getWarning = $cityId->id;
                $newNotic->save();
            }
            else{
                if($noticsHotel->getWarning == null){
                    $noticsHotel->getWarning = $cityId->id;
                }
                else{
                    $noticsHotel->getWarning = $noticsHotel->getWarning . '-' . $cityId->id;
                }
                $noticsHotel->save();
            }

            echo 'ok';
            return;
        }
        else{
            echo 'nok';
            return;
        }
    }

    public function AlibabaInfo()
    {
        return \view('alibaba');
    }

    public function saveAlibabaInfo()
    {
        $validator = \Validator::make(request()->all(),
            ['userName' => 'required'],
            ['password' => 'required']
        );
        if($validator->fails()){
            echo 'nok';
        }
        else{
            $array = array(
                'userName' => request('userName'),
                'password' => request('password'),
            );

            $alibaba = saveApiInfo::whereName('register_ali_baba')->first();
            if($alibaba != null){
                $alibaba->array = $array;
                $alibaba->save();
            }
            else{
                $new =  new saveApiInfo();
                $new->name = 'register_ali_baba';
                $new->array = $array;
                $new->save();
            }
            echo 'ok';
        }
        return;
    }
}
