<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogEvent;
use App\models\ActivationCode;
use App\models\Activity;
use App\models\ActivityLogs;
use App\models\Age;
use App\models\places\Amaken;
use App\models\BookMark;
use App\models\BookMarkReference;
use App\models\Cities;
use App\models\DefaultPic;
use App\models\Festival;
use App\models\Followers;
use App\models\InvitationCode;
use App\models\Level;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\Medal;
use App\models\Message;
use App\models\PhotographersLog;
use App\models\PhotographersPic;
use App\models\places\Place;
use App\models\places\PlaceFeatures;
use App\models\places\Restaurant;
use App\models\Reviews\ReviewPic;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\SafarnamehPlaceRelation;
use App\models\SafarnamehTagRelation;
use App\models\safarnameh\SafarnamehTags;
use App\models\State;
use App\models\Tag;
use App\models\User;
use App\models\UserAddPlace;
use App\models\UserTripStyles;
use Carbon\Carbon;
use Exception;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Author;


class ProfileController extends Controller {

    public $userProfilePicFolder = __DIR__ . "/../../../../assets/userProfile";
    public $userPhotoFolder = __DIR__ . "/../../../../assets/userProfile";

    private function sideProfilePages($uId){
        $user = User::find($uId);
        $user->picture = getUserPic($uId);
        $sideInfos = [];

        $sideInfos['nearestMedals'] = getNearestMedals($uId);
        $sideInfos['username'] = $user->username;
        $sideInfos['userPicture'] = $user->picture;
        $sideInfos['introduction'] = $user->introduction;
        $sideInfos['tripStyle'] = UserTripStyles::join('tripStyle', 'tripStyle.id', 'userTripStyles.tripStyleId')->where('userTripStyles.uId', $uId)->get();
        $sideInfos['userActivityCount'] = User::getUserActivityCount($uId);
        $sideInfos['userScore'] = User::getUserPointInModel($uId);
        $sideInfos['nearLvl'] = User::nearestLevelInModel($uId);

        $location = $this->userPhotoFolder. '/';
        $allUserPics = [];
        $photographer = PhotographersPic::where('userId', $uId)->where('status', 1)->orderByDesc('created_at')->get();
        for($i = 0, $j = 0; $i < count($photographer) && $j < 3 ; $i++){
            $kindPlace = Place::find($photographer[$i]->kindPlaceId);
            $pl = \DB::table($kindPlace->tableName)->find($photographer[$i]->placeId);
            $location1 = $location.'/'.$kindPlace->fileName.'/'.$pl->file.'/'.$photographer[$i]->pic;
            if(is_file($location1)) {
                $p = \URL::asset('userPhoto/' . $kindPlace->fileName . '/' . $pl->file . '/' . $photographer[$i]->pic);
                $insert = [
                    'id' => 'photographer_' . $photographer[$i]->id,
                    'mainPic' => $p,
                    'sidePic' => $p,
                    'userName' => $user->username,
                    'userPic' => $user->picture,
                    'like' => $photographer[$i]->like,
                    'dislike' => $photographer[$i]->like,
                    'alt' => $photographer[$i]->alt,
                    'showInfo' => true,
                    'uploadTime' => getDifferenceTimeString($photographer[$i]->created_at),
                    'description' => $photographer[$i]->description,
                ];
                array_push($allUserPics, $insert);
                $j++;
            }
        }

        $revAct = Activity::where('name', 'نظر')->first();
        $reviewLog = LogModel::where('visitorId', $uId)->where('activityId', $revAct->id)->orderByDesc('date')->get();
        $reviewLogId = $reviewLog->pluck('id')->toArray();

        $reviewPic = ReviewPic::where('isVideo', 0)->where('is360', 0)->whereIn('logId', $reviewLogId)->get();
        for($i = 0, $j = 0; $i < count($reviewPic) && $j < 3; $i++){
            foreach ($reviewLog as $item){
                if($item->id == $reviewPic[$i]->logId){
                    if($item->kindPlaceId == 0 && $item->placeId == 0){
                        $kindPlace = null;
                        $pl = null;
                        $fileName = "nonePlaces";
                    }
                    else {
                        $kindPlace = Place::find($item->kindPlaceId);
                        $pl = \DB::table($kindPlace->tableName)->find($item->placeId);
                        $fileName = "{$kindPlace->fileName}/{$pl->file}";
                    }
                    break;
                }
            }

            $location1 = "{$location}/{$fileName}/{$reviewPic[$i]->pic}";
            if(is_file($location1)) {
                $p = \URL::asset("userPhoto/{$fileName}/{$reviewPic[$i]->pic}");
                $insert = [
                    'id' => 'review_' . $reviewPic[$i]->id,
                    'mainPic' => $p,
                    'sidePic' => $p,
                    'userName' => $user->username,
                    'userPic' => $user->picture,
                    'showInfo' => false,
                    'uploadTime' => getDifferenceTimeString($reviewPic[$i]->created_at),
                ];
                array_push($allUserPics, $insert);
                $j++;
            }
        }

        $sideInfos['allUserPics'] = $allUserPics;

        return $sideInfos;
    }

    public function showProfile($username = '') {
        $myPage = false;
        if($username != '') {
            $user = User::where('username', $username)->first();
            if($user == null)
                return \redirect(route('main'));

            $myPage = \auth()->check() && $user->id == \auth()->user()->id;
        }
        else if($username == '' && \auth()->check()) {
            $user = Auth::user();
            return \redirect(route('profile', ['username' => $user->username]));
        }
        else
            return \redirect(route('main'));

        $uId = $user->id;
        $sideInfos = $this->sideProfilePages($uId);

        $counts = array();
        $counter = 0;
        $activities = Activity::whereVisibility(1)->orderBy('rate', 'ASC')->get();
        foreach ($activities as $activity) {
            $activity->name = $activity->actualName;
            $condition = ["visitorId" => $user->id, "activityId" => $activity->id, 'confirm' => 1];
            $counts[$counter++] = LogModel::where($condition)->count();
        }

        if($user->uploadBanner == 0) {
            $user->banner = $user->banner == null ? '1.webp' : $user->banner;
            $user->banner = URL::asset('images/mainPics/background/' . $user->banner);
        }
        else
            $user->banner = URL::asset('userProfile/'.$user->banner, null, $user->baner_server);

        $userMedals = getTakenMedal($uId)['takenMedal'];

        $followersUserCount = Followers::where('followedId', $user->id)->count();

        $youFollowed = 0;
        if(!$myPage && \auth()->check())
            $youFollowed = Followers::where('userId', \auth()->user()->id)->where('followedId', $user->id)->count();

        return view('profile.mainProfile', compact(['user', 'sideInfos', 'myPage', 'userMedals', 'followersUserCount', 'youFollowed']));
    }

    public function placeSuggestion(Request $request)
    {
        $inPlace = [];
        $deletedWord = ['هتل','اقامتگاه','مهمانسرا','رستوران','فست فود'];
        $text = strip_tags($request->text);

        $states = State::all();
        foreach ($states as $item){
            if(strpos($text, $item->name) !== false || strpos($text, 'استان ' . $item->name) !== false)
                array_push($inPlace, ['kindPlaceId' => 'state', 'kindPlaceName' => '', 'placeId' => $item->id, 'name' => 'استان ' . $item->name, 'pic' => getStatePic($item->id, 0), 'state' => '']);
        }

        $kindPlace = Place::whereNotNull('tableName')->where('mainSearch', 1)->get();
        foreach ($kindPlace as $kind) {
            $allPlace = \DB::table($kind->tableName)->select(['id', 'name', 'cityId'])->get();
            foreach ($allPlace as $item){
                foreach ($deletedWord as $word)
                    str_replace($word, '', $item->name);

                if(strpos($text, $item->name) !== false) {
                    $pic = getPlacePic($item->id, $kind->id, 'f');
                    $cit = Cities::find($item->cityId);
                    $sta = State::find($cit->stateId);
                    $stasent = 'استان ' . $sta->name . ' ، شهر' . $cit->name;
                    array_push($inPlace, ['kindPlaceId' => $kind->id, 'kindPlaceName' => $kind->name, 'placeId' => $item->id, 'name' => $item->name, 'pic' => $pic, 'state' => $stasent]);
                }
            }
        }

        echo json_encode(['result' => $inPlace]);
        return ;
    }

    public function getUserInfoFooter()
    {

    }

    public function getQuestions(Request $request)
    {
        $activityId = Activity::whereName('سوال')->first()->id;
        $ansActivityId = Activity::whereName('پاسخ')->first()->id;
        $logs = [];
        if($request->kind == 'question' || !isset($request->kind)) {
            if (\auth()->check() && ($request->userId == \auth()->user()->id || !isset($request->userId))) {
                $uId = \auth()->user()->id;
                $sqlQuery = 'activityId = ' . $activityId . ' AND relatedTo = 0 AND visitorId = ' . $uId;
            } else if (isset($request->userId)) {
                $uId = $request->userId;
                $sqlQuery = 'activityId = ' . $activityId . ' AND confirm = 1 AND relatedTo = 0 AND visitorId = ' . $uId;
            } else {
                echo json_encode(['status' => 'nok']);
                return;
            }
            $logs = LogModel::whereRaw($sqlQuery)->orderByDesc('date')->orderByDesc('time')->get();
        }
        else{
            $logId = [];
            if (\auth()->check() && ($request->userId == \auth()->user()->id || !isset($request->userId))) {
                $uId = \auth()->user()->id;
                $sqlQuery = 'activityId = ' . $ansActivityId . ' AND relatedTo != 0 AND visitorId = ' . $uId;
            } else if (isset($request->userId)) {
                $uId = $request->userId;
                $sqlQuery = 'activityId = ' . $ansActivityId . ' AND confirm = 1 AND relatedTo != 0 AND visitorId = ' . $uId;
            }
            else {
                echo json_encode(['status' => 'nok']);
                return;
            }
            $anses = LogModel::whereRaw($sqlQuery)->get();

            foreach ($anses as $item){
                $top = LogModel::find($item->relatedTo);
                while($top != null && $top->activityId == $ansActivityId && $top->relatedTo != 0) {
                    $top = LogModel::find($top->relatedTo);
                }

                if($top != null && $top->activityId == $activityId)
                    array_push($logId, $top->id);
            }
            if($logId != [])
                $logs = LogModel::whereIn('id', $logId)->orderByDesc('date')->orderByDesc('time')->get();
        }

        foreach ($logs as $log)
            $log = questionTrueType($log);

        if(isset($request->sort) && $request->sort == 'hot'){
            for ($i = 0; $i < count($logs)-1; $i++){
                for($j = $i+1; $j < count($logs); $j++) {
                    if ($logs[$j]->answersCount > $logs[$i]->answersCount){
                        $arr = $logs[$i];
                        $logs[$i] = $logs[$j];
                        $logs[$j] = $arr;
                    }
                }
            }
        }

        echo json_encode(['status' => 'ok', 'result' => $logs]);
    }

    public function getUserMedals(Request $request)
    {
        if(\auth()->check() && (\auth()->user()->id == $request->userId || $request->userId == 0))
            $owner = true;
        else
            $owner = false;

        $allMedals = [];
        $inProgressMedal = [];

        $medals = getTakenMedal($request->userId);
        $takenMedal = $medals['takenMedal'];
        if($owner){
            $allMedals = $medals['allMedal'];
            $inProgressMedal = $medals['inProgressMedal'];
        }

        echo json_encode(['status' => 'ok', 'allMedals' => $allMedals, 'takenMedal' => $takenMedal, 'inProgressMedal' => $inProgressMedal]);
        return;
    }

    public function getUserPicsAndVideo()
    {
        $userId = $_GET['userId'];
        $user = User::find($userId);
        $uId = $user->id;
        $user->picture = getUserPic($uId);

        $allUserPics = [];
        $location = $this->userPhotoFolder.'/';
        $allUserPics = [];
        if(\auth()->check() && \auth()->user()->id == $uId)
            $photographer = PhotographersPic::where('userId', $uId)->orderByDesc('created_at')->get();
        else
            $photographer = PhotographersPic::where('userId', $uId)->where('status', 1)->orderByDesc('created_at')->get();

        for($i = 0; $i < count($photographer) ; $i++){
            $kindPlace = Place::find($photographer[$i]->kindPlaceId);
            $pl = \DB::table($kindPlace->tableName)->find($photographer[$i]->placeId);
            $city = Cities::find($pl->cityId);
            $state = State::find($city->stateId);

            $location1 = $location.'/'.$kindPlace->fileName.'/'.$pl->file.'/s-'.$photographer[$i]->pic;
            if(is_file($location1)) {
                $p = \URL::asset('userPhoto/' . $kindPlace->fileName . '/' . $pl->file . '/s-' . $photographer[$i]->pic);
                $side = \URL::asset('userPhoto/' . $kindPlace->fileName . '/' . $pl->file . '/f-' . $photographer[$i]->pic);
                $userLike = 0;
                if(\auth()->check()){
                    $mUId = \auth()->user()->id;
                    $logLike = PhotographersLog::where('userId', $mUId)->where('picId', $photographer[$i]->id)->first();
                    if($logLike != null)
                        $userLike = $logLike->like;
                }

                $insert = [
                    'id' => 'photographer_' . $photographer[$i]->id,
                    'mainPic' => $p,
                    'sidePic' => $side,
                    'userName' => $user->username,
                    'userPic' => $user->picture,
                    'like' => $photographer[$i]->like,
                    'dislike' => $photographer[$i]->dislike,
                    'alt' => $photographer[$i]->alt,
                    'showInfo' => true,
                    'userLike' => $userLike,
                    'fileKind' => 'pic',
                    'uploadTime' => getDifferenceTimeString($photographer[$i]->created_at),
                    'created_at' => $photographer[$i]->created_at,
                    'description' => $photographer[$i]->description,
                    'where' => 'در ' . $pl->name . ' شهر ' . $city->name . ' استان ' . $state->name ,
                    'whereUrl' => createUrl($photographer[$i]->kindPlaceId, $photographer[$i]->placeId, 0, 0, 0),
                ];
                array_push($allUserPics, $insert);
            }
        }

        $revAct = Activity::where('name', 'نظر')->first();
        $reviewLog = LogModel::where('visitorId', $uId)->where('activityId', $revAct->id)->orderByDesc('date')->get();
        $reviewLogId = $reviewLog->pluck('id')->toArray();

        $reviewPic = ReviewPic::whereIn('logId', $reviewLogId)->get();
        for($i = 0; $i < count($reviewPic); $i++){
            foreach ($reviewLog as $log){
                if($log->id == $reviewPic[$i]->logId){
                    if($log->kindPlaceId == 0 && $log->placeId == 0){
                        $kindPlace = null;
                        $pl = null;
                        $fileName = "nonePlaces";
                        $where = '';
                        $placeUrl = '';
                    }
                    else {
                        $kindPlace = Place::find($log->kindPlaceId);
                        $pl = \DB::table($kindPlace->tableName)->find($log->placeId);
                        $fileName = "{$kindPlace->fileName}/{$pl->file}";
                        $cityAndState = Cities::join('state', 'state.id', 'cities.stateId')
                            ->where('cities.id', $pl->cityId)
                            ->select(['state.id AS stateId', 'cities.id AS cityId', 'cities.name AS cityName', 'state.name AS stateName'])
                            ->first();
                        $where = 'در ' . $pl->name . ' شهر ' . $cityAndState->cityName . ' استان ' . $cityAndState->stateName ;
                        $placeUrl = route('placeDetails', ['kindPlaceId' => $kindPlace->id, 'placeId' => $pl->id]);
                    }
                }
            }

            if($reviewPic[$i]->isVideo == 1){
                if($reviewPic[$i]->thumbnail != null)
                    $thumbnail = $reviewPic[$i]->thumbnail;
                else{
                    $videoArray = explode('.', $reviewPic[$i]->pic);
                    $videoArray[count($videoArray)-1] = '.png';
                    $thumbnail = implode('', $videoArray);
                }

                $loca1 = "{$location}/{$fileName}/{$thumbnail}";
                $loca2 = "{$location}/{$fileName}/{$reviewPic[$i]->pic}";

                if(is_file($loca1) && is_file($loca2)) {
                    $p = URL::asset("userPhoto/{$fileName}/{$thumbnail}");

                    $insert = [
                        'id' => 'review_' . $reviewPic[$i]->id,
                        'mainPic' => $p,
                        'sidePic' => $p,
                        'video' => URL::asset("userPhoto/{$fileName}/{$reviewPic[$i]->pic}"),
                        'fileKind' => $reviewPic[$i]->is360 == 1 ? 'video360' : 'video',
                        'userName' => $user->username,
                        'userPic' => $user->picture,
                        'showInfo' => false,
                        'uploadTime' => getDifferenceTimeString($reviewPic[$i]->created_at),
                        'created_at' => $reviewPic[$i]->created_at,
                        'where' => $where,
                        'whereUrl' => $placeUrl,
                    ];
                    array_push($allUserPics, $insert);
                }
            }
            else {
                $location1 = "{$location}/{$fileName}/{$reviewPic[$i]->pic}";
                if (is_file($location1)) {
                    $p =  \URL::asset("userPhoto/{$fileName}/{$reviewPic[$i]->pic}");
                    $insert = [
                        'id' => 'review_' . $reviewPic[$i]->id,
                        'mainPic' => $p,
                        'sidePic' => $p,
                        'fileKind' => 'pic',
                        'userName' => $user->username,
                        'userPic' => $user->picture,
                        'showInfo' => false,
                        'uploadTime' => getDifferenceTimeString($reviewPic[$i]->created_at),
                        'created_at' => $reviewPic[$i]->created_at,
                        'where' => $where,
                        'whereUrl' => $placeUrl,
                    ];
                    array_push($allUserPics, $insert);
                }
            }
        }

        $sort = array_column($allUserPics, 'created_at');
        array_multisort($sort, SORT_DESC, $allUserPics);

        return response()->json(['status' => 'ok', 'result' => $allUserPics]);
    }

    public function getSafarnameh(Request $request)
    {
        $userId = $request->userId;
        $username = User::find($userId)->username;

        if(\auth()->check() && \auth()->user()->id == $userId)
            $safarnameh = Safarnameh::where('userId', $userId)->orderByDesc('created_at')->get();
        else
            $safarnameh = Safarnameh::where('userId', $userId)->where('confirm', 1)->orderByDesc('created_at')->get();

        foreach ($safarnameh as $item) {
            $item->pic = \URL::asset("_images/posts/{$item->id}/{$item->pic}", null, $item->server);
            $item->time = verta($item->created_at)->format('Y/m/d');
            $item->username = $username;
            $item->userPic = getUserPic($userId);
            $item->url = url("/safarnameh/show/{$item->id}");
        }

        echo json_encode(['status'  => 'ok', 'result' => $safarnameh]);

        return;
    }

    public function getMainFestival()
    {
        $festivals = Festival::where('parent', 0)->where('status', 1)->get();
        foreach ($festivals as $item){
            if($item->picture == null)
                $item->pic = \URL::asset('images/mainPics/noData.png');
            else
                $item->pic = \URL::asset('_images/festival/mainPics/'.$item->picture);

            if($item->description == null)
                $item->description = '';

            $item->subs = Festival::where('parent', $item->id)->get();
        }
        return response()->json(['status' => 'ok', 'result' => $festivals]);
    }

    public function getFestivalContent()
    {
        $user = auth()->user();
        $user->pic = getUserPic($user->id);
        $festivalId = $_GET['id'];
        $festival = Festival::find($festivalId);
        if($festival != null){
            $myWorks = \DB::table($festival->tableName)->where('userId', $user->id)->get();
            foreach ($myWorks as $item){
                $item->file = URL::asset('_images/festival/'.$festival->folderName.'/'.$item->file);
                $item->showPic = $item->file;
                if($item->type == "video"){
                    $item->thumbnail = URL::asset('_images/festival/'.$festival->folderName.'/'.$item->thumbnail);
                    $item->showPic = $item->thumbnail;
                }

                $item->userPic = getUserPic($user->id);
                $item->username = $user->username;
                $item->userUrl = '#';

                $item->title = $item->foodName;
                $item->place = $item->foodName;
                $item->placeUrl = '#';

                if($item->foodId != null){
                    $food = MahaliFood::find($item->foodId);
                    if($food != null){
                        $item->title = $food->name;
                        $item->place = $food->name;
                        $item->placeUrl = route('placeDetails', ['kindPlaceId' => 11, 'placeId' => $food->id]);
                    }
                }

            }
            return response()->json(['status' => 'ok', 'result' => $myWorks]);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function deleteFestivalContent(Request $request)
    {
        if(isset($request->id) && isset($request->festivalId)){
            $festival = Festival::find($request->festivalId);
            $content = \DB::table($festival->tableName)->find($request->id);
            $direction = __DIR__."/../../../../assets/_images/festival/$festival->folderName/";
            if(is_file($direction.$content->file))
                unlink($direction.$content->file);

            if($direction.$content->thumbnail != null && is_file($direction.$content->thumbnail))
                unlink($direction.$content->thumbnail);

            \DB::table($festival->tableName)->where('id', $content->id)->delete();
            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }


    public function getBannerPics()
    {
        $banners = [];
        $location = __DIR__ .'/../../../public/images/mainPics/background';
        if(is_dir($location)){
            $ban = scandir($location);
            foreach ($ban as $item){
                if(is_file($location.'/'.$item))
                    array_push($banners, [
                        'url'  => URL::asset('images/mainPics/background/'.$item),
                        'name' => $item
                    ]);
            }
        }

        echo json_encode($banners);
        return;
    }

    public function getBookMarks(Request $request)
    {
        if(\auth()->check()){
            $bookmarks = [];

            $bookmarksKinds = BookMark::where('userId', \auth()->user()->id)
                                        ->get()
                                        ->groupBy('bookMarkReferenceId');
            foreach($bookmarksKinds as $kind){
                if(count($kind) > 0){
                    $kk = BookMarkReference::find($kind[0]->bookMarkReferenceId);

                    foreach ($kind as $item){
                        if($kk->group == 'safarnameh'){
                            $bm = \DB::table($kk->tableName)
                                    ->select(['title', 'id', 'userId', 'summery', 'meta', 'pic', 'created_at'])
                                    ->find($item->referenceId);

                            if($bm != null) {
                                $us = User::find($bm->userId);
                                $bm->pic = \URL::asset('_images/posts/' . $bm->id . '/' . $bm->pic);
                                $bm->time = verta($bm->created_at)->format('Y/m/d');
                                $bm->username = $us->username;
                                $bm->userPic = getUserPic($us->id);
                                $bm->url = url("/safarnameh/show/" . $bm->id);
                                $bm->kind = 'safarnameh';
                                if ($bm->summery == null)
                                    $bm->summery = $bm->meta;
                            }
                        }
                        else if($kk->group == 'review'){
                            $bm = \DB::table($kk->tableName)->find($item->referenceId);
                            if($bm != null) {
                                $bm = reviewTrueType($bm); // in common.php
                                $bm->kind = 'review';
                            }
                        }
                        else if($kk->group == 'place'){
                            $bm = \DB::table($kk->tableName)->find($item->referenceId);
                            if($bm != null) {
                                $kindPlace = Place::where('tableName', $kk->tableName)->first();
                                $plcSug = createSuggestionPack($kindPlace->id, $bm->id);
                                if (isset($bm->dastresi))
                                    $plcSug->address = $bm->dastresi;
                                else if (isset($bm->address))
                                    $plcSug->address = $bm->address;

                                if (isset($bm->D) && isset($bm->C)) {
                                    $plcSug->D = $bm->D;
                                    $plcSug->C = $bm->C;
                                }
                                $plcSug->logId = $item->id;
                                $plcSug->kindPlaceId = $kindPlace->id;
                                $plcSug->kindPlaceName = $kindPlace->tableName;
                                $plcSug->kind = 'place';
                                $bm = $plcSug;
                            }
                        }
                        if($bm != null) {
                            $bm->bmId = $item->id;
                            array_push($bookmarks, $bm);
                        }
                        else
                            $item->delete();
                    }
                }
            }

           return response()->json(['status' => 'ok', 'result' => $bookmarks]);
        }
        else
            return response()->json(['status' => 'notAuth']);
    }

    public function deleteBookMarkWithId(Request $request)
    {
        if(isset($request->id)){
            BookMark::where('id', $request->id)
                    ->where('userId', \auth()->user()->id)
                    ->delete();

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }


    public function updateMyBio(Request $request)
    {
        $user = Auth::user();
        $tripStyles = $request->tripStyles;
        UserTripStyles::where('uId', $user->id)->delete();
        if($tripStyles != null){
            foreach ($tripStyles as $trip){
                if($trip != 0){
//                    event(new ActivityLogEvent($user->id, $user->id, 'completeUserTripStyle'));
                    $userTripStyle = new UserTripStyles();
                    $userTripStyle->uId = $user->id;
                    $userTripStyle->tripStyleId = $trip;
                    $userTripStyle->save();
                }
            }
        }

//        if($request->myBio != null && $request->myBio != '')
//            event(new ActivityLogEvent($user->id, $user->id, 'completeUserBio'));

        $user->introduction = $request->myBio;
        $user->save();

        $tripStyles = UserTripStyles::join('tripStyle', 'tripStyle.id', 'userTripStyles.tripStyleId')
                                        ->where('uId', $user->id)->get();

        echo json_encode(['status' => 'ok', 'tripStyles' => $tripStyles, 'introduction' => $user->introduction]);
        return;
    }

    public function updateUserPhoto(Request $request)
    {
        if(isset($request->id)){
            $user = \auth()->user();

            if($user->uploadPhoto == 1){
                if(config('app.ServerName') == $user->server) {
                    if (file_exists($this->userProfilePicFolder . "/" . $user->picture))
                        unlink($this->userProfilePicFolder . "/" . $user->picture);
                }
                else{
                    $files = ["userProfile/{$user->picture}"];
                    Controller::sendDeleteFileApiToServer($files, $user->server);
                }
            }

            if($request->id != 0){
                $user->picture = $request->id;
                $user->uploadPhoto = 0;
                $user->server = 1;
                $user->save();
                echo 'ok';
            }
            else if(isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
                $targetFile = $this->userProfilePicFolder;
                $size = [
                    [
                        'width' => 450,
                        'height' => null,
                        'name' => '',
                        'destination' => $targetFile
                    ],
                ];

                $image = $request->file('pic');
                $fileName = resizeImage($image, $size);
                $user->picture = $fileName;
                $user->uploadPhoto = 1;
                $user->server = config('app.ServerNumber');
                $user->save();

                echo 'ok';
            }
            else
                echo 'nok1';
        }
        else
            echo 'nok';

        return;
    }

    public function updateBannerPic(Request $request)
    {
        if(isset($request->uploaded) && isset($request->pic)){
            $user = \auth()->user();

            if($user->uploadBanner == 1){
                if(config('app.ServerName') == $user->baner_server) {
                    if (file_exists($this->userProfilePicFolder . "/" . $user->banner))
                        unlink($this->userProfilePicFolder . "/" . $user->banner);
                }
                else{
                    $files = ["userProfile/{$user->banner}"];
                    Controller::sendDeleteFileApiToServer($files, $user->baner_server);
                }
            }

            if($request->uploaded == 'false'){
                $user->banner = $request->pic;
                $user->uploadBanner = 0;
                $user->baner_server = 1;
                $user->save();

                $url = URL::asset('images/mainPics/background/'.$user->banner);
            }
            else if($request->uploaded == 'true'){
                $targetFile = $this->userProfilePicFolder;
                $size = [
                    [
                        'width' => null,
                        'height' => 300,
                        'name' => '',
                        'destination' => $targetFile
                    ],
                ];

                $image = $request->file('pic');
                $fileName = resizeImage($image, $size);
                $user->banner = $fileName;
                $user->uploadBanner = 1;
                $user->baner_server = config('app.ServerNumber');
                $user->save();

                $url = URL::asset('userProfile/'.$user->banner, null, $user->baner_server);
            }
        }
        else
            return response()->json(['status' => 'nok']);

        return response()->json(['status' => 'ok', 'url' => $url]);
    }

    public function sendMyInvitationCode() {

        if(isset($_POST["phoneNum"])) {

            $user = Auth::user();

            $last = InvitationCode::where('uId',$user->id)->orderBy('sendTime', 'DESC')->first();

            if($last != null) {
                if(time() - $last->sendTime < 90) {
                    echo "nok";
                    return;
                }
            }

            $send = new InvitationCode();
            $send->phoneNum = makeValidInput($_POST["phoneNum"]);
            $send->sendTime = time();
            $send->uId = $user->id;

            try {
                $send->save();
                sendSMS(makeValidInput($_POST["phoneNum"]), $user->username, 'invite', $user->invitationCode);
                echo "ok";
                return;
            }
            catch (Exception $x) {}
        }

        echo "nok";
    }

    public function accountInfo($msg = "", $mode = 1, $reminder = "", $phoneNum = "") {
        if(session('msg')) {
            $msg = session('msg');
            $mode = 0;
        }
        session()->forget('msg');

        $user = Auth::user();

        $tmp = Cities::whereId($user->cityId);
        if($tmp != null) {
            $user->cityName = $tmp->name;
            $user->cityId = $tmp->id;
        }
        else{
            $user->cityName = "";
            $user->cityId = 0;
        }

        $isAcitveCode = false;
        $activeCode = ActivationCode::where('userId', $user->id)->get();
        if($activeCode != null){
            foreach ($activeCode as $item){
                if(time() - $item->sendTime < 90){
                    $user->phone = $item->phoneNum;
                    $isAcitveCode = true;
                    break;
                }
            }
        }

        return view('accountInfo', ['msg' => $msg, 'mode2' => $mode, 'reminder' => $reminder,
            'ages' => Age::all(), 'phoneNum' => $phoneNum, 'isAcitveCode' => $isAcitveCode]);
    }

    public function searchInCities() {
        if(isset($_POST["key"])) {
            $key = makeValidInput($_POST["key"]);
            echo json_encode(DB::select("select * from cities WHERE name LIKE '%$key%'"));
        }
    }

    public function updateProfile2() {
        $user = Auth::user();
        if(isset($_POST["introduction"]) && isset($_POST["sex"]) && isset($_POST["ageId"])) {
            $user->introduction = makeValidInput($_POST["introduction"]);
            $user->sex = makeValidInput($_POST["sex"]) == "f" ? 0 : (makeValidInput($_POST["sex"]) == "m" ? 1 : 2);
            $user->age = makeValidInput($_POST["ageId"]);
            $user->save();

            echo 'ok';
        }
        else
            echo 'nok';
        return;
    }

    public function editPhoto($msg = "") {
        $user = Auth::user();

        $photo = getUserPic($user->id);

        return view("editPhoto", array('msg' => $msg, 'photo' => $photo));
    }

    public function getDefaultPics() {
        $defaultPics = DefaultPic::all();
        foreach($defaultPics as $defaultPic)
            $defaultPic->name = URL::asset("defaultPic/" . $defaultPic->name);

        echo json_encode($defaultPics);
    }

    public function deleteAccount() {

        $uId = Auth::user()->id;
        if(!Auth::check()) {
            echo 'nok';
            return;
        }
        else {
            if($uId != User::whereLevel(1)->first()->id) {
                User::destroy($uId);
                echo 'ok';
                return;
            }
            echo 'nok';
        }
    }

    public function doEditPhoto(Request $request) {

        $err = "";

        if(isset($_POST["cancel"]))
            return Redirect::to("profile/editPhoto");

        if(isset($_FILES["newPic"])) {

            $uId = Auth::user()->id;

            $file = $_FILES["newPic"];
            $user = User::whereId($uId);

            if($user->uploadPhoto == 0 || $user->picture != $file["name"]) {

                $targetFile = $this->userProfilePicFolder;

                $size = [
                    [
                        'width' => 300,
                        'height' => null,
                        'name' => '',
                        'destination' => $targetFile
                    ],
                ];

                $image = $request->file('newPic');
                $fileName = resizeImage($image, $size);

                if($user->uploadPhoto == 1 && file_exists($this->userProfilePicFolder. "/" . $user->picture))
                    unlink($this->userProfilePicFolder. "/" . $user->picture);
                $user->picture = $fileName;
                $user->uploadPhoto = 1;
                $user->save();
                $err = '';
            }
        }

        if(empty($err) ) {
            return Redirect::to("profile/editPhoto");
        }

        return $this->editPhoto($err);

    }

    public function submitPhoto() {

        $uId = Auth::user()->id;

        $pic = makeValidInput($_POST["pic"]);
        $mode = makeValidInput($_POST["mode"]);

        $user = User::whereId($uId);

        $pic = explode('/', $pic);

        if($mode == 0) {

            if($user->uploadPhoto == 1 && file_exists($this->userProfilePicFolder. "/" . $user->picture))
                unlink($this->userProfilePicFolder. "/" . $user->picture);

            $user->uploadPhoto = 0;
            $user->picture = DefaultPic::whereName($pic[count($pic) - 1])->first()->id;
            $user->save();
        }

        echo "ok";
    }

    public function addPlaceByUserPage()
    {
        $states = State::iranStates()->get();
        $kindPlace = [
            'amaken' => [
                'id' => 1,
            ],
            'restaurant' => [
                'id' => 3,
            ],
            'hotel' => [
                'id' => 4,
            ],
            'boomgardy' => [
                'id' => 12,
            ]
        ];

        foreach ($kindPlace as $key => $item2){
            $features = PlaceFeatures::where('kindPlaceId', $kindPlace[$key]['id'])->where('parent', 0)->get();
            foreach ($features as $item)
                $item->subFeat = PlaceFeatures::where('parent', $item->id)->get();
            $kindPlace[$key]['features'] = $features;
        }

        if(\auth()->check()) {
            $logs = createSeeLog(0, 0, 'addPlace', 'start');
            $getLog = LogModel::where(['placeId' => 0, 'kindPlaceId' => 0,
                'subject' => 'addPlace', 'text' => 'start',
                'time' => $logs[0], 'date' => $logs[1], 'activityId' => 1,
                'visitorId' => \auth()->user()->id])->get();

            for ($i = 1; $i < count($getLog); $i++) {
                if (isset($getLog[$i]))
                    $getLog[$i]->delete();
            }
        }

        return view('profile.addPlaceByUser', compact(['states', 'kindPlace']));
    }

    public function createStepLog(Request $request)
    {
        createSeeLog(0, 0, 'addPlace', $request->step);
        return;
    }

    public function storeAddPlaceByUser(Request $request)
    {
        $data = json_decode($request->data);

        if(isset($data->kindPlaceId) && isset($data->name) && isset($data->cityId)){
            $place = new UserAddPlace();
            $place->server = config('app.ServerNumber');
            $place->userId = \auth()->user()->id;
            $place->kindPlaceId = $data->kindPlaceId;
            $place->name = $data->name;
            $place->city = $data->cityId;
            $place->stateId = $data->stateId;
            $place->address = $data->address;
            $place->lat = $data->lat;
            $place->lng = $data->lng;
            $place->phone = $data->phone;
            $place->fixPhone = $data->fixPhone;
            $place->email = $data->email;
            $place->website = $data->website;
            $place->description = $data->description;

            if(in_array($place->kindPlaceId, [1, 3, 4, 12])){
                $features['featuresId'] = $data->features;
                if($place->kindPlaceId == 3)
                    $features['kind'] = $data->restaurantKind;
                else if($place->kindPlaceId == 4){
                    $features['kind_id'] = $data->hotelKind;
                    $features['rate_int'] = $data->hotelStar;
                }
                else if($place->kindPlaceId == 12){
                    $features['room_num'] = $data->room_num;
                }
            }
            else if($place->kindPlaceId == 10){
                $features['eatable'] = $data->eatable;
                if(isset($data->size))
                    $features['size'] = $data->size;
                else
                    $features['size'] = null;

                if(isset($data->weight))
                    $features['weight'] = $data->weight;
                else
                    $features['weight'] = null;

                if(isset($data->price))
                    $features['price'] = $data->price;
                else
                    $features['price'] = null;

                $features['features'] = $data->features;
            }
            else if($place->kindPlaceId == 11){
                $features['kind'] = $data->kind;
                $features['material'] = json_encode($data->material);
                $features['recipes'] = $data->recipes;
                if(isset($data->hotFood))
                    $features['hotFood'] = $data->hotFood;
                else
                    $features['hotFood'] = null;
                $features['features'] = $data->features;
            }

            $place->features = json_encode($features);
            $place->save();

            return response()->json(['status' => 'ok', 'result' => $place->id]);
        }
        else
            return response()->json(['status' => 'nok']);
    }

    public function storeImgAddPlaceByUser(Request $request)
    {
        if(isset($request->id) && $request->id != 0){
            if(isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
                $place = UserAddPlace::find($request->id);
                if($place != null){
                    $fileType = last(explode('.', $_FILES['pic']['name']));
                    $fileTypeAccepted = ['png', 'jpeg', 'jpg', 'webp'];

                    if(!in_array($fileType, $fileTypeAccepted))
                        return response()->json(['status' => 'wrongType']);

                    $fileName = time().'_'.rand(10000, 99999).'.'.$fileType;

                    $location = __DIR__ .'/../../../../assets/_images/addPlaceByUser';
                    if(!is_dir($location))
                        mkdir($location);
                    $location .= '/' . $fileName;

                    if(move_uploaded_file($_FILES['pic']['tmp_name'], $location)){
                        $pics = $place->pics;
                        $pics = json_decode($pics);
                        if($pics == null)
                            $pics = [];
                        array_push($pics, $fileName);
                        $place->pics = json_encode($pics);
                        $place->save();

                        return response()->json(['status' => 'ok', 'result' => $fileName]);
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
        else
            return response()->json(['status' => 'nok']);
    }

    public function deleteImgAddPlaceByUser(Request $request)
    {
        if(isset($request->id) && isset($request->name)){
            $addPlace = UserAddPlace::find($request->id);
            if($addPlace != null){
                $pic = $addPlace->pics;
                $pic = json_decode($pic);
                $index = array_search($request->name, $pic);
                if($index !== false){
                    $location = __DIR__ .'/../../../../assets/_images/addPlaceByUser/' . $request->name;
                    if(is_file($location))
                        unlink($location);

                    $pic[$index] = null;
                    $addPlace->pics = json_encode($pic);
                    $addPlace->save();

                    return response()->json(['status' => 'ok']);
                }
                else
                    return response()->json(['status' => 'nok2']);
            }
            else
                return response()->json(['status' => 'nok1']);
        }
        else
            return response()->json(['status' => 'nok']);
    }

}
