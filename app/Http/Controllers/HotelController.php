<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\places\Hotel;
use App\models\places\HotelApi;
use App\models\LogModel;
use App\models\places\Majara;
use App\models\PhotographersPic;
use App\models\PicItem;
use App\models\places\Place;
use App\models\places\PlaceFeatureRelation;
use App\models\places\PlaceFeatures;
use App\models\places\PlacePic;
use App\models\places\PlaceStyle;
use App\models\QuestionAns;
use App\models\places\Restaurant;
use App\models\ReviewPic;
use App\models\saveApiInfo;
use App\models\SectionPage;
use App\models\State;
use App\models\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class HotelController extends Controller {

    public function editor($placeId, $kindPlaceId)
    {
        switch ($kindPlaceId) {
            case 4:
            default:
                $place = Hotel::whereId($placeId);
                break;
            case 1:
                $place = Amaken::whereId($placeId);
                break;
            case 3:
                $place = Restaurant::whereId($placeId);
                break;
            case 6:
                $place = Majara::whereId($placeId);
                break;
            case 8:
                $place = Adab::whereId($placeId);
                break;
        }

        return view('editor', ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'placeName' => $place->name,
            'tags' => PicItem::where('kindPlaceId',$kindPlaceId)->get()]);
    }

    private function getSimilarHotels($place)
    {

        $stateId = State::whereId(Cities::whereId($place->cityId)->stateId)->id;

        $hotels = DB::Select('select * from hotels where cityId in (select cities.id from cities where stateId = ' . $stateId . ')');
        $arr = [];
        $count = 0;

        foreach ($hotels as $hotel) {

            if ($hotel->id == $place->id) {
                $hotel->point = -1;
                continue;
            }

            $point = 0;
            if ($hotel->tarikhi == $place->tarikhi)
                $point += 3;
            if ($hotel->coffeeshop == $place->coffeeshop)
                $point += 3;
            if ($hotel->hoome == $place->hoome)
                $point += 3;
            if ($hotel->shologh == $place->shologh)
                $point += 3;
            if ($hotel->khalvat == $place->khalvat)
                $point += 3;
            if ($hotel->tabiat == $place->tabiat)
                $point += 3;
            if ($hotel->kooh == $place->kooh)
                $point += 3;
            if ($hotel->darya == $place->darya)
                $point += 3;
            if ($hotel->rate_int == $place->rate_int)
                $point += 2;

            $arr[$count++] = [$count, $point];

        }

        usort($arr, function ($a, $b) {
            return $a[1] - $b[1];
        });

        if (count($hotels) < 4)
            $out = Hotel::take(4)->get();
        else
            $out = [$hotels[$arr[0][0]], $hotels[$arr[1][0]], $hotels[$arr[2][0]], $hotels[$arr[3][0]]];

        $kindPlaceId = Place::whereName('هتل')->first()->id;
        for ($i = 0; $i < count($out); $i++) {

            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $out[$i]->file . '/f-1.jpg')))
                $out[$i]->pic = URL::asset("_images/hotels/" . $out[$i]->file . '/f-1.jpg');
            else
                $out[$i]->pic = URL::asset("_images/nopic/blank.jpg");

            $condition = ['placeId' => $out[$i]->id, 'kindPlaceId' => $kindPlaceId, 'confirm' => 1,
                'activityId' => Activity::whereName('نظر')->first()->id];
            $out[$i]->reviews = LogModel::where($condition)->count();
            $out[$i]->rate = $out->fullRate;
        }

        return $out;
    }

    public function getSimilarsHotel() {

        if (isset($_POST["placeId"])) {
            $place = Hotel::whereId(makeValidInput($_POST["placeId"]));
            if ($place != null) {
                echo \GuzzleHttp\json_encode($this->getSimilarHotels($place));
                return;
            }
        }

        echo \GuzzleHttp\json_encode([]);
    }

    public function searchPlaceHotelList2()
    {
        $cityId = DB::select('SELECT id FROM cities WHERE NAME ="'.request("city").'"');
        $place = DB::select('SELECT * FROM amaken WHERE name LIKE "%'.request("name").'%" AND cityId = '.$cityId[0]->id);
        echo json_encode($place);
        return;
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

    private function getRoomDetails($input, $access_token)
    {
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

}
