<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\Alert;
use App\models\places\Amaken;
use App\models\BookMark;
use App\models\BookMarkReference;
use App\models\places\Boomgardy;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\GoyeshCity;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\QuestionAns;
use App\models\QuestionUserAns;
use App\models\Report;
use App\models\ReportsType;
use App\models\places\Restaurant;
use App\models\LogFeedBack;
use App\models\ReviewPic;
use App\models\ReviewUserAssigned;
use App\models\places\SogatSanaie;
use App\models\State;
use App\models\UserOpinion;
use App\User;
use Beta\B;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;


class ReviewsController extends Controller
{
    public function showReviewPage($id)
    {
        $activity = Activity::where('name', 'نظر')->first();
        $review = LogModel::where('id', $id)->where('activityId', $activity->id)->first();
        if($review == null)
            return redirect()->back();


        $kindPlace = Place::find($review->kindPlaceId);
        $place = createSuggestionPack($review->kindPlaceId, $review->placeId);
        $reviewId = $review->id;

        return view('pages.placeDetails.ReviewPage', compact(['place', 'kindPlace', 'reviewId']));
    }

    public function reviewUploadPic(Request $request)
    {
        $location = __DIR__ . '/../../../../assets/limbo';

        if (!file_exists($location))
            mkdir($location);

        if (isset($_FILES['pic']) && isset($request->code) && $_FILES['pic']['error'] == 0) {

            $valid_ext = array('image/jpeg', 'image/png');
            if (in_array($_FILES['pic']['type'], $valid_ext)) {
                $filename = time() . '_' . pathinfo($_FILES['pic']['name'], PATHINFO_FILENAME) . '.jpg';
                $destinationMainPic = $location . '/' . $filename;
                compressImage($_FILES['pic']['tmp_name'], $destinationMainPic, 60);

                $newPicReview = new ReviewPic();
                $newPicReview->pic = $filename;
                $newPicReview->code = $request->code;
                $newPicReview->save();

                echo json_encode(['ok', $filename]);
            } else
                echo 'nok2';
        } else
            echo 'nok3';

        return;
    }

    public function reviewUploadVideo(Request $request)
    {
        $location = __DIR__ . '/../../../../assets/limbo';

        if (!file_exists($location))
            mkdir($location);

        if (isset($_FILES['video']) && isset($request->code)) {
            $filename = time() . '_' . $_FILES['video']['name'];
            $destinationMainPic = $location . '/' . $filename;
            move_uploaded_file($_FILES['video']['tmp_name'], $destinationMainPic);

            $img = $_POST['videoPic'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $videoArray = explode('.', $filename);
            $videoName = '';
            for ($k = 0; $k < count($videoArray) - 1; $k++)
                $videoName .= $videoArray[$k] . '.';
            $videoName .= 'png';

            $file = __DIR__ . '/../../../../assets/limbo/' . $videoName;
            $success = file_put_contents($file, $data);

            $newPicReview = new ReviewPic();
            $newPicReview->pic = $filename;
            $newPicReview->code = $request->code;
            if (isset($request->isVideo) && $request->isVideo == 1)
                $newPicReview->isVideo = 1;
            if (isset($request->is360) && $request->is360 == 1) {
                $newPicReview->is360 = 1;
                $newPicReview->isVideo = 1;
            }
            $newPicReview->save();

            echo json_encode(['ok', $filename]);
        } else
            echo 'nok3';

        return;
    }

    public function deleteReviewPic(Request $request)
    {
        $code = $request->code;
        $name = $request->name;

        $pics = ReviewPic::where('code', $code)->where('pic', $name)->first();

        if ($pics != null) {
            if ($pics->isVideo == 1) {
                $videoArray = explode('.', $pics->pic);
                $videoName = '';
                for ($k = 0; $k < count($videoArray) - 1; $k++)
                    $videoName .= $videoArray[$k] . '.';
                $videoName .= 'png';

                $location2 = __DIR__ . '/../../../../assets/limbo/' . $videoName;

                if (file_exists($location2)) {
                    unlink($location2);
                }
            }
            $location = __DIR__ . '/../../../../assets/limbo/' . $pics->pic;
            if (file_exists($location))
                unlink($location);
            $pics->delete();
            echo 'ok';
        } else
            echo 'nok';

        return;
    }

    public function doEditReviewPic(Request $request)
    {
        if (isset($request->code) && isset($request->name)) {
            $name = $request->name;
            $code = $request->code;

            $location = __DIR__ . '/../../../../assets/limbo/' . $name;
            if (file_exists($location))
                unlink($location);

            move_uploaded_file($_FILES['pic']['tmp_name'], $location);

            echo 'ok';
        }
        else
            echo 'nok';

        return;
    }

    public function storeReview(Request $request)
    {
        $activity = Activity::where('name', 'نظر')->first();

        if (isset($request->placeId) && isset($request->kindPlaceId) && isset($request->code)) {

            $placeId = $request->placeId;
            $uId = Auth::user()->id;
            $kindPlaceId = $request->kindPlaceId;
            $kindPlace = Place::find($kindPlaceId);
            $place = DB::table($kindPlace->tableName)->find($placeId);
            $kindPlaceName = $kindPlace->fileName;

            $log = new LogModel();
            $log->placeId = $placeId;
            $log->kindPlaceId = $kindPlaceId;
            $log->visitorId = $uId;
            $log->date = Carbon::now()->format('Y-m-d');
            $log->time = getToday()['time'];
            $log->activityId = $activity->id;
            $log->text = $request->text != null ? $request->text : '';
            $log->save();

            $reviewPic = ReviewPic::where('code', $request->code)->get();
            ReviewPic::where('code', $request->code)->update(['logId' => $log->id]);

            if (count($reviewPic) > 0) {
                $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlaceName;
                if (!file_exists($location))
                    mkdir($location);
                $location .= '/' . $place->file;
                if (!file_exists($location))
                    mkdir($location);

                $limboLocation = __DIR__ . '/../../../../assets/limbo/';

                foreach ($reviewPic as $item) {
                    $file = $limboLocation . $item->pic;
                    $dest = $location . '/' . $item->pic;
                    if (file_exists($file))
                        rename($file, $dest);

                    if ($item->isVideo == 1) {
                        $videoArray = explode('.', $item->pic);
                        $videoName = '';
                        for ($k = 0; $k < count($videoArray) - 1; $k++)
                            $videoName .= $videoArray[$k] . '.';
                        $videoName .= 'png';

                        $file = $limboLocation . $videoName;
                        $dest = $location . '/' . $videoName;
                        if (file_exists($file))
                            rename($file, $dest);
                    }
                }
            }
            else if ($request->text == null) {
                $log->subject = 'dontShowThisText';
                $log->confirm = 1;
                $log->save();
            }

            $assignedUser = json_decode($request->assignedUser);
            if ($assignedUser != null) {
                foreach ($assignedUser as $item) {
                    $newAssigned = new ReviewUserAssigned();
                    $newAssigned->logId = $log->id;

                    $user = User::where('username', $item)->orWhere('email', $item)->first();
                    if ($user != null) {
                        $newAssigned->userId = $user->id;
                        $findUser = ReviewUserAssigned::where('logId', $log->id)->where('userId', $user->id)->first();
                        if($findUser != null)
                            continue;
                    }
                    else
                        $newAssigned->email = $item;

                    $newAssigned->save();

                    if ($user != null) {
                        $newAlert = new Alert();
                        $newAlert->subject = 'assignedUserToReview';
                        $newAlert->referenceTable = 'reviewUserAssigned';
                        $newAlert->referenceId = $newAssigned->id;
                        $newAlert->userId = $user->id;
                        $newAlert->seen = 0;
                        $newAlert->click = 0;
                        $newAlert->save();
                    }

                }
            }

            if ($request->textId != null && $request->textAns != null) {
                $textQuestion = $request->textId;
                $textAns = $request->textAns;
                for ($i = 0; $i < count($textAns); $i++) {
                    if ($textAns[$i] != null && $textAns[$i] != '' && $textQuestion[$i] != null) {
                        $newAns = new QuestionUserAns();
                        $newAns->logId = $log->id;
                        $newAns->questionId = $textQuestion[$i];
                        $newAns->ans = $textAns[$i];
                        $newAns->save();
                    }
                }
            }

            if ($request->multiQuestion != null && $request->multiAns != null) {
                $multiQuestion = json_decode($request->multiQuestion);
                $multiAns = json_decode($request->multiAns);

                for ($i = 0; $i < count($multiAns); $i++) {
                    if ($multiAns[$i] != null && $multiAns[$i] != '' && $multiQuestion[$i] != null) {
                        $newAns = new QuestionUserAns();
                        $newAns->logId = $log->id;
                        $newAns->questionId = $multiQuestion[$i];
                        $newAns->ans = $multiAns[$i];
                        $newAns->save();
                    }
                }
            }

            if ($request->rateQuestion != null && $request->rateAns != null) {
                $rateQuestion = json_decode($request->rateQuestion);
                $rateAns = json_decode($request->rateAns);

                for ($i = 0; $i < count($rateAns); $i++) {
                    if ($rateAns[$i] != null && $rateAns[$i] != '' && $rateQuestion[$i] != null) {
                        $newAns = new QuestionUserAns();
                        $newAns->logId = $log->id;
                        $newAns->questionId = $rateQuestion[$i];
                        $newAns->ans = $rateAns[$i];
                        $newAns->save();
                    }
                }
            }

            $newAlert = new Alert();
            $newAlert->subject = 'addReview';
            $newAlert->referenceTable = 'log';
            $newAlert->referenceId = $log->id;
            $newAlert->userId = $uId;
            $newAlert->seen = 0;
            $newAlert->click = 0;
            $newAlert->save();

            $code = $uId . '_' . rand(10000, 99999);

            echo json_encode(['status' => 'ok', 'code' => $code]);
        } else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function getReviews(Request $request)
    {

        if (isset($request->placeId) && isset($request->kindPlaceId)) {
            $activity = Activity::where('name', 'نظر')->first();
            $a = Activity::where('name', 'پاسخ')->first();

            $ques = array();
            $ans = array();
            $isFilter = false;
            $isPicFilter = false;
            $sqlQuery = '';
            $onlyPic = 0;

            $count = 0;
            $num = 0;
            if (isset($request->count))
                $count = $request->count;
            if (isset($request->num))
                $num = $request->num;

            if (\auth()->check())
                $uId = \auth()->user()->id;
            else
                $uId = 0;

            $sqlQuery = 'activityId = ' . $activity->id . ' AND placeId = ' . $request->placeId . ' AND kindPlaceId = ' . $request->kindPlaceId . ' AND relatedTo = 0 AND (visitorId = ' . $uId . ' OR confirm = 1) ';

            if (isset($request->filters)) {
                $sqlQuery .= ' AND CHARACTER_LENGTH(text) >= 0';

                foreach ($request->filters as $item) {
                    if ($item != null && $item['kind'] != 'onlyPic' && $item['kind'] != 'textSearch') {
                        array_push($ques, $item['id']);
                        array_push($ans, $item['value']);
                    }
                    else if ($item != null && $item['kind'] == 'onlyPic') {

                        if ($item['value'] != 3) {
                            $onlyPic = $item['value'];
                            $isPicFilter = true;
                        } else {
                            if ($sqlQuery != '')
                                $sqlQuery .= ' AND';
                            $sqlQuery = ' CHARACTER_LENGTH(text) > 150';
                        }

                    } else if ($item != null && $item['kind'] == 'textSearch') {

                        if ($sqlQuery != '')
                            $sqlQuery .= ' AND';

                        $sqlQuery .= ' text LIKE "%' . $item['value'] . '%"';
                    }

                }

                $lo = array();
                if (count($ques) > 0) {
                    $isFilter = true;

                    $logs = LogModel::whereRaw($sqlQuery)->get();

                    $logId = array();
                    for ($i = 0; $i < count($logs); $i++)
                        array_push($logId, $logs[$i]->id);

                    $isNull = false;

                    for ($i = 0; $i < count($ques); $i++) {
                        if (count($lo) != 0)
                            $n = DB::select('SELECT logId FROM questionUserAns WHERE questionId = ' . $ques[$i] . ' AND ans = ' . $ans[$i] . ' AND  logId IN (' . implode(",", $lo) . ')');
                        else
                            $n = DB::select('SELECT logId FROM questionUserAns WHERE questionId = ' . $ques[$i] . ' AND ans = ' . $ans[$i] . ' AND logId IN (' . implode(",", $logId) . ')');

                        if (count($n) == 0) {
                            $isNull = true;
                            break;
                        }

                        $lo = array();
                        foreach ($n as $l)
                            array_push($lo, $l->logId);
                    }

                    if ($isNull) {
                        echo 'nok1';
                        return;
                    }
                }

                if ($isPicFilter) {

                    if ($sqlQuery == '')
                        $sqlQuery = '1';

                    $logs = LogModel::whereRaw($sqlQuery)->get();

                    $loo = array();
                    foreach ($logs as $item)
                        array_push($loo, $item->id);

                    if ($onlyPic != 3) {
                        $ni = DB::select('SELECT logId, GROUP_CONCAT(isVideo) AS video FROM reviewPics WHERE logId IN (' . implode(",", $loo) . ') GROUP BY logId;');

                        $lo = array();
                        foreach ($ni as $item) {
                            switch ($onlyPic) {
                                case 1:
                                    if (strpos($item->video, '1') === false)
                                        array_push($lo, $item->logId);
                                    break;
                                case 2:
                                    if (strpos($item->video, '0') === false) {
                                        array_push($lo, $item->logId);
                                    }
                                    break;
                                case 4:
                                    array_push($lo, $item->logId);
                                    break;
                            }
                        }
                    }
                    $isFilter = true;
                }

                if (count($lo) > 0) {
                    if ($sqlQuery != '')
                        $sqlQuery .= ' AND';

                    $sqlQuery .= ' id IN (' . implode(",", $lo) . ')';
                } else if (($isPicFilter || count($ques) > 0) && count($lo) == 0) {
                    echo 'nok1';
                    return;
                }

            }

            $logCount = LogModel::whereRaw($sqlQuery)->count();
            if ($num == 0 && $count == 0)
                $logs = LogModel::whereRaw($sqlQuery)->orderByDesc('date')->orderByDesc('time')->get();
            else
                $logs = LogModel::whereRaw($sqlQuery)->orderByDesc('date')->orderByDesc('time')->skip(($num - 1) * $count)->take($count)->get();

            if (count($logs) == 0)
                echo 'nok1';
            else {
                foreach ($logs as $key => $item)
                    $item = reviewTrueType($item); // in common.php

                echo json_encode([$logs, $logCount]);
            }
        }

        return;

    }

    public function ansReview(Request $request)
    {
        if (\auth()->check()) {
            if (isset($request->text) && isset($request->logId)) {
                if (strlen($request->text) > 2) {
                    $u = Auth::user();
                    $a = Activity::where('name', 'پاسخ')->first();
                    $mainLog = LogModel::find($request->logId);
                    if ($mainLog != null) {
                        $newLog = New LogModel();
                        $newLog->placeId = $mainLog->placeId;
                        $newLog->kindPlaceId = $mainLog->kindPlaceId;
                        $newLog->visitorId = $u->id;
                        $newLog->date = Carbon::now()->format('Y-m-d');;
                        $newLog->time = getToday()['time'];
                        $newLog->activityId = $a->id;
                        $newLog->text = $request->text;
                        $newLog->relatedTo = $mainLog->id;
                        $newLog->save();

                        if ($mainLog->activityId == $a->id) {
                            $mainLog->subject = 'ans';
                            $mainLog->save();

                            $mainLog = LogModel::find($mainLog->relatedTo);
                            while($mainLog->activityId == $a->id && $mainLog != null)
                                $mainLog = LogModel::find($mainLog->relatedTo);
                        }
                        $reviewId = $mainLog->id;

                        return response()->json(['status' => 'ok', 'reviewId' => $reviewId]);
                    }
                }
            }
        }

        return response()->json(['status' => 'nok']);
    }

    public function addReviewToBookMark(Request $request)
    {
        if(\auth()->check()){
            if(isset($request->id)){
                $bookmarkKind = BookMarkReference::where('group', 'review')->first();
                $bookmark = BookMark::where('userId', \auth()->user()->id)
                                    ->where('referenceId', $request->id)
                                    ->where('bookMarkReferenceId', $bookmarkKind->id)
                                    ->first();
                if($bookmark == null){
                    $bookmark = new BookMark();
                    $bookmark->userId = \auth()->user()->id;
                    $bookmark->referenceId = $request->id;
                    $bookmark->bookMarkReferenceId = $bookmarkKind->id;
                    $bookmark->save();

                    echo 'store';
                }
                else{
                    $bookmark->delete();
                    echo 'delete';
                }
            }
            else
                echo 'nok';
        }
        else
            echo 'notAuth';

        return;
    }
}

