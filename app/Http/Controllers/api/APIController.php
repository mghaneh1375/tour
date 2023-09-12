<?php

namespace App\Http\Controllers\api;

use App\models\AboutMe;
use App\models\ActivationCode;
use App\models\Activity;
use App\models\Adab;
use App\models\Age;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\Comment;
use App\models\DefaultPic;
use App\models\GoyeshCity;
use App\models\places\Hotel;
use App\models\InvitationCode;
use App\models\Level;
use App\models\LogModel;
use App\models\places\Majara;
use App\models\Medal;
use App\models\Message;
use App\models\Oauth_access_tokens;
use App\models\OpOnActivity;
use App\models\places\Place;
use App\models\places\PlaceStyle;
use App\models\Question;
use App\models\places\Restaurant;
use App\models\State;
use App\models\Tag;
use App\models\User;
use Carbon\Carbon;
use DB;
use Exception;
use Firebase\JWT\JWT;
use Google_Client;
use Google_Service_Oauth2;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use URL;

class APIController extends Controller {

    private $content;
    private static $sharedKey = "myTokenSharedKeyMammadKia";

    private static function createToken() {
        $time = time();
        return [hash("sha256", self::$sharedKey . $time), $time];
    }

    private static function checkToken($token, $time) {

        if(time() - $time > 180)
            return false;

        $hash = hash("sha256", self::$sharedKey . $time);

        if($hash != $token)
            return false;

        return true;
    }

    public function __construct(){
        $this->content = array();
    }


    public function totalSearchAPI() {

        if(isset($_POST["param"])) {

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            $kindPlaceId = -1;
            $key = -1;

            foreach ($param as $k => $value){

                switch ($k) {
                    case "kindPlaceId":
                        $kindPlaceId = $value;
                        break;
                    case "key":
                        $key = $value;
                        break;
                }
            }

            if($kindPlaceId == -1 || $key == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
            }

            switch ($kindPlaceId) {
                case 1:
                default:
                    $route = "amakenList";
                    break;
                case 3:
                    $route = "restaurantList";
                    break;
                case 4:
                    $route = "hotelList";
                    break;
            }

            $key = str_replace(' ', '', $key);
            $key2 = (isset($_POST["key2"]) ? makeValidInput($_POST["key2"]) : '');
            $key2 = str_replace(' ', '', $key2);

            if(!empty($key2))
                $result = DB::select("SELECT name as targetName from state WHERE replace(name, ' ', '') LIKE '%$key%' or replace(name, ' ', '') LIKE '%$key2%'");
            else
                $result = DB::select("SELECT name as targetName from state WHERE replace(name, ' ', '') LIKE '%$key%'");

            foreach ($result as $itr) {
                $itr->mode = "state";
                $itr->url = route($route, ['city' => $itr->targetName, 'mode' => 'state']);
            }

            if(!empty($key2))
                $tmp = DB::select("SELECT cities.name as targetName, state.name as stateName from cities, state WHERE (replace(cities.name, ' ', '') LIKE '%$key%' or replace(cities.name, ' ', '') LIKE '%$key2%') and
					stateId = state.id");
            else
                $tmp = DB::select("SELECT cities.name as targetName, state.name as stateName from cities, state WHERE replace(cities.name, ' ', '') LIKE '%$key%' and
					stateId = state.id");

            foreach ($tmp as $itr) {
                $itr->mode = "city";
                $itr->url = route($route, ['city' => $itr->targetName, 'mode' => 'city']);
            }
            $result = array_merge($result, $tmp);

            switch ($kindPlaceId) {
                case 1:
                default:
                    if(!empty($key2))
                        $tmp = DB::select("SELECT amaken.id, amaken.name as targetName, cities.name as cityName, state.name as stateName from amaken, cities, state WHERE cityId = cities.id and state.id = cities.stateId and (replace(amaken.name, ' ', '') LIKE '%$key%' or replace(amaken.name, ' ', '') LIKE '%$key2%')");
                    else
                        $tmp = DB::select("SELECT amaken.id, amaken.name as targetName, cities.name as cityName, state.name as stateName from amaken, cities, state WHERE cityId = cities.id and state.id = cities.stateId and replace(amaken.name, ' ', '') LIKE '%$key%'");
                    foreach ($tmp as $itr) {
                        $itr->mode = "amaken";
                        $itr->url = route('amakenDetails', ['placeId' => $itr->id, 'placeName' => $itr->targetName]);
                    }
                    break;
                case 3:
                    if(!empty($key2))
                        $tmp = DB::select("SELECT restaurant.id, restaurant.name as targetName, cities.name as cityName, state.name as stateName from restaurant, cities, state WHERE cityId = cities.id and state.id = cities.stateId and (replace(restaurant.name, ' ', '') LIKE '%$key%' or replace(restaurant.name, ' ', '') LIKE '%$key2%')");
                    else
                        $tmp = DB::select("SELECT restaurant.id, restaurant.name as targetName, cities.name as cityName, state.name as stateName from restaurant, cities, state WHERE cityId = cities.id and state.id = cities.stateId and replace(restaurant.name, ' ', '') LIKE '%$key%'");
                    foreach ($tmp as $itr) {
                        $itr->mode = "restaurant";
                        $itr->url = route('restaurantDetails', ['placeId' => $itr->id, 'placeName' => $itr->targetName]);
                    }
                    break;
                case 4:
                    $tmp = DB::select("SELECT hotels.id, hotels.name as targetName, cities.name as cityName, state.name as stateName from hotels, cities, state WHERE cityId = cities.id and state.id = cities.stateId and (replace(hotels.name, ' ', '') LIKE '%$key%' or replace(hotels.name, ' ', '') LIKE '%$key2%')");
                    foreach ($tmp as $itr) {
                        $itr->mode = "hotel";
                        $itr->url = route('hotelDetails', ['placeId' => $itr->id, 'placeName' => $itr->targetName]);
                    }
                    break;
            }

            $result = array_merge($result, $tmp);

            echo json_encode(['places' => $result]);
        }
    }

    public function getHotelListElemsAPI() {

        $city = $mode = $currPage = $kind_id = -1;
        $sort = "rate";

        if(isset($_POST["param"])) {

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value){

                switch ($k) {
                    case "pageNum":
                        $currPage = $value;
                        break;
                    case "sort":
                        $sort = $value;
                        break;
                    case "kind_id":
                        $kind_id = $value;
                        break;
                    case "city":
                        $city = $value;
                        break;
                    case "mode":
                        $mode = $value;
                        break;
                }
            }
        }

        if($city == -1 || $mode == -1 || $currPage == -1) {
            echo json_encode(["err" => "format err"]);
            return;
        }

        $z = "1 = 1 ";

        if ($kind_id != -1) {

            $name = $kind_id;

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
                $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, COUNT(*) as matches from hotels, log, activity WHERE " . $z . " cityId = " . $city->id . " and activity.id = " . $activityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 4 offset " . (($currPage - 1) * 4));
            elseif ($sort == "rate")
                $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, AVG(userOpinions.rate) as avgRate from hotels, log, activity, userOpinions WHERE " . $z . " cityId = " . $city->id . " and activity.id = " . $rateActivityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id GROUP BY(log.placeId) HAVING avgRate > 2 ORDER by avgRate DESC limit 4 offset " . (($currPage - 1) * 4));
            else
                $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1 from hotels WHERE " . $z . " cityId = " . $city->id . " ORDER by hotels.name ASC limit 4 offset " . (($currPage - 1) * 4));

            $reminder = 4 - count($hotels);

            if($reminder > 0) {
                if ($sort == "review")
                    $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1 from hotels where " . $z . " not exists (Select * from log WHERE " . $z . " cityId = " . $city->id . " and log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . ") and cityId = " . $city->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                else if($sort == "rate")
                    $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1 from hotels where " . $z . " not exists (Select * from log, userOpinions WHERE " . $z . " cityId = " . $city->id . " and log.activityId = " . $rateActivityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id) and cityId = " . $city->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
            }
        }
        else {

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
                $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, COUNT(*) as matches from hotels, cities, state, log, activity WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " and activity.id = " . $activityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 4 offset " . (($currPage - 1) * 4));
            elseif ($sort == "rate")
                $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, AVG(userOpinions.rate) as avgRate from hotels, cities, state, log, activity, userOpinions WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " and activity.id = " . $rateActivityId . " and log.activityId = activity.id and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id GROUP BY(log.placeId) HAVING avgRate > 2 ORDER by avgRate DESC limit 4 offset " . (($currPage - 1) * 4));
            else
                $hotels = DB::select("Select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1 from hotels, cities, state WHERE " . $z . " cityId = cities.id and state.id = stateId and state.id = " . $state->id . " ORDER by hotels.name ASC limit 4 offset " . (($currPage - 1) * 4));

            $reminder = 4 - count($hotels);
            if($reminder > 0) {
                if ($sort == "review")
                    $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1 from hotels, cities, state where " . $z . " not exists (Select * from log WHERE " . $z . " cityId = cities.id and stateId = " . $state->id . " and log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . ") and cityId = cities.id and state.id = stateId and state.id = " . $state->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                else if($sort == "rate") {
                    $hotels = array_merge($hotels, DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1 from hotels, cities, state where " . $z . " not exists (Select * from log, userOpinions WHERE " . $z . " cityId = cities.id and stateId = " . $state->id . " and log.activityId = " . $rateActivityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " and userOpinions.logId = log.id) and cityId = cities.id and state.id = stateId and state.id = " . $state->id . " limit " . $reminder . " offset " . (($currPage - 1) * 4)));
                }
            }
        }

        foreach ($hotels as $hotel) {

            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $hotel->file . '/f-1.jpg')))
                $hotel->pic = URL::asset('_images/hotels/' . $hotel->file . '/f-1.jpg');
            else
                $hotel->pic = URL::asset('images/mainPics/noPicSite.jpg');

            $condition = ['placeId' => $hotel->id, 'kindPlaceId' => $kindPlaceId,
                'activityId' => $activityId];
            $hotel->reviews = LogModel::where($condition)->count();
            $cityObj = Cities::whereId($hotel->cityId);
            $hotel->city = $cityObj->name;
            $hotel->state = State::whereId($cityObj->stateId)->name;
            $hotel->avgRate = getRate($hotel->id, $kindPlaceId)[1];
        }

        if ($sort == "rate") {
            usort($hotels, function ($a, $b) {
                return $b->avgRate - $a->avgRate;
            });
        }
        echo \GuzzleHttp\json_encode(['places' => $hotels]);
    }

    public function getStates() {
        echo json_encode(['states' => State::all()]);
    }

    public function getCitiesAPI() {

        if(isset($_POST["param"])) {

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            $stateId = -1;

            foreach ($param as $k => $value){

                switch ($k) {
                    case "stateId":
                        $stateId = $value;
                        break;
                }
            }

            if($stateId != -1)
                echo json_encode(['cities' => Cities::where('stateId',$stateId)->get()]);
        }
    }

    public function login() {

        if(isset($_POST["param"])) {

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            $username = $password = -1;

            foreach ($param as $k => $value){

                switch ($k) {
                    case "username":
                        $username = $value;
                        break;
                    case "password":
                        $password = $value;
                        break;
                }
            }

            if($username != -1 && $password != -1 && Auth::attempt(['username' => $username, 'password' => $password], true)){
                $user = Auth::user();

                $token = Oauth_access_tokens::where('user_id', '=', $user->id)->first();

                if($token == null || Carbon::now() > $token->expires_at) {
                    Oauth_access_tokens::where('user_id', '=', $user->id)->delete();
                    $this->content['token'] =  $user->createToken('BogenDesign1982')->accessToken;
                    $user->api_token = $this->content['token'];
                    $user->save();
                }
                else {
                    $this->content['msg'] = 'token has been created';
                }

                $status = 200;
            }
            else {
                $this->content['error'] = "Unauthorised";
                $status = 401;
            }
            return response()->json($this->content, $status);
        }
    }

    public function showProfile() {

        $user = Auth::user();
        $uId = $user->id;

        $user->created = convertDate($user->created_at);

        $activities = Activity::whereVisibility(1)->orderBy('rate', 'ASC')->get();

        $counts = array();
        $counter = 0;

        foreach ($activities as $activity) {
            $activity->name = $activity->actualName;
            $condition = ["visitorId" => $user->id, "activityId" => $activity->id, 'confirm' => 1];
            $counts[$counter++] = LogModel::where($condition)->count();
        }

        $recentlyBadges = [['badgeId' => -1, 'badgeDate' => -1],
            ['badgeId' => -1, 'badgeDate' => -1],
            ['badgeId' => -1, 'badgeDate' => -1]];

        $badges = Medal::all();
        foreach ($badges as $badge) {
            $date = getBadgeDate($badge->activityId, $badge->floor, $uId, $badge->kindPlaceId);
            if($date != -1) {
                if($date > $recentlyBadges[0]['badgeDate']) {
                    $recentlyBadges[2]['badgeDate'] = $recentlyBadges[1]['badgeDate'];
                    $recentlyBadges[2]['badgeId'] = $recentlyBadges[1]['badgeId'];
                    $recentlyBadges[1]['badgeDate'] = $recentlyBadges[0]['badgeDate'];
                    $recentlyBadges[1]['badgeId'] = $recentlyBadges[0]['badgeId'];
                    $recentlyBadges[0]['badgeDate'] = $date;
                    $recentlyBadges[0]['badgeId'] = $badge->id;
                }
                else if($date > $recentlyBadges[1]['badgeDate']) {
                    $recentlyBadges[2]['badgeDate'] = $recentlyBadges[1]['badgeDate'];
                    $recentlyBadges[2]['badgeId'] = $recentlyBadges[1]['badgeId'];
                    $recentlyBadges[1]['badgeDate'] = $date;
                    $recentlyBadges[1]['badgeId'] = $badge->id;
                }
                else if($date > $recentlyBadges[2]['badgeDate']) {
                    $recentlyBadges[2]['badgeDate'] = $date;
                    $recentlyBadges[2]['badgeId'] = $badge->id;
                }
            }
        }

        $limit = (count($recentlyBadges) >= 3) ? 3 : count($recentlyBadges);
        array_splice($recentlyBadges, $limit);
        $outMedals = [];

        foreach ($recentlyBadges as $badge) {
            if($badge['badgeId'] != -1) {
                $badgeTmp = Medal::whereId($badge['badgeId']);
                $badgeTmp->activityId = Activity::whereId($badgeTmp->activityId)->name;
                $outMedals[count($outMedals)] = $badgeTmp;
            }
        }

        if(!$user->uploadPhoto) {
            $photo = DefaultPic::whereId($user->picture);
            if($photo == null)
                $user->picture = DefaultPic::first()->name;
            else
                $user->picture = $photo->name;
        }

        $this->content['activities'] = $activities;
        $this->content['counts'] = $counts;
        $this->content['totalPoint'] = getUserPoints($user->id);
        $this->content['levels'] = Level::orderBy('floor', 'ASC')->get();
        $this->content['userLevels'] = nearestLevel($user->id);
        $this->content['medals'] = getMedals($user->id);
        $this->content['nearestMedals'] = getNearestMedals($user->id);
        $this->content['recentlyBadges'] = $outMedals;

        echo \GuzzleHttp\json_encode(['data' => $this->content]);
    }

    public function badgesAPI() {

        $this->content['badges'] = [];

        if(Auth::check()) {

            $badges = Medal::all();

            $uId = Auth::user()->_id;

            foreach ($badges as $badge) {

                if (checkBadge($uId, $badge))
                    $badge->status = 1;
                else
                    $badge->status = 0;

                $badge->activityId = Activity::whereId($badge->activityId)->actualName;
                if ($badge->kindPlaceId != -1)
                    $badge->kindPlaceId = Place::whereId($badge->kindPlaceId)->name;
            }

            $this->content['badges'] = $badges;

            return response()->json($this->content, 200);
        }

        return response()->json($this->content, 401);

    }

    public function inMsgCountAPI() {

        $this->content['inMsgCount'] = -1;

        if(Auth::check()) {

            $condition = ['receiverId' => Auth::user()->_id, 'receiverShow' => 1];
            $this->content['inMsgCount'] = Message::where($condition)->count();
            return response()->json($this->content, 200);
        }

        return response()->json($this->content, 401);

    }

    public function outMsgCountAPI() {

        $this->content['outMsgCount'] = -1;

        if(Auth::check()) {

            $condition = ['senderId' => Auth::user()->_id, 'senderShow' => 1];
            $this->content['outMsgCount'] = Message::where($condition)->count();
            return response()->json($this->content, 200);
        }

        return response()->json($this->content, 401);

    }

    public function loginWithGoogle() {

        if(Auth::check()) {
            $this->content['msg'] = 'token has been created';
            return response()->json($this->content);
        }


        $id_token = -1;

        if(isset($_POST["param"])) {

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value){

                switch ($k) {
                    case "id_token":
                        $id_token = $value;
                        break;
                }
            }
        }

        if($id_token == -1)
            $this->content['msg'] = 'Bad format';

        else {

            require_once __DIR__ . '/../glogin/libraries/Google/autoload.php';
            // Get $id_token via HTTPS POST.

            $client = new Google_Client(['client_id' => config('app.GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($id_token);
            if ($payload) {
                $userId = $payload['sub'];
                $user_count = User::whereUserName($userId)->count();

                $rand = rand(10000, 999999);

                if ($user_count == 0) {

                    $tmpUser = new User();
                    $tmpUser->username = $payload['name'];
                    $tmpUser->password = Hash::make($rand);
                    $tmpUser->first_name = $payload['given_name'];
                    $tmpUser->last_name = $payload['family_name'];
                    $tmpUser->email = $payload['email'];
                    $tmpUser->picture = $payload['picture'];

                    try {
                        $tmpUser->save();
                    } catch (Exception $x) {
                    }
                }

                if (Auth::attempt(array('username' => $payload['name'], 'password' => $rand), true)) {

                    $user = Auth::user();

                    $token = Oauth_access_tokens::where('user_id', '=', $user->id)->first();

                    if ($token == null || Carbon::now() > $token->expires_at) {
                        Oauth_access_tokens::where('user_id', '=', $user->id)->delete();
                        $this->content['token'] = $user->createToken('BogenDesign1982')->accessToken;
                        $user->api_token = $this->content['token'];
                        $user->save();
                    } else {
                        $this->content['msg'] = 'token has been created';
                    }
                } else {
                    $this->content['msg'] = 'auth failed';
                }
                // If request specified a G Suite domain:
                //$domain = $payload['hd'];
            } else {
                $this->content['msg'] = 'Invalid ID token';
            }
        }

        return response()->json($this->content);
    }

    public function logout() {

        $user = Auth::user();
        Session::flush();
        Oauth_access_tokens::where('user_id', '=', $user->id)->delete();

        echo \GuzzleHttp\json_encode(['msg' => 'ok', 'status' => Auth::check()]);
    }

    public function accountInfoAPI() {

        $user = Auth::user();

        $aboutMe = AboutMe::where('uId',$user->id)->select(['first_name', 'last_name', 'username', 'email', 'phone'])->first();

        $tmp = Cities::whereId($user->cityId);
        if($tmp != null)
            $user->cityId = $tmp->name;
        else
            $user->cityId = "";

        $this->content['user'] = $user;
        $this->content['ages'] = Age::all();
        $this->content['aboutMe'] = $aboutMe;

        return response()->json($this->content, 200);

    }

    public function updateProfile1API() { // should change I think

        if(!Auth::check())
            return response()->json($this->content, 401);

        $uId = Auth::user()->_id;

        if(isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["username"]) &&
            isset($_POST["email"]) && isset($_POST["cityName"])) {

            $username = makeValidInput($_POST["username"]);

            if(User::whereId($uId)->username != $username && User::whereUserName($username)->count() > 0) {
                $this->content['msg'] = "نام کاربری وارد شده در سامانه موجود است";
            }

            else {

                $user = User::whereId($uId);

                $user->first_name = makeValidInput($_POST["firstName"]);
                $user->last_name = makeValidInput($_POST["lastName"]);
                $user->email = makeValidInput($_POST["email"]);
                $user->cityId = Cities::whereName(makeValidInput($_POST["cityName"]))->first()->id;
                $user->username = $username;

                $user->save();

                if(isset($_POST["phone"]) && makeValidInput($_POST["phone"]) != $user->phone) {

                    $phoneNum = makeValidInput($_POST["phone"]);
                    $activation = ActivationCode::wherePhoneNum($phoneNum)->first();

                    if($activation == null) {
                        $activation = new ActivationCode();
                        $activation->phoneNum = $phoneNum;
                        $activation->code = createCode();
                        $activation->sendTime = time();
                        $activation->save();
                        sendSMS($phoneNum, $activation->code, 'sms');

                        $this->content['msg'] = "sendActivation";
                        $this->content['mode'] = 1;
                        $this->content['reminder'] = 90;
                        $this->content['phoneNum'] = $phoneNum;

                        return response()->json($this->content, 200);
                    }

                    if(time() - $activation->sendTime > 90) {
                        $activation->phoneNum = $phoneNum;
                        $activation->code = createCode();
                        $activation->sendTime = time();
                        $activation->save();
                        sendSMS($phoneNum, $activation->code, 'sms');

                        $this->content['msg'] = "sendActivation";
                        $this->content['mode'] = 1;
                        $this->content['reminder'] = 90;
                        $this->content['phoneNum'] = $phoneNum;

                        return response()->json($this->content, 200);
                    }


                    $this->content['msg'] = "sendActivation";
                    $this->content['mode'] = 1;
                    $this->content['reminder'] = 90 - time() + $activation->sendTime;
                    $this->content['phoneNum'] = $phoneNum;

                    return response()->json($this->content, 200);
                }

                $this->content['msg'] = 'success';
            }
        }
        else {
            $this->content['msg'] = "مقادیر لازم به سرور ارسال نشده است";
        }

        return response()->json($this->content, 200);
    }

    public function updateProfile2API() { // should change I think

        if(!Auth::check())
            return response()->json($this->content, 401);

        $uId = Auth::user()->_id;

        if(isset($_POST["introduction"]) && isset($_POST["sex"]) && isset($_POST["ageId"])) {

            if(AboutMe::where('uId',$uId)->count() > 0)
                $aboutMe = AboutMe::where('uId',$uId)->first();
            else {
                $aboutMe = new AboutMe();
                $aboutMe->uId = $uId;
            }

            $aboutMe->introduction = makeValidInput($_POST["introduction"]);
            $aboutMe->sex = (makeValidInput($_POST["sex"]) == "f") ? 0 : 1;
            $aboutMe->ageId = makeValidInput($_POST["ageId"]);

            $aboutMe->save();

            $this->content['msg'] = 'success';
        }

        else
            $this->content['msg'] = "اشکالی در برقراری ارتباط با سرور به وجود آمده است";

        $this->content['mode'] = 2;
        return response()->json($this->content, 200);
    }

    public function updateProfile3API() { // should change I think

        if(!Auth::check())
            return response()->json($this->content, 401);

        $uId = Auth::user()->_id;

        if(!empty(Auth::user()->link))
            $this->content['msg'] = "شما اجازه تغییر رمز عبور خود را ندارید";

        else if(isset($_POST["oldPassword"]) && isset($_POST["newPassword"]) && isset($_POST["repeatPassword"])) {
            if (Hash::check(makeValidInput($_POST["oldPassword"]), User::whereId($uId)->password)) {

                if (makeValidInput($_POST["newPassword"]) == makeValidInput($_POST["repeatPassword"])) {
                    $user = User::whereId($uId);
                    $user->password = Hash::make(makeValidInput($_POST["newPassword"]));
                    $user->save();

                    $this->content['status'] = 'successPasChanged';
                    return response()->json($this->content, 200);
                } else {
                    $this->content['msg'] = "پسورد جدید و تکرار آن یکی نیستند";
                }
            } else {
                $this->content['msg'] = "پسورد وارد شده معتبر نمی باشد";
            }
        }
        else {
            $this->content['msg'] = "اشکالی در برقراری ارتباط با سرور به وجود آمده است";
        }

        $this->content['mode'] = 3;
        return response()->json($this->content, 200);

    }

    public function showAdabDetailAPI($placeId, $mode = "", $err = "") {

        if(Adab::whereId($placeId) == null) {
            $this->content['msg'] = 'place not found';
            return response()->json($this->content);
        }

        $hasLogin = true;
        $kindPlaceId = Place::whereName('آداب')->first()->id;
        $uId = -1;

        if(Auth::check())
            $uId = Auth::user()->_id;
        else
            $hasLogin = false;

        if($hasLogin) {

            $activityId = Activity::whereName('مشاهده')->first()->id;

            $condition = ['visitorId' => $uId, 'placeId' => $placeId, 'kindPlaceId' => $kindPlaceId,
                'activityId' => $activityId];
            $log = LogModel::where($condition)->first();
            if($log == null) {
                $log = new LogModel();
                $log->activityId = $activityId;
                $log->time = getToday()["time"];
                $log->placeId = $placeId;
                $log->kindPlaceId = $kindPlaceId;
                $log->visitorId = $uId;
                $log->date = date('Y-m-d');
                $log->save();
            }
            else {
                $log->date = date('Y-m-d');
                $log->save();
            }
        }
        $bookMark = false;
        $condition = ['visitorId' => $uId, 'activityId' => Activity::whereName("نشانه گذاری")->first()->id,
            'placeId' => $placeId, 'kindPlaceId' => $kindPlaceId];
        if(LogModel::where($condition)->count() > 0)
            $bookMark = true;

        $rates = getRate($placeId, $kindPlaceId);

        $place = Adab::whereId($placeId);
        $state = State::whereId($place->stateId)->name;
        $photos = [];
        $thumbnail = "";
        $sitePhotos = 1;

        if(!empty($place->pic_1)) {
            if($place->category == 3) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/s-1.jpg'))) {
                    $photos[count($photos)] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/s-1.jpg');
                    $thumbnail = URL::asset('_images/adab/ghazamahali/' . $place->file . '/f-1.jpg');
                } else {
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
                    $thumbnail = URL::asset('images/mainPics/noPicSite.jpg');
                }
            }
            else {
                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/s-1.jpg'))) {
                    $photos[count($photos)] = URL::asset('_images/adab/soghat/' . $place->file . '/s-1.jpg');
                    $thumbnail = URL::asset('_images/adab/soghat/' . $place->file . '/f-1.jpg');
                } else {
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
                    $thumbnail = URL::asset('images/mainPics/noPicSite.jpg');
                }
            }
        }
        else {
            $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
            $thumbnail = URL::asset('images/mainPics/noPicSite.jpg');
        }

        if(!empty($place->pic_2)) {
            $sitePhotos++;
        }

        if(!empty($place->pic_3)) {
            $sitePhotos++;
        }

        if(!empty($place->pic_4)) {
            $sitePhotos++;
        }

        if(!empty($place->pic_5)) {
            $sitePhotos++;
        }

        $aksActivityId = Activity::whereName('عکس')->first()->id;

        $userPhotos = 0;
        $logPhoto = '';

        $tmp = DB::select("select count(*) as countNum from log WHERE confirm = 1 and activityId = " . $aksActivityId . " and placeId = " . $placeId . " and kindPlaceId = " . $kindPlaceId . " and pic <> 0");
        if($tmp != null && count($tmp) > 0)
            $userPhotos = $tmp[0]->countNum;

        if($userPhotos > 0) {
            $tmp2 = DB::select("select picItems.id, picItems.name, count(*) as countNum, text from log, picItems WHERE confirm = 1 and activityId = " . $aksActivityId . " and placeId = " . $placeId . " and log.kindPlaceId = " . $kindPlaceId . " and pic <> 0 and picItems.id = log.pic group by(picItems.id)");
            if ($tmp2 != null && count($tmp2) > 0) {
                $logPhoto['pic'] = URL::asset('userPhoto/hotels/' . $tmp2[0]->text);
                $logPhoto['id'] = $tmp2[0]->id;
            }
        }

        $srcCities = DB::select("select DISTINCT(src) from log, comment WHERE log.placeId = " . $placeId . ' and ' .
            'kindPlaceId = ' . $kindPlaceId . ' and activityId = ' . Activity::whereName('نظر')->first()->id .
            ' and logId = log.id and status = 1');

        $brands = [];

        if(!empty($place->brand_name_1)) {
            $brands[count($brands)] = [$place->brand_name_1, $place->des_name_1];
        }
        if(!empty($place->brand_name_2)) {
            $brands[count($brands)] = [$place->brand_name_2, $place->des_name_2];
        }
        if(!empty($place->brand_name_3)) {
            $brands[count($brands)] = [$place->brand_name_3, $place->des_name_3];
        }
        if(!empty($place->brand_name_4)) {
            $brands[count($brands)] = [$place->brand_name_4, $place->des_name_4];
        }
        if(!empty($place->brand_name_5)) {
            $brands[count($brands)] = [$place->brand_name_5, $place->des_name_5];
        }
        if(!empty($place->brand_name_6)) {
            $brands[count($brands)] = [$place->brand_name_6, $place->des_name_6];
        }
        if(!empty($place->brand_name_7)) {
            $brands[count($brands)] = [$place->brand_name_7, $place->des_name_7];
        }

        switch ($place->category) {
            case 1:
            default:
                $placeMode = 'soghat';
                break;
            case 3:
                $placeMode = 'ghazamahali';
                break;
            case 6:
                $placeMode = 'sanaye';
                break;
        }

        $this->content['place'] = $place;
        $this->content['mode'] = $mode;
        $this->content['brands'] = $brands;
        $this->content['thumbnail'] = $thumbnail;
        $this->content['tags'] = Tag::where('kindPlaceId',$kindPlaceId)->get();
        $this->content['state'] = $state;
        $this->content['avgRate'] = $rates[1];
        $this->content['kindPlaceId'] = $kindPlaceId;
        $this->content['rates'] = $rates[0];
        $this->content['photos'] = $photos;
        $this->content['userPhotos'] = $userPhotos;
        $this->content['sitePhotos'] = $sitePhotos;
        $this->content['logPhoto'] = $logPhoto;
        $this->content['hasLogin'] = $hasLogin;
        $this->content['bookMark'] = $bookMark;
        $this->content['srcCities'] = $srcCities;
        $this->content['err'] = $err;
        $this->content['placeStyles'] = PlaceStyle::where('kindPlaceId',$kindPlaceId)->get();
        $this->content['placeMode'] = $placeMode;

        return response()->json($this->content);
    }

    public function showReviewAPI($logId) {

        $log = LogModel::whereId($logId);

        if($log == null || $log->confirm != 1) {
            return response()->json($this->content, 200);
        }

        $address = "";
        $phone = "";
        $site = "";
        $hasLogin = true;
        $placePhotosCount = 0;

        if(Auth::check())
            $hasLogin = false;

        $comment = Comment::whereLogId($logId)->first();

        switch ($log->kindPlaceId) {
            case 1:
            default:
                $place = Amaken::whereId($log->placeId);
                $address = $place->address;
                if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/amaken/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "amaken";
                $state = State::whereId(Cities::whereId($place->cityId)->stateId)->name;
                break;
            case 3:
                $place = Restaurant::whereId($log->placeId);
                $address = $place->address;
                if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/restaurant/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "restaurant";
                $state = State::whereId(Cities::whereId($place->cityId)->stateId)->name;
                break;
            case 4:
                $place = Hotel::whereId($log->placeId);
                $address = $place->address;
                if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/hotels/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "hotel";
                $state = State::whereId(Cities::whereId($place->cityId)->stateId)->name;
                break;
            case 6:
                $place = Majara::whereId($log->placeId);
                $address = $place->address;
                if(file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/majara/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "majara";
                $state = State::whereId($place->cityId)->name;
                break;
            case 8:
                $place = Adab::whereId($log->placeId);
                if($place->category == 3) {
                    if(file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/' . $place->pic_1)))
                        $placePic = URL::asset('_images/adab/ghazamahali/' . $place->file . '/' . $place->pic_1);
                    else
                        $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                }
                else {
                    if(file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/' . $place->pic_1)))
                        $placePic = URL::asset('_images/adab/soghat/' . $place->file . '/' . $place->pic_1);
                    else
                        $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                }
                $placeMode = "adab";
                $state = State::whereId($place->stateId)->name;
                break;
        }

        if($place->pic_1 != "")
            $placePhotosCount++;
        if($place->pic_2 != "")
            $placePhotosCount++;
        if($place->pic_3 != "")
            $placePhotosCount++;
        if($place->pic_4 != "")
            $placePhotosCount++;
        if($place->pic_5 != "")
            $placePhotosCount++;

        $condition = ['placeId' => $log->placeId, 'kindPlaceId' => $log->kindPlaceId, 'confirm' => 1,
            'activityId' => Activity::whereName('عکس')->first()->id];
        $userPhotosCount = LogModel::where($condition)->count();

        $condition = ['placeId' => $log->placeId, 'kindPlaceId' => $log->kindPlaceId,
            'activityId' => Activity::whereName('امتیاز')->first()->id,
            'visitorId' => $log->visitorId];
        $logId = LogModel::where($condition)->first()->id;
        $log->rate = ceil(DB::select('select avg(rate) as avgRate from userOpinions where logId = ' . $logId)[0]->avgRate);

        $condition = ['activityId' => Activity::whereName('نظر')->first()->id,
            'visitorId' => $log->visitorId, 'confirm' => 1];
        $log->commentsCount = LogModel::where($condition)->count();

        $user = User::whereId($log->visitorId);
        $log->visitorId = $user->username;
        $city = Cities::whereId($user->cityId);

        if(!empty($log->pic) && file_exists(__DIR__ . '/../../../../assets/userPhoto/comments/' . $log->kindPlaceId . '/' . $log->pic)) {
            $log->userPic = URL::asset('userPhoto/comments/' . $log->kindPlaceId . '/' . $log->pic);
        }

        $log->city = $city->name;
        $log->date = convertDate($log->date);
        $log->state = State::whereId($city->stateId)->name;

        $log->visitorPic = $user->picture;
        if(count(explode('.', $log->visitorPic)) == 1) {
            if(!empty(DefaultPic::whereId($log->visitorPic)))
                $log->visitorPic = URL::asset('defaultPic/' . DefaultPic::whereId($log->visitorPic)->name);
            else
                $log->visitorPic = URL::asset('defaultPic/' . DefaultPic::first()->name);
        }
        else {
            $log->visitorPic = URL::asset('userPhoto/' . $log->visitorPic);
        }

        $condition = ['logId' => $log->id, 'like_' => 1];
        $likes = OpOnActivity::where($condition)->count();

        $condition = ['logId' => $log->id, 'dislike' => 1];
        $dislikes = OpOnActivity::where($condition)->count();

        $activityId = Activity::whereName('نظر')->first()->id;
        $tags = DB::select('SELECT DISTINCT(subject), id FROM log WHERE confirm = 1 and activityId = ' . $activityId . ' and placeId = ' . $log->placeId . ' and kindPlaceId = ' . $log->kindPlaceId . ' ORDER BY date DESC LIMIT 0, 10');

        $this->content['log'] = $log;
        $this->content['comment'] = $comment;
        $this->content['hasLogin'] = $hasLogin;
        $this->content['state'] = $state;
        $this->content['placeName'] = $place->name;
        $this->content['placePic'] = $placePic;
        $this->content['address'] = $address;
        $this->content['phone'] = $phone;
        $this->content['site'] = $site;
        $this->content['userPhotosCount'] = $userPhotosCount + $placePhotosCount;
        $this->content['likes'] = $likes;
        $this->content['dislikes'] = $dislikes;
        $this->content['rate'] = getRate($log->placeId, $log->kindPlaceId)[1];
        $this->content['tags'] = $tags;
        $this->content['placeMode'] = $placeMode;

        return response()->json($this->content, 200);
    }

    public function writeReviewAPI($placeId, $kindPlaceId, $err = "") {

        switch ($kindPlaceId) {
            case 1:
            default:
                $place = Amaken::whereId($placeId);
                if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/amaken/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "amaken";
                $state = State::whereId(Cities::whereId($place->cityId)->stateId)->name;
                break;
            case 3:
                $place = Restaurant::whereId($placeId);
                if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/restaurant/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "restaurant";
                $state = State::whereId(Cities::whereId($place->cityId)->stateId)->name;
                break;
            case 4:
                $place = Hotel::whereId($placeId);
                if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/hotels/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "hotel";
                $state = State::whereId(Cities::whereId($place->cityId)->stateId)->name;
                break;
            case 6:
                $place = Majara::whereId($placeId);
                if(file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/majara/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $state = State::whereId($place->cityId)->name;
                $placeMode = "majara";
                break;
            case 8:
                $place = Adab::whereId($placeId);
                if($place->category == 3) {
                    if(file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/' . $place->pic_1)))
                        $placePic = URL::asset('_images/adab/ghazamahali/' . $place->file . '/' . $place->pic_1);
                    else
                        $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                }
                else {
                    if(file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/' . $place->pic_1)))
                        $placePic = URL::asset('_images/adab/soghat/' . $place->file . '/' . $place->pic_1);
                    else
                        $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                }
                $placeMode = "adab";
                $state = State::whereId($place->stateId)->name;
                break;
        }

        $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'visitorId' => Auth::user()->_id,
            'activityId' => Activity::whereName('نظر')->first()->id];

        if($kindPlaceId != 8) {
            $city = Cities::whereId($place->cityId);

            $log = LogModel::where($condition)->first();

            if($log != null) {
                $comment = Comment::whereLogId($log->id)->first();
                return view('review', array('placePic' => $placePic, 'city' => $city->name,
                    'state' => State::whereId($city->stateId)->name, 'placeId' => $placeId, 'placeName' => $place->name,
                    'kindPlaceId' => $kindPlaceId, 'opinions' => Opinion::where('kindPlaceId',$kindPlaceId)->get(),
                    'questions' => Question::where('kindPlaceId',$kindPlaceId)->get(), 'err' => $err, 'log' => $log, 'comment' => $comment,
                    'placeStyles' => PlaceStyle::where('kindPlaceId',$kindPlaceId)->get(), 'placeMode' => $placeMode));
            }

            return view('review', array('placePic' => $placePic, 'city' => $city->name,
                'state' => State::whereId($city->stateId)->name, 'placeId' => $placeId, 'placeName' => $place->name,
                'kindPlaceId' => $kindPlaceId, 'opinions' => Opinion::where('kindPlaceId',$kindPlaceId)->get(),
                'questions' => Question::where('kindPlaceId',$kindPlaceId)->get(), 'err' => $err,
                'placeStyles' => PlaceStyle::where('kindPlaceId',$kindPlaceId)->get(), 'placeMode' => $placeMode));
        }
        $city = State::whereId($place->stateId);

        $log = LogModel::where($condition)->first();

        if($log != null) {
            $comment = Comment::whereLogId($log->id)->first();
            return view('review', array('placePic' => $placePic, 'city' => $city->name,
                'placeId' => $placeId, 'placeName' => $place->name, 'state' => $state,
                'kindPlaceId' => $kindPlaceId, 'opinions' => Opinion::where('kindPlaceId',$kindPlaceId)->get(),
                'questions' => Question::where('kindPlaceId',$kindPlaceId)->get(), 'err' => $err, 'log' => $log, 'comment' => $comment,
                'placeStyles' => PlaceStyle::where('kindPlaceId',$kindPlaceId)->get(), 'placeMode' => $placeMode));
        }
        else {
            return view('review', array('placePic' => $placePic, 'city' => $city->name,
                'placeId' => $placeId, 'placeName' => $place->name, 'state' => $state,
                'kindPlaceId' => $kindPlaceId, 'opinions' => Opinion::where('kindPlaceId',$kindPlaceId)->get(),
                'questions' => Question::where('kindPlaceId',$kindPlaceId)->get(), 'err' => $err,
                'placeStyles' => PlaceStyle::where('kindPlaceId',$kindPlaceId)->get(), 'placeMode' => $placeMode));
        }
    }

    public function getHotelsMainAPI() {

        $activityId = Activity::whereName('نظر')->first()->id;
        $kindPlaceId = Place::whereName('هتل')->first()->id;

        $place1 = DB::select("select hotels.id, hotels.name, hotels.cityId, hotels.file, hotels.pic_1, COUNT(*) as matches from hotels, log WHERE confirm = 1 and log.activityId = " . $activityId . " and log.placeId = hotels.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 0, 4");

        $reminder = 4 - count($place1);
        $z = "(";
        $first = true;

        foreach ($place1 as $itr) {
            if ($first)
                $first = false;
            else
                $z .= ',';

            $z .= $itr->id;
        }

        $z .= ')';

        if (!$first)
            $place1 = array_merge($place1, DB::select('select id, name, cityId, file, pic_1, 0 as matches from
                      hotels WHERE id not in ' . $z . 'limit 0, ' . $reminder));
        else
            $place1 = array_merge($place1, DB::select('select id, name, cityId, file, pic_1, 0 as matches from
                      hotels limit 0, ' . $reminder));

        foreach ($place1 as $itr) {
            if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $itr->file . '/f-1.jpg')))
                $itr->pic = URL::asset('_images/hotels/' . $itr->file . '/f-1.jpg');
            else
                $itr->pic = URL::asset('images/mainPics/noPicSite.jpg');

            $itr->reviews = $itr->matches;
            $itr->rate = getRate($itr->id, $kindPlaceId)[1];
            $itr->url = route('hotelDetails', ['placeId' => $itr->id, 'placeName' => $itr->name]);
            $itr->kindPlaceId = $kindPlaceId;
        }

        foreach ($place1 as $itr) {

            if($itr == null) {
                $itr = null;
                continue;
            }

            $itr->present = true;

            if($itr->kindPlaceId != 8) {
                $city = Cities::whereId($itr->cityId);
                if($city == null) {
                    $itr->present = false;
                    continue;

                }

                $itr->city = $city->name;
                $itr->state = State::whereId($city->stateId)->name;
            }
            else {
                $city = State::whereId($itr->stateId);
                if($city == null) {
                    $itr = null;
                    continue;
                }
                $itr->state = $itr->city = $city->name;
            }
        }

        echo json_encode(["places" => $place1]);
    }

    public function getAmakensMainAPI() {

        $activityId = Activity::whereName('نظر')->first()->id;
        $kindPlaceId = Place::whereName('اماکن')->first()->id;
        $place1 = DB::select("select amaken.id, amaken.name, amaken.cityId, amaken.file, amaken.pic_1, COUNT(*) as matches from amaken, log WHERE confirm = 1 and log.activityId = " . $activityId . " and log.placeId = amaken.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 0, 4");

        $reminder = 4 - count($place1);
        $z = "(";
        $first = true;

        foreach ($place1 as $itr) {
            if($first)
                $first = false;
            else
                $z .= ',';

            $z .= $itr->id;
        }

        $z .= ')';

        if(!$first)
            $place1 = array_merge($place1, DB::select('select id, name, cityId, file, pic_1, 0 as matches from
              amaken WHERE id not in ' . $z . 'limit 0, ' . $reminder));
        else
            $place1 = array_merge($place1, DB::select('select id, name, cityId, file, pic_1, 0 as matches from
              amaken limit 0, ' . $reminder));

        foreach ($place1 as $itr) {

            if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $itr->file . '/f-1.jpg')))
                $itr->pic = URL::asset('_images/amaken/' . $itr->file . '/f-1.jpg');
            else
                $itr->pic = URL::asset('images/mainPics/noPicSite.jpg');

            $itr->reviews = $itr->matches;
            $itr->rate = getRate($itr->id, $kindPlaceId)[1];
            $itr->url = route('amakenDetails', ['placeId' => $itr->id, 'placeName' => $itr->name]);
            $itr->kindPlaceId = $kindPlaceId;
        }

        foreach ($place1 as $itr) {

            if($itr == null) {
                $itr = null;
                continue;
            }

            $itr->present = true;

            if($itr->kindPlaceId != 8) {
                $city = Cities::whereId($itr->cityId);
                if($city == null) {
                    $itr->present = false;
                    continue;

                }

                $itr->city = $city->name;
                $itr->state = State::whereId($city->stateId)->name;
            }
            else {
                $city = State::whereId($itr->stateId);
                if($city == null) {
                    $itr = null;
                    continue;
                }
                $itr->state = $itr->city = $city->name;
            }
        }

        echo json_encode(['places' => $place1]);
    }

    public function getRestaurantsMainAPI() {

        $activityId = Activity::whereName('نظر')->first()->id;
        $kindPlaceId = Place::whereName('رستوران')->first()->id;
        $place1 = DB::select("select restaurant.id, restaurant.name, restaurant.cityId, restaurant.file, restaurant.pic_1, COUNT(*) as matches from restaurant, log, activity WHERE confirm = 1 and log.activityId = " . $activityId . " and log.activityId = activity.id and log.placeId = restaurant.id and log.kindPlaceId = " . $kindPlaceId . " GROUP BY(log.placeId) ORDER by matches limit 0, 4");

        $reminder = 4 - count($place1);
        $z = "(";
        $first = true;

        foreach ($place1 as $itr) {
            if($first)
                $first = false;
            else
                $z .= ',';

            $z .= $itr->id;
        }

        $z .= ')';

        if(!$first)
            $place1 = array_merge($place1, DB::select('select id, name, cityId, file, pic_1, 0 as matches from
              restaurant WHERE id not in ' . $z . 'limit 0, ' . $reminder));
        else
            $place1 = array_merge($place1, DB::select('select id, name, cityId, file, pic_1, 0 as matches from
              restaurant limit 0, ' . $reminder));

        foreach ($place1 as $itr) {

            if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $itr->file . '/f-1.jpg')))
                $itr->pic = URL::asset('_images/restaurant/' . $itr->file . '/f-1.jpg');
            else
                $itr->pic = URL::asset('images/mainPics/noPicSite.jpg');

            $itr->reviews = $itr->matches;
            $itr->rate = getRate($itr->id, $kindPlaceId)[1];
            $itr->url = route('restaurantDetails', ['placeId' => $itr->id, 'placeName' => $itr->name]);
            $itr->kindPlaceId = $kindPlaceId;
        }

        foreach ($place1 as $itr) {

            if($itr == null || count($itr) == 0) {
                $itr = null;
                continue;
            }

            $itr->present = true;

            if($itr->kindPlaceId != 8) {
                $city = Cities::whereId($itr->cityId);
                if($city == null) {
                    $itr->present = false;
                    continue;

                }

                $itr->city = $city->name;
                $itr->state = State::whereId($city->stateId)->name;
            }
            else {
                $city = State::whereId($itr->stateId);
                if($city == null) {
                    $itr = null;
                    continue;
                }
                $itr->state = $itr->city = $city->name;
            }
        }

        echo json_encode(['places' => $place1]);
    }

    public function getFoodsMainAPI() {

        $place4 = Adab::whereCategory(3)->take(4)->get();
        $kindPlaceId = Place::whereName('آداب')->first()->id;
        foreach ($place4 as $itr) {
            if(file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $itr->file . '/f-1.jpg')))
                $itr->pic = URL::asset('_images/adab/ghazamahali/' . $itr->file . '/f-1.jpg');
            else
                $itr->pic = URL::asset('images/mainPics/noPicSite.jpg');

            $itr->reviews = 0;
            $itr->rate = getRate($itr->id, $kindPlaceId)[1];
            $itr->url = route('adabDetails', ['placeId' => $itr->id, 'placeName' => $itr->name]);
            $itr->city = State::whereId($itr->stateId)->name;
            $itr->state = $itr->city;
            $itr->kindPlaceId = $kindPlaceId;
        }

        foreach ($place4 as $itr) {

            if($itr == null) {
                $itr = null;
                continue;
            }

            $itr->present = true;

            if($itr->kindPlaceId != 8) {
                $city = Cities::whereId($itr->cityId);
                if($city == null) {
                    $itr->present = false;
                    continue;

                }

                $itr->city = $city->name;
                $itr->state = State::whereId($city->stateId)->name;
            }
            else {
                $city = State::whereId($itr->stateId);
                if($city == null) {
                    $itr = null;
                    continue;
                }
                $itr->state = $itr->city = $city->name;
            }
        }

        echo json_encode(['places' => $place4]);
    }

    public function getLastRecentlyMainAPI() {

        $activityId = Activity::whereName('نظر')->first()->id;
        $seenActivityId = Activity::whereName('مشاهده')->first()->id;

        $uId = Auth::user()->_id;
        $condition = ['visitorId' => $uId, 'activityId' => $seenActivityId];
        $place2 = LogModel::where($condition)->orderBy('date', 'DESC')->take(4)->get();

        for ($i = 0; $i < count($place2); $i++) {

            $kindPlaceIdTmp = $place2[$i]->kindPlaceId;
            switch ($kindPlaceIdTmp) {
                case 1:
                default:
                    $tmp = Amaken::whereId($place2[$i]->placeId);
                    if($tmp == null) {
                        $place2[$i]->delete();
                        break;
                    }
                    $place2[$i] = $tmp;
                    if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place2[$i]->file . '/f-1.jpg')))
                        $place2[$i]->pic = URL::asset('_images/amaken/' . $place2[$i]->file . '/f-1.jpg');
                    else
                        $place2[$i]->pic = URL::asset('images/mainPics/noPicSite.jpg');

                    $place2[$i]->url = route('amakenDetails', ['placeId' => $place2[$i]->id, 'placeName' => $place2[$i]->name]);
                    break;
                case 3:
                    $tmp = Restaurant::whereId($place2[$i]->placeId);
                    if($tmp == null) {
                        $place2[$i]->delete();
                        break;
                    }
                    $place2[$i] = $tmp;
                    if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place2[$i]->file . '/f-1.jpg')))
                        $place2[$i]->pic = URL::asset('_images/restaurant/' . $place2[$i]->file . '/f-1.jpg');
                    else
                        $place2[$i]->pic = URL::asset('images/mainPics/noPicSite.jpg');

                    $place2[$i]->url = route('restaurantDetails', ['placeId' => $place2[$i]->id, 'placeName' => $place2[$i]->name]);
                    break;
                case 4:
                    $tmp = Hotel::whereId($place2[$i]->placeId);
                    if($tmp == null) {
                        $place2[$i]->delete();
                        break;
                    }
                    $place2[$i] = $tmp;
                    if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place2[$i]->file . '/f-1.jpg')))
                        $place2[$i]->pic = URL::asset('_images/hotels/' . $place2[$i]->file . '/f-1.jpg');
                    else
                        $place2[$i]->pic = URL::asset('images/mainPics/noPicSite.jpg');

                    $place2[$i]->url = route('hotelDetails', ['placeId' => $place2[$i]->id, 'placeName' => $place2[$i]->name]);
                    break;
                case 6:
                    $tmp = Majara::whereId($place2[$i]->placeId);
                    if($tmp == null) {
                        $place2[$i]->delete();
                        break;
                    }
                    $place2[$i] = $tmp;
                    if(file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place2[$i]->file . '/f-1.jpg')))
                        $place2[$i]->pic = URL::asset('_images/majara/' . $place2[$i]->file . '/f-1.jpg');
                    else
                        $place2[$i]->pic = URL::asset('images/mainPics/noPicSite.jpg');

                    $place2[$i]->url = route('majaraDetails', ['placeId' => $place2[$i]->id, 'placeName' => $place2[$i]->name]);
                    break;
                case 8:
                    $tmp = Adab::whereId($place2[$i]->placeId);
                    if($tmp == null) {
                        $place2[$i]->delete();
                        break;
                    }
                    $place2[$i] = $tmp;
                    if($place2[$i]->category == 3) {
                        if(file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place2[$i]->file . '/f-1.jpg')))
                            $place2[$i]->pic = URL::asset('_images/adab/ghazamahali/' . $place2[$i]->file . '/f-1.jpg');
                        else
                            $place2[$i]->pic = URL::asset('images/mainPics/noPicSite.jpg');
                    }
                    else {
                        if(file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place2[$i]->file . '/f-1.jpg')))
                            $place2[$i]->pic = URL::asset('_images/adab/soghat/' . $place2[$i]->file . '/f-1.jpg');
                        else
                            $place2[$i]->pic = URL::asset('images/mainPics/noPicSite.jpg');
                    }
                    $place2[$i]->url = route('majaraDetails', ['placeId' => $place2[$i]->id, 'placeName' => $place2[$i]->name]);
                    break;
            }

            if($tmp == null || $place2[$i] == null || count($place2[$i]) == 0) {
                $place2[$i] = null;
                continue;
            }

            $place2[$i]->rate = getRate($place2[$i]->id, $kindPlaceIdTmp)[1];

            $condition = ['placeId' => $place2[$i]->id, 'kindPlaceId' => $kindPlaceIdTmp,
                'confirm' => 1, 'activityId' => $activityId];

            $place2[$i]->reviews = LogModel::where($condition)->count();

            $place2[$i]->kindPlaceId = $kindPlaceIdTmp;
        }

        foreach ($place2 as $itr) {

            if($itr == null || count($itr) == 0) {
                $itr = null;
                continue;
            }

            $itr->present = true;

            if($itr->kindPlaceId != 8) {
                $city = Cities::whereId($itr->cityId);
                if($city == null) {
                    $itr->present = false;
                    continue;

                }

                $itr->city = $city->name;
                $itr->state = State::whereId($city->stateId)->name;
            }
            else {
                $city = State::whereId($itr->stateId);
                if($city == null) {
                    $itr = null;
                    continue;
                }
                $itr->state = $itr->city = $city->name;
            }
        }

        echo json_encode(['places' => $place2]);
    }

    public function getBookMarkMainAPI() {

        $uId = Auth::user()->_id;

        $activityId = Activity::whereName('نشانه گذاری')->first()->id;

        $activities = DB::select("SELECT * FROM log WHERE log.activityId = " . $activityId . " and log.visitorId = " . $uId . " order by log.date DESC");

        $activityId = Activity::whereName('نظر')->first()->id;

        foreach($activities as $itr) {

            if($itr->placeId == -1)
                continue;

            switch ($itr->kindPlaceId) {
                case 1:
                default:
                    $tmp = Amaken::whereId($itr->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $tmp->file . "/f-1.jpg")))
                        $itr->placePic = URL::asset("_images/amaken/" . $tmp->file . "/f-1.jpg");
                    else
                        $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                    $itr->placeRedirect = route('amakenDetails', ['placeId' => $tmp->id]);
                    break;
                case 3:
                    $tmp = Restaurant::whereId($itr->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $tmp->file . "/f-1.jpg")))
                        $itr->placePic = URL::asset('_images/restaurant/' . $tmp->file . "/" . $tmp->pic_1);
                    else
                        $itr->placePic = URL::asset('_images/nopic/blank.jg');

                    $itr->placeRedirect = route('restaurantDetails', ['placeId' => $tmp->id]);
                    break;
                case 4:
                    $tmp = Hotel::whereId($itr->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $tmp->file . "/f-1.jpg")))
                        $itr->placePic = URL::asset("_images/hotels/" . $tmp->file . "/f-1.jpg");
                    else
                        $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                    $itr->placeRedirect = route('hotelDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                    break;

                case 6:
                    $tmp = Majara::whereId($itr->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $tmp->file . "/f-1.jpg")))
                        $itr->placePic = URL::asset("_images/majara/" . $tmp->file . "/f-1.jpg");
                    else
                        $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                    $itr->placeRedirect = route('majaraDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                    break;

                case 8:
                    $tmp = Adab::whereId($itr->placeId);
                    if($tmp->category == 3) {
                        if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $tmp->file . "/f-1.jpg")))
                            $itr->placePic = URL::asset("_images/adab/ghazamahali/" . $tmp->file . "/f-1.jpg");
                        else
                            $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
                    }
                    else {
                        if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $tmp->file . "/f-1.jpg")))
                            $itr->placePic = URL::asset("_images/adab/soghat/" . $tmp->file . "/f-1.jpg");
                        else
                            $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
                    }

                    $itr->placeRedirect = route('adabDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                    break;
            }

            $city = Cities::whereId($tmp->cityId);
            $itr->placeCity = $city->name;
            $itr->placeState = State::whereId($city->stateId)->name;
            $itr->placeName = $tmp->name;
            $itr->placeRate = getRate($itr->placeId, $itr->kindPlaceId)[1];

            $itr->placeReviews = DB::select('select count(*) as countNum from log, comment WHERE logId = log.id and status = 1 and placeId = ' . $itr->placeId .
                ' and kindPlaceId = ' . $itr->kindPlaceId . ' and activityId = ' . $activityId)[0]->countNum;

        }

        echo json_encode(['places' => $activities]);

    }

    public function getGoyeshAPI() {
        echo json_encode(['goyeshes' => GoyeshCity::all()]);
    }

    public function getActivitiesNumSelfAPI() {

        if(isset($_POST["param"])) {

            $activityId = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "activityId":
                        $activityId = $value;
                        break;
                }
            }


            if($activityId == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $uId = Auth::user()->_id;
            $nums = DB::select("SELECT place.name as placeName, place.id as placeId, COUNT(kindPlaceId) as nums FROM log, place WHERE confirm = 1 and kindPlaceId = place.id and visitorId = " . $uId . " and activityId = " . $activityId . " GROUP BY(kindPlaceId)");

            echo json_encode(['data' => $nums]);
        }
    }

    public function getActivitiesNumGeneralAPI() {

        if(isset($_POST["param"])) {

            $activityId = -1;
            $uId = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "activityId":
                        $activityId = $value;
                        break;
                    case "uId":
                        $uId = $value;
                        break;
                }
            }

            if($activityId == -1 || $uId == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $nums = DB::select("SELECT place.name as placeName, place.id as placeId, COUNT(kindPlaceId) as nums FROM log, place WHERE confirm = 1 and kindPlaceId = place.id and visitorId = " . $uId . " and activityId = " . $activityId . " GROUP BY(kindPlaceId)");

            echo json_encode(['data' => $nums]);
        }
    }

    public function getActivitiesSelfAPI() {

        if(isset($_POST["param"])) {

            $activityId = -1;
            $kindPlaceId = -1;
            $page = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "activityId":
                        $activityId = $value;
                        break;
                    case "kindPlaceId":
                        $kindPlaceId = $value;
                        break;
                    case "page":
                        $page = $value;
                        break;

                }
            }

            if($activityId == -1 || $page == -1 || $kindPlaceId == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $rateActivityId = Activity::whereName('امتیاز')->first()->id;
            $reviewActivityId = Activity::whereName('نظر')->first()->id;
            $page = ($page - 1) * 5;
            $uId = Auth::user()->_id;


            if($kindPlaceId != -1)
                $condition = ["visitorId" => $uId, "activityId" => $activityId, "kindPlaceId" => $kindPlaceId, 'confirm' => 1];
            else
                $condition = ["visitorId" => $uId, "activityId" => $activityId, 'confirm' => 1];

            $out = LogModel::where($condition)->skip($page)->limit(5)->get();

            if($out != null && count($out) > 0) {

                foreach($out as $itr) {
                    if($itr->pic == 0)
                        $itr->pic = "";
                    $itr->visitorId = User::whereId($itr->visitorId)->username;
                    switch ($itr->kindPlaceId) {
                        case 1:
                        default:
                            $tmp = Amaken::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset("_images/amaken/" . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                            $itr->placeRedirect = route('amakenDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/amaken/" . $itr->text);
                            break;
                            break;
                        case 3:
                            $tmp = Restaurant::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset('_images/restaurant/' . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset('images/mainPics/noPicSite.jpg');

                            $itr->placeRedirect = route('restaurantDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/restaurant/" . $itr->text);
                            break;
                        case 4:
                            $tmp = Hotel::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset("_images/hotels/" . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                            $itr->placeRedirect = route('hotelDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/hotels/" . $itr->text);
                            break;

                        case 6:
                            $tmp = Majara::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset("_images/majara/" . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                            $itr->placeRedirect = route('majaraDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/majara/" . $itr->text);
                            break;

                        case 8:
                            $tmp = Adab::whereId($itr->placeId);
                            if($tmp->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $tmp->file . "/f-1.jpg")))
                                    $itr->placePic = URL::asset("_images/adab/ghazamahali/" . $tmp->file . "/f-1.jpg");
                                else
                                    $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
                            }
                            else {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $tmp->file . "/f-1.jpg")))
                                    $itr->placePic = URL::asset("_images/adab/soghat/" . $tmp->file . "/f-1.jpg");
                                else
                                    $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
                            }

                            $itr->placeRedirect = route('adabDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/adab/" . $itr->text);
                            break;
                    }
                    $itr->date = convertDate($itr->date);
                    if($activityId == $rateActivityId)
                        $itr->point = ceil(DB::select('select AVG(userOpinions.rate) as avgRate from log, userOpinions WHERE log.id = logId and log.id = ' . $itr->id)[0]->avgRate);
                    elseif ($activityId == $reviewActivityId) {
                        $condition = ['activityId' => $reviewActivityId, 'visitorId' => $uId, 'placeId' => $itr->placeId,
                            'kindPlaceId' => $itr->kindPlaceId, 'confirm' => 1];
                        $logId = LogModel::where($condition)->first()->id;
                        $itr->point = ceil(DB::select('select AVG(userOpinions.rate) as avgRate from log, userOpinions WHERE log.id = logId and log.id = ' . $logId)[0]->avgRate);
                    }
                    else
                        $itr->point = -1;
                }
            }
            else
                $out = [];


            echo \GuzzleHttp\json_encode(['data' => $out]);

        }

    }

    public function getActivitiesGeneralAPI() {

        if(isset($_POST["param"])) {

            $activityId = -1;
            $uId = -1;
            $kindPlaceId = -1;
            $page = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "activityId":
                        $activityId = $value;
                        break;
                    case "uId":
                        $uId = $value;
                        break;
                    case "kindPlaceId":
                        $kindPlaceId = $value;
                        break;
                    case "page":
                        $page = $value;
                        break;

                }
            }

            if($activityId == -1 || $page == -1 || $kindPlaceId == -1 || $uId == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $rateActivityId = Activity::whereName('امتیاز')->first()->id;
            $reviewActivityId = Activity::whereName('نظر')->first()->id;
            $page = ($page - 1) * 5;


            if($kindPlaceId != -1)
                $condition = ["visitorId" => $uId, "activityId" => $activityId, "kindPlaceId" => $kindPlaceId, 'confirm' => 1];
            else
                $condition = ["visitorId" => $uId, "activityId" => $activityId, 'confirm' => 1];

            $out = LogModel::where($condition)->skip($page)->limit(5)->get();

            if($out != null && count($out) > 0) {

                foreach($out as $itr) {
                    if($itr->pic == 0)
                        $itr->pic = "";
                    $itr->visitorId = User::whereId($itr->visitorId)->username;
                    switch ($itr->kindPlaceId) {
                        case 1:
                        default:
                            $tmp = Amaken::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset("_images/amaken/" . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                            $itr->placeRedirect = route('amakenDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/amaken/" . $itr->text);
                            break;
                            break;
                        case 3:
                            $tmp = Restaurant::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset('_images/restaurant/' . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset('images/mainPics/noPicSite.jpg');

                            $itr->placeRedirect = route('restaurantDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/restaurant/" . $itr->text);
                            break;
                        case 4:
                            $tmp = Hotel::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset("_images/hotels/" . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                            $itr->placeRedirect = route('hotelDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/hotels/" . $itr->text);
                            break;

                        case 6:
                            $tmp = Majara::whereId($itr->placeId);
                            if(file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $tmp->file . "/f-1.jpg")))
                                $itr->placePic = URL::asset("_images/majara/" . $tmp->file . "/f-1.jpg");
                            else
                                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                            $itr->placeRedirect = route('majaraDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/majara/" . $itr->text);
                            break;

                        case 8:
                            $tmp = Adab::whereId($itr->placeId);
                            if($tmp->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $tmp->file . "/f-1.jpg")))
                                    $itr->placePic = URL::asset("_images/adab/ghazamahali/" . $tmp->file . "/f-1.jpg");
                                else
                                    $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
                            }
                            else {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $tmp->file . "/f-1.jpg")))
                                    $itr->placePic = URL::asset("_images/adab/soghat/" . $tmp->file . "/f-1.jpg");
                                else
                                    $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
                            }

                            $itr->placeRedirect = route('adabDetails', ['placeId' => $tmp->id, 'placeName' => $tmp->name]);
                            if($itr->pic != "")
                                $itr->pic = URL::asset("userPhoto/adab/" . $itr->text);
                            break;
                    }
                    $itr->date = convertDate($itr->date);
                    if($activityId == $rateActivityId)
                        $itr->point = ceil(DB::select('select AVG(userOpinions.rate) as avgRate from log, userOpinions WHERE log.id = logId and log.id = ' . $itr->id)[0]->avgRate);
                    elseif ($activityId == $reviewActivityId) {
                        $condition = ['activityId' => $reviewActivityId, 'visitorId' => $uId, 'placeId' => $itr->placeId,
                            'kindPlaceId' => $itr->kindPlaceId, 'confirm' => 1];
                        $logId = LogModel::where($condition)->first()->id;
                        $itr->point = ceil(DB::select('select AVG(userOpinions.rate) as avgRate from log, userOpinions WHERE log.id = logId and log.id = ' . $logId)[0]->avgRate);
                    }
                    else
                        $itr->point = -1;
                }
            }
            else
                $out = [];


            echo \GuzzleHttp\json_encode(['data' => $out]);

        }

    }

    public function sendMyInvitationCodeAPI() {

        if(isset($_POST["param"])) {

            $phoneNum = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "phoneNum":
                        $phoneNum = $value;
                        break;
                }
            }

            if($phoneNum == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $user = Auth::user();
            $last = InvitationCode::where('uId',$user->id)->orderBy('sendTime', 'DESC')->first();

            if($last != null) {

                if(time() - $last->sendTime < 90) {
                    echo \GuzzleHttp\json_encode(['msg' => 'nok']);
                    return;
                }
            }

            $send = new InvitationCode();
            $send->phoneNum = $phoneNum;
            $send->sendTime = time();
            $send->uId = $user->id;

            try {
                $send->save();
                sendSMS($phoneNum, $user->username, 'invite', $user->invitationCode);
                echo \GuzzleHttp\json_encode(['msg' => 'ok']);
                return;
            }
            catch (Exception $x) {}
        }

        echo \GuzzleHttp\json_encode(['msg' => 'nok2']);
    }

    public function showBadgesAPI() {

        $badges = Medal::all();

        $uId = Auth::user()->_id;

        foreach ($badges as $badge) {

            if(checkBadge($uId, $badge))
                $badge->status = 1;
            else
                $badge->status = 0;

            $badge->activityId = Activity::whereId($badge->activityId)->actualName;
            if($badge->kindPlaceId != -1)
                $badge->kindPlaceId = Place::whereId($badge->kindPlaceId)->name;
        }

        echo \GuzzleHttp\json_encode(['badges' => $badges]);
    }

    public function showOtherBadgeAPI() {

        if(isset($_POST["param"])) {

            $username = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "username":
                        $username = $value;
                        break;
                }
            }

            if ($username == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $uId = User::whereUserName($username)->first();

            if ($uId == null) {
                echo \GuzzleHttp\json_encode(['err' => 'username not exist']);
                return;
            }

            $badges = Medal::all();
            $uId = $uId->id;

            foreach ($badges as $badge) {

                if (checkBadge($uId, $badge))
                    $badge->status = 1;
                else
                    $badge->status = 0;

                $badge->activityId = Activity::whereId($badge->activityId)->name;

            }

            $user = User::whereId($uId);

            echo \GuzzleHttp\json_encode(['badges' => $badges, 'user' => $user]);
        }
    }

    public function getCitiesOrStates() {

        if(isset($_POST["param"])) {

            $key = -1;

            $param = \GuzzleHttp\json_decode($_POST["param"]);

            foreach ($param as $k => $value) {

                switch ($k) {
                    case "key":
                        $key = $value;
                        break;
                }
            }

            if ($key == -1) {
                echo \GuzzleHttp\json_encode(['err' => 'format err']);
                return;
            }

            $arr = [];
            $counter = 0;
            $cities = DB::select("select c.id, c.name, s.name as stateName from cities c, state s WHERE s.id = c.stateId and c.name LIKE '%$key%'");

            if ($cities != null && count($cities) > 0) {

                foreach ($cities as $city) {
                    $arr[$counter]["name"] = "شهر " . $city->name . " در " . $city->stateName;
                    $arr[$counter]["id"] = $city->id;
                    $arr[$counter++]["mode"] = "city";
                }
            }

            $states = DB::select("select s.id, s.name from state s WHERE s.name LIKE '%$key%'");

            if($states != null && count($states) > 0) {
                foreach ($states as $state) {
                    $arr[$counter]["name"] = $state->name;
                    $arr[$counter]["id"] = $state->id;
                    $arr[$counter++]["mode"] = "state";
                }
            }

            echo \GuzzleHttp\json_encode(['result' => $arr]);
        }

    }

    public function checkPhone(Request $request) {

        $request->validate([
            "token" => "required",
            "time" => "required",
            "phone" => "required|regex:/(09)[0-9]{9}/"
        ]);

        if(!self::checkToken($request["token"], $request["time"]))
            return response()->json(["status" => "nok2"]);

        $u = User::wherePhone($request["phone"])->first();
        if($u == null) {
            return response()->json([
                "status" => "1"
            ]);
        }

        return response()->json([
            "status" => "0",
            "username" => $u->username
        ]);
    }

    public function addUser(Request $request) {

        $request->validate([
            "data" => "required|unique:users,username",
            "parentUsername" => "nullable|exists:users,username",
            "phone" => "nullable|regex:/(09)[0-9]{9}/",
            "token" => "required",
            "time" => "required"
        ]);

        if(!self::checkToken($request["token"], $request["time"]))
            return response()->json(["status" => "nok2"]);

        if($request->has("phone") && $request["phone"] != null &&
            !empty($request["phone"])) {
            self::checkUsernameStatic($request["data"], true, $request["phone"]);
        }
        else if($request->has("parentUsername") && $request["parentUsername"] != null &&
            !empty($request["parentUsername"])) {
            $parentId = User::whereUserName($request["parentUsername"])->first()->id;
            self::checkUsernameStatic($request["data"], true, $parentId);
        }
        else
            return response()->json([
                "status" => "-1"
            ]);

        return response()->json([
            "status" => "0"
        ]);
    }

    public function updateUser(Request $request) {

        $request->validate([
            "newUsername" => "required|unique:users,username",
            "oldUsername" => "required|exists:users,username",
            "token" => "required",
            "time" => "required"
        ]);

        if(!self::checkToken($request["token"], $request["time"]))
            return response()->json(["status" => "nok2"]);

        $u = User::whereUserName($request["oldUsername"])->first();
        $u->username = $request["newUsername"];
        $u->save();

        return response()->json([
            "status" => "0"
        ]);
    }
}
