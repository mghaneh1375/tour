<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\Alert;
use App\models\CountryCode;
use App\models\PassengerInfos;
use App\models\places\Amaken;
use App\models\places\Boomgardy;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\Followers;
use App\models\FoodMaterial;
use App\models\GoyeshCity;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\MainSuggestion;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\places\PlaceFeatureRelation;
use App\models\places\PlaceFeatures;
use App\models\Question;
use App\models\QuestionAns;
use App\models\QuestionUserAns;
use App\models\Report;
use App\models\ReportsType;
use App\models\places\Restaurant;
use App\models\LogFeedBack;
use App\models\Reviews\ReviewUserAssigned;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\safarnameh\SafarnamehComments;
use App\models\places\SogatSanaie;
use App\models\State;
use App\models\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;


class AjaxController extends Controller {

    public function getMyInfoForPassenger(){
        return response()->json([
            'status' => 'ok',
            'result' => User::select(['first_name', 'last_name', 'sex', 'birthday'])->find(\auth()->user()->id)
            ]);
    }

    public function getLastPassengers(){
        if(\auth()->check()){
            $passengers = PassengerInfos::where('userId', \auth()->user()->id)->get();
            foreach ($passengers as $item){
                $item->name = '';
                if($item->firstNameFa != null)
                    $item->name .= $item->firstNameFa;
                else if($item->firstNameEn != null)
                    $item->name .= $item->firstNameEn;

                if($item->lastNameFa != null)
                    $item->name .= $item->lastNameFa;
                else if($item->lastNameEn != null)
                    $item->name .= $item->lastNameEn;
            }
            return response()->json(['status' => 'ok', 'result' => $passengers]);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function searchInCounty()
    {
        $value = $_GET['value'];
        $countries = CountryCode::where('name', 'LIKE', '%'.$value.'%')->get();
        return response(['status' => 'ok', 'result' => $countries]);
    }

    public function getVideosFromKoochitaTv()
    {
        $nouns = config('app.koochitaTvNouncCode');
        $KOOCHITATV_URL_API = config('app.KOOCHITATV_URL_API');

        $kindPlace = Place::find($_GET['kindPlaceId']);
        $place = \DB::table($kindPlace->tableName)->find($_GET['id']);


        if($place != null && $kindPlace != null){
            $curl = curl_init();
            $kindPlaceId = $kindPlace->id;
            $placeId = $place->id;

            $time = Carbon::now()->getTimestamp();
            $hash = Hash::make($nouns.'_'.$time.'_'.$kindPlaceId.'_'.$placeId);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "{$KOOCHITATV_URL_API}/getVideosForPlaces?time={$time}&code={$hash}&kind={$kindPlaceId}&id={$placeId}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if($response){
                $response = json_decode($response);
                if($response->status == 'ok')
                    return response()->json(['status' => 'ok', 'result' => $response->result]);
                else
                    return response()->json(['status' => 'errorInResult']);
            }
            else
                return response()->json(['status' => 'errorInGet']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function getNewestVideoFromKoochitaTv()
    {
        $nouns = config('app.koochitaTvNouncCode');
        $KOOCHITATV_URL_API = config('app.KOOCHITATV_URL_API');

        $curl = curl_init();

        $time = Carbon::now()->getTimestamp();
        $hash = Hash::make($nouns.'_'.$time);

        $getCount = 10;

        curl_setopt_array($curl, [
            CURLOPT_URL => "{$KOOCHITATV_URL_API}/getNewestVideos?time={$time}&code={$hash}&count={$getCount}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        if($response){
            $response = json_decode($response);
            if($response->status == 'ok')
                return response()->json(['status' => 'ok', 'result' => $response->result]);
            else
                return response()->json(['status' => 'errorInResult']);
        }
        else
            return response()->json(['status' => 'errorInGet']);

    }


    public function searchForFoodMaterial()
    {
        $result = FoodMaterial::where('name', 'LIKE', '%'.$_GET["value"].'%')->pluck('name')->toArray();
        return response()->json(['searchNumber' => $_GET['searchNumber'], 'result' => $result]);
    }

    public function getSingleQuestion(Request $request)
    {
        if(isset($request->id)){
            $act = Activity::where('name', 'سوال')->first();
            $quest = LogModel::find($request->id);
            if($quest->activityId != $act->id){
                while($quest->activityId != $act->id && $quest->relatedTo != 0)
                    $quest = LogModel::find($quest->relatedTo);
            }
            $quest = questionTrueType($quest);

            return response()->json(['status' => 'ok', 'result' => $quest]);
        }
        else
            return response()->json(['status' => 'nok']);
    }

    public function getPlacePic() {

        if(isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {

            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $placeId = makeValidInput($_POST["placeId"]);

            switch ($kindPlaceId) {
                case 1:
                    $target = Amaken::whereId($placeId);
                    break;
                case 3:
                    $target = Restaurant::whereId($placeId);
                    break;
                case 4:
                    $target = Hotel::whereId($placeId);
                    break;
                case 6:
                    $target = Majara::whereId($placeId);
                    break;
                case 8:
                    $target = Adab::whereId($placeId);
                    break;
                default:
                    return;
            }

            if($target == null)
                return;

            switch ($kindPlaceId) {
                case 1:
                    $target = 'amaken/' . $target->file . '/l-1.jpg';
                    break;
                case 3:
                    $target ='restaurant/' . $target->file . '/l-1.jpg';
                    break;
                case 4:
                    $target = 'hotels/' . $target->file . '/l-1.jpg';
                    break;
                case 6:
                    $target = 'majara/' . $target->file . '/l-1.jpg';
                    break;
                case 8:
                    if($target->category == 3)
                        $target = 'adab/ghazamahali/' . $target->file . '/l-1.jpg';
                    else
                        $target = 'adab/soghat/' . $target->file . '/l-1.jpg';;

                    break;
            }

            if(!file_exists((__DIR__ . '/../../../../assets/_images/' . $target)))
                echo URL::asset('images/mainPics/noPicSite.jpg');
            else
                echo URL::asset('_images/' . $target);
        }

    }

    public function getPlaceKinds() {
        echo json_encode(Place::whereVisibility(1)->get());
    }

    public function getStates() {
        echo json_encode(State::all());
    }

    public function getGoyesh() {
        echo json_encode(GoyeshCity::all());
    }

    public function searchEstelah() {

        if(isset($_POST["goyesh"]) && isset($_POST["key"]) && isset($_POST["mode"])) {

            $goyesh = makeValidInput($_POST["goyesh"]);
            $key = makeValidInput($_POST["key"]);
            $mode = makeValidInput($_POST["mode"]);

            if($mode == 1) {
                if ($goyesh != -1)
                    echo json_encode(DB::select("select estelah, talafoz, maani from estelahat WHERE goyeshId = " . $goyesh . " and estelah LIKE '%$key%'"));
                else
                    echo json_encode(DB::select("select estelah, talafoz, maani from estelahat WHERE estelah LIKE '%$key%'"));
            }
            else {
                if ($goyesh != -1)
                    echo json_encode(DB::select("select estelah, talafoz, maani from estelahat WHERE goyeshId = " . $goyesh . " and maani LIKE '%$key%'"));
                else
                    echo json_encode(DB::select("select estelah, talafoz, maani from estelahat WHERE maani LIKE '%$key%'"));
            }
        }

    }

    public function getCitiesDir() {

        $stateId = makeValidInput($_POST["stateId"]);

        echo json_encode(Cities::where('stateId',$stateId)->get());
    }

    public function searchPlace() {
        $places = [];
        $value = $_GET['value'];
        if(isset($_GET['kindPlaceId']) && $_GET['kindPlaceId'] == "all")
            $kindPlace = Place::whereNotNull('tableName')->where('id', '!=', 13)->get();
        else if(isset($_GET['kindPlaceId']))
            $kindPlace = Place::whereIn('id', [$_GET['kindPlaceId']])->get();
        else
            $kindPlace = Place::whereIn('id', [1, 3, 4, 6, 12])->get();

        foreach ($kindPlace as $kind){
            if($kind->id == 11 || $kind->id == 10)
                $pds = \DB::select("SELECT `id`, `name`, `cityId` FROM $kind->tableName WHERE `name` LIKE '%".$value."%'");
            else
                $pds = \DB::select("SELECT `id`, `name`, `C`, `D`, `cityId` FROM $kind->tableName WHERE `name` LIKE '%".$value."%'");

            foreach ($pds as $item){
                $city = Cities::find($item->cityId);
                $item->city = $city->name;
                $item->state = $city->getState->name;
                $item->kindPlaceId = $kind->id;
                $item->kindPlaceName = $kind->tableName;
                array_push($places, $item);
            }
        }

        return response()->json(['status' => 'ok', 'result' => $places]);
    }

    public function searchForCity(Request $request) {
        $result = [];
        $key = $request->key;
        if(isset($request->state) && $request->state == 1)
            $result = DB::select("SELECT state.id, state.name as stateName FROM state WHERE state.name LIKE '%$key%' ");

        foreach ($result as $item)
            $item->kind = 'state';

        $cities = DB::select("SELECT cities.id, cities.name as cityName, state.name as stateName, cities.isVillage as isVillage FROM cities, state WHERE cities.stateId = state.id AND isVillage = 0 AND cities.name LIKE '%$key%' ");
        foreach ($cities as $item) {
            $item->kind = 'city';
            array_push($result, $item);
        }

        if(isset($request->village) && $request->village == 1) {
            $village = DB::select("SELECT cities.id, cities.name as cityName, state.name as stateName, cities.isVillage as isVillage FROM cities, state WHERE cities.stateId = state.id AND isVillage != 0 AND cities.name LIKE '%$key%' ");
            foreach ($village as $item) {
                $item->kind = 'village';
                array_push($result, $item);
            }
        }
        echo json_encode($result);
        return;
    }

    public function searchForLine() {

        if(isset($_POST["key"]) && isset($_POST["mode"])) {

            $key = makeValidInput($_POST["key"]);
            $mode = makeValidInput($_POST["mode"]);

            $mode = explode(',', $mode)[0];

            if($mode == "train" || $mode == "train_phone") {
                $results = DB::select("select name from train WHERE name LIKE '%$key%'");

                if($results == null || count($results) == 0) {

                    $city = DB::select("select x, y from cities WHERE name LIKE '$key'");

                    if($city != null && count($city) > 0) {
                        $C = $city[0]->x * 3.14 / 180;
                        $D = $city[0]->y * 3.14 / 180;

                        $results = DB::select("select 'near' as mode, 'راه آهن' as place, t.name, acos(" . sin($D) . " * sin(c.y / 180 * 3.14) + " . cos($D) . " * cos(c.y / 180 * 3.14) * cos(c.x / 180 * 3.14 - " . $C . ")) * 6371 as distance from train t, cities c where c.id = t.cityId order by distance ASC limit 0, 5");
                    }
                }
            }
            elseif($mode == "internalFlight" || $mode == "internalFlight_phone") {
                $results = DB::select("select 'exact' as mode, concat(name, ' - ' ,abbreviation) as name from airLine WHERE name LIKE '%$key%'");
                if($results == null || count($results) == 0) {

                    $city = DB::select("select x, y from cities WHERE name LIKE '$key'");

                    if($city != null && count($city) > 0) {

                        $C = $city[0]->x * 3.14 / 180;
                        $D = $city[0]->y * 3.14 / 180;

                        $results = DB::select("select 'near' as mode, 'فرودگاه' as place, concat(a.name, ' - ' ,a.abbreviation) as name, acos(" . sin($D) . " * sin(c.y / 180 * 3.14) + " . cos($D) . " * cos(c.y / 180 * 3.14) * cos(c.x / 180 * 3.14 - " . $C . ")) * 6371 as distance from airLine a, cities c where c.id = a.cityId order by distance ASC limit 0, 5");
                    }
                }
            }

            echo json_encode($results);
        }

    }

    public function searchForMyContacts() {

        $key = makeValidInput($_POST["key"]);
        $uId = Auth::user()->id;

        $users = DB::select("SELECT DISTINCT(users.username) FROM users, messages WHERE (senderId = " . $uId . " or receiverId = " . $uId . ") and (users.id = messages.senderId or users.id = messages.receiverId) and users.username LIKE '%$key%' ");
        echo json_encode($users);
        return;
    }

    public function proSearch(Request $request) {

        if(isset($_POST["hotelFilter"]) && isset($_POST["amakenFilter"]) && isset($_POST["restaurantFilter"])
            && isset($_POST["majaraFilter"]) && isset($_POST["mahaliFoodFilter"])
            && isset($_POST["key"]) && isset($_POST["selectedCities"]) && isset($_POST["sogatSanaieFilter"]) && isset($_POST["boomgardyFilter"])) {

            $cities = $_POST["selectedCities"];

            $cityConstraint = "";
            $allow = true;
            $key = $_POST["key"];

            if(isset($request->mode) && $request->mode == 'state'){
                $state = State::find($request->selectedCities);
                if($state != null){
                    $cities = Cities::where('stateId', $state->id)->get();
                    foreach ($cities as $city){
                        if ($city != null) {
                            if ($allow) {
                                $allow = false;
                                $cityConstraint .= $city->id;
                            } else
                                $cityConstraint .= "," . $city->id;
                        }
                    }
                }
            }
            elseif(isset($request->mode) && $request->mode == 'city') {
                if ($cities != -1) {
                    if(is_array($cities)) {
                        foreach ($cities as $city) {
                            $city = Cities::whereName($city)->first();

                            if ($city != null) {
                                if ($allow) {
                                    $allow = false;
                                    $cityConstraint .= $city->id;
                                } else
                                    $cityConstraint .= "," . $city->id;
                            }
                        }
                    }
                    else
                        $cityConstraint .= $cities;
                }
            }

            if($cityConstraint != '')
                $allow = false;
            else
                $allow = true;

            $target = [];
            if($_POST["hotelFilter"] == 1) {
                if($allow)
                    $target = DB::select("select hotels.name, hotels.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from hotels, cities, place, state WHERE place.name = 'هتل' and cities.id = cityId AND cities.stateId = state.id and hotels.name LIKE '%$key%'");
                else
                    $target = DB::select("select hotels.name, hotels.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from hotels, cities, place, state WHERE place.name = 'هتل' and cities.id = cityId  AND cities.stateId = state.id and hotels.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")");
            }
            if($_POST["amakenFilter"] == 1) {
                if($allow)
                    $target = array_merge($target, DB::select("select amaken.name, amaken.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from amaken, cities, place, state WHERE place.name = 'اماکن' and cities.id = cityId AND cities.stateId = state.id and amaken.name LIKE '%$key%'"));
                else
                    $target = array_merge($target, DB::select("select amaken.name, amaken.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from amaken, cities, place, state WHERE place.name = 'اماکن' and cities.id = cityId AND cities.stateId = state.id and amaken.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")"));
            }
            if($_POST["restaurantFilter"] == 1) {
                if($allow)
                    $target = array_merge($target, DB::select("select restaurant.name, restaurant.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from restaurant, cities, place, state WHERE place.name = 'رستوران' and cities.id = cityId AND cities.stateId = state.id and restaurant.name LIKE '%$key%'"));
                else
                    $target = array_merge($target, DB::select("select restaurant.name, restaurant.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from restaurant, cities, place, state WHERE place.name = 'رستوران' and cities.id = cityId AND cities.stateId = state.id and restaurant.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")"));
            }
            if($_POST["majaraFilter"] == 1) {
                if($allow)
                    $target = array_merge($target, DB::select("select majara.name, majara.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from majara, cities, place, state WHERE place.name = 'ماجرا' and cities.id = cityId AND cities.stateId = state.id and majara.name LIKE '%$key%'"));
                else
                    $target = array_merge($target, DB::select("select majara.name, majara.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from majara, cities, place, state WHERE place.name = 'ماجرا' and cities.id = cityId AND cities.stateId = state.id and majara.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")"));
            }
            if($_POST["sogatSanaieFilter"] == 1) {
                if($allow)
                    $target = array_merge($target, DB::select("select sogatSanaies.name, sogatSanaies.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from sogatSanaies, cities, place, state WHERE place.name = 'صنایع سوغات' and cities.id = cityId AND cities.stateId = state.id and sogatSanaies.name LIKE '%$key%'"));
                else
                    $target = array_merge($target, DB::select("select sogatSanaies.name, sogatSanaies.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from sogatSanaies, cities, place, state WHERE place.name = 'صنایع سوغات' and cities.id = cityId AND cities.stateId = state.id and  sogatSanaies.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")"));
            }
            if($_POST["mahaliFoodFilter"] == 1) {
                if($allow)
                    $target = array_merge($target, DB::select("select mahaliFood.name, mahaliFood.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from mahaliFood, cities, place, state WHERE place.name = 'غذای محلی' and cities.id = cityId AND cities.stateId = state.id and mahaliFood.name LIKE '%$key%'"));
                else
                    $target = array_merge($target, DB::select("select mahaliFood.name, mahaliFood.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from mahaliFood, cities, place, state WHERE place.name = 'غذای محلی' and cities.id = cityId AND cities.stateId = state.id and mahaliFood.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")"));
            }
            if($_POST["boomgardyFilter"] == 1) {
                if($allow)
                    $target = array_merge($target, DB::select("select boomgardies.name, boomgardies.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from boomgardies, cities, place, state WHERE place.name = 'بوم گردی' and cities.id = cityId AND cities.stateId = state.id and boomgardies.name LIKE '%$key%'"));
                else
                    $target = array_merge($target, DB::select("select boomgardies.name, boomgardies.id, cities.name as cityName, state.name as stateName, place.id as kindPlaceId, place.name as kindPlace from boomgardies, cities, place, state WHERE place.name = 'بوم گردی' and cities.id = cityId AND cities.stateId = state.id and boomgardies.name LIKE '%$key%' and cityId IN (" . $cityConstraint . ")"));
            }


            foreach ($target as $item)
                $item->url = route('placeDetails', ['kindPlaceId' => $item->kindPlaceId, 'placeId' => $item->id]);

            echo json_encode($target);
        }
        return;
    }

    public function findCityWithState()
    {
        if(isset($_GET['stateId']) && isset($_GET["value"])){
            $city = Cities::where('stateId', $_GET['stateId'])->where('name', 'LIKE', '%'.$_GET["value"].'%')->get();
            foreach ($city as $item){
                $item->state = $item->getState;
                if(is_file(__DIR__.'/../../../../assets/_images/city/'.$item->image))
                    $item->pic = URL::asset('_images/city/'.$item->image);
                else
                    $item->pic = URL::asset('images/mainPics/noPicSite.jpg');
            }
            return response()->json(['status' => 'ok', 'result' => $city]);
        }
        return response()->json(['status' => 'nok']);
    }

    public function searchSpecificKindPlace()
    {
        $place = [];
        if($_GET['kindPlaceId'] == 0){
            $kindPlaceses = Place::whereNotNull('tableName')->where('mainSearch', 1)->get();
            foreach ($kindPlaceses as $kindPlace){
                if($kindPlace->id == 10 || $kindPlace->id == 11)
                    $select = ['id', 'name', 'picNumber', 'cityId', 'file'];
                else
                    $select = ['id', 'name', 'picNumber', 'cityId', 'file', 'C', 'D'];
                $pl = \DB::table($kindPlace->tableName)->where('name', 'LIKE', '%' . $_GET["value"] . '%')->select($select)->get();
                foreach ($pl as $item) {
                    $item->kindPlaceId = $kindPlace->id;
                    $item->fileName = $kindPlace->fileName;
                    array_push($place, $item);
                }
            }
        }
        else {
            $kindPlace = Place::find($_GET['kindPlaceId']);
            if($kindPlace->id == 10 || $kindPlace->id == 11)
                $select = ['id', 'name', 'picNumber', 'cityId', 'file'];
            else
                $select = ['id', 'name', 'picNumber', 'cityId', 'file', 'C', 'D'];

            $place = \DB::table($kindPlace->tableName)->where('name', 'LIKE', '%' . $_GET["value"] . '%')->select($select)->get();
            foreach ($place as $item) {
                $item->kindPlaceId = $kindPlace->id;
                $item->fileName = $kindPlace->fileName;
            }
        }

        foreach ($place as $item){
            $item->city = Cities::find($item->cityId);
            if($item->city != null)
                $item->state = $item->city->getState;

            if(file_exists(__DIR__ . '/../../../../assets/_images/'.$item->fileName.'/'.$item->file.'/l-'.$item->picNumber))
                $item->pic = URL::asset('_images/'.$item->fileName.'/'.$item->file.'/l-'.$item->picNumber);
            else
                $item->pic = URL::asset('images/mainPics/noPicSite.jpg');
        }
        return response()->json(['status' => 'ok', 'result' => $place]);
    }


    public function findKoochitaAccount(Request $request)
    {
        if(isset($request->email)){
            $user = User::where('email', $request->email)->get();

            if($user != null && count($user) != 0)
                echo 'ok';
            else
                echo 'nok';

            return;
        }
    }

    public function findUser()
    {
        $value = $_GET['username'];

        $userEmail = [];
        if(\auth()->check())
            $iUserId = \auth()->user()->id;
        else
            $iUserId = 0;

        $userName = User::where('username', 'LIKE', '%' . $value . '%')->select(['id', 'username'])->get();
        foreach ($userName as $user){
            $user->userId = $user->id;
            $user->url = route('profile', ['username' => $user->username]);
            $user->pic = getUserPic($user->id);
            $user->followed = Followers::where('userId', $iUserId)->where('followedId', $user->id)->count();
            $user->notMe = 1;
            if($user->id == $iUserId)
                $user->notMe = 0;
        }
        if($userName == null && $userEmail == null)
            return response()->json(['status' => 'nok3']);
        else
            return response()->json(['status' => 'ok', 'result' => ['email' => $userEmail, 'userName' => $userName]]);
    }

    public function likeLog(Request $request)
    {
        if(\auth()->check()) {
            if (isset($request->logId) && isset($request->like)) {
                $u = Auth::user();
                $condition = ['userId' => $u->id, 'logId' => $request->logId];
                $like = LogFeedBack::where($condition)->first();

                $subject = '';

                if($like != null && $like->like == $request->like){
                    Alert::where('referenceTable', 'logFeedBack')->where('referenceId', $like->id)->delete();
                    $like->delete();
                    $status = 'delete';
                }
                else{
                    if($like == null){
                        $like = new LogFeedBack();
                        $like->logId = $request->logId;
                        $like->userId = $u->id;
                    }

                    $like->like = $request->like == 1 ? 1 : -1;
                    $like->save();

                    if($like->like == 1) $subject = 'like';
                    elseif($like->like == -1) $subject = 'dislike';

                    $log = LogModel::find($request->logId);
                    $actId = Activity::find($log->activityId);
                    $subject .= $actId->name == 'نظر' ? 'Review' : 'Ans';

                    $alert = new Alert();
                    $alert->subject = $subject;
                    $alert->referenceTable = 'logFeedBack';
                    $alert->referenceId = $like->id;
                    $alert->userId = $log->visitorId;
                    $alert->save();

                    $status = 'ok';
                }

                $like = LogFeedBack::where('logId', $request->logId)->where('like', 1)->count();
                $dislike = LogFeedBack::where('logId', $request->logId)->where('like', -1)->count();

                echo json_encode([$status, $like, $dislike]);
            }
            else
                echo json_encode(['nok2']);
        }
        else
            echo json_encode(['nok1']);

        return;
    }


    public function getMainPageSuggestion()
    {
        $lastPages = json_decode($_GET['lastPage']);
        $lastState = [];

        $reviewId = Activity::where('name', 'نظر')->first()->id;
        $ansId = Activity::where('name', 'پاسخ')->first()->id;

        $kindPlaceId = [1, 3, 4, 6, 10, 11, 12];
        $result = array();

        for($i = 0; $i < count($kindPlaceId); $i++){
            $kindPlace = Place::find($kindPlaceId[$i]);
            $place = DB::table($kindPlace->tableName)->latest('id')->first();
            $placeId = $place->id;
//            if(Carbon::now()->diffInWeeks($place->created_at) > 2){
//                $nPlaceId = \DB::select('SELECT MAX(`date`), placeId, kindPlaceId, activityId, id FROM `log` WHERE kindPlaceId = ' . $kindPlace->id . ' AND ( activityId = '.$reviewId.' OR activityId = ' . $ansId . ' ) ORDER BY `date` DESC' );
//                if($nPlaceId[0]->placeId != null)
//                    $placeId = $nPlaceId[0]->placeId;
//            }

            $place = createSuggestionPack($kindPlaceId[$i], $placeId);
            if($place != null)
                array_push($result, $place);
        }

        $topFoodId = [];
        $topMajaraId = [];
        $topRestuarantId = [];
        $topAmakenId = [];
        $topBazarId = [];
        $safarnamehId = [];
        $today = getToday()['date'];

        if($lastPages != null){
            foreach ($lastPages as $lp){
                if(!in_array($lp, $lastState) && $lp != null && count($lastState) < 3)
                    array_push($lastState, $lp);
            }
        }
        $lastStateId = State::whereIn('name', $lastState)->pluck('id')->toArray();

        $citiesId = [];
        foreach ($lastStateId as $lsi)
            array_push($citiesId, Cities::where('stateId', $lsi)->where('isVillage', 0)->pluck('id')->toArray());

        if(count($citiesId) > 0){
            $getCount = (int)(8 / count($citiesId))+1;
            foreach ($citiesId as $citId) {
                $resultWithCityId = $this->getMainPageSuggestionPackWithCityIds($citId, $getCount);
                $topFoodId = array_merge($topFoodId, $resultWithCityId[0]);
                $topMajaraId = array_merge($topMajaraId, $resultWithCityId[1]);
                $topRestuarantId = array_merge($topRestuarantId, $resultWithCityId[2]);
                $topAmakenId = array_merge($topAmakenId, $resultWithCityId[3]);
                $topBazarId = array_merge($topBazarId, $resultWithCityId[4]);
                $safarnamehId = array_merge($safarnamehId, $resultWithCityId[5]);
            }
        }
        else{
            $getCount = 8;
            $citId = [];

            $resultWithCityId = $this->getMainPageSuggestionPackWithCityIds($citId, $getCount);
            $topFoodId = array_merge($topFoodId, $resultWithCityId[0]);
            $topMajaraId = array_merge($topMajaraId, $resultWithCityId[1]);
            $topRestuarantId = array_merge($topRestuarantId, $resultWithCityId[2]);
            $topAmakenId = array_merge($topAmakenId, $resultWithCityId[3]);
            $topBazarId = array_merge($topBazarId, $resultWithCityId[4]);
            $safarnamehId = array_merge($safarnamehId, $resultWithCityId[5]);
        }

        $topFood = [];
        $topMajara = [];
        $topRestuarant = [];
        $topAmaken = [];
        $topBazar = [];
        foreach ($topFoodId as $item){
            $true = createSuggestionPack(11, $item);
            if($true != null)
                array_push($topFood, $true);
        }
        foreach ($topMajaraId as $item){
            $true = createSuggestionPack(6, $item);
            if($true != null)
                array_push($topMajara, $true);
        }
        foreach ($topRestuarantId as $item){
            $true = createSuggestionPack(3, $item);
            if($true != null)
                array_push($topRestuarant, $true);
        }
        foreach ($topAmakenId as $item){
            $true = createSuggestionPack(1, $item);
            if($true != null)
                array_push($topAmaken, $true);
        }
        foreach ($topBazarId as $item){
            $true = createSuggestionPack(1, $item);
            if($true != null)
                array_push($topBazar, $true);
        }

        $safarnameh = Safarnameh::whereIn('id', $safarnamehId)
                                ->select(['id', 'title', 'slug', 'meta', 'pic', 'date', 'userId', 'keyword', 'seen'])
                                ->get();
        foreach ($safarnameh as $item){
            $item = SafarnamehMinimalData($item);
            $item->name = $item->title;
            $item->review = $item->msgs;
            $item->section = 'مقالات';
        }


//        $today = getToday()['date'];
//        $activityId1 = Activity::where('name', 'نظر')->first()->id;
//        $activityId2 = Activity::where('name', 'پاسخ')->first()->id;
//        $commentCount = 0;
//        $commentCount += LogModel::where('activityId', $activityId1)->where('confirm', 1)->count();
//        $commentCount += LogModel::where('activityId', $activityId2)->where('confirm', 1)->count();
//        $commentCount += SafarnamehComments::where('confirm', 1)->count();
//        $userCount = \App\models\User::all()->count();
//
//        $counts = [ 'hotel' => Hotel::all()->count(),
//                    'restaurant' => Restaurant::all()->count(),
//                    'amaken' => Amaken::all()->count(),
//                    'sogatSanaie' => SogatSanaie::all()->count(),
//                    'mahaliFood' => MahaliFood::all()->count(),
//                    'safarnameh' => Safarnameh::where('date', '<=', $today)->where('release', '!=', 'draft')->count(),
//                    'comment' => $commentCount,
//                    'userCount' => $userCount,
//                    'boomgardy' => Boomgardy::all()->count()
//                ];
        $counts = [];
        return response()->json(['result' => $result, 'safarnameh' => $safarnameh,
                                'topFood' => $topFood, 'majara' => $topMajara,
                                'restaurant' => $topRestuarant, 'amaken' => $topAmaken,
                                'bazar' => $topBazar, 'count' => $counts]);
    }

    private function getMainPageSuggestionPackWithCityIds($cityIds, $getCount){

        if(count($cityIds) > 0)
            $foodId = MahaliFood::whereIn('cityId', $cityIds)->pluck('id')->toArray();
        else
            $foodId = MahaliFood::pluck('id')->toArray();
        $allFoodId = MahaliFood::pluck('id')->toArray();
        $foodId = $this->getPlaceInKindPlaceId($foodId, $allFoodId, 11, $getCount);

        if(count($cityIds) > 0)
            $majaraId = Majara::whereIn('cityId', $cityIds)->pluck('id')->toArray();
        else
            $majaraId = Majara::pluck('id')->toArray();
        $allMajara = Majara::pluck('id')->toArray();
        $majaraId = $this->getPlaceInKindPlaceId($majaraId, $allMajara, 6, $getCount);

        if(count($cityIds) > 0)
            $restId = Restaurant::whereIn('cityId', $cityIds)->pluck('id')->toArray();
        else
            $restId = Restaurant::pluck('id')->toArray();
        $allRest = Restaurant::pluck('id')->toArray();
        $restId = $this->getPlaceInKindPlaceId($restId, $allRest,3, $getCount);

        $amakenFeatParent = PlaceFeatures::where('name', 'کاربری')->where('kindPlaceId', 1)->where('parent', 0)->first()->id;
        $amakenFeat = PlaceFeatures::where('parent', $amakenFeatParent)->where(function($query){
            $query->where('name', 'تاریخی')->orWhere('name', 'مذهبی');
        })->pluck('id')->toArray();
        $allAmakenId = PlaceFeatureRelation::where('kindPlaceId', 1)->whereIn('featureId', $amakenFeat)->pluck('placeId')->toArray();
        if(count($allAmakenId) > 0){
            if(count($cityIds) > 0)
                $regionalId = Amaken::whereIn('id', $allAmakenId)->whereIn('cityId', $cityIds)->pluck('id')->toArray();
            else
                $regionalId = Amaken::whereIn('id', $allAmakenId)->pluck('id')->toArray();

            $regionalId = $this->getPlaceInKindPlaceId($regionalId, $allAmakenId, 1, $getCount);
        }

        $amakenFeat = PlaceFeatures::where('parent', $amakenFeatParent)->where('name', 'تجاری')->pluck('id')->toArray();
        $allAmakenId = PlaceFeatureRelation::where('kindPlaceId', 1)->whereIn('featureId', $amakenFeat)->pluck('placeId')->toArray();
        if(count($allAmakenId) > 0){
            if(count($cityIds) > 0)
                $bazarId = Amaken::whereIn('id', $allAmakenId)->whereIn('cityId', $cityIds)->pluck('id')->toArray();
            else
                $bazarId = Amaken::whereIn('id', $allAmakenId)->pluck('id')->toArray();
            $bazarId = $this->getPlaceInKindPlaceId($bazarId, $allAmakenId, 1, $getCount);
        }

        if(count($cityIds) > 0)
            $safarnamehIds = SafarnamehCityRelations::whereIn('cityId', $cityIds)->pluck('safarnamehId')->toArray();
        else
            $safarnamehIds = SafarnamehCityRelations::pluck('safarnamehId')->toArray();

        $today = getToday()['date'];
        $safarnameh = Safarnameh::where('date', '<=', $today)
            ->where('release', '!=', 'draft')
            ->where('confirm', 1)
            ->whereIn('id', $safarnamehIds)
            ->orderBy('date', 'DESC')
            ->take('8')
            ->pluck('id')
            ->toArray();

        if(count($safarnameh) < 8){
            $remind = 8 - count($safarnameh);
            $safarnameh = Safarnameh::where('date', '<=', $today)
                ->where('release', '!=', 'draft')
                ->where('confirm', 1)
                ->whereNotIn('id', $safarnamehIds)
                ->orderBy('date', 'DESC')
                ->take($remind)
                ->pluck('id')
                ->toArray();
        }

        return [$foodId, $majaraId, $restId, $regionalId, $bazarId, $safarnameh];
    }

    private function getPlaceInKindPlaceId($placeId, $allPlace, $kindPlaceId, $getCount){
        $questionRate = Question::where('ansType', 'rate')->pluck('id')->toArray();
        $reviewId = Activity::where('name', 'نظر')->first()->id;
        $ansId = Activity::where('name', 'پاسخ')->first()->id;
        $quesActivityId = Activity::where('name', 'سوال')->first()->id;
        $seeActivityId = Activity::where('name', 'مشاهده')->first()->id;

        if (count($placeId) > $getCount) {
            $topInCity = $this->getTopInIds($kindPlaceId, $placeId, $getCount, $questionRate, $reviewId, $ansId, $quesActivityId);
            $placeId = [];
            if (count($topInCity) > 0)
                $placeId = array_merge($placeId, $topInCity);
        }
        else{
            $notIn = $placeId;
            if(count($placeId) == 0)
                $notIn = [0];
            $remind = $getCount - count($placeId);
            $kinPlace = Place::find($kindPlaceId);
            $allPlaces = \DB::table($kinPlace->tableName)->whereIn('id', $allPlace)->whereNotIn('id', $notIn)->pluck('id')->toArray();

            $topInCity = $this->getTopInIds($kindPlaceId, $allPlaces, $remind, $questionRate, $reviewId, $ansId, $quesActivityId);
            if (count($topInCity) > 0)
                $placeId = array_merge($placeId, $topInCity);
        }

        return $placeId;
    }

    private function getTopInIds($_kindPlaceId, $_placeIds, $getCount, $questionRate, $reviewId, $ansId, $quesActivityId, $seeActivityId = ''){

        if (count($_placeIds) == 0)
            $_placeIds = [0];

        $topIdInCity = [];
        if($seeActivityId != '')
            $p = DB::select('SELECT log.placeId as placeId, COUNT(log.id) as `count` FROM log WHERE log.kindPlaceId = ' . $_kindPlaceId . ' AND log.placeId IN (' . implode(",", $_placeIds) . ') AND log.activityId = '. $seeActivityId . ' GROUP BY log.placeId ORDER BY `count` DESC LIMIT ' . $getCount);
        else
            $p = DB::select('SELECT log.placeId as placeId, AVG(qua.ans) as rate FROM log INNER JOIN questionUserAns AS qua ON log.kindPlaceId = ' . $_kindPlaceId . ' AND log.placeId IN (' . implode(",", $_placeIds) . ') AND qua.questionId IN (' . implode(",", $questionRate) . ') AND qua.logId = log.id GROUP BY log.placeId ORDER BY rate DESC LIMIT ' . $getCount);

        foreach ($p as $item)
            array_push($topIdInCity, $item->placeId);
        $remind = $getCount - count($topIdInCity);

        if($remind > 0){
            if(count($topIdInCity) == 0)
                $topIdInCity = [0];

            $p = DB::select('SELECT log.placeId as placeId, COUNT(log.id) as `count` FROM log WHERE log.kindPlaceId = ' . $_kindPlaceId . ' AND log.placeId IN (' . implode(",", $_placeIds) . ') AND log.placeId NOT IN (' . implode(",", $topIdInCity) . ') AND (log.activityId = '. $reviewId . ' OR log.activityId = ' . $ansId . ' OR log.activityId = ' . $quesActivityId . ')  GROUP BY log.placeId ORDER BY `count` DESC LIMIT ' . $remind);
            foreach ($p as $item)
                array_push($topIdInCity, $item->placeId);
        }

        $remind = $getCount - count($topIdInCity);
        if($remind > 0){
            if($topIdInCity[0] == 0)
                $topIdInCity = [];

            while($getCount - count($topIdInCity) > 0 && count($_placeIds) > count($topIdInCity)){
                $randId = $_placeIds[rand(0, count($_placeIds)-1)];
                while(in_array($randId, $topIdInCity))
                    $randId = $_placeIds[rand(0, count($_placeIds)-1)];

                array_push($topIdInCity, $randId);
            }
        }

        return $topIdInCity;
    }

    public function getTags(Request $request)
    {
        $tag = $request->tag;
        $tags = [];

        if(strlen($tag) != 0 ) {
            $similar = Tag::where('name', 'LIKE', '%' . $tag . '%')->where('name', '!=', $tag)->get();

            foreach ($similar as $t) {
                array_push($tags, [
                    'name' => $t->name,
                    'id' => $t->id
                ]);
            }

            $same = Tag::where('name', $tag)->first();
            if($same == null)
                $same = 0;
            else{
                $same = [
                    'name' => $same->name,
                    'id' => $same->id
                ];
            }
            echo json_encode(['tags' => $tags, 'send' => $tag, 'same' => $same]);
        }

        return;
    }

    public function searchSuggestion(Request $request)
    {
        $inPlace = [];
        $kindPlace = $request->kindPlace;
        if($kindPlace == 'state' || $kindPlace == 'village' || $kindPlace == 'city'){
            if($kindPlace == 'state'){
                $result = State::where('name', 'LIKE', '%'.$request->text.'%')->get();
                foreach ($result as $item)
                    array_push($inPlace, ['kindPlaceId' => 'state', 'kindPlaceName' => '', 'placeId' => $item->id, 'name' => 'استان ' . $item->name, 'pic' => getStatePic($item->id, 0), 'state' => '']);
            }
            else if($kindPlace == 'city'){
                $result = Cities::where('name', 'LIKE','%'.$request->text.'%')->where('isVillage', 0)->get();

                foreach ($result as $item) {
                    $state = State::find($item->stateId);
                    array_push($inPlace, ['kindPlaceId' => 'city', 'kindPlaceName' => '', 'placeId' => $item->id, 'name' => 'شهر ' . $item->name, 'pic' => getStatePic($item->id, 0), 'state' => 'در استان ' . $state->name]);
                }
            }
            else{
                $result = Cities::where('name', 'LIKE', '%'.$request->text.'%')->where('isVillage','!=', 0)->get();
                foreach ($result as $item) {
                    $state = State::find($item->stateId);
                    $city = Cities::find($item->isVillage);
                    array_push($inPlace, ['kindPlaceId' => 'city', 'kindPlaceName' => '', 'placeId' => $item->id, 'name' => 'شهر ' . $item->name, 'pic' => getStatePic($item->id, 0), 'state' => 'در استان ' . $state->name . ' ، در شهر ' . $city->name]);
                }
            }
        }
        else{
            $kindPlace = Place::where('tableName', $kindPlace)->first();
            $places = \DB::table($kindPlace->tableName)->where('name', 'LIKE','%'.$request->text.'%')->get();
            foreach ($places as $pl){
                $pic = getPlacePic($pl->id, $kindPlace->id, 'f');
                $cit = Cities::find($pl->cityId);
                $sta = State::find($cit->stateId);
                $stasent = 'استان ' . $sta->name . ' ، شهر' . $cit->name;
                array_push($inPlace, ['kindPlaceId' => $kindPlace->id, 'kindPlaceName' => $kindPlace->name, 'placeId' => $pl->id, 'name' => $pl->name, 'pic' => $pic, 'state' => $stasent]);
            }
        }

        echo json_encode(['status' => 'ok', 'result' => $inPlace]);
        return ;
    }
}
