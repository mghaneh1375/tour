<?php


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
use App\models\ReviewPic;
use App\models\ReviewUserAssigned;
use App\models\QuestionAns;

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
    $place = \DB::table($kindPlace->tableName)->select(['name', 'id', 'file', 'picNumber', 'alt', 'cityId', 'fullRate'])->find($_placeId);
    if($place != null) {
        $city = Cities::whereId($place->cityId);

        $place->pic = getPlacePic($place->id, $kindPlace->id);
        $place->url = createUrl($kindPlace->id, $place->id, 0, 0);
        if($city != null) {
            $place->city = $city->name;
            $place->state = State::whereId($city->stateId)->name;
        }
        else{
            $place->city = '';
            $place->state = '';
        }
        $place->rate = $place->fullRate;
        $condition = ['placeId' => $place->id, 'kindPlaceId' => $_kindPlaceId, 'activityId' => $activityId, 'confirm' => 1];
        $place->review = LogModel::where($condition)->count();
        return $place;
    }
    return null;
}

function reviewTrueType($_log){
    $user = User::select(['first_name', 'last_name', 'username', 'picture', 'uploadPhoto', 'id'])->find($_log->visitorId);
    $kindPlace = Place::find($_log->kindPlaceId);
    $place = DB::table($kindPlace->tableName)->select(['id', 'name', 'cityId', 'file'])->find($_log->placeId);

    $_log->userName = $user->username;
    $_log->userPageUrl = route('profile', ['username' => $user->username]);
    $_log->userPic = getUserPic($user->id);
    $_log->like = LogFeedBack::where('logId', $_log->id)->where('like', 1)->count();
    $_log->disLike = LogFeedBack::where('logId', $_log->id)->where('like', -1)->count();

    $_log->mainFile = $kindPlace->fileName;
    $_log->placeName = $place->name;
    $_log->kindPlace = $kindPlace->name;
    $_log->placeUrl = createUrl($kindPlace->id, $place->id, 0, 0);
    $_log->pics = ReviewPic::where('logId', $_log->id)->get();
    $_log = getReviewPicsURL($_log, $place->file);
    if(count($_log->pics) > 0){
        $_log->hasPic = true;
        $_log->mainPic = $_log->pics[0]->picUrl;
        if(count($_log->pics) > 1){
            $_log->morePic = true;
            $_log->picCount = count($_log->pics) - 1;
        }
        else
            $_log->morePic = false;
    }
    else {
        $_log->hasPic = false;
        $_log->picCount = 0;
    }

    $getAnses = getAnsToComments($_log->id);
    $_log->answersCount = $getAnses[1];
    if(count($getAnses[0]) > 0)
        $_log->answers = $getAnses[0];
    else
        $_log->answers = array();

    $_log->city = Cities::find($place->cityId);
    $_log->state = State::find($_log->city->stateId);
    $_log->placeCity = $_log->city->name;
    $_log->placeState = $_log->state->name;
    $_log->where = $place->name . ' شهر ' .  $_log->city->name . ' ، استان ' . $_log->state->name;

    $time = $_log->date . '';
    if(strlen($_log->time) == 1)
        $_log->time = '000' . $_log->time;
    else if(strlen($_log->time) == 2)
        $_log->time = '00' . $_log->time;
    else if(strlen($_log->time) == 3)
        $_log->time = '0' . $_log->time;

    if(strlen($_log->time) == 4) {
        $time .= ' ' . substr($_log->time, 0, 2) . ':' . substr($_log->time, 2, 2);
        $_log->timeAgo = getDifferenceTimeString($time);
    }
    else
        $_log->timeAgo = '';

    if(strlen($_log->text) > 180) {
        $_log->summery = mb_substr($_log->text, 0, 180, 'utf-8');
        $_log->hasSummery = true;
    }
    else
        $_log->hasSummery = false;

    $_log->assigned = ReviewUserAssigned::where('logId', $_log->id)->get();
    if (count($_log->assigned) != 0) {
        foreach ($_log->assigned as $item) {
            if ($item->userId != null) {
                $u = User::find($item->userId);
                if ($u != null)
                    $item->name = $u->username;
            }
        }
    }

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

    $_log->userLike = null;
    $_log->bookmark = false;
    $_log->yourReview = false;
    if (\auth()->check()) {
        $u = \auth()->user();
        $_log->userLike = LogFeedBack::where('logId', $_log->id)->where('userId', $u->id)->first();
        if($_log->visitorId == $u->id)
            $_log->yourReview = true;

        $bookMarkKind = BookMarkReference::where('group', 'review')->first();
        $bookmark = BookMark::where('userId', $u->id)
                            ->where('referenceId', $_log->id)
                            ->where('bookMarkReferenceId', $bookMarkKind->id)
                            ->first();
        if($bookmark != null)
            $_log->bookmark = true;
    }

    return $_log;
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
