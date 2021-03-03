<?php


use App\models\localShops\LocalShops;
use App\models\logs\UserSeenLog;
use App\models\safarnameh\SafarnamehCategoryRelations;
use App\models\safarnameh\SafarnamehComments;
use App\models\safarnameh\SafarnamehLike;
use App\models\User;
use App\models\Activity;
use App\models\places\Place;
use App\models\Cities;
use App\models\State;
use App\models\LogModel;
use App\models\BookMarkReference;
use App\models\BookMark;
use App\models\LogFeedBack;
use App\models\Reviews\ReviewPic;
use App\models\Reviews\ReviewUserAssigned;
use App\models\QuestionAns;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;

function SafarnamehMinimalData($safarnameh){

    $safarnameh->msgs = SafarnamehComments::where('safarnamehId', $safarnameh->id)
                                            ->where(function($query){
                                                if(auth()->check())
                                                    $query->where('confirm', 1)->orWhere('userId', auth()->user()->id);
                                                else
                                                    $query->where('confirm', 1);
                                            })
                                            ->count();
    $safarnameh->like = SafarnamehLike::where('safarnamehId', $safarnameh->id)
                                        ->where('like',1)
                                        ->count();
    $safarnameh->disLike = SafarnamehLike::where('safarnamehId', $safarnameh->id)
                                            ->where('like',-1)
                                            ->count();
    if($safarnameh->date == null)
        $safarnameh->date = \verta($safarnameh->created_at)->format('Ym%d');
    if($safarnameh->date != null)
        $safarnameh->date = convertJalaliToText($safarnameh->date);

    $safarnameh->pic = \URL::asset('_images/posts/' . $safarnameh->id . '/' . $safarnameh->pic);
    $writer = User::find($safarnameh->userId);
    $safarnameh->username = $writer->username;
    $safarnameh->writerPic = getUserPic($writer->id);
    $safarnameh->url = route('safarnameh.show', ['id' => $safarnameh->id]);
    $category = SafarnamehCategoryRelations::join('safarnamehCategories', 'safarnamehCategories.id', 'safarnamehCategoryRelations.categoryId')
        ->where('safarnamehCategoryRelations.safarnamehId', $safarnameh->id)
        ->where('safarnamehCategoryRelations.isMain', 1)->first();

    if($category != null) {
        $safarnameh->category = $category->name;
        $safarnameh->categoryId = $category->id;
    }
    else{
        $safarnameh->category = null;
        $safarnameh->categoryId = 0;
    }

    if($safarnameh->category == null)
        $safarnameh->category = '';
    if ($safarnameh->summery == null) {
        if ($safarnameh->meta != null)
            $safarnameh->summery = $safarnameh->meta;
        else
            $safarnameh->summery = '';
    }

    $safarnameh->bookMark = false;
    if(auth()->check()){
        $bookMarkKind = BookMarkReference::where('group', 'safarnameh')->first();
        $bookMark = BookMark::where('userId', auth()->user()->id)
                            ->where('referenceId', $safarnameh->id)
                            ->where('bookMarkReferenceId', $bookMarkKind->id)->first();

        if($bookMark != null)
            $safarnameh->bookMark = true;
    }

    return $safarnameh;
}

function createSuggestionPack($_kindPlaceId, $_placeId){
    $activityId = Activity::whereName('نظر')->first()->id;

    $kindPlace = Place::find($_kindPlaceId);
    if($kindPlace->id == 13)
        $place = LocalShops::select(['name', 'id', 'file', 'cityId', 'fullRate', 'reviewCount', 'meta', 'slug', 'seoTitle', 'keyword'])->find($_placeId);
    else
        $place = \DB::table($kindPlace->tableName)->select(['name', 'id', 'file', 'picNumber', 'alt', 'reviewCount', 'cityId', 'fullRate', 'meta', 'slug', 'seoTitle', 'keyword'])->find($_placeId);

    if($place != null) {
        $city = Cities::whereId($place->cityId);

        $place->pic = getPlacePic($place->id, $kindPlace->id);
        $place->url = createUrl($kindPlace->id, $place->id, 0, 0);
        $place->city = $city != null ? $city->name : '';
        $place->state = $city != null ? $city->getState->name : '';

        $place->rate = $place->fullRate;
        $condition = ['placeId' => $place->id, 'kindPlaceId' => $_kindPlaceId, 'activityId' => $activityId, 'confirm' => 1];
        $place->review = $place->reviewCount;
        return $place;
    }
    return null;
}

function reviewTrueType($_log){
    $authUserId = auth()->check() ? auth()->user()->id : 0;

    $_log = LogModel::join('users', 'users.id', 'log.visitorId')
                        ->where('log.id', $_log->id)
                        ->orderByDesc('created_at')
                        ->select(['log.*', 'users.username'])
                        ->first();

    $_log = getReviewContents($_log, $authUserId);

    $_log->questionAns = \DB::select('SELECT us.logId, us.questionId, us.ans, qus.id, qus.description, qus.ansType FROM questionUserAns AS us , questions AS qus WHERE us.logId = ' . $_log->id . ' AND qus.id = us.questionId ORDER BY qus.ansType');
    if (count($_log->questionAns) != 0) {
        foreach ($_log->questionAns as $item) {
            if ($item->ansType == 'multi') {
                $anss = QuestionAns::where('questionId', $item->id)->where('id', $item->ans)->first();
                $item->ans = $anss->ans;
                $item->ansId = $anss->id;
            }
        }
    }

    return $_log;
}

function reviewTrueTypeIdArray($reviewIds){
    $authUserId = auth()->check() ? auth()->user()->id : 0;

    $reviews = LogModel::join('users', 'users.id', 'log.visitorId')
                        ->whereIn('log.id', $reviewIds)
                        ->orderByDesc('created_at')
                        ->select(['log.*', 'users.username'])
                        ->get();

    foreach($reviews as $item)
        $item = getReviewContents($item, $authUserId);

    return $reviews;
}

function getReviewContents($item, $authUserId){

    if($item->kindPlaceId != 0 && $item->placeId != 0) {
        $kindPlace = Place::find($item->kindPlaceId);
        $place = DB::table($kindPlace->tableName)->select(['id', 'name', 'cityId', 'file'])->find($item->placeId);

        $item->mainFile = $kindPlace->fileName;
        $item->placeName = $place->name;
        $item->kindPlace = $kindPlace->name;
        $item->placeUrl = createUrl($kindPlace->id, $place->id, 0, 0);

        $cityAndState = Cities::join('state', 'state.id', 'cities.stateId')
            ->where('cities.id', $place->cityId)
            ->select(['cities.id AS cityId', 'state.id AS stateId', 'cities.name AS cityName', 'state.name AS stateName', 'state.isCountry'])
            ->first();
        $item->placeCity = $cityAndState->cityName;
        $item->placeState = $cityAndState->stateName;

        $stateText = $cityAndState->isCountry == 1 ? ' کشور ' : ' استان ';

        $item->where = "{$place->name} شهر {$cityAndState->cityName}، {$stateText} {$cityAndState->stateName}";

        $folderName = "{$kindPlace->fileName}/{$place->file}";
    }
    else{
        $folderName = "nonePlaces";
        $item->where = '';
    }

    $item->yourReview = $authUserId == $item->visitorId;
    $item->userName = $item->username;
    $item->userPageUrl = route('profile', ['username' => $item->username]);
    $item->userPic = getUserPic($item->visitorId);

    $likes = \DB::select("SELECT COUNT(IF(`like` = 1, 1, null)) `likeCount`, COUNT(IF(`like` = -1, 1, null)) `disLikeCount`, IF(`userId` = {$authUserId}, `like`, null) `youLike` FROM `logFeedBack` WHERE `logId` = {$item->id}");
    $item->like = $likes[0]->likeCount;
    $item->disLike = $likes[0]->disLikeCount;
    $item->userLike = $likes[0]->youLike;

    $getAnses = getAnsToComments($item->id);
    $item->answersCount = $getAnses[1];
    $item->answers = count($getAnses[0]) > 0 ? $getAnses[0] : [];


    $noneTagText = strip_tags($item->text);
    $item->summery = strlen($noneTagText) > 180 ? mb_substr($noneTagText, 0, 180, 'utf-8') : null;

    $item->assigned = ReviewUserAssigned::join('users', 'users.id', 'reviewUserAssigned.userId')
        ->where('reviewUserAssigned.logId', $item->id)
        ->select(['users.username AS name'])
        ->get();

    $item->bookmark = false;
    if ($authUserId != 0) {
        $bookmark = BookMark::join('bookMarkReferences', 'bookMarkReferences.id', 'bookMarks.bookMarkReferenceId')
            ->where('bookMarkReferences.group', 'review')
            ->where('bookMarks.userId', $authUserId)
            ->where('bookMarks.referenceId', $item->id)
            ->select(['bookMarks.id', 'bookMarks.userId', 'bookMarks.referenceId', 'bookMarks.bookMarkReferenceId'])
            ->first();
        if($bookmark != null)
            $item->bookmark = true;
    }

    $item->pics = ReviewPic::where('logId', $item->id)->get();
    $item->pics = getReviewPicsURL($item->pics, $folderName);
    if(count($item->pics) > 0){
        $item->hasPic = true;
        $item->mainPic = $item->pics[0]->picUrl;
        $item->mainPicIsVideo = $item->pics[0]->isVideo;

        if(count($item->pics) > 1){
            $item->morePic = true;
            $item->picCount = count($item->pics) - 1;
        }
        else
            $item->morePic = false;
    }
    else {
        $item->hasPic = false;
        $item->picCount = 0;
    }

    if($item->created_at != null){
        if(gettype($item->created_at) === 'object') {
            $time = $item->created_at->format('H:i:s');
            $date = verta($item->created_at)->format('Y-m-d');
        }
        else{
            $dateAndTime = explode(' ', $item->created_at);
            $time = $dateAndTime[1];
            $date = Carbon::createFromFormat('Y-m-d', $dateAndTime[0]);
        }
    }
    else if($item->date != null && $item->time != null){
        if(strlen($item->time) == 1) $item->time = '000' . $item->time;
        else if(strlen($item->time) == 2) $item->time = '00' . $item->time;
        else if(strlen($item->time) == 3) $item->time = '0' . $item->time;

        $carbon = Carbon::createFromFormat('Y-m-d', $item->date);
        $date = \verta($carbon)->format('Y-m-d');
        $time = substr($item->time, 0, 2) . ':' . substr($item->time, 2, 2) .':00';
    }
    try {
        $time = explode(':', $time);
        $date = explode('-', $date);
        $item->timeAgo = Verta::createJalali($date[0], $date[1], $date[2], $time[0], $time[1], $time[2])->formatDifference();
    }
    catch (\Exception $exception){
        $item->timeAgo = '';
    }

    return $item;
}

function getReviewPicsURL($pics, $placeFile){
    foreach ($pics as $pic) {
        if($pic->isVideo == 1 || $pic->is360 == 1){
            if($pic->thumbnail != null)
                $pic->picUrl = URL::asset("userPhoto/{$placeFile}/{$pic->thumbnail}");
            else {
                $videoArray = explode('.', $pic->pic);
                $videoArray[count($videoArray)-1] = '.png';
                $videoName = implode('', $videoArray);

                $pic->picUrl = URL::asset("userPhoto/{$placeFile}/{$videoName}");
            }
            $pic->videoUrl = URL::asset("userPhoto/{$placeFile}/{$pic->pic}");
        }
        else
            $pic->picUrl = URL::asset("userPhoto/{$placeFile}/{$pic->pic}");
        $pic->picKind = 'review';
    }
    return $pics;
}

function questionTrueType($_ques){
    $user = User::whereId($_ques->visitorId);
    $_ques->userName = $user->username;
    $_ques->userPic = getUserPic($user->id);

    $anss = getAnsToComments($_ques->id);

    $_ques->answers = $anss[0];
    $_ques->answersCount = $anss[1];

    $kindPlace = Place::find($_ques->kindPlaceId);
    $_ques->mainFile = $kindPlace->fileName;
    $_ques->place = DB::table($kindPlace->tableName)->select(['id', 'name', 'cityId', 'file'])->find($_ques->placeId);
    $_ques->placeName = $_ques->place->name;
    $_ques->kindPlace = $kindPlace->name;
    $_ques->placeUrl = createUrl($kindPlace->id, $_ques->place->id, 0, 0, 0);

    $_ques->city = Cities::find($_ques->place->cityId);
    $_ques->cityName = $_ques->city->name;
    $_ques->state = State::find($_ques->city->stateId);
    $_ques->stateName = $_ques->state->name;

    $time = $_ques->date . '';
    if(strlen($_ques->time) == 1)
        $_ques->time = '000' . $_ques->time;
    else if(strlen($_ques->time) == 2)
        $_ques->time = '00' . $_ques->time;
    else if(strlen($_ques->time) == 3)
        $_ques->time = '0' . $_ques->time;

    if(strlen($_ques->time) == 4) {
        $time .= ' ' . substr($_ques->time, 0, 2) . ':' . substr($_ques->time, 2, 2);
        $_ques->timeAgo = getDifferenceTimeString($time);
    }
    else
        $_ques->timeAgo = '';

    $_ques->date = convertDate($_ques->date);

    $_ques->yourReview = false;
    if(\auth()->check() && $_ques->visitorId == \auth()->user()->id)
        $_ques->yourReview = true;

    return $_ques;
}

function getAnsToComments($logId){

    $uId = 0;
    if(auth()->check())
        $uId = auth()->user()->id;

    $a = Activity::where('name', 'پاسخ')->first();

    $ansToReview = DB::select('SELECT log.visitorId, log.text, log.subject, log.id, log.confirm, log.date, log.time FROM log WHERE (log.confirm = 1 || log.visitorId = ' . $uId . ') AND log.relatedTo = ' . $logId . ' AND log.activityId = ' . $a->id . ' ORDER BY `created_at` DESC; ');

    $countAns = 0;
    if(count($ansToReview) > 0) {
        $logIds = array();
        $ansToReviewUserId = array();
        $countAns += count($ansToReview);
        for ($i = 0; $i < count($ansToReview); $i++) {
            array_push($logIds, $ansToReview[$i]->id);
            array_push($ansToReviewUserId, $ansToReview[$i]->visitorId);

            $ansToReview[$i]->answers = array();

            if($ansToReview[$i]->subject == 'ans') {
                $anss = getAnsToComments($ansToReview[$i]->id);
                $ansToReview[$i]->answers = $anss[0];
                $ansToReview[$i]->answersCount = $anss[1];
                $countAns += $ansToReview[$i]->answersCount;
            }
            else
                $ansToReview[$i]->answersCount = 0;
        }

        $likeLogIds = DB::select('SELECT COUNT(RFB.like) AS likeCount, RFB.logId FROM logFeedBack AS RFB WHERE RFB.logId IN (' . implode(",", $logIds) . ') AND RFB.like = 1 GROUP BY RFB.logId');
        $dislikeLogIds = DB::select('SELECT COUNT(RFB.like) AS dislikeCount, RFB.logId FROM logFeedBack AS RFB WHERE RFB.logId IN (' . implode(",", $logIds) . ') AND RFB.like = -1 GROUP BY RFB.logId');
        $ansToReviewUser = DB::select('SELECT * FROM users WHERE id IN (' . implode(",", $ansToReviewUserId) . ')');

        for ($i = 0; $i < count($ansToReview); $i++) {
            $l = false;
            $dl = false;

            for ($j = 0; $j < count($likeLogIds); $j++) {
                if ($ansToReview[$i]->id == $likeLogIds[$j]->logId) {
                    $ansToReview[$i]->like = $likeLogIds[$j]->likeCount;
                    $l = true;
                    break;
                }
            }
            if (!$l)
                $ansToReview[$i]->like = 0;

            for ($j = 0; $j < count($dislikeLogIds); $j++) {
                if ($ansToReview[$i]->id == $dislikeLogIds[$j]->logId) {
                    $ansToReview[$i]->disLike = $dislikeLogIds[$j]->dislikeCount;
                    $dl = true;
                    break;
                }
            }
            if (!$dl)
                $ansToReview[$i]->disLike = 0;

            for ($j = 0; $j < count($ansToReviewUser); $j++) {
                if ($ansToReview[$i]->visitorId == $ansToReviewUser[$j]->id) {
                    $ansToReview[$i]->userName = $ansToReviewUser[$j]->username;
                    $ansToReview[$i]->writerPic = getUserPic($ansToReviewUser[$j]->id);

                    $ansToReview[$i]->youLike = 0;
                    if($uId != 0){
                        $youLike = LogFeedBack::where('logId', $ansToReview[$i]->id)
                            ->where('userId', $uId)
                            ->first();

                        if($youLike != null)
                            $ansToReview[$i]->youLike = $youLike->like;
                    }

                    $time = $ansToReview[$i]->date . '';
                    if(strlen($ansToReview[$i]->time) == 1)
                        $ansToReview[$i]->time = '000' . $ansToReview[$i]->time;
                    else if(strlen($ansToReview[$i]->time) == 2)
                        $ansToReview[$i]->time = '00' . $ansToReview[$i]->time;
                    else if(strlen($ansToReview[$i]->time) == 3)
                        $ansToReview[$i]->time = '0' . $ansToReview[$i]->time;

                    if(strlen($ansToReview[$i]->time) == 4) {
                        $time .= ' ' . substr($ansToReview[$i]->time, 0, 2) . ':' . substr($ansToReview[$i]->time, 2, 2);
                        $ansToReview[$i]->timeAgo = getDifferenceTimeString($time);
                    }
                    else
                        $ansToReview[$i]->timeAgo = '';

                    break;
                }
            }
        }
    }
    else
        $ansToReview = array();

    return [$ansToReview, $countAns];
}

function getNewsMinimal($news){
    $news->pic = URL::asset("_images/news/{$news->id}/{$news->pic}");
    $news->url = route('news.show', ['slug' => $news->slug]);

    return $news;
}
