<?php

namespace App\Http\Controllers;

use App\Events\SaveErrorEvent;
use App\models\Activity;
use App\models\Adab;
use App\models\Alert;
use App\models\localShops\LocalShops;
use App\models\localShops\LocalShopsCategory;
use App\models\localShops\LocalShopsPictures;
use App\models\places\Amaken;
use App\models\BannerPics;
use App\models\BookMark;
use App\models\BookMarkReference;
use App\models\places\Boomgardy;
use App\models\Cities;
use App\models\Comment;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\FoodMaterial;
use App\models\places\Hotel;
use App\models\LogFeedBack;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\MainSliderPic;
use App\models\places\Majara;
use App\models\Opinion;
use App\models\OpOnActivity;
use App\models\PhotographersLog;
use App\models\PhotographersPic;
use App\models\PicItem;
use App\models\places\Place;
use App\models\places\PlaceFeatureRelation;
use App\models\places\PlaceFeatures;
use App\models\places\PlaceRates;
use App\models\places\PlaceStyle;
use App\models\places\PlaceTag;
use App\models\Question;
use App\models\QuestionUserAns;
use App\models\Report;
use App\models\places\Restaurant;
use App\models\ReviewPic;
use App\models\ReviewUserAssigned;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\SectionPage;
use App\models\places\SogatSanaie;
use App\models\SpecialAdvice;
use App\models\State;
use App\models\Survey;
use App\models\Tag;
use App\models\TripPlace;
use App\models\User;
use App\models\UserOpinion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;


class PlaceController extends Controller {

    public function setPlaceDetailsURL($kindPlaceId, $placeId)
    {
        $kindPlace = Place::find($kindPlaceId);
        if($kindPlace == null)
            return \redirect(\url('/'));
        else
            $place = DB::table($kindPlace->tableName)->select(['id', 'name', 'slug'])->find($placeId);

        if($place == null)
            return \redirect(\url('/'));

        if($kindPlace->id == 13)
            return \redirect(route('business.show', ['id' => $place->id]));


        if($place->slug != null)
            return \redirect(url('show-place-details/' . $kindPlace->fileName . '/' . $place->slug));
        else
            return \redirect(url('show-place-details/' . $kindPlace->fileName . '/' . $place->id));
    }

    public function showPlaceDetails($kindPlaceName, $slug, Request $request){
        deleteReviewPic();  // common.php

        $kindPlace = Place::where('fileName', $kindPlaceName)->first();
        if($kindPlace == null)
            return \redirect(\url('/'));

        $kindPlaceId = $kindPlace->id;
        switch ($kindPlaceId){
            case 1:
                $placeMode = 'amaken';
                $kindPlace->title = 'جاذبه های';
                break;
            case 3:
                $placeMode = 'restaurant';
                $kindPlace->title = 'رستوران های';
                break;
            case 4:
                $placeMode = 'hotel';
                $kindPlace->title = 'مراکز اقامتی';
                break;
            case 6:
                $placeMode = 'majara';
                $kindPlace->title = 'طبیعت گردی های';
                break;
            case 10:
                $placeMode = 'sogatSanaies';
                $kindPlace->title = 'صنایع دستی و سوغات';
                break;
            case 11:
                $placeMode = 'mahaliFood';
                $kindPlace->title = 'غذاهای محلی';
                break;
            case 12:
                $placeMode = 'boomgardy';
                $kindPlace->title = 'بوم گردی های';
                break;
            case 13:
                return \redirect(\url('/'));
                break;
        }

        if(is_numeric($slug))
            $place = DB::table($kindPlace->tableName)->find((int)$slug);
        else
            $place = DB::table($kindPlace->tableName)->where('slug', $slug)->first();

        if($place == null)
            return \redirect(\url('/'));

        $place->tags = PlaceTag::getTags($kindPlace->id, $place->id);

        $hasLogin = true;
        $uId = -1;
        if(auth()->check()){
            $uId = Auth::user()->id;
            $userCode = $uId . '_' . rand(10000,99999);
            $uPic = getUserPic(\auth()->user()->id); // common.php
        }
        else{
            $userCode = null;
            $hasLogin = false;
            $uPic = getUserPic(); // common.php
        }
        saveViewPerPage($kindPlaceId, $place->id); // common.php

        $bmcheck = BookMark::join('bookMarkReferences', 'bookMarkReferences.id', 'bookMarks.bookMarkReferenceId')
                            ->where('userId', $uId)
                            ->where('bookMarks.referenceId', $place->id)
                            ->where('bookMarkReferences.tableName', $kindPlace->tableName)
                            ->count();
        $bookMark = $bmcheck > 0;

        $youRate = PlaceRates::where('kindPlaceId', $kindPlace->id)->where('placeId', $place->id)->where('userId', $uId)->first();
        $youRate = $youRate != null ? $youRate->rate : 0;

        $getRates = getRate($place->id, $kindPlace->id);
        $rates = ['numOfRate' => $getRates[0], 'avg' => $getRates[1], 'yourRate' => $youRate];

        $save = false;
        $count = DB::select("select count(*) as tripPlaceNum from trip, tripPlace WHERE tripPlace.placeId = " . $place->id . " and tripPlace.kindPlaceId = " . $kindPlaceId . " and tripPlace.tripId = trip.id and trip.uId = " . $uId);
        if ($count[0]->tripPlaceNum > 0)
            $save = true;

        if(isset($place->phone) && $place->phone != null) {
            if(strpos($place->phone, '-') !== false)
                $place->phone = explode('-', $place->phone);
            else if(strpos($place->phone,'_') !== false)
                $place->phone = explode('_', $place->phone);
            else
                $place->phone = explode(',', $place->phone);
        }

        $city = Cities::whereId($place->cityId);
        $state = State::whereId($city->stateId);

        $photos = [];
        $photos[count($photos)] = getPlacePic($place->id, $kindPlaceId, 'f');
        $thumbnail = getPlacePic($place->id, $kindPlaceId, 's');

        $pics = getAllPlacePicsByKind($kindPlaceId, $place->id); // common.php
        $sitePics = $pics['sitePics'];
        $photographerPics = $pics['photographerPics'];
        $userPhotos = $pics['userPhotos'];
        $userVideo = $pics['userVideo'];
        $allPlacePics = $pics['allPics'];

        $result = commonInPlaceDetails($kindPlaceId, $place->id, $city, $state, $place);  // common.php
        $reviewCount = $result[0];
        $ansReviewCount = $result[1];
        $userReviewCount = $result[2];
        $multiQuestion = $result[3];
        $textQuestion = $result[4];
        $rateQuestion = $result[5];

        $features = PlaceFeatures::where('kindPlaceId', $kindPlace->id)->where('parent', 0)->get();
        $featId = array();
        foreach ($features as $item) {
            $item->subFeat = PlaceFeatures::where('parent', $item->id)->get();
            $fId = PlaceFeatures::where('parent', $item->id)->pluck('id')->toArray();
            $featId = array_merge($featId, $fId);
        }
        $place->features = PlaceFeatureRelation::where('placeId', $place->id)->whereIn('featureId', $featId)->pluck('featureId')->toArray();

        if($kindPlace->tableName == 'sogatSanaies')
            $place = $this->sogatSanaieDet($place);
        else if($kindPlace->tableName == 'mahaliFood')
            $place = $this->mahaliFoodDet($place);

        $articleUrl = route('safarnameh.list', ['type' => 'place', 'search' => $kindPlaceId . '_' . $place->id]);
        $locationName = ["name" => $place->name, 'state' => $state->name, "stateNameUrl" => $state->name,
                        'cityName' => $city->name, 'cityNameUrl' => $city->name, 'articleUrl' => $articleUrl,
                        'kindState' => 'city', 'kindPage' => 'place'];

        $mainPic = count($sitePics) > 0 ? $sitePics[0]['f'] : URL::asset('images/mainPics/nopicv01.jpg');
        $video = isset($place->video) ? $place->video : '';

        $reviewAction = Activity::where('name', 'نظر')->first();
        $place->firstReview = \DB::table('log')
                    ->where('activityId', $reviewAction->id)
                    ->where('kindPlaceId', $kindPlaceId)
                    ->where('placeId', $place->id)
                    ->first();
        if($place->firstReview != null)
            $place->firstReview = reviewTrueType($place->firstReview);

        $questionAction = Activity::where('name', 'سوال')->first();
        $place->firstQuestion = \DB::table('log')
                    ->where('activityId', $questionAction->id)
                    ->where('kindPlaceId', $kindPlaceId)
                    ->where('placeId', $place->id)
                    ->first();
        if($place->firstQuestion != null)
            $place->firstQuestion = questionTrueType($place->firstQuestion);

        $place->mainPic = $mainPic;

        $localStorageData = ['kind' => 'place', 'name' => $place->name, 'city' => $city->name, 'state' => $state->name, 'mainPic' => $mainPic, 'redirect' => \Request::url()];
        session(['inPage' => 'place_' . $kindPlaceId . '_' . $place->id]);

        return view('pages.placeDetails.placeDetails', array('place' => $place, 'features' => $features , 'save' => $save, 'city' => $city, 'thumbnail' => $thumbnail,
            'state' => $state, 'avgRate' => $rates['avg'], 'rates' => $rates['numOfRate'], 'yourRate' => $rates['yourRate'], 'locationName' => $locationName, 'localStorageData' => $localStorageData,
            'reviewCount' => $reviewCount, 'ansReviewCount' => $ansReviewCount, 'userReviewCount' => $userReviewCount, 'photographerPics' => $photographerPics,
            'userPic' => $uPic, 'rateQuestion' => $rateQuestion, 'textQuestion' => $textQuestion, 'multiQuestion' => $multiQuestion,
            'sitePics' => $sitePics, 'userCode' => $userCode, 'kindPlaceId' => $kindPlaceId, 'mode' => 'city',
            'photos' => $photos, 'userPhotos' => $userPhotos, 'userVideo' => $userVideo,
            'config' => ConfigModel::first(), 'hasLogin' => $hasLogin, 'bookMark' => $bookMark, 'err' => '',
            'placeStyles' => PlaceStyle::where('kindPlaceId',$kindPlaceId)->get(), 'kindPlace' => $kindPlace,
            'placeMode' => $kindPlace->tableName, 'video' => $video,
            'sections' => SectionPage::wherePage(getValueInfo('hotel-detail'))->get()));
    }

    public function getNearby()
    {
        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {

            $count = isset($_POST["count"]) ? $_POST["count"] : 4;

            $kindPlace = Place::find($_POST["kindPlaceId"]);
            if($kindPlace == null){
                echo 'nok';
                return;
            }
            else
                $place = DB::table($kindPlace->tableName)->find($_POST["placeId"]);

            if ($place != null) {
                $today = getToday()["date"];
                $nowTime = getToday()["time"];

                $cityId = $place->cityId;
                $safarnamehId = SafarnamehCityRelations::where('cityId', $cityId)->pluck('safarnamehId')->toArray();
                if(count($safarnamehId) < 5){
                    $state = Cities::find($cityId);
                    if($state != null){
                        $psId = SafarnamehCityRelations::where('stateId', $state->id)->where('cityId', 0)->pluck('safarnamehId')->toArray();
                        $safarnamehId = array_merge($safarnamehId, $psId);
                    }
                }

                $safarnameh = array();

                if(count($safarnamehId) != 0) {
                    $allSafarnameh = Safarnameh::whereRaw('(date <= ' . $today . ' OR (date = ' . $today . ' AND (time < ' . $nowTime . ' || time IS NULL)))')
                                                ->where('release', '!=','draft')
                                                ->whereIn('id', $safarnamehId)
                                                ->where('confirm', 1)
                                                ->take(10)
                                                ->select(['userId', 'id', 'title', 'meta',
                                                        'slug', 'seen', 'date', 'created_at',
                                                        'pic', 'keyword'])
                                                ->orderBy('date', 'DESC')
                                                ->get();

                    foreach ($allSafarnameh as $i)
                        array_push($safarnameh, $i);
                }

                if(count($safarnameh) < 5){
                    $alP = Safarnameh::whereRaw('(date <= ' . $today . ' OR (date = ' . $today . ' AND (time < ' . $nowTime . ' || time IS NULL)))')
                                    ->where('release', '!=','draft')
                                    ->whereNotIn('id', $safarnamehId)
                                    ->where('confirm', 1)
                                    ->take(10 - count($safarnameh))
                                    ->select(['userId', 'id', 'title',
                                              'meta', 'slug', 'seen',
                                              'date', 'created_at',
                                               'pic', 'keyword'])
                                    ->orderBy('date', 'DESC')
                                    ->get();

                    if(count($safarnameh) == 0)
                        $safarnameh = $alP;
                    else{
                        foreach ($alP as $i)
                            array_push($safarnameh, $i);
                    }
                }

                foreach ($safarnameh as $item) {
                    $item = SafarnamehMinimalData($item);
                    $item->name = $item->title;
                    $item->review = $item->msgs;
                }

                $places = $this->getNearbies($place->C, $place->D, $count, $_POST["kindPlaceId"]);

                $selectedPlace = \DB::table($kindPlace->tableName)->select(['id', 'name', 'reviewCount', 'fullRate', 'slug', 'alt', 'cityId', 'C', 'D'])->find($place->id);
                $selectedPlace->pic = getPlacePic($selectedPlace->id, $kindPlace->id);
                $selectedPlace->distance = 0;
                $selectedPlace->review = $selectedPlace->reviewCount;
                $selectedPlace->rate = floor($selectedPlace->fullRate);
                $selectedPlace->url =  createUrl($kindPlace->id, $selectedPlace->id, 0, 0, 0);
                if($selectedPlace->cityId != 0) {
                    $selectedPlace->city = Cities::find($selectedPlace->cityId);
                    $selectedPlace->state = State::find($selectedPlace->city->stateId);

                    $selectedPlace->cityName = $selectedPlace->city->name;
                    $selectedPlace->stateName = $selectedPlace->state->name;

                    $selectedPlace->city = $selectedPlace->city->name;
                    $selectedPlace->state = $selectedPlace->state->name;
                }

                $places['selected'] = [$selectedPlace];

                return response()->json(['places' => $places, 'safarnameh' => $safarnameh]);
            }
        }

        return response()->json([]);
    }

    public function setBookMark()
    {
        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {
            $uId = Auth::user()->id;
            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $kindPlace = Place::find($kindPlaceId);

            $bookmarkKind = BookMarkReference::where('tableName', $kindPlace->tableName)->first();
            $bookmark = BookMark::where('userId', $uId)
                                ->where('referenceId', $placeId)
                                ->where('bookMarkReferenceId', $bookmarkKind->id)
                                ->first();
            if($bookmark == null){
                $bookmark = new BookMark();
                $bookmark->userId = $uId;
                $bookmark->referenceId = $placeId;
                $bookmark->bookMarkReferenceId = $bookmarkKind->id;
                $bookmark->save();
                return response()->json('ok-add');
            }
            else{
                $bookmark->delete();
                return response()->json('ok-del');
            }
        }

        return response()->json('error1');
    }

    function getCommentsCount()
    {
        if (isset($_POST["filters"]) && isset($_POST["placeId"]) && isset($_POST["kindPlaceId"]) &&
            isset($_POST["tag"])) {

            $filters = $_POST["filters"];
            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $activityId = Activity::whereName('نظر')->first()->id;
            $tag = makeValidInput($_POST["tag"]);
            $season = [];
            $rate = [];
            $placeStyle = [];
            $srcCity = [];

            $total = DB::select("select count(*) as countNum from log, comment WHERE confirm = 1 and log.id = logId and placeId = " . $placeId . " and kindPlaceId = " . $kindPlaceId . " and activityId = " . $activityId . " and status = 1")[0]->countNum;

            if ($filters != -1) {

                for ($i = 0; $i < count($filters); $i++) {

                    $filter = makeValidInput($filters[$i]);

                    $subStr = explode('_', $filter);
                    if (count($subStr) == 2) {
                        switch ($subStr[0]) {
                            case "season":
                                $season[count($season)] = $subStr[1];
                                break;
                            case "rate":
                                $rate[count($rate)] = $subStr[1];
                                break;
                            case "placeStyle":
                                $placeStyle[count($placeStyle)] = $subStr[1];
                                break;
                            case "srcCity":
                                $srcCity[count($srcCity)] = $subStr[1];
                                break;
                        }
                    }

                }
            }

            $sql = "";

            if (count($season) > 0)
                $sql .= " and (";

            for ($i = 0; $i < count($season) - 1; $i++) {
                $sql .= "seasonTrip = " . $season[$i] . " OR ";
            }

            if (count($season) > 0)
                $sql .= "seasonTrip = " . $season[count($season) - 1] . ')';

            if (count($placeStyle) > 0)
                $sql .= " and (";

            for ($i = 0; $i < count($placeStyle) - 1; $i++) {
                $sql .= "placeStyleId = " . $placeStyle[$i] . " OR ";
            }

            if (count($placeStyle) > 0)
                $sql .= "placeStyleId = " . $placeStyle[count($placeStyle) - 1] . ')';

            if (count($srcCity) > 0)
                $sql .= " and (";

            for ($i = 0; $i < count($srcCity) - 1; $i++) {
                $sql .= "src = '" . $srcCity[$i] . "' OR ";
            }

            if (count($srcCity) > 0)
                $sql .= "src = '" . $srcCity[count($srcCity) - 1] . "')";

            if (count($rate) > 0) {

                $sql .= ' and visitorId in (';

                $rates = DB::select('select avg(rate) as AVGRATE, logId from log, userOpinions WHERE log.id = logId and placeId = ' . $placeId . " and kindPlaceId = " . $kindPlaceId . " and activityId = " . Activity::whereName('امتیاز')->first()->id . " group by(visitorId)");
                $first = true;
                foreach ($rates as $itr) {
                    $itr->AVGRATE = ceil($itr->AVGRATE);
                    if (in_array($itr->AVGRATE, $rate)) {
                        if (!$first)
                            $sql .= ', ';
                        else
                            $first = false;

                        $sql .= LogModel::whereId($itr->logId)->visitorId;
                    }
                }

                if ($first == true) {
                    $sql .= ' -1 ';
                }

                $sql .= ')';
            }

            if ($tag != -1)
                $sql .= " and text LIKE '%$tag%'";

            $sql .= " and status = 1 and confirm = 1";

            $logs = DB::select('select count(*) as countNum from log, comment WHERE log.id = logId and placeId = ' . $placeId .
                " and kindPlaceId = " . $kindPlaceId . " and ActivityId = " . $activityId .
                $sql);

            echo json_encode([$logs[0]->countNum, $total]);
        }
    }

    function opOnComment()
    {

        if (isset($_POST["logId"]) && isset($_POST["mode"])) {

            $uId = Auth::user()->id;
            $logId = makeValidInput($_POST["logId"]);
            $mode = makeValidInput($_POST["mode"]);

            $tmp = LogModel::whereId($logId);
            if ($tmp == null || $tmp->confirm != 1)
                return;

            if ($mode == "like")
                echo $this->likeComment($uId, $logId);
            else if ($mode == "dislike")
                echo $this->dislikeComment($uId, $logId);

        }

    }

    function getOpinionRate()
    {

        if (isset($_POST["opinionId"]) && isset($_POST["kindPlaceId"]) && isset($_POST["placeId"])) {

            $uId = Auth::user()->id;
            $condition = ['placeId' => makeValidInput($_POST["placeId"]), 'confirm' => 1,
                'kindPlaceId' => makeValidInput($_POST["kindPlaceId"]), 'visitorId' => $uId,
                'activityId' => Activity::whereName('امتیاز')->first()->id];

            try {
                $logId = LogModel::where($condition)->first()->id;

                $condition = ['logId' => $logId, 'opinionId' => makeValidInput($_POST["opinionId"])];
                echo UserOpinion::where($condition)->first()->rate;
            } catch (Exception $x) {
                echo 0;
            }
        }
    }

    function setPlaceRate()
    {
        if (isset($_POST["opinionId"]) && isset($_POST["rate"]) && isset($_POST["kindPlaceId"]) && isset($_POST["placeId"])) {

            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $uId = Auth::user()->id;
            $activityId = Activity::whereName('امتیاز')->first()->id;

            $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'visitorId' => $uId, 'activityId' => $activityId];

            $log = LogModel::where($condition)->first();

            if ($log == null) {

                $log = new LogModel();
                $log->visitorId = $uId;
                $log->time = getToday()["time"];
                $log->activityId = $activityId;
                $log->placeId = $placeId;
                $log->kindPlaceId = $kindPlaceId;
                $log->date = date('Y-m-d');
                $log->confirm = 1;
                $log->save();

                $opinion = new UserOpinion();
                $opinion->logId = $log->id;
                $opinion->opinionId = makeValidInput($_POST["opinionId"]);
                $opinion->rate = makeValidInput($_POST["rate"]);

                try {
                    $opinion->save();
                } catch (Exception $x) {
                    echo $x->getMessage();
                }

            } else {

                $condition = ['logId' => $log->id, 'opinionId' => makeValidInput($_POST["opinionId"])];
                $opinion = UserOpinion::where($condition)->first();
                if ($opinion == null) {
                    $opinion = new UserOpinion();
                    $opinion->logId = $log->id;
                    $opinion->opinionId = makeValidInput($_POST["opinionId"]);
                    $opinion->rate = makeValidInput($_POST["rate"]);

                    try {
                        $opinion->save();
                    } catch (Exception $x) {
                        echo $x->getMessage();
                    }

                } else {
                    $opinion->rate = makeValidInput($_POST["rate"]);

                    try {
                        $opinion->save();
                    } catch (Exception $x) {
                        echo $x->getMessage();
                    }
                }
            }
        }
    }

    function sendComment()
    {

        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"]) && isset($_POST["placeStyle"]) &&
            isset($_POST["reviewTitle"]) && isset($_POST["reviewText"]) && isset($_POST["src"]) &&
            isset($_POST["seasonTrip"]) && isset($_POST["status"])) {

            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $placeStyle = makeValidInput($_POST["placeStyle"]);
            $reviewText = makeValidInput($_POST["reviewText"]);
            $reviewTitle = makeValidInput($_POST["reviewTitle"]);
            $src = makeValidInput($_POST["src"]);
            $seasonTrip = makeValidInput($_POST["seasonTrip"]);
            $status = makeValidInput($_POST["status"]);
            $uId = Auth::user()->id;

            $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'visitorId' => $uId,
                'activityId' => Activity::whereName('امتیاز')->first()->id];
            $log = LogModel::where($condition)->first();

            if ($log == null) {
                echo "-1";
                return;
            }

            if (empty($reviewTitle)) {
                echo "-2";
                return;
            }

            if (empty($reviewText)) {
                echo "-3";
                return;
            }

            if (empty($placeStyle)) {
                echo "-4";
                return;
            }

            if (empty($src)) {
                echo "-5";
                return;
            }

            if (empty($seasonTrip)) {
                echo "-6";
                return;
            }

            if (Cities::whereName($src)->count() == 0) {
                echo "-7";
                return;
            }

            if ($status == 1)
                $status = true;
            else
                $status = false;

            $activityId = Activity::whereName('نظر')->first()->id;

            $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'visitorId' => $uId,
                'activityId' => $activityId];

            $log = LogModel::where($condition)->first();

            if ($log == null) {
                $log = new LogModel();
                $log->visitorId = $uId;
                $log->time = getToday()["time"];
                $log->activityId = Activity::whereName('نظر')->first()->id;
                $log->placeId = $placeId;
                $log->kindPlaceId = $kindPlaceId;
                $log->date = date('Y-m-d');
                $log->text = $reviewText;
                $log->subject = $reviewTitle;

                $log->save();

                $comment = new Comment();
                $comment->status = $status;
                $comment->src = $src;
                $comment->logId = $log->id;
                $comment->placeStyleId = $placeStyle;
                $comment->seasonTrip = $seasonTrip;
                $comment->save();

            } else {

                $log->text = $reviewText;
                $log->subject = $reviewTitle;
                $log->confirm = 0;
                $log->save();

                $comment = Comment::whereLogId($log->id)->first();

                if ($comment != null) {
                    $comment->status = $status;
                    $comment->src = $src;
                    $comment->logId = $log->id;
                    $comment->placeStyleId = $placeStyle;
                    $comment->seasonTrip = $seasonTrip;
                    $comment->save();
                }

            }

            echo "ok";

        }

    }

    function getComment()
    {

        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {

            $uId = Auth::user()->id;
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);

            $condition = ['placeId' => makeValidInput($_POST["placeId"]),
                'kindPlaceId' => $kindPlaceId, 'confirm' => 1,
                'visitorId' => $uId, 'activityId' => Activity::whereName('نظر')->first()->id];

            $log = LogModel::where($condition)->first();

            if ($log != null) {
                $out = [];
                $out["reviewText"] = $log->text;
                $out["reviewTitle"] = $log->subject;

                if ($log->pic != "")
                    $out["reviewPic"] = URL::asset('userPhoto/comments/' . $kindPlaceId . '/' . $log->pic);
                else
                    $out["reviewPic"] = -1;

                $comment = Comment::whereLogId($log->id)->first();
                if ($comment != null) {
                    $out["src"] = $comment->src;
                    $out["placeStyle"] = $comment->placeStyleId;
                    $out["seasonTrip"] = $comment->seasonTrip;
                    echo json_encode($out);
                }
            }
        }
    }

    function filterComments()
    {
        if (isset($_POST["filters"]) && isset($_POST["placeId"]) && isset($_POST["kindPlaceId"]) &&
            isset($_POST["tag"]) && isset($_POST["page"])) {

            $filters = $_POST["filters"];
            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $activityId = Activity::whereName('نظر')->first()->id;
            $rateActivityId = Activity::whereName('امتیاز')->first()->id;
            $tag = makeValidInput($_POST["tag"]);
            $season = [];
            $rate = [];
            $placeStyle = [];
            $srcCity = [];

            if ($filters != -1) {

                for ($i = 0; $i < count($filters); $i++) {

                    $filter = makeValidInput($filters[$i]);

                    $subStr = explode('_', $filter);
                    if (count($subStr) == 2) {
                        switch ($subStr[0]) {
                            case "season":
                                $season[count($season)] = $subStr[1];
                                break;
                            case "rate":
                                $rate[count($rate)] = $subStr[1];
                                break;
                            case "placeStyle":
                                $placeStyle[count($placeStyle)] = $subStr[1];
                                break;
                            case "srcCity":
                                $srcCity[count($srcCity)] = $subStr[1];
                                break;
                        }
                    }

                }
            }

            $sql = "";

            if (count($season) > 0)
                $sql .= " and (";

            for ($i = 0; $i < count($season) - 1; $i++) {
                $sql .= "seasonTrip = " . $season[$i] . " OR ";
            }

            if (count($season) > 0)
                $sql .= "seasonTrip = " . $season[count($season) - 1] . ')';

            if (count($placeStyle) > 0)
                $sql .= " and (";

            for ($i = 0; $i < count($placeStyle) - 1; $i++) {
                $sql .= "placeStyleId = " . $placeStyle[$i] . " OR ";
            }

            if (count($placeStyle) > 0)
                $sql .= "placeStyleId = " . $placeStyle[count($placeStyle) - 1] . ')';

            if (count($srcCity) > 0)
                $sql .= " and (";

            for ($i = 0; $i < count($srcCity) - 1; $i++) {
                $sql .= "src = '" . $srcCity[$i] . "' OR ";
            }

            if (count($srcCity) > 0)
                $sql .= "src = '" . $srcCity[count($srcCity) - 1] . "')";

            if (count($rate) > 0) {

                $sql .= ' and visitorId in (';

                $rates = DB::select('select avg(rate) as AVGRATE, logId from log, userOpinions WHERE log.id = logId and placeId = ' . $placeId . " and kindPlaceId = " . $kindPlaceId . " and activityId = " . Activity::whereName('امتیاز')->first()->id . " group by(visitorId)");
                $first = true;
                foreach ($rates as $itr) {
                    $itr->AVGRATE = ceil($itr->AVGRATE);
                    if (in_array($itr->AVGRATE, $rate)) {
                        if (!$first)
                            $sql .= ', ';
                        else
                            $first = false;

                        $sql .= LogModel::whereId($itr->logId)->visitorId;
                    }
                }

                if ($first == true) {
                    $sql .= ' -1 ';
                }

                $sql .= ')';
            }

            if ($tag != -1)
                $sql .= " and text LIKE '%$tag%'";

            $sql .= " and status = 1 and confirm = 1";

            $page = makeValidInput($_POST["page"]);
            $sql .= " limit 6 offset " . (($page - 1) * 6);

            $logs = DB::select('select log.id, visitorId, pic, text, subject, date from log, comment WHERE log.id = logId and placeId = ' . $placeId .
                " and kindPlaceId = " . $kindPlaceId . " and ActivityId = " . $activityId .
                $sql);

            foreach ($logs as $log) {
                $condition = ["activityId" => $activityId, 'visitorId' => $log->visitorId];
                $log->comments = LogModel::where($condition)->count();

                $condition = ["activityId" => $rateActivityId, 'visitorId' => $log->visitorId,
                    'placeId' => $placeId, 'kindPlaceId' => $kindPlaceId];

                $logId = LogModel::where($condition)->first()->id;
                $log->rate = ceil(DB::select('Select AVG(rate) as avgRate from userOpinions WHERE logId = ' . $logId)[0]->avgRate);
                $user = User::whereId($log->visitorId);
                $log->visitorId = $user->username;

                $userPic = $user->picture;

                if (count(explode('.', $userPic)) == 2) {
                    $log->visitorPic = URL::asset('userPhoto/' . $userPic);
                } else {
                    $defaultPic = DefaultPic::whereId($userPic);
                    if ($defaultPic == null)
                        $defaultPic = DefaultPic::first();
                    $log->visitorPic = URL::asset('defaultPic/' . $defaultPic->name);
                }

                $condition = ["logId" => $log->id, "like_" => 1];
                $log->likes = OpOnActivity::where($condition)->count();
                $condition = ["logId" => $log->id, "dislike" => 1];
                $log->dislikes = OpOnActivity::where($condition)->count();

                if (!empty($log->pic))
                    $log->pic = URL::asset('userPhoto/comments/' . $kindPlaceId . '/' . $log->pic);
                else
                    $log->pic = -1;

                $log->date = convertDate($log->date);

            }

            echo json_encode($logs);
        }

    }

    public function seeAllAns($questionId, $mode = "", $logId = -1)
    {
        $hasLogin = true;
        if (!Auth::check())
            $hasLogin = false;

        $log = LogModel::whereId($questionId);
        if ($log == null || $log->confirm != 1)
            return Redirect::to('profile');

        $placeId = $log->placeId;
        $kindPlaceId = $log->kindPlaceId;

        switch ($kindPlaceId) {
            case 1:
            default:
                $place = Amaken::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/amaken/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "amaken";
                break;
            case 3:
                $place = Restaurant::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/restaurant/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "restaurant";
                break;
            case 4:
                $place = Hotel::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/hotels/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "hotel";
                break;
            case 6:
                $place = Majara::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/' . $place->pic_1)))
                    $placePic = URL::asset('_images/majara/' . $place->file . '/' . $place->pic_1);
                else
                    $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                $placeMode = "majara";
                break;
            case 8:
                $place = Adab::whereId($placeId);
                if ($place->category == 3) {
                    if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/' . $place->pic_1)))
                        $placePic = URL::asset('_images/adab/ghazamahali/' . $place->file . '/' . $place->pic_1);
                    else
                        $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                } else {
                    if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/' . $place->pic_1)))
                        $placePic = URL::asset('_images/adab/soghat/' . $place->file . '/' . $place->pic_1);
                    else
                        $placePic = URL::asset('images/mainPics/noPicSite.jpg');
                }
                $placeMode = "adab";
                break;
        }

        $city = Cities::whereId($place->cityId);
        $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId,
            'activityId' => Activity::whereName('پاسخ')->first()->id,
            'relatedTo' => $questionId];

        $answers = LogModel::where($condition)->get();

        foreach ($answers as $answer) {

            $user = User::whereId($answer->visitorId);
            $pic = $user->picture;

            if (count(explode('.', $pic)) != 2) {
                $defaultPic = DefaultPic::whereId($pic);
                if ($defaultPic == null)
                    $pic = URL::asset('defaultPic/' . $defaultPic->name);
                else
                    $pic = URL::asset('defaultPic/' . DefaultPic::first()->name);
            } else {
                $pic = URL::asset('userPhoto/' . $pic);
            }

            $condition = ['logId' => $answer->id, 'like_' => 1];
            $answer->rate = OpOnActivity::where($condition)->count();
            $condition = ['logId' => $answer->id, 'dislike' => 1];
            $answer->rate -= OpOnActivity::where($condition)->count();

            $answer->userPhoto = $pic;
            $city = Cities::whereId($user->cityId);
            $answer->city = $city->name;
            $answer->state = State::whereId($city->stateId)->name;
            $answer->visitorId = $user->username;
            $answer->date = convertDate($answer->date);
        }

        $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId,
            'activityId' => Activity::whereName('نظر')->first()->id];
        $reviews = LogModel::where($condition)->count();

        $question = LogModel::whereId($questionId);
        if ($question != null) {

            $user = User::whereId($question->visitorId);
            $pic = $user->picture;

            if (count(explode('.', $pic)) != 2) {
                $defaultPic = DefaultPic::whereId($pic);
                if ($defaultPic == null)
                    $pic = URL::asset('defaultPic/' . $defaultPic->name);
                else
                    $pic = URL::asset('defaultPic/' . DefaultPic::first()->name);
            } else {
                $pic = URL::asset('userPhoto/' . $pic);
            }

            $question->userPhoto = $pic;

            $city = Cities::whereId($user->cityId);
            $question->city = $city->name;
            $question->state = State::whereId($city->stateId)->name;
            $question->visitorId = $user->username;
            $question->date = convertDate($question->date);
        }

        return view('questionList', array('placePic' => $placePic, 'city' => $city->name,
            'state' => State::whereId($city->stateId)->name, 'placeId' => $placeId, 'placeName' => $place->name,
            'kindPlaceId' => $kindPlaceId, 'answers' => $answers, 'mode' => $mode, 'logId' => $logId,
            'rate' => $place->fullRate, 'hasLogin' => $hasLogin,
            'reviews' => $reviews, 'question' => $question, 'placeMode' => $placeMode));
    }

    public function getPlaceStyles()
    {
        if (isset($_POST["kindPlaceId"]))
            echo \GuzzleHttp\json_encode(PlaceStyle::where('kindPlaceId',makeValidInput($_POST["kindPlaceId"]))->get());
    }

    public function getSrcCities()
    {

        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {
            echo \GuzzleHttp\json_encode(DB::select("select DISTINCT(src) from log, comment WHERE log.placeId = " . makeValidInput($_POST["placeId"]) . ' and ' .
                'kindPlaceId = ' . makeValidInput($_POST["kindPlaceId"]) . ' and activityId = ' . Activity::whereName('نظر')->first()->id .
                ' and logId = log.id and status = 1'));
        }
    }

    public function getTags()
    {
        if (isset($_POST["kindPlaceId"]))
            echo \GuzzleHttp\json_encode(Tag::where('kindPlaceId', '=', makeValidInput($_POST["kindPlaceId"]))->get());
    }

    public function showAllPlaces($placeId1, $kindPlaceId1, $placeId2 = "", $kindPlaceId2 = "", $placeId3 = "", $kindPlaceId3 = "", $placeId4 = "", $kindPlaceId4 = "", $mode = "", $err = "")
    {
        $hasLogin = true;
        $kindPlaceIds = [$kindPlaceId1, $kindPlaceId2, $kindPlaceId3, $kindPlaceId4];

        $placeIds = [$placeId1, $placeId2, $placeId3, $placeId4];
        $uId = -1;
        $bookMarks = [];
        $ratesArr = [];
        $saves = [];
        $places = [];
        $cityNames = [];
        $stateNames = [];
        $tagsArr = [];
        $sitePhotosArr = [];
        $placeModes = [];
        $photosArr = [];
        $validate = [true, true, true, true];
        $nearbiesArr = [];

        if (Auth::check())
            $uId = Auth::user()->id;
        else
            $hasLogin = false;

        for ($i = 0; $i < 4; $i++) {

            if ($kindPlaceIds[$i] == "") {
                $validate[$i] = false;
                continue;
            }

            if ($kindPlaceIds[$i] != 1 && $kindPlaceIds[$i] != 3 && $kindPlaceIds[$i] != 4 &&
                $kindPlaceIds[$i] != 8 && $kindPlaceIds[$i] != 6)
                return Redirect::route('main');

            switch ($kindPlaceIds[$i]) {
                case 1:
                default:
                    $place = Amaken::whereId($placeIds[$i]);
                    $imgPath = "amaken";
                    $imgPath2 = "amaken";
                    break;
                case 3:
                    $place = Restaurant::whereId($placeIds[$i]);
                    $imgPath = "restaurant";
                    $imgPath2 = "restaurant";
                    break;
                case 4:
                    $place = Hotel::whereId($placeIds[$i]);
                    $imgPath = "hotels";
                    $imgPath2 = "hotel";
                    break;
                case 6:
                    $place = Majara::whereId($placeIds[$i]);
                    $imgPath = "majara";
                    $imgPath2 = "majara";
                    break;
                case 8:
                    $place = Adab::whereId($placeIds[$i]);
                    if ($place->category == 3) {
                        $imgPath = "adab/ghazamahali";
                        $imgPath2 = "ghazamahali";
                    } else {
                        $imgPath = "adab/soghat";
                        if ($place->category == 1)
                            $imgPath2 = "soghat";
                        else
                            $imgPath2 = "sanaye";
                    }
                    break;
            }

            if ($place == null)
                return Redirect::route('main');

            $kindPlaceId = $kindPlaceIds[$i];

            if ($hasLogin) {

                $activityId = Activity::whereName('مشاهده')->first()->id;

                $condition = ['visitorId' => $uId, 'placeId' => $placeIds[$i], 'kindPlaceId' => $kindPlaceId,
                    'activityId' => $activityId];
                $log = LogModel::where($condition)->first();
                if ($log == null) {
                    $log = new LogModel();
                    $log->activityId = $activityId;
                    $log->time = getToday()["time"];
                    $log->placeId = $placeIds[$i];
                    $log->kindPlaceId = $kindPlaceId;
                    $log->visitorId = $uId;
                    $log->date = date('Y-m-d');
                    $log->save();
                } else {
                    $log->date = date('Y-m-d');
                    $log->save();
                }
            }

            $placeModes[$i] = $imgPath2;

            $bookMark = false;
            $condition = ['visitorId' => $uId, 'activityId' => Activity::whereName("نشانه گذاری")->first()->id,
                'placeId' => $placeIds[$i], 'kindPlaceId' => $kindPlaceId];

            if (LogModel::where($condition)->count() > 0)
                $bookMark = true;

            $bookMarks[$i] = $bookMark;

            $ratesArr[$i] = $place->fullRate;

            $save = false;
            $count = DB::select("select count(*) as tripPlaceNum from trip, tripPlace WHERE tripPlace.placeId = " . $placeIds[$i] . " and tripPlace.kindPlaceId = " . $kindPlaceId . " and tripPlace.tripId = trip.id and trip.uId = " . $uId);
            if ($count[0]->tripPlaceNum > 0)
                $save = true;

            $saves[$i] = $save;

            if ($kindPlaceId != 8) {
                $city = Cities::whereId($place->cityId);
                $state = State::whereId($city->stateId)->name;
            } else {
                $city = State::whereId($place->stateId);
                $state = $city;
            }

            $cityNames[$i] = $city->name;
            $stateNames[$i] = $state;

            $photos = [];
            if (!empty($place->pic_1)) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_1)))
                    $photos[count($photos)] = URL::asset('_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_1);
                else
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
            } else
                $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');

            if (!empty($place->pic_2)) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_2)))
                    $photos[count($photos)] = URL::asset('_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_2);
                else
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
            }

            if (!empty($place->pic_3)) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_3)))
                    $photos[count($photos)] = URL::asset('_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_3);
                else
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
            }

            if (!empty($place->pic_4)) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_4)))
                    $photos[count($photos)] = URL::asset('_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_4);
                else
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
            }

            if (!empty($place->pic_5)) {
                if (file_exists((__DIR__ . '/../../../../assets/_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_5)))
                    $photos[count($photos)] = URL::asset('_images/' . $imgPath . '/' . $place->file . '/' . $place->pic_5);
                else
                    $photos[count($photos)] = URL::asset('images/mainPics/noPicSite.jpg');
            }

            $sitePhotosArr[$i] = count($photos);

            $activityId = Activity::whereName('عکس')->first()->id;
            $tmp = DB::select("select text from log WHERE confirm = 1 and activityId = " . $activityId . " and placeId = " . $placeIds[$i] . " and kindPlaceId = " . $kindPlaceId . " and pic <> 0");
            foreach ($tmp as $itr)
                $photos[count($photos)] = URL::asset('userPhoto/' . $imgPath2 . '/l-' . $itr->text);

            $photosArr[$i] = $photos;
            $places[$i] = $place;

            if ($kindPlaceId == 8) {
                $brands = [];

                if (!empty($place->brand_name_1)) {
                    $brands[count($brands)] = $place->brand_name_1 . "<br/>" . $place->des_name_1;
                }
                if (!empty($place->brand_name_2)) {
                    $brands[count($brands)] = $place->brand_name_2 . "<br/>" . $place->des_name_2;
                }
                if (!empty($place->brand_name_3)) {
                    $brands[count($brands)] = $place->brand_name_3 . "<br/>" . $place->des_name_3;
                }
                if (!empty($place->brand_name_4)) {
                    $brands[count($brands)] = $place->brand_name_4 . "<br/>" . $place->des_name_4;
                }
                if (!empty($place->brand_name_5)) {
                    $brands[count($brands)] = $place->brand_name_5 . "<br/>" . $place->des_name_5;
                }
                if (!empty($place->brand_name_6)) {
                    $brands[count($brands)] = $place->brand_name_6 . "<br/>" . $place->des_name_6;
                }

                $nearbiesArr[$i] = $brands;
            } else {
                $nearbiesArr[$i] = [];
            }

        }

        return view('showAllPlaces', array('places' => $places, 'saves' => $saves, 'cityNames' => $cityNames, 'nearbies' => $nearbiesArr,
            'tags' => $tagsArr, 'stateNames' => $stateNames, 'avgRates' => $ratesArr, 'photos' => $photosArr,
            'kindPlaceIds' => $kindPlaceIds, 'mode' => $mode, 'rates' => $ratesArr, 'sitePhotos' => $sitePhotosArr,
            'hasLogin' => $hasLogin, 'bookMarks' => $bookMarks, 'childAge' => ConfigModel::first()->childAge, 'err' => $err,
            'validate' => $validate, 'placeMode' => 'policies', 'placeModes' => $placeModes));
    }

    public function showUserBriefDetail()
    {

        if (isset($_POST["username"])) {

            $username = makeValidInput($_POST['username']);

            if ($username == 'سایت')
                return;

            $user = User::whereUserName($username)->first();

            $city = Cities::whereId($user->cityId);
            if ($city == null) {
                $out["city"] = "نامشخص";
                $out["state"] = "نامشخص";
            } else {
                $out["city"] = $city->name;
                $out["state"] = State::whereId($city->stateId)->name;
            }

            $rateActivity = Activity::whereName('امتیاز')->first()->id;
            $condition = ['visitorId' => $user->id, 'activityId' => $rateActivity];
            $out["rates"] = LogModel::where($condition)->count();

            $condition = ['visitorId' => $user->id, 'activityId' => Activity::whereName('مشاهده')->first()->id];
            $out["seen"] = LogModel::where($condition)->count();

            $activityId = Activity::whereName('پاسخ')->first()->id;
            $out["likes"] = DB::select('select count(*) as countNum from log, opOnActivity WHERE logId = log.id and visitorId = ' . $user->id . ' and activityId = ' . $activityId . ' and like_ = 1')[0]->countNum;

            $out["dislikes"] = DB::select('select count(*) as countNum from log, opOnActivity WHERE logId = log.id and visitorId = ' . $user->id . ' and activityId = ' . $activityId . ' and dislike = 1')[0]->countNum;

            $out["excellent"] = DB::select("SELECT COUNT(*) as countNum FROM log WHERE visitorId = " . $user->id . " and activityId = " . $rateActivity . " and (SELECT AVG(rate) FROM userOpinions WHERE logId = log.id) > 4")[0]->countNum;
            $out["veryGood"] = DB::select("SELECT COUNT(*) as countNum FROM log WHERE visitorId = " . $user->id . " and activityId = " . $rateActivity . " and (SELECT AVG(rate) FROM userOpinions WHERE logId = log.id) > 3")[0]->countNum - $out["excellent"];
            $out["average"] = DB::select("SELECT COUNT(*) as countNum FROM log WHERE visitorId = " . $user->id . " and activityId = " . $rateActivity . " and (SELECT AVG(rate) FROM userOpinions WHERE logId = log.id) > 2")[0]->countNum - $out["veryGood"] - $out["excellent"];
            $out["bad"] = DB::select("SELECT COUNT(*) as countNum FROM log WHERE visitorId = " . $user->id . " and activityId = " . $rateActivity . " and (SELECT AVG(rate) FROM userOpinions WHERE logId = log.id) > 1")[0]->countNum - $out["veryGood"] - $out["average"] - $out["excellent"];
            $out["veryBad"] = DB::select("SELECT COUNT(*) as countNum FROM log WHERE visitorId = " . $user->id . " and activityId = " . $rateActivity . " and (SELECT AVG(rate) FROM userOpinions WHERE logId = log.id) > 0")[0]->countNum - $out["veryGood"] - $out["average"] - $out["excellent"] - $out["bad"];

            $out["level"] = nearestLevel($user->id)[0]->name;

            $out["created"] = convertDate($user->created_at);

            echo json_encode($out);

        }

    }

    public function getPhotos()
    {

        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"]) && isset($_POST["picItemId"])) {

            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $picItemId = makeValidInput($_POST["picItemId"]);

            $activityId = Activity::whereName('عکس')->first()->id;

            $logs = [];

            if ($picItemId != -2) {
                if ($picItemId == -1) {
                    $condition = ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId,
                        'activityId' => $activityId];
                    $logs = LogModel::where($condition)->select('text', 'visitorId')->get();
                } else if ($picItemId == -3) {
                    $logs = DB::select("select text, visitorId FROM log WHERE placeId = " . $placeId . " and kindPlaceId = " . $kindPlaceId . " and activityId = " . $activityId);
                } else
                    $logs = DB::select("select text, visitorId FROM log WHERE placeId = " . $placeId . " and kindPlaceId = " . $kindPlaceId . " and activityId = " . $activityId . " and pic = " . $picItemId);
            }

            $arr = [];
            $count = 0;

            $photoFilters = DB::select("select name, id, (SELECT count(*) FROM log WHERE placeId = " . $placeId . " and log.kindPlaceId = " . $kindPlaceId . " and activityId = " . $activityId . " and pic = picItems.id) as countNum FROM picItems WHERE kindPlaceId = " . $kindPlaceId);

            $userPic = URL::asset('images/icons/KOFAV0.svg');

            switch ($kindPlaceId) {
                case 1:
                default:

                    if ($picItemId == -1 || $picItemId == -2) {
                        $place = Amaken::whereId($placeId);
                        if ($place->pic_1 != "") {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/s-1.jpg')))
                                $arr[$count]['pic'] = URL::asset('_images/amaken/' . $place->file . '/s-1.jpg');
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');
                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/t-1.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/amaken/' . $place->file . '/t-1.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]['alt'] = $place->alt1;
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_2 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/s-2.jpg' )))
                                $arr[$count]['pic'] = URL::asset('_images/amaken/' . $place->file . '/s-2.jpg' );
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');
                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/t-2.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/amaken/' . $place->file . '/t-2.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('images/mainPics/noPicSite.jpg');
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt2;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_3 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/s-3.jpg' )))
                                $arr[$count]['pic'] = URL::asset('_images/amaken/' . $place->file . '/s-3.jpg' );
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');
                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/t-3.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/amaken/' . $place->file . '/t-3.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt3;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_4 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/s-4.jpg')))
                                $arr[$count]['pic'] = URL::asset('_images/amaken/' . $place->file . '/s-4.jpg');
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');
                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/t-4.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/amaken/' . $place->file . '/t-4.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt4;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_5 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/s-5.jpg')))
                                $arr[$count]['pic'] = URL::asset('_images/amaken/' . $place->file . '/s-5.jpg');
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');
                            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $place->file . '/t-5.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/amaken/' . $place->file . '/t-5.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt5;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                    }

                    foreach ($logs as $log) {

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/amaken/l-' . $log->text))
                            $arr[$count]["pic"] = URL::asset("userPhoto/amaken/l-" . $log->text);
                        else
                            $arr[$count]["pic"] = URL::asset("images/mainPics/noPicSite.jpg");

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/amaken/s-' . $log->text))
                            $arr[$count]["picT"] = URL::asset("userPhoto/amaken/s-" . $log->text);
                        else
                            $arr[$count]["picT"] = URL::asset("images/mainPics/noPicSite.jpg");

                        $user = User::whereId($log->visitorId);
                        $arr[$count]["owner"] = $user->username;
                        $userPic = $user->picture;
                        if (count(explode('.', $userPic)) == 2)
                            $userPic = URL::asset("userPhoto/" . $userPic);
                        else {
                            $defaultPic = DefaultPic::whereId($userPic);
                            if ($defaultPic == null || count($defaultPic) == 0)
                                $defaultPic = DefaultPic::first();
                            $userPic = URL::asset('defaultPic/' . $defaultPic->name);
                        }
                        $arr[$count++]["ownerPic"] = $userPic;
                    }
                    break;

                case 3:

                    if ($picItemId == -1 || $picItemId == -2) {
                        $place = Restaurant::whereId($placeId);
                        if ($place->pic_1) {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/s-1.jpg')))
                                $arr[$count]['pic'] = URL::asset('_images/restaurant/' . $place->file . '/s-1.jpg');
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/t-1.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/restaurant/' . $place->file . '/t-1.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('_images/restaurant');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt1;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_2) {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/s-2.jpg' )))
                                $arr[$count]['pic'] = URL::asset('_images/restaurant/' . $place->file . '/s-2.jpg' );
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/t-2.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/restaurant/' . $place->file . '/t-2.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('_images/restaurant');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt2;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_3) {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/s-3.jpg' )))
                                $arr[$count]['pic'] = URL::asset('_images/restaurant/' . $place->file . '/s-3.jpg' );
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/t-3.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/restaurant/' . $place->file . '/t-3.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('_images/restaurant');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt3;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_4) {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/s-4.jpg')))
                                $arr[$count]['pic'] = URL::asset('_images/restaurant/' . $place->file . '/s-4.jpg');
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/t-4.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/restaurant/' . $place->file . '/t-4.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('_images/restaurant');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt4;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_5) {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/s-5.jpg')))
                                $arr[$count]['pic'] = URL::asset('_images/restaurant/' . $place->file . '/s-5.jpg');
                            else
                                $arr[$count]['pic'] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $place->file . '/t-5.jpg')))
                                $arr[$count]['picT'] = URL::asset('_images/restaurant/' . $place->file . '/t-5.jpg');
                            else
                                $arr[$count]['picT'] = URL::asset('_images/restaurant');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt5;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                    }

                    foreach ($logs as $log) {

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/restaurant/l-' . $log->text))
                            $arr[$count]["pic"] = URL::asset("userPhoto/restaurant/l-" . $log->text);
                        else
                            $arr[$count]["pic"] = URL::asset("images/mainPics/noPicSite.jpg");

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/restaurant/s-' . $log->text))
                            $arr[$count]["picT"] = URL::asset("userPhoto/restaurant/s-" . $log->text);
                        else
                            $arr[$count]["picT"] = URL::asset("images/mainPics/noPicSite.jpg");

                        $user = User::whereId($log->visitorId);
                        $arr[$count]["owner"] = $user->username;
                        $userPic = $user->picture;
                        if (count(explode('.', $userPic)) == 2)
                            $userPic = URL::asset("userPhoto/" . $userPic);
                        else {
                            $defaultPic = DefaultPic::whereId($userPic);
                            if ($defaultPic == null || count($defaultPic) == 0)
                                $defaultPic = DefaultPic::first();
                            $userPic = URL::asset('defaultPic/' . $defaultPic->name);
                        }
                        $arr[$count++]["ownerPic"] = $userPic;
                    }
                    break;

                case 4:

                    if ($picItemId == -1 || $picItemId == -2) {
                        $place = Hotel::whereId($placeId);
                        if ($place->pic_1 != "") {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/s-1.jpg')))
                                $arr[$count]["pic"] = URL::asset('_images/hotels/' . $place->file . '/s-1.jpg');
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/t-1.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/hotels/' . $place->file . '/t-1.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt1;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_2 != "") {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/s-2.jpg' )))
                                $arr[$count]["pic"] = URL::asset('_images/hotels/' . $place->file . '/s-2.jpg' );
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/t-2.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/hotels/' . $place->file . '/t-2.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt2;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_3 != "") {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/s-3.jpg' )))
                                $arr[$count]["pic"] = URL::asset('_images/hotels/' . $place->file . '/s-3.jpg' );
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/t-3.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/hotels/' . $place->file . '/t-3.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt3;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_4 != "") {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/s-4.jpg')))
                                $arr[$count]["pic"] = URL::asset('_images/hotels/' . $place->file . '/s-4.jpg');
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/t-4.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/hotels/' . $place->file . '/t-4.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt4;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_5 != "") {
                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/s-5.jpg')))
                                $arr[$count]["pic"] = URL::asset('_images/hotels/' . $place->file . '/s-5.jpg');
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $place->file . '/t-5.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/hotels/' . $place->file . '/t-5.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt5;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                    }

                    foreach ($logs as $log) {

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/hotels/l-' . $log->text))
                            $arr[$count]["pic"] = URL::asset("userPhoto/hotels/l-" . $log->text);
                        else
                            $arr[$count]["pic"] = URL::asset("images/mainPics/noPicSite.jpg");

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/hotels/s-' . $log->text))
                            $arr[$count]["picT"] = URL::asset("userPhoto/hotels/s-" . $log->text);
                        else
                            $arr[$count]["picT"] = URL::asset("images/mainPics/noPicSite.jpg");

                        $user = User::whereId($log->visitorId);
                        $arr[$count]["owner"] = $user->username;
                        $userPic = $user->picture;
                        if (count(explode('.', $userPic)) == 2)
                            $userPic = URL::asset("userPhoto/" . $userPic);
                        else {
                            $defaultPic = DefaultPic::whereId($userPic);
                            if ($defaultPic == null)
                                $defaultPic = DefaultPic::first();
                            $userPic = URL::asset('defaultPic/' . $defaultPic->name);
                        }
                        $arr[$count++]["ownerPic"] = $userPic;
                    }
                    break;

                case 6:

                    if ($picItemId == -1 || $picItemId == -2) {
                        $place = Majara::whereId($placeId);
                        if ($place->pic_1 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/s-1.jpg')))
                                $arr[$count]["pic"] = URL::asset('_images/majara/' . $place->file . '/s-1.jpg');
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/t-1.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/majara/' . $place->file . '/t-1.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_1 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/s-2.jpg' )))
                                $arr[$count]["pic"] = URL::asset('_images/majara/' . $place->file . '/s-2.jpg' );
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/t-2.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/majara/' . $place->file . '/t-2.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt2;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_1 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/s-3.jpg' )))
                                $arr[$count]["pic"] = URL::asset('_images/majara/' . $place->file . '/s-3.jpg' );
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/t-3.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/majara/' . $place->file . '/t-3.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt3;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_1 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/s-4.jpg')))
                                $arr[$count]["pic"] = URL::asset('_images/majara/' . $place->file . '/s-4.jpg');
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/t-4.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/majara/' . $place->file . '/t-4.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt4;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_1 != "") {

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/s-5.jpg')))
                                $arr[$count]["pic"] = URL::asset('_images/majara/' . $place->file . '/s-5.jpg');
                            else
                                $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                            if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $place->file . '/t-5.jpg')))
                                $arr[$count]["picT"] = URL::asset('_images/majara/' . $place->file . '/t-5.jpg');
                            else
                                $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');

                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt5;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                    }

                    foreach ($logs as $log) {

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/majara/l-' . $log->text))
                            $arr[$count]["pic"] = URL::asset("userPhoto/majara/l-" . $log->text);
                        else
                            $arr[$count]["pic"] = URL::asset("images/mainPics/noPicSite.jpg");

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/majara/s-' . $log->text))
                            $arr[$count]["picT"] = URL::asset("userPhoto/majara/s-" . $log->text);
                        else
                            $arr[$count]["picT"] = URL::asset("images/mainPics/noPicSite.jpg");

                        $user = User::whereId($log->visitorId);
                        $arr[$count]["owner"] = $user->username;
                        $userPic = $user->picture;
                        if (count(explode('.', $userPic)) == 2)
                            $userPic = URL::asset("userPhoto/" . $userPic);
                        else {
                            $defaultPic = DefaultPic::whereId($userPic);
                            if ($defaultPic == null || count($defaultPic) == 0)
                                $defaultPic = DefaultPic::first();
                            $userPic = URL::asset('defaultPic/' . $defaultPic->name);
                        }
                        $arr[$count++]["ownerPic"] = $userPic;
                    }
                    break;

                case 8:

                    if ($picItemId == -1 || $picItemId == -2) {
                        $place = Adab::whereId($placeId);
                        if ($place->pic_1 != "") {
                            if ($place->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/s-1.jpg')))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/s-1.jpg');
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/t-1.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/t-1.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            } else {

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/s-1.jpg')))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/soghat/' . $place->file . '/s-1.jpg');
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/t-1.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/soghat/' . $place->file . '/t-1.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                            $arr[$count]['alt'] = $place->alt1;
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_2 != "") {
                            if ($place->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/s-2.jpg' )))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/s-2.jpg' );
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/t-2.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/t-2.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            } else {

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/s-2.jpg' )))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/soghat/' . $place->file . '/s-2.jpg' );
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/t-2.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/soghat/' . $place->file . '/t-2.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                            $arr[$count]['alt'] = $place->alt2;
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_3 != "") {
                            if ($place->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/s-3.jpg' )))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/s-3.jpg' );
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/t-3.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/t-3.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            } else {

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/s-3.jpg' )))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/soghat/' . $place->file . '/s-3.jpg' );
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/t-3.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/soghat/' . $place->file . '/t-3.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                            $arr[$count]["filter"] = -1;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count]['alt'] = $place->alt3;
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_4 != "") {
                            if ($place->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/s-4.jpg')))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/s-4.jpg');
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/t-4.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/t-4.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            } else {

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/s-4.jpg')))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/soghat/' . $place->file . '/s-4.jpg');
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/t-4.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/soghat/' . $place->file . '/t-4.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt4;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                        if ($place->pic_5 != "") {
                            if ($place->category == 3) {
                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/s-5.jpg')))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/s-5.jpg');
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/ghazamahali/' . $place->file . '/t-5.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/ghazamahali/' . $place->file . '/t-5.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            } else {

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/s-5.jpg')))
                                    $arr[$count]["pic"] = URL::asset('_images/adab/soghat/' . $place->file . '/s-5.jpg');
                                else
                                    $arr[$count]["pic"] = URL::asset('images/mainPics/noPicSite.jpg');

                                if (file_exists((__DIR__ . '/../../../../assets/_images/adab/soghat/' . $place->file . '/t-5.jpg')))
                                    $arr[$count]["picT"] = URL::asset('_images/adab/soghat/' . $place->file . '/t-5.jpg');
                                else
                                    $arr[$count]["picT"] = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                            $arr[$count]["filter"] = -1;
                            $arr[$count]['alt'] = $place->alt5;
                            $arr[$count]["owner"] = "سایت";
                            $arr[$count++]["ownerPic"] = $userPic;
                        }
                    }

                    foreach ($logs as $log) {


                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/adab/l-' . $log->text))
                            $arr[$count]["pic"] = URL::asset("userPhoto/adab/l-" . $log->text);
                        else
                            $arr[$count]["pic"] = URL::asset("images/mainPics/noPicSite.jpg");

                        if (file_exists(__DIR__ . '/../../../../assets/userPhoto/adab/s-' . $log->text))
                            $arr[$count]["picT"] = URL::asset("userPhoto/adab/s-" . $log->text);
                        else
                            $arr[$count]["picT"] = URL::asset("images/mainPics/noPicSite.jpg");

                        $user = User::whereId($log->visitorId);
                        $arr[$count]["owner"] = $user->username;
                        $userPic = $user->picture;
                        if (count(explode('.', $userPic)) == 2)
                            $userPic = URL::asset("userPhoto/" . $userPic);
                        else {
                            $defaultPic = DefaultPic::whereId($userPic);
                            if ($defaultPic == null || count($defaultPic) == 0)
                                $defaultPic = DefaultPic::first();
                            $userPic = URL::asset('defaultPic/' . $defaultPic->name);
                        }
                        $arr[$count++]["ownerPic"] = $userPic;
                    }
                    break;
            }

            echo json_encode(["pics" => $arr, "filters" => $photoFilters]);
        }

    }

    public function addPhotoToPlace(Request $request)
    {

        $placeId = $request->placeId;
        $kindPlaceId = $request->kindPlaceId;

        if( isset($_FILES['pic']) && $_FILES['pic']['error'] == 0 && isset($request->name) && isset($placeId) && isset($kindPlaceId)){
            $valid_ext = array('image/jpeg', 'image/png', 'image/jpg', 'image/webp');
            if(in_array($_FILES['pic']['type'], $valid_ext)){
                $id = $placeId;

                $kindPlace = Place::find($kindPlaceId);
                if($kindPlace == null)
                    return response()->json(['status' => 'nok9']);

                $kindPlaceName = $kindPlace->fileName;
                $place = DB::table($kindPlace->tableName)->find($id);

                if($place != null) {

                    $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlaceName . '/' . $place->file;
                    if(!file_exists($location))
                        mkdir($location);

                    if(isset($request->fileName) && $request->fileName == 'null'){
                        $fileType = explode('.', $_FILES['pic']['name']);
                        $filename = time().'_'.generateRandomString(3).'.'.end($fileType);
                        $photographer = new PhotographersPic();
                        $photographer->userId = Auth::user()->id;
                        $photographer->name = $request->name;
                        $photographer->pic = $filename;
                        $photographer->kindPlaceId = $kindPlaceId;
                        $photographer->placeId = $placeId;
                        $photographer->alt = $request->alt;
                        $photographer->description = $request->description;
                        $photographer->like = 0;
                        $photographer->dislike = 0;
                        $photographer->isSitePic = 0;
                        $photographer->isPostPic = 0;
                        $photographer->status = 0;
                        $photographer->save();
                    }
                    else
                        $filename = $request->fileName;

                    if($request->fileKind == 'squ')
                        $size = [
                            [
                                'width' => 150,
                                'height' => null,
                                'name' => 't-',
                                'destination' => $location
                            ],
                            [
                                'width' => 200,
                                'height' => null,
                                'name' => 'l-',
                                'destination' => $location
                            ],
                        ];
                    else
                        $size = [
                            [
                                'width' => 350,
                                'height' => 250,
                                'name' => 'f-',
                                'destination' => $location
                            ],
                            [
                                'width' => 600,
                                'height' => 400,
                                'name' => 's-',
                                'destination' => $location
                            ],
                        ];

                    $image = $request->file('pic');
                    $result = resizeImage($image, $size, $filename);
                    if($result) {
                        $url = \URL::asset('userPhoto/' . $kindPlaceName . '/' . $place->file.'/f-'.$request->fileName);
                        return response()->json(['status' => 'ok', 'result' => [$filename, $url]]);
                    }
                    else
                        return response()->json(['status' => 'nok5']);
                }
                else
                    return response()->json(['status' => 'nok3']);
            }
            else
                return response()->json(['status' => 'nok2']);
        }
        else
            return response()->json(['status' => 'nok1']);
    }

    public function addPhotoToComment($placeId, $kindPlaceId)
    {

        if (!Auth::check())
            return Redirect::to(route('hotelDetails', ['placeId' => $placeId, 'placeName' => Hotel::whereId($placeId)->name]));

        $uId = Auth::user()->id;
        $err = "";

        if (isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"])) {

            $condition = ["visitorId" => $uId, 'activityId' => Activity::whereName('نظر')->first()->id,
                'placeId' => $placeId, 'kindPlaceId' => $kindPlaceId];

            $log = LogModel::where($condition)->first();

            if ($log == null) {
                return $this->writeReview($placeId, $kindPlaceId, "شما باید ابتدا نقد خود را ارسال کرده و سپس به آن عکس اضافه کنید");
            }

            if (!file_exists(__DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId)) {
                mkdir(__DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId, 0777, true);
            }

            $file = $_FILES["photo"];
            $targetFile = __DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId . "/" . $file["name"];
            $fileName = $file["name"];

            if (file_exists($targetFile)) {
                $count = 2;
                $targetFile = __DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId . "/" . $count . $file["name"];
                $fileName = $count . $file["name"];
                while (file_exists($targetFile)) {
                    $count++;
                    $targetFile = __DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId . "/" . $count . $file["name"];
                    $fileName = $count . $file["name"];
                }
            }

            $err = uploadCheck($targetFile, "photo", "افزودن تصویر", 3000000, "jpg");
            if (empty($err)) {
                $err = upload($targetFile, "photo", "افزودن تصویر");
            }

            if (empty($err)) {

                $allow = true;
                if ($log->pic == "")
                    $allow = false;

                $oldFileName = __DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId . "/" . $log->pic;
                $log->confirm = 0;
                $log->pic = $fileName;

                try {
                    if ($allow && file_exists($oldFileName))
                        unlink($oldFileName);
                    $log->save();
                    return Redirect::to(route('review', ['placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'mode' => 'success']));
                } catch (Exception $e) {
                };
            }
        }

        if (empty($err)) {
            $err = 'لطفا تصویر مورد نظر خود را انتخاب نمایید';
        }
        return $this->writeReview($placeId, $kindPlaceId, $err);
    }

    public function deleteUserPicFromComment()
    {

        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {

            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);

            $condition = ['visitorId' => Auth::user()->id, 'placeId' => makeValidInput($_POST["placeId"]),
                'kindPlaceId' => $kindPlaceId,
                'activityId' => Activity::whereName('نظر')->first()->id];

            $log = LogModel::where($condition)->first();
            if ($log != null) {
                $target = __DIR__ . "/../../../../assets/userPhoto/comments/" . $kindPlaceId . '/' . $log->pic;
                if (file_exists($target))
                    unlink($target);
                $log->pic = "";
                $log->save();
                echo "ok";
                return;
            }
        }

        echo "nok";

    }

    public function getPhotoFilter()
    {

        if (isset($_POST["kindPlaceId"])) {
            echo json_encode(PicItem::where('kindPlaceId', '=', makeValidInput($_POST["kindPlaceId"]))->get());
        }

    }

    public function fillMyDivWithAdv() {

        if (isset($_POST["state"]) && isset($_POST["sectionId"])) {

            $state = makeValidInput($_POST["state"]);
            $sectionId = makeValidInput($_POST["sectionId"]);

            $today = getToday()["date"];

            if($state != -1) {
                $out = DB::select("select s.*, p.pic, p.url from publicity p, section s, sectionPublicity sep, statePublicity stp WHERE " .
                    "sep.publicityId = p.id and stp.publicityId = p.id and s.id = sep.sectionId and sep.sectionId = " . $sectionId . " and stp.stateId = '$state'" .
                    " and p.from_ <= " . $today . ' and p.to_ >= ' . $today
                );
            }
            else {
                $out = DB::select("select s.*, p.pic, p.url from publicity p, section s, sectionPublicity sep WHERE " .
                    "sep.publicityId = p.id and s.id = sep.sectionId and sep.sectionId = " . $sectionId .
                    " and p.from_ <= " . $today . ' and p.to_ >= ' . $today
                );
            }

            if($out != null && count($out) > 0) {
                $out = $out[0];
                $out->pic = URL::asset('ads/' . $out->pic);
                $out->backgroundSize = ($out->backgroundSize) ? 'contain' : 'cover';
            }

            echo \GuzzleHttp\json_encode($out);
        }
    }

    public function newPlaceForMap()
    {

        $hotelId = json_decode($_POST['hotelId']);
        $restId = json_decode($_POST['restId']);
        $majaraId = json_decode($_POST['majaraId']);
        $amakenId = json_decode($_POST['amakenId']);
        $swLat = makeValidInput($_POST['swLat']);
        $swLng = makeValidInput($_POST['swLng']);
        $neLat = makeValidInput($_POST['neLat']);
        $neLng = makeValidInput($_POST['neLng']);
        $C = makeValidInput($_POST['C']);
        $D = makeValidInput($_POST['D']);
        $D *= 3.14 / 180;
        $C *= 3.14 / 180;

        if ($majaraId == null) {
            $majaraNull = DB::table('majara')->select('id')->latest('id')->first();
            $majaraId[0] = $majaraNull->id + 1;
        }
        if ($hotelId == null) {
            $hotelNull = DB::table('hotels')->select('id')->latest('id')->first();
            $hotelId[0] = $hotelNull->id + 1;
        }
        if ($restId == null) {
            $restNull = DB::table('restaurant')->select('id')->latest('id')->first();
            $restId[0] = $restNull->id + 1;
        }
        if ($amakenId == null) {
            $amakenNull = DB::table('amaken')->select('id')->latest('id')->first();
            $amakenId[0] = $amakenNull->id + 1;
        }


        $nearbyHotels = DB::select("SELECT id, fullRate, name, C, D, file, pic_1, alt1, address, acos(" . sin($D) . " * sin(D / 180 * 3.14) + " . cos($D) . " * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - " . $C . ")) * 6371 as distance FROM hotels WHERE C between " . $swLat . " and " . $neLat . " and D between " . $swLng . " and " . $neLng . " and NOT id IN(" . implode(",", $hotelId) . ")  order by distance ASC ");
        $majaras = DB::select("SELECT id, fullRate, name, C, D, file, pic_1, alt1, dastresi, acos(" . sin($D) . " * sin(D / 180 * 3.14) + " . cos($D) . " * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - " . $C . ")) * 6371 as distance FROM majara WHERE C between " . $swLat . " and " . $neLat . " and D between " . $swLng . " and " . $neLng . " and NOT id IN(" . implode(",", $majaraId) . ")  order by distance ASC ");
        $nearbyRestaurants = DB::select("SELECT id, fullRate, name, C, D, kind_id, file, address, pic_1, alt1, acos(" . sin($D) . " * sin(D / 180 * 3.14) + " . cos($D) . " * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - " . ($C) . ")) * 6371 as distance FROM restaurant WHERE C between " . $swLat . " and " . $neLat . " and D between " . $swLng . " and " . $neLng . "and NOT id IN(" . implode(",", $restId) . ")  order by distance ASC ");
        $nearbyAmakens = DB::select("SELECT id, fullRate, name, address, mooze, tarikhi, tafrihi, tabiatgardi, markazkharid,  C, D, file, pic_1, alt1, acos(" . sin($D) . " * sin(D / 180 * 3.14) + " . cos($D) . " * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - " . ($C) . ")) * 6371 as distance FROM amaken WHERE C between " . $swLat . " and " . $neLat . " and D between " . $swLng . " and " . $neLng . " and NOT id IN(" . implode(",", $amakenId) . ")   order by distance ASC ");

        foreach ($nearbyHotels as $nearbyHotel) {

            $condition = ['placeId' => $nearbyHotel->id, 'kindPlaceId' => 4, 'confirm' => 1,
                'activityId' => Activity::whereName('نظر')->first()->id];
            $nearbyHotel->reviews = LogModel::where($condition)->count();
            $nearbyHotel->distance = round($nearbyHotel->distance, 2);
            $nearbyHotel->rate = $nearbyHotel->fullRate;

        }

        foreach ($majaras as $majara) {

            $condition = ['placeId' => $majara->id, 'kindPlaceId' => 6, 'confirm' => 1,
                'activityId' => Activity::whereName('نظر')->first()->id];
            $majara->reviews = LogModel::where($condition)->count();
            $majara->distance = round($majara->distance, 2);
            $majara->rate = $majara->fullRate;
        }

        $restaurantPlaceId = Place::whereName('رستوران')->first()->id;
        foreach ($nearbyRestaurants as $nearbyRestaurant) {
            $condition = ['placeId' => $nearbyRestaurant->id, 'kindPlaceId' => $restaurantPlaceId, 'confirm' => 1, 'activityId' => Activity::whereName('نظر')->first()->id];
            $nearbyRestaurant->reviews = LogModel::where($condition)->count();
            $nearbyRestaurant->distance = round($nearbyRestaurant->distance, 2);
            $nearbyRestaurant->rate = $nearbyRestaurant->fullRate;
        }

        $amakenPlaceId = Place::whereName('اماکن')->first()->id;

        foreach ($nearbyAmakens as $nearbyAmaken) {

            $condition = ['placeId' => $nearbyAmaken->id, 'kindPlaceId' => $amakenPlaceId, 'confirm' => 1,
                'activityId' => Activity::whereName('نظر')->first()->id];
            $nearbyAmaken->reviews = LogModel::where($condition)->count();
            $nearbyAmaken->distance = round($nearbyAmaken->distance, 2);
            $nearbyAmaken->rate = $nearbyAmaken->fullRate;
        }


        echo json_encode(array('hotel' => $nearbyHotels, 'rest' => $nearbyRestaurants, 'amaken' => $nearbyAmakens, 'majara' => $majaras));
        return;
    }

    public function getPlacePicture()
    {

        if (!isset($_POST["kindPlaceId"]) || !isset($_POST["placeId"]))
            return;

        $kindPlaceId = makeValidInput($_POST['kindPlaceId']);
        $placeId = makeValidInput($_POST['placeId']);

        switch ($kindPlaceId) {
            case 1:
            default:
                $tmp = Amaken::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $tmp->file . "/f-1.jpg")))
                    echo URL::asset("_images/amaken/" . $tmp->file . "/f-1.jpg");
                else
                    echo URL::asset("images/mainPics/noPicSite.jpg");
                return;
            case 3:
                $tmp = Restaurant::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $tmp->file . "/f-1.jpg")))
                    echo URL::asset('_images/restaurant/' . $tmp->file . "/f-1.jpg");
                else
                    echo URL::asset('images/mainPics/noPicSite.jpg');
                return;
            case 4:
                $tmp = Hotel::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/hotels/' . $tmp->file . "/f-1.jpg")))
                    echo URL::asset("_images/hotels/" . $tmp->file . "/f-1.jpg");
                else
                    echo URL::asset("images/mainPics/noPicSite.jpg");
                return;
            case 6:
                $tmp = Majara::whereId($placeId);
                if (file_exists((__DIR__ . '/../../../../assets/_images/majara/' . $tmp->file . "/f-1.jpg")))
                    echo URL::asset("_images/majara/" . $tmp->file . "/f-1.jpg");
                else
                    echo URL::asset("images/mainPics/noPicSite.jpg");
                return;
        }
    }

    public function video360()
    {
        $videoSrc = '_images/movie.mp4';
        return view('video3602', array('videoSrc' => $videoSrc));
    }

    public function likePhotographer(Request $request)
    {
        if(Auth::check())
            $user = Auth::user();
        else {
            echo json_encode(['nok1']);
            return;
        }

        if(isset($request->id) && isset($request->like)){
            $id = explode('_', $request->id);
            if($id[0] == 'photographer') {
                $photo = PhotographersPic::find($id[1]);
                if ($photo != null) {
                    $userStatus = PhotographersLog::where('picId', $photo->id)->where('userId', $user->id)->first();

                    if ($userStatus == null) {
                        $userStatus = new PhotographersLog();

                        if ($request->like == 1) {
                            $userStatus->like = 1;
                            $photo->like++;
                        } else if ($request->like == -1) {
                            $userStatus->like = -1;
                            $photo->dislike++;
                        }

                        $userStatus->userId = $user->id;
                        $userStatus->picId = $photo->id;
                    }
                    else {
                        if ($userStatus->like == 1)
                            $photo->like--;
                        else if ($userStatus->like == -1)
                            $photo->dislike--;
                        if ($request->like == 1) {
                            $userStatus->like = 1;
                            $photo->like++;
                        } else if ($request->like == -1) {
                            $userStatus->like = -1;
                            $photo->dislike++;
                        }
                    }

                    $userStatus->save();
                    $photo->save();
                    echo json_encode(['status' => 'ok', 'like' => $photo->like, 'disLike' => $photo->dislike]);
                }
                else
                    echo json_encode(['nok3']);
            }
        }
        else
            echo json_encode(['nok4']);
        return;
    }

    public function askQuestion()
    {
        if (isset($_POST["placeId"]) &&
            isset($_POST["kindPlaceId"]) &&
            isset($_POST["text"])) {

            $text = makeValidInput($_POST["text"]);
            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $activityId = Activity::whereName('سوال')->first()->id;
            $uId = Auth::user()->id;

            $log = new LogModel();
            $log->visitorId = $uId;
            $log->time = getToday()["time"];
            $log->activityId = $activityId;
            $log->placeId = $placeId;
            $log->kindPlaceId = $kindPlaceId;
            $log->text = $text;
            $log->date = date("Y-m-d");
            $log->relatedTo = 0;
            $log->confirm = 0;
            $log->save();

            $alert = new Alert();
            $alert->userId = $uId;
            $alert->subject = 'addQuestion';
            $alert->referenceTable = 'log';
            $alert->referenceId = $log->id;
            $alert->save();

            echo "ok";
        }
        else
            echo 'nok1';

        return;
    }

    public function deleteQuestion(Request $request)
    {
        if(\auth()->check()){
            $uId = \auth()->user()->id;
            $log = LogModel::find($request->id);
            if($log != null){
                $this->deleteRelatedQuestion($request->id);
                echo 'ok';
            }
            else
                echo 'nok1';
        }
        else
            echo 'auth';

        return;
    }

    public function getQuestions()
    {
        if (isset($_POST["placeId"]) && isset($_POST["kindPlaceId"]) && isset($_POST["page"]) && isset($_POST["count"])) {

            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
            $page = makeValidInput($_POST["page"]);
            $count = makeValidInput($_POST["count"]);
            $activityId = Activity::whereName('سوال')->first()->id;
            $ansActivityId = Activity::whereName('پاسخ')->first()->id;

            if(\auth()->check())
                $uId = \auth()->user()->id;
            else
                $uId = 0;

            $sqlQuery = ' placeId = ' . $placeId . ' AND kindPlaceId = ' . $kindPlaceId . ' AND activityId = ' . $activityId . ' AND relatedTo = 0 AND (( visitorId = ' . $uId . ' AND confirm = 0) OR (confirm = 1))';
            $logs = LogModel::whereRaw($sqlQuery)->orderByDesc('date')->orderByDesc('time')->skip(($page - 1) * $count)->take($count)->get();

            $allCount = 0;
            $allAnswerCount = 0;

            if($_POST['isQuestionCount'])
                $allCount = LogModel::whereRaw($sqlQuery)->count();

            foreach ($logs as $log) {
                $log = questionTrueType($log);
                if($_POST['isQuestionCount'])
                    $allAnswerCount += getAnsToComments($log->id)[1];
            }

            return response()->json(['status' => 'ok', 'questions' => $logs, 'allCount' => $allCount, 'answerCount' => $allAnswerCount]);
        }
        else
            return response()->json(['status' => 'nok']);

    }

    public function sendAns(Request $request)
    {
        if(isset($request->text) && isset($request->relatedTo)){

            $text = makeValidInput($_POST["text"]);
            $relatedTo = makeValidInput($_POST["relatedTo"]);
            $activityId = Activity::whereName('پاسخ')->first()->id;
            $uId = Auth::user()->id;

            $tmp = LogModel::whereId($relatedTo);
            if ($tmp == null) {
                echo 'nok2';
                return;
            }

            $log = new LogModel();
            $log->visitorId = $uId;
            $log->time = getToday()["time"];
            $log->activityId = $activityId;
            $log->placeId = $tmp->placeId;
            $log->kindPlaceId = $tmp->kindPlaceId;
            $log->text = $text;
            $log->relatedTo = $relatedTo;
            $log->date = date("Y-m-d");
            $log->confirm = 0;
            $log->save();

            if($relatedTo != 0){
                $tmp->subject = 'ans';
                $tmp->save();
            }

            $alert = new Alert();
            $alert->userId = $uId;
            $alert->subject = 'addAns';
            $alert->referenceTable = 'log';
            $alert->referenceId = $log->id;
            $alert->save();

            echo "ok";
        }
        else
            echo 'nok1';

        return;
    }

    public function sendAns2()
    {

        if (isset($_POST["text"]) && isset($_POST["relatedTo"])) {
            $text = makeValidInput($_POST["text"]);
            $relatedTo = makeValidInput($_POST["relatedTo"]);

            $logTmp = LogModel::whereId($relatedTo);
            if ($logTmp == null || $logTmp->confirm != 1)
                return;

            $activityId = Activity::whereName('پاسخ')->first()->id;
            $uId = Auth::user()->id;

            $condition = ['visitorId' => $uId, 'relatedTo' => $relatedTo, 'activityId' => $activityId];
            if (LogModel::where($condition)->count() == 0) {

                $log = new LogModel();
                $log->visitorId = $uId;
                $log->time = getToday()["time"];
                $log->activityId = $activityId;
                $log->placeId = $logTmp->placeId;
                $log->kindPlaceId = $logTmp->kindPlaceId;
                $log->text = $text;
                $log->relatedTo = $relatedTo;
                $log->date = date("Y-m-d");
                $log->save();

                echo "ok";
            } else {
                echo "nok";
            }
        }
    }

    public function showAllAns()
    {

        if (isset($_POST["logId"]) && isset($_POST["num"])) {

            $num = makeValidInput($_POST["num"]);
            $logId = makeValidInput($_POST["logId"]);
            $ansActivityId = Activity::whereName('پاسخ')->first()->id;
            $condition = ["relatedTo" => $logId, 'activityId' => $ansActivityId, 'confirm' => 1];

            if ($num == -1)
                $logs = LogModel::where($condition)->get();
            else
                $logs = LogModel::where($condition)->take($num)->get();

            foreach ($logs as $log) {
                $log->visitorId = User::whereId($log->visitorId)->username;
                $condition = ['logId' => $log->id, 'like_' => 1];
                $log->rate = OpOnActivity::where($condition)->count();
                $condition = ['logId' => $log->id, 'dislike' => 1];
                $log->rate -= OpOnActivity::where($condition)->count();
            }

            echo json_encode($logs);
        }

    }

    public function showPlaceList($kindPlaceId, $mode, $city = '')
    {
        $kindPlace = Place::find($kindPlaceId);

        if($kindPlace != null){
            $meta = [];
            $mode = strtolower($mode);

            $kindPlaceId = $kindPlace->id;
            $showOther = false;
            $notItemToShow = false;
            $cityRel = 0;

            if($mode == 'country'){
                $state = '';
                $city = '';
                $articleUrl = \route('safarnameh.index');
                $n = ' لیست ';
                $n .= $kindPlace->title;
                $n .= ' ایران ';
                $locationName = ["name" => $n, 'state' => '',  'cityName' => 'ایران من', 'cityNameUrl' => 'ایران من', 'articleUrl' => $articleUrl, 'kindState' => 'country', 'kindPage' => 'list'];
                $contentCount = \DB::table($kindPlace->tableName)->count();
                $inHeaderName = 'ایران ';
            }
            else if ($mode == "state") {
                $city = str_replace('+', ' ', $city);
                $state = State::whereName($city)->first();
                $city = $state;
                if ($state == null)
                    return "نتیجه ای یافت نشد";

                $cityIds = Cities::where('stateId', $city->id)->pluck('id')->toArray();

                $articleUrl = \url('/safarnameh/list/city/' . $state->name);
                $n = ' استان ' . $state->name;
                $locationName = ['name' => $n, 'state' => $state->name, "stateNameUrl" => $state->name,
                                'cityName' => $n, 'cityNameUrl' => $state->name,
                                'articleUrl' => $articleUrl, 'kindState' => 'state',
                                'kindPage' => 'list'];

                $inHeaderName = $n;

                $contentCount = \DB::table($kindPlace->tableName)->whereIn('cityId', $cityIds)->count();
            }
            else if ($mode == "city") {
                $city = str_replace('+', ' ', $city);
                $city = Cities::whereName($city)->first();
                if ($city == null)
                    return "نتیجه ای یافت نشد";

                $state = State::whereId($city->stateId);
                if ($state == null)
                    return "نتیجه ای یافت نشد";

                $articleUrl = route('safarnameh.list', ['type' => 'city', 'search' => $city->name]);
                $locationName = ["name" => $city->name, 'state' => $state->name, 'stateNameUrl' => $state->name, 'cityName' => $city->name,
                                'cityNameUrl' => $city->name, 'articleUrl' => $articleUrl,
                                'kindState' => 'city', 'kindPage' => 'list'];

                $inHeaderName = $city->name;

                $contentCount = \DB::table($kindPlace->tableName)->where('cityId', $city->id)->count();
            }

            if($contentCount == 0){
                $notItemToShow = true;
                $showOther = true;
            }

            if(($kindPlaceId == 10 || $kindPlaceId == 11 || $kindPlaceId == 6) && $mode == 'city'){
                $cityRel = $city;
                $city = $state;
                $cityIds = Cities::where('stateId', $city->id)->pluck('id')->toArray();
                $contentCount = \DB::table($kindPlace->tableName)->whereIn('cityId', $cityIds)->count();

                if($contentCount > 1)
                    $notItemToShow = false;
            }


            switch ($kindPlaceId){
                case 1:
                    $topPic = 'amaken.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'جاذبه ای برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ جاذبه های ' . $locationName['cityName'] . ' را در <span onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'amaken';
                    $kindPlace->title = ' جاذبه های';
                    $meta['title'] = 'جاهای دیدنی '.$inHeaderName.' + عکس و آدرس';
                    $meta['keyword'] = 'جاذبه های گردشگری ' . $inHeaderName . ' + جاهای دیدنی' . $inHeaderName . ' + جاهای گردشگری' . $inHeaderName . ' + جاهای تاریخی' . $inHeaderName;
//                    $meta['description'] = 'معرفی جاهای دیدنی و گردشگری و تفریحی ' . $inHeaderName . ' برای سفر شما ، ما اطلاعات کاملی به همراه عکس اماکن، نقشه و آدرس و تاریخچه همراه با امتیازبندی کاربران در بستر شبکه‌ی اجتماعی جمع آوری کرده ایم تا سفر آسوده‌ای داشته باشید. ';
                    $meta['description'] = 'جاهای دیدنی '.$inHeaderName.' و جاذبه های دیدنی '.$inHeaderName.' و مکان های زیارتی '.$inHeaderName.'، آثار تاریخی '.$inHeaderName.' و مکان های تفریحی '.$inHeaderName.' و پاساژهای '.$inHeaderName.' را در کوچیتا ببینید. در این صفحه می توانید تمامی جاذبه های '.$inHeaderName.' را به همراه آدرس و عکس و نظرات کاربران در کوچیتا مشاهده کنید.';
                    break;
                case 3:
                    $topPic = 'restaurant.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'رستورانی برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ رستوران های ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'restaurant';
                    $kindPlace->title = ' رستوران های';
                    $meta['title'] = 'معرفی رستوران ها و فست فود های '.$inHeaderName.' + عکس و آدرس و تلفن';
                    $meta['keyword'] = 'رستوران‌های ' . $inHeaderName . ',عکس رستوران‌های ' . $inHeaderName . ' , تلقن رستوران های ' . $inHeaderName . ' , بهترین رستوران‌های ' . $inHeaderName . ' , فست فود ها و رستوران های سنتی ' . $inHeaderName ;
//                    $meta['description'] = 'قبل از سفر رستوران های ' . $inHeaderName . ' رو بشناس و برای رستورانایی که رفتی  نقد بنویس و نظر بده. ما اطلاعات کاملی از رستوران ها و فست فود ها به همراه عکس ا، نقشه و آدرس و معرفی ، همراه با امتیاز بندی کاربران در بستر شبکه‌ی اجتماعی جمع آوری کرده ایم تا سفر آسوده‌ای داشته باشید. ';
                    $meta['description'] = 'رستوران های '.$inHeaderName.' :معرفی رستوران های معروف '.$inHeaderName.' بهمراه آدرس و تلفن را در وب سایت کوچیتا مشاهده کنید. رستوران های خوب '.$inHeaderName.' بهمراه آدرس و موقعیت نقشه  و تلفن رستوران های '.$inHeaderName.' به همراه نظرات مشتریان و منو رستوران های '.$inHeaderName;
                    $meta['description'] .= 'فست فود های '.$inHeaderName.' :معرفی فست فود های معروف '.$inHeaderName.' بهمراه آدرس و تلفن را در وب سایت کوچیتا مشاهده کنید. فست فود های خوب '.$inHeaderName.' بهمراه آدرس و موقعیت نقشه  و تلفن فست فود های '.$inHeaderName.' به همراه نظرات مشتریان و منو فست فود های '.$inHeaderName;
                    $meta['description'] .= 'رستوران های سنتی '.$inHeaderName.' :معرفی رستوران های سنتی معروف '.$inHeaderName.' بهمراه آدرس و تلفن را در وب سایت کوچیتا مشاهده کنید. رستوران های سنتی خوب '.$inHeaderName.' بهمراه آدرس و موقعیت نقشه  و تلفن رستوران های سنتی '.$inHeaderName.' به همراه نظرات مشتریان و منو رستوران های سنتی '.$inHeaderName;
                    break;
                case 4:
                    $topPic = 'hotel.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'هتلی برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ هتل های ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'hotel';
                    $kindPlace->title = 'اقامتگاه های ';
                    $meta['title'] = 'هتل ها و مهمانسراهای '.$inHeaderName.'+ عکس و آدرس و تلفن';
                    $meta['keyword'] = 'هتل در ' . $inHeaderName . ' , هتل در ' . $inHeaderName . ' با قیمت مناسب , هتل ارزان در ' . $inHeaderName . '  , رزرو هتل در ' . $inHeaderName . ' ,مهمانسراهای '.$inHeaderName.' , هتل آپارتمان های '.$inHeaderName;
//                    $meta['description'] = 'هتل ها و مهمانسراهای ' . $inHeaderName . ' برای سفر شما ، ما اطلاعات کاملی به همراه عکس ، نقشه و آدرس و شماره تلفن و معرفی همراه با امتیازبندی کاربران در بستر شبکه‌ی اجتماعی جمع آوری کرده ایم تا بهترین اقامت خود را در سفر داشته باشید. ';
                    $meta['description'] = 'معرفی هتل های '.$inHeaderName.' با کوچیتا. تلفن هتل '.$inHeaderName.' با بررسی عکس ها، قیمت، نظرات میهمانان، مقایسه هتل های '.$inHeaderName.' و موقعیت نقشه هتل های '.$inHeaderName.'معرفی هتل آپارتمان و مهمان سراهای '.$inHeaderName.' با کوچیتا. تلفن هتل آپارتمان و مهمان سراهای '.$inHeaderName.' با بررسی عکس ها، قیمت، نظرات میهمانان، مقایسه هتل آپارتمان و مهمان سراهای '.$inHeaderName.' و موقعیت نقشه هتل آپارتمان و مهمان سراهای '.$inHeaderName.'';
                    break;
                case 6:
                    $topPic = 'majara.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'طبیعت گردی برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[1] =  $showOther ? 'برای شما اطلاعات ' . $state->name . ' را نمایش داده ایم.' : '';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ طبیعت گردی های ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'majara';
                    $kindPlace->title = ' طبیعت گردی های ';
                    $meta['title'] = 'طبیعت گردی در '.$inHeaderName.' و سفرهای ماجراجویانه + عکس و آدرس و تجهیزات لازم';
                    $meta['keyword'] = 'کوه نوردی در ' . $inHeaderName . ' ، پیاده‌روی در ' . $inHeaderName . ' ، غار‌نوردی در ' . $inHeaderName . ' ، صحرانوردی در ' . $inHeaderName . ' ، یخ‌نوردی در ' . $inHeaderName . ' ، پیک نیک در ' . $inHeaderName . ' ، محل های مناسب شنا در ' . $inHeaderName . ' ، آفرود در ' . $inHeaderName . ' ، رفتینگ در ' . $inHeaderName . ' ، صخره‌نوردی در ' . $inHeaderName . ' ، قایق‌سواری در ' . $inHeaderName . ' ، سنگ‌نوردی در ' . $inHeaderName . ' ، موج سواری در ' . $inHeaderName . ' ، دره‌نوردی در ' . $inHeaderName . ' ، کمپ (چادر زدن) در ' . $inHeaderName . ' ، کوهستان های ' . $inHeaderName . ' ، جنگل های ' . $inHeaderName . ' ، کویر های ' . $inHeaderName;
                    $meta['description'] = 'جاهای مناسب برای طبیعت گردی در '.$inHeaderName.' ، زیباترین روستاها '.$inHeaderName.'، ییلاق های '.$inHeaderName.' و جاذبه های طبیعی ' . $inHeaderName . ' در سایت کوچیتا می توانید تمامی جاهای بکر '.$inHeaderName.' و روستاهای '.$inHeaderName.' را به همراه آدرس و موقعیت نقشه و عکس و نظرات کاربران مشاهده کنید.';
                    break;
                case 10:
                    $topPic = 'soghat.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'سوغات و صنایع دستی برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[1] =  $showOther ? 'برای شما اطلاعات ' . $state->name . ' را نمایش داده ایم.' : '';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ سوغات و صنایع دستی ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'sogatSanaies';
                    $kindPlace->title = 'سوغات و صنایع دستی ';
                    $meta['title'] = 'صنایع دستی و سوغات '.$inHeaderName;
                    $meta['keyword'] = 'صنایع دستی '.$inHeaderName.' ، سوغات '.$inHeaderName.' ،  طرز تهیه سوغات '.$inHeaderName.' ، ویژگی های سوغات '.$inHeaderName.' ، ویژگی های صنایع دستی '.$inHeaderName.' ، قیمت سوغات '.$inHeaderName.' ، قیمت صنایع دستی '.$inHeaderName.' ، سوغات '.$inHeaderName.' چیست ، صنایع دستی '.$inHeaderName.' چیست ، معرفی سوغات '.$inHeaderName.' ، معرفی صنایع دستی '.$inHeaderName;
                    $meta['description'] = 'صنایع دستی و سوغات ' . $inHeaderName . ' و معرفی صنایع دستی '.$inHeaderName.' و معرفی سوغات '.$inHeaderName.' با کوچیتا. معرفی فروشندگان صنایع دستی و سوغات '.$inHeaderName.' همراه با عکس ، قیمت، نظرات کاربران، مقایسه سوغات و صنایع دستی '.$inHeaderName.' و موقعیت نقشه فروشندگان سوغات وصنایع دستی '.$inHeaderName;
                    break;
                case 11:
                    $topPic = 'food.webp';
                    if(isset($_GET['filter'])){
                        if($_GET['filter'] == 'diabet') {
                            $kindSearch = ' مناسب برای افراد دیابتی';
                            $kindSearch2 = ' غذاهای دیابتی';
                        }
                        elseif($_GET['filter'] == 'vegan'){
                            $kindSearch = ' مناسب برای افراد وگن';
                            $kindSearch2 = ' غذاهای وگن';
                        }
                        elseif($_GET['filter'] == 'vegetarian'){
                            $kindSearch = ' مناسب برای افراد گیاه خوار';
                            $kindSearch2 = ' غذاهای گیاه خوار';
                        }
                        else{
                            $kindSearch = 'محلی';
                            $kindSearch2 = '';
                        }
                    }
                    else{
                        $kindSearch2 = '';
                        $kindSearch = 'محلی';
                    }

                    $errorTxt = [];
                    $errorTxt[0] = 'غذای محلی برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[1] =  $showOther ? 'برای شما اطلاعات ' . $state->name . ' را نمایش داده ایم.' : '';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ غذای محلی ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'mahaliFood';
                    $kindPlace->title = 'غذاهای '.$kindSearch;
//                    $meta['title'] = 'عکس+دستور پخت '.$kindSearch2.' +میزان کالری+ غذاهای '.$kindSearch .' '.$inHeaderName;
                    $meta['title'] = 'معرفی غذاهای '.$kindSearch.' '.$inHeaderName.'+ عکس و دستور پخت و کالری';
                    $meta['keyword'] = 'غذاهای ' . $kindSearch . $inHeaderName . ' ، غذاهای سنتی ' . $inHeaderName . ' ، طرز تهیه غذای ' . $kindSearch . $inHeaderName . ' ، دستور پخت غذای '.$kindSearch . $inHeaderName . ' ، غذای '.$kindSearch . $inHeaderName . ' چیست ، غذای سنتی ' . $inHeaderName . ' چیست ، غذای مناسب برای افراد گیاه خوار، غذاهای مناسب برای افراد وگان ، غذاهای مناسب برای افراد دیابتی ، آش های محلی ' . $inHeaderName . ' ، خورشت های ' . $inHeaderName . ' ، خورش های ' . $inHeaderName . ' ، خوراک های ' . $inHeaderName ;
                    $meta['description'] = 'ما برای شما غذاهای محلی '.$inHeaderName.' و غذاهای سنتی '.$inHeaderName.' همراه با دستور پخت و عکس و میزان کالری که شامل آش های '.$inHeaderName.'، سوپ های '.$inHeaderName.'، خورشت های '.$inHeaderName.' ، خوراک های '.$inHeaderName.' ،شیرینی ها '.$inHeaderName.'، نان ها '.$inHeaderName.'، مربا های '.$inHeaderName.' و سالاد های '.$inHeaderName.' را جمع اوری کرده ایم.';
                    break;
                case 12:
                    $topPic = 'boom.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'بوم گردی برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
                    $errorTxt[1] = 'برای شما اطلاعات ' . $locationName['cityName'] . ' را نمایش داده ایم.';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ بوم گردی ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'boomgardy';
                    $kindPlace->title = 'بوم گردی های ';
                    $meta['title'] = 'بوم گردی های '.$inHeaderName.'+ عکس و آدرس و تلفن و نقشه';
                    $meta['keyword'] = 'بوم گردی های '.$inHeaderName.'اقامتگاه بوم گردی '.$inHeaderName.' ، خونه محلی '.$inHeaderName.'، خونه روستایی '.$inHeaderName.'، خونه شخصی در '.$inHeaderName.'';
//                    $meta['description'] = 'بوم گردی های ' . $inHeaderName . ' برای سفر شما ، ما اطلاعات کاملی به همراه عکس ، نقشه و آدرس و شماره تلفن و معرفی همراه با امتیازبندی کاربران در بستر شبکه‌ی اجتماعی جمع آوری کرده ایم تا بهترین اقامت خود را در سفر داشته باشید. ';
                    $meta['description'] = 'معرفی بوم گردی های '.$inHeaderName.' با کوچیتا. تلفن بوم گردی '.$inHeaderName.' با بررسی عکس ها، قیمت، نظرات میهمانان، مقایسه بوم گردی در '.$inHeaderName.' و موقعیت نقشه بوم گردی های '.$inHeaderName.'';
                    break;
                case 13:
                    $topPic = 'boom.webp';
                    $errorTxt = [];
                    $errorTxt[0] = 'کسب و کاری برای نمایش در ' . $locationName['cityName'] . ' موجود نمی باشد.';
//                    $errorTxt[1] = 'برای شما اطلاعات ' . $locationName['cityName'] . ' را نمایش داده ایم.';
                    $errorTxt[2] = 'اهل ' . $locationName['cityName'] . ' هستید؟ تا به حال به ' . $locationName['cityName'] . ' رفته اید؟ بوم گردی ' . $locationName['cityName'] . ' را در <span class="goToCampain" onclick="goToCampain()">در اینجا</span> معرفی کنید';

                    $placeMode = 'localShop';
                    $kindPlace->title = 'کسب و کار های ';
                    $meta['title'] = 'کسب و کار های '.$inHeaderName.'+ عکس و آدرس و تلفن و نقشه';
                    $meta['keyword'] = 'کسب و کار های '.$inHeaderName;
//                    $meta['description'] = 'بوم گردی های ' . $inHeaderName . ' برای سفر شما ، ما اطلاعات کاملی به همراه عکس ، نقشه و آدرس و شماره تلفن و معرفی همراه با امتیازبندی کاربران در بستر شبکه‌ی اجتماعی جمع آوری کرده ایم تا بهترین اقامت خود را در سفر داشته باشید. ';
                    $meta['description'] = 'معرفی کسب و کار های '.$inHeaderName.' با کوچیتا. تلفن کسب و کار '.$inHeaderName;
                    break;
            }

            $features = PlaceFeatures::where('kindPlaceId', $kindPlaceId)->where('parent', 0)->get();
            foreach ($features as $feature)
                $feature->subFeat = PlaceFeatures::where('parent', $feature->id)->where('type', 'YN')->get();
            $kind = $mode;

            if($kindPlace->id == 13){
                $features = LocalShopsCategory::where('parentId', 0)->get();
                foreach ($features as $feature)
                    $feature->subFeat = LocalShopsCategory::where('parentId', $feature->id)->get();
            }

            return view('pages.placeList.placeList', compact(['features', 'meta', 'errorTxt', 'locationName', 'kindPlace',
                                                                    'kind', 'kindPlaceId', 'mode', 'city', 'placeMode', 'state',
                                                                    'contentCount', 'notItemToShow', 'topPic', 'cityRel']));
        }
        else
            return \redirect(\url('/'));
    }

    public function getPlaceListElems(Request $request)
    {
        $startTime = microtime(true);

        $page = (int)$request->pageNum;
        $take = (int)$request->take;
        $reqFilter = $request->featureFilter;
        $sort = $request->sort;
        $rateFilter = $request->rateFilter;
        $specialFilters = $request->specialFilters;
        $nameFilter = $request->nameFilter;
        $materialFilter = $request->materialFilter;
        $nearPlaceIdFilter = $request->nearPlaceIdFilter;
        $nearKindPlaceIdFilter = $request->nearKindPlaceIdFilter;
        $featureFilters = [];
        $placeIds = [];
        $places = [];

        $kindPlace = Place::find($request->kindPlaceId);
        $table = $kindPlace->tableName;

        $activityId = Activity::whereName('نظر')->first()->id;
        $ansActivityId = Activity::whereName('پاسخ')->first()->id;
        $quesActivityId = Activity::whereName('سوال')->first()->id;
        $seenActivityId = Activity::whereName('مشاهده')->first()->id;
        $rateActivityId = Activity::whereName('امتیاز')->first()->id;

        //first get all places in state or city
        if($request->mode == 'country') {
            $placeIds = DB::table($table)->where('name', 'LIKE', '%' . $nameFilter . '%')->pluck('id')->toArray();
            $totalCount = DB::table($table)->count();
        }
        else if($request->mode == 'state'){
            $state = State::find($request->city);
            $cities = Cities::where('stateId', $request->city)->pluck('id')->toArray();
            $placeIds = DB::table($table)->whereIn('cityId', $cities)->where('name', 'LIKE', '%'.$nameFilter.'%')->pluck('id')->toArray();
            $totalCount = DB::table($table)->whereIn('cityId', $cities)->count();
        }
        else {
            $city = Cities::find($request->city);
            $state = $city->getState;
            $placeIds = DB::table($table)->where('cityId', $request->city)->where('name', 'LIKE', '%' . $nameFilter . '%')->pluck('id')->toArray();
            $totalCount = DB::table($table)->where('cityId', $request->city)->count();
        }

        if(count($placeIds) == 0)
            return response()->json(['places' => [], 'placeCount' => 0, 'totalCount' => $totalCount]);


        //filter with material in mahalifood
        if($kindPlace->id == 11 && $materialFilter != null && count($materialFilter) > 0) {
            $materialId = FoodMaterial::whereIn('name', $materialFilter)->pluck('id')->toArray();
            if(count($materialId) == 0)
                $materialId = [0];

            $pIds = DB::select('SELECT mahaliFoodId, COUNT(id) AS count FROM foodMaterialRelations WHERE foodMaterialId IN (' . implode(",", $materialId) . ') AND mahaliFoodId IN (' . implode(",", $placeIds) . ') GROUP BY mahaliFoodId');
            $placeIds = [];
            foreach ($pIds as $item){
                if($item->count == count($materialId))
                    array_push($placeIds, $item->mahaliFoodId);
            }

            if(count($placeIds) == 0)
                return response()->json(['places' => [], 'placeCount' => 0, 'totalCount' => $totalCount]);
        }

        //special filters for each kind place
        if($specialFilters != null) {
            $kindValues = [];
            $kindName = [];
            if(is_array($specialFilters) && count($specialFilters) > 0) {
                foreach ($specialFilters as $item){
                    if($item != 0) {
                        $index = array_search($item['kind'], $kindName);
                        if ($index === false) {
                            array_push($kindName, $item['kind']);
                            array_push($kindValues, [$item['value']]);
                        } else
                            array_push($kindValues[$index], $item['value']);
                    }
                }

                foreach ($kindName as $index => $value)
                    $placeIds = DB::table($kindPlace->tableName)
                                    ->whereIn($value, $kindValues[$index])
                                    ->whereIn('id', $placeIds)
                                    ->pluck('id')
                                    ->toArray();
            }

            if(count($placeIds) == 0)
                return response()->json(['places' => array(), 'placeCount' => 0, 'totalCount' => $totalCount]);
        }

        // second get places have selected features
        if($reqFilter != null && count($reqFilter) > 0){
            foreach ($reqFilter as $item){
                if($item != 0)
                    array_push($featureFilters, $item);
            }

            if(count($featureFilters) != 0) {
                if($kindPlace->id == 13){
                    $pIds = LocalShops::whereIn('categoryId', $featureFilters)->pluck('id')->toArray();
                    $placeIds = [];
                    foreach ($pIds as $item)
                        array_push($placeIds, $item);
                }
                else{
                    $pIds = DB::select('SELECT placeId, COUNT(id) AS count FROM placeFeatureRelations WHERE featureId IN (' . implode(",", $featureFilters) . ') AND placeId IN (' . implode(",", $placeIds) . ') GROUP BY placeId');
                    $placeIds = [];
                    foreach ($pIds as $p){
                        if($p->count == count($featureFilters))
                            array_push($placeIds, $p->placeId);
                    }
                }
            }

            if(count($placeIds) == 0)
                return response()->json(['places' => [], 'placeCount' => 0, 'totalCount' => $totalCount]);
        }

        // if have rate filter
        if($rateFilter != 0){
            $placeIds = DB::table($kindPlace->tableName)->whereIn('id', $placeIds)->where('fullRate', '>', ($rateFilter-1))->pluck('id')->toArray();
            if(count($placeIds) == 0)
                return response()->json(['places' => array(), 'placeCount' => 0, 'totalCount' => $totalCount]);
        }

        if($kindPlace->id == 13)
            $placeIds = LocalShops::whereIn('id', $placeIds)->where('confirm', 1)->pluck('id')->toArray();

        $placeCount = count($placeIds);

        $filterTime = microtime(true);

        // and sort results by kind
        if($sort == 'distance' && $nearPlaceIdFilter != 0 && $nearKindPlaceIdFilter != 0){
            $nearKind = Place::find($nearKindPlaceIdFilter);
            $nearPlace = DB::table($nearKind->tableName)->find($nearPlaceIdFilter);
            $C1 = (float)$nearPlace->C;
            $D1 = (float)$nearPlace->D;

            $D = $D1 * 3.14 / 180;
            $C = $C1 * 3.14 / 180;

            $places = \DB::select('SELECT *, acos(' . sin($D) . ' * sin(D / 180 * 3.14) + ' . cos($D) . ' * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - ' . ($C) . ')) * 6371 as distance FROM ' . $table . ' WHERE id IN (' . implode(",", $placeIds) . ') ORDER BY distance LIMIT ' . $take . ' OFFSET ' . ($page-1) * $take);
        }
        else if($sort == 'alphabet')
            $places = DB::table($table)->whereIn('id', $placeIds)->orderBy('name')->skip(($page - 1) * $take)->take($take)->get();
        else if($sort == 'review')
            $places = \DB::table($table)->whereIn('id', $placeIds)->orderByDesc('reviewCount')->skip(($page - 1) * $take)->take($take)->get();
        else if($sort == 'seen')
            $places = \DB::table($table)->whereIn('id', $placeIds)->orderByDesc('seen')->skip(($page - 1) * $take)->take($take)->get();
        else if($sort == 'lessSeen')
            $places = \DB::table($table)->whereIn('id', $placeIds)->orderBy('seen')->skip(($page - 1) * $take)->take($take)->get();
        else
            $places = \DB::table($table)->whereIn('id', $placeIds)->orderByDesc('fullRate')->skip(($page - 1) * $take)->take($take)->get();


        $sortTime = microtime(true);

        $uId = 0;
        if(\auth()->check())
            $uId = Auth::id();

        $bookMarkReferenceId = BookMarkReference::where('tableName', $table)->first();
        $nonePicUrl = URL::asset('images/mainPics/nopicv01.jpg');
        foreach ($places as $place) {
            $place->pic = $nonePicUrl;
            if($place->file != 'none' && $place->file != null){

                if($kindPlace->id == 13) {
                    $picNm = LocalShopsPictures::where('localShopId', $place->id)->where('isMain', 1)->first();
                    if($picNm != null)
                        $picNm = $picNm->pic;
                }
                else
                    $picNm = $place->picNumber;
;
                $location = __DIR__ . "/../../../../assets/_images/$kindPlace->fileName/$place->file/l-$picNm";
                if (is_file($location))
                    $place->pic = URL::asset("_images/$kindPlace->fileName/$place->file/l-$picNm");
            }
            $place->reviews = $place->reviewCount;

            $place->city = '';
            $place->state = '';
            if($request->mode == 'country') {
                $cityObj = Cities::whereId($place->cityId);
                if($cityObj != null) {
                    $place->city = $cityObj->name;
                    $place->state = $cityObj->getState->name;
                }
            }
            else if($request->mode == 'state'){
                $place->state = $state->name;
                $cityObj = Cities::find($place->cityId);
                if($cityObj != null)
                    $place->city = $cityObj->name;
            }
            else if($request->mode == 'city'){
                $place->state = $state->name;
                $place->city = $city->name;
            }
            $place->avgRate = (int)$place->fullRate;
            $place->url = route('placeDetails', ['kindPlaceId' => $kindPlace->id, 'placeId' => $place->id]);
            if($uId != 0) {
                $place->bookMark = BookMark::where('userId', $uId)
                                    ->where('bookMarkReferenceId', $bookMarkReferenceId->id)
                                    ->where('referenceId', $place->id)
                                    ->count();
            }
            else
                $place->bookMark = 0;
        }

        $formatTime = microtime(true);

        $times = [
            'filter' => $filterTime - $startTime,
            'sort' => $sortTime - $filterTime,
            'format' => $formatTime - $sortTime,
        ];

        return response()->json(['places' => $places, 'placeCount' => $placeCount, 'totalCount' => $totalCount, 'times' => $times]);
    }

    public function setRateToPlace(Request $request)
    {
        if(isset($request->kindPlaceId) && isset($request->placeId) && isset($request->rate)){
            if($request->rate <= 0)
                return response()->json(['status' => 'error3']);

            $kindPlace = Place::find($request->kindPlaceId);
            $place = \DB::table($kindPlace->tableName)->find($request->placeId);
            $user = \auth()->user();

            if($place != null) {
                $rate = PlaceRates::where('kindPlaceId', $kindPlace->id)
                        ->where('placeId', $place->id)
                        ->where('userId', $user->id)
                        ->first();

                if($rate == null){
                    $rate = new PlaceRates();
                    $rate->kindPlaceId = $kindPlace->id;
                    $rate->placeId = $place->id;
                    $rate->userId = $user->id;
                }

                if($request->rate > 5)
                    $request->rate = 5;

                $rate->rate = $request->rate;
                $rate->save();

                $avgRate = PlaceRates::where('kindPlaceId', $kindPlace->id)->where('placeId', $place->id)->avg('rate');

                \DB::table($kindPlace->tableName)->where('id', $place->id)->update(['fullRate' => $avgRate]);

                $rates = getRate($place->id, $kindPlace->id);

                return response()->json(['status' => 'ok', 'rates' => ['avg' => $rates[1], 'rate' => $rates[0]]]);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }


    private function sogatSanaieDet($place){

        switch ($place->style){
            case 1:
                $place->style = 'سنتی';
                break;
            case 2:
                $place->style = 'مدرن';
                break;
            case 3:
                $place->style = 'تلفیقی';
                break;
        }

        if($place->fragile == 1)
            $place->fragile = 'شکستنی';
        else
            $place->fragile = 'غیر شکستنی';

        switch ($place->size){
            case 1:
                $place->size = 'کوچک';
                break;
            case 2:
                $place->size = 'متوسط';
                break;
            case 3:
                $place->size = 'بزرگ';
                break;
        }
        switch ($place->price){
            case 1:
                $place->price = 'ارزان';
                break;
            case 2:
                $place->price = 'متوسط';
                break;
            case 3:
                $place->price = 'گران';
                break;
        }
        switch ($place->weight){
            case 1:
                $place->weight = 'سبک';
                break;
            case 2:
                $place->weight = 'متوسط';
                break;
            case 3:
                $place->weight = 'متوسط';
                break;
        }

        $place->kind = [];
        if($place->jewelry == 1)
            array_push($place->kind, 'زیورآلات');
        if($place->cloth == 1)
            array_push($place->kind, 'پارچه و پوشیدنی');
        if($place->applied == 1)
            array_push($place->kind, 'لوازم کاربردی منزل');
        if($place->decorative == 1)
            array_push($place->kind, 'لوازم تزئینی');

        $place->taste = [];
        if($place->torsh == 1)
            array_push($place->taste, 'ترش');
        if($place->shirin == 1)
            array_push($place->taste, 'شیرین');
        if($place->talkh == 1)
            array_push($place->taste, 'تلخ');
        if($place->malas == 1)
            array_push($place->taste, 'ملس');
        if($place->shor == 1)
            array_push($place->taste, 'شور');
        if($place->tond == 1)
            array_push($place->taste, 'تند');

        return $place;
    }

    private function mahaliFoodDet($place){

        $place->material = MahaliFood::find($place->id)->materials;
        foreach($place->material as $mat)
            $mat->volume = $mat->pivot->volume;

        switch ($place->kind){
            case 1:
                $place->kindName = 'چلوخورش';
                break;
            case 2:
                $place->kindName = 'خوراک';
                break;
            case 3:
                $place->kindName = 'سالاد و پیش غذا';
                break;
            case 4:
                $place->kindName = 'ساندویچ';
                break;
            case 5:
                $place->kindName = 'کباب';
                break;
            case 6:
                $place->kindName = 'دسر';
                break;
            case 7:
                $place->kindName = 'نوشیدنی';
                break;
            case 8:
                $place->kindName = 'سوپ و آش';
                break;
        }

        if($place->hotOrCold == 1)
            $place->hotOrCold = 'گرم';
        else
            $place->hotOrCold = 'سرد';

        if($place->gram == 1)
            $place->source = 'گرم';
        else
            $place->source = 'قاشق غذاخوری';

        return $place;
    }

    private function getNearbies($C, $D, $count, $kindPlaceId)
    {
        // Latitude: 1 deg = 110.574 km
        // Longitude: 1 deg = 111.320*cos(latitude) km

        try {
            $radius = ConfigModel::first()->radius;
            $latDeg = $radius / 110.574;
            $lngDeg = $radius / (111.320 * cos(deg2rad($C)));
        }
        catch (Exception $exception){
            event(new SaveErrorEvent('placeController', 'getNearbies', json_encode(['radius' => $radius, '$C' => $C, '$D' => $D,'$count' => $count, '$kindPlaceId' => $kindPlaceId])));
        }

//        $latBetween = [$C + $latDeg, $C - $latDeg];
//        $lngBetween = [$D + $lngDeg, $D - $lngDeg];

        $D = (float)$D * 3.14 / 180;
        $C = (float)$C * 3.14 / 180;

        $tableNames = ['hotels', 'restaurant', 'amaken', 'majara', 'boomgardies'];

        foreach ($tableNames as $tableName){
            $kindPlace = Place::where('tableName', $tableName)->first();
            if($kindPlace != null) {
                $nearbys = DB::select("SELECT acos(" . sin($D) . " * sin(D / 180 * 3.14) + " . cos($D) . " * cos(D / 180 * 3.14) * cos(C / 180 * 3.14 - " . $C . ")) * 6371 as distance, id, name, reviewCount, fullRate, slug, alt, cityId, C, D FROM " . $tableName . " HAVING distance between -1 and " . ConfigModel::first()->radius . " order by distance ASC limit 0, " . $count);
//                $nearbys = DB::select("SELECT id, `name`, reviewCount, fullRate, slug, alt, cityId, `C`, `D` FROM $tableName WHERE `C` > $latBetween[1] AND `C` < $latBetween[0] AND `D` > $lngBetween[1] AND `D` < $lngBetween[0] limit 0, $count" );
                foreach ($nearbys as $nearby) {
//                    $condition = ['placeId' => $nearby->id, 'kindPlaceId' => $kindPlace->id, 'confirm' => 1,
//                                  'activityId' => Activity::whereName('نظر')->first()->id];
//                    $nearby->review = LogModel::where($condition)->count();
//                    $nearby->distance = round($nearby->distance, 2);
                    $nearby->pic = getPlacePic($nearby->id, $kindPlace->id);
                    $nearby->review = $nearby->reviewCount;
                    $nearby->rate = floor($nearby->fullRate);
                    $nearby->url =  createUrl($kindPlace->id, $nearby->id, 0, 0, 0);
                    if($nearby->cityId != 0) {
                        $nearby->city = Cities::find($nearby->cityId);
                        $nearby->state = State::find($nearby->city->stateId);

                        $nearby->cityName = $nearby->city->name;
                        $nearby->stateName = $nearby->state->name;

                        $nearby->city = $nearby->city->name;
                        $nearby->state = $nearby->state->name;
                    }
                }

                switch ($kindPlace->id){
                    case 1:
                        $nearbyAmakens = $nearbys;
                        break;
                    case 3:
                        $nearbyRestaurants = $nearbys;
                        break;
                    case 4:
                        $nearbyHotels = $nearbys;
                        break;
                    case 6:
                        $nearbyMajaras = $nearbys;
                        break;
                    case 12:
                        $nearbyBoomgardi = $nearbys;
                        break;
                }
            }
        }

        return ['hotels' => $nearbyHotels, 'restaurant' => $nearbyRestaurants, 'amaken' => $nearbyAmakens, 'majara' => $nearbyMajaras, 'boomgardy' => $nearbyBoomgardi];
    }

    private function deleteRelatedQuestion($id){
        $log = LogModel::find($id);
        if($log != null){
            LogFeedBack::where('logId', $log->id)->delete();
            $logRelated = LogModel::where('relatedTo', $log->id)->get();
            foreach ($logRelated as $item)
                $this->deleteRelatedQuestion($item->id);
            $log->delete();
        }

        return;
    }

    private function likeComment($uId, $logId)
    {

        $out = 1;
        $condition = ['logId' => $logId, 'uId' => $uId, 'like_' => 1];

        if (OpOnActivity::where($condition)->count() > 0) {
            echo 0;
            return;
        }

        $condition = ['logId' => $logId, 'uId' => $uId, 'dislike' => 1];

        $opOnActivity = OpOnActivity::where($condition)->first();
        if ($opOnActivity != null) {
            $out = 2;
            $opOnActivity->dislike = 0;
        } else {
            $opOnActivity = new OpOnActivity();
            $opOnActivity->uId = $uId;
            $opOnActivity->logId = $logId;
        }

        $log = LogModel::whereId($logId);
        $log->date = date('Y-m-d');
        $log->time = getToday()["time"];
        $log->save();

        $opOnActivity->time = time();
        $opOnActivity->like_ = 1;
        $opOnActivity->save();
        echo $out;
    }

    private function dislikeComment($uId, $logId)
    {

        $out = 1;
        $condition = ['logId' => $logId, 'uId' => $uId, 'dislike' => 1];

        if (OpOnActivity::where($condition)->count() > 0) {
            echo 0;
            return;
        }

        $condition = ['logId' => $logId, 'uId' => $uId, 'like_' => 1];

        $opOnActivity = OpOnActivity::where($condition)->first();
        if ($opOnActivity != null) {
            $out = 2;
            $opOnActivity->like_ = 0;
        } else {
            $opOnActivity = new OpOnActivity();
            $opOnActivity->uId = $uId;
            $opOnActivity->logId = $logId;
        }

        $log = LogModel::whereId($logId);
        $log->date = date('Y-m-d');
        $log->time = getToday()["time"];
        $log->save();

        $opOnActivity->time = time();
        $opOnActivity->dislike = 1;
        $opOnActivity->save();
        echo $out;
    }
}
