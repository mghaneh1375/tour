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

    public $limboLocation = __DIR__ . '/../../../../assets/limbo';

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
        $location = $this->limboLocation;
        if (!file_exists($location))
            mkdir($location);

        if($request->kind == 'thumbnail')
            return response()->json($this->uploadThumbnailVideo($request));
        else {
            if (isset($_FILES['pic']) && isset($request->code) && $_FILES['pic']['error'] == 0) {
                $valid_ext = array('image/jpeg', 'image/png', 'image/webp', 'image/jpg');
                $fileType = strtolower($_FILES['pic']['type']);
                if (in_array($fileType, $valid_ext)) {
                    $fileType = explode('.', $_FILES['pic']['name']);

                    $size = [['width' => 800, 'height' => null, 'name' => '', 'destination' => $location]];
                    $image = $request->file('pic');
                    $filename = resizeImage($image, $size);

                    $code = $request->code == 'false' ? \auth()->user()->id . '_' . generateRandomString(4) : $request->code;

                    $newPicReview = new ReviewPic();
                    $newPicReview->pic = $filename;
                    $newPicReview->code = $code;
                    $newPicReview->save();

                    return response()->json(['status' => 'ok', 'result' => ['fileName' => $filename, 'code' => $code]]);
                } else
                    return response()->json(['status' => 'nok2']);
            }
            else
                return response()->json(['status' => 'nok3']);
        }
    }

    private function uploadThumbnailVideo($request){
        $location = $this->limboLocation;
        if (!file_exists($location))
            mkdir($location);

        $thumbnailFileName = time().rand(1000, 9999).'.png';
        $filePath = "{$location}/{$thumbnailFileName}";

        $success = uploadLargeFile($filePath, $request->file);
        if($success){

            $size = [['width' => 800, 'height' => null, 'name' => '', 'destination' => $location]];
            $image = file_get_contents($filePath);
            $thumbnailFileName = resizeUploadedImage($image, $size, $thumbnailFileName);

            ReviewPic::where('code', $request->code)
                        ->where('pic', $request->fileName)
                        ->update(['thumbnail' => $thumbnailFileName]);

            return ['status' => 'ok', 'result' => ['fileName' => $thumbnailFileName, 'code' => $request->code]];
        }
        else
            return ['status' => 'error6'];
    }

    public function reviewUploadVideo(Request $request)
    {
        $data = json_decode($request->data);
        $direction = $this->limboLocation;
        if(!is_dir($direction))
            mkdir($direction);

        $code = $data->code;

        if(isset($request->cancelUpload) && $request->cancelUpload == 1){
            $direction .= '/'.$request->storeFileName;
            if(is_file($direction))
                unlink($direction);
            ReviewPic::where('code', $data->code)->where('pic', $request->storeFileName)->delete();
            return response()->json(['status' => 'canceled']);
        }

        if(isset($request->storeFileName) && isset($request->file_data) && $request->storeFileName != 0){
            $fileName = $request->storeFileName;
            $direction .= '/'.$fileName;
            $result = uploadLargeFile($direction, $request->file_data);
        }
        else{
            $file_name = $request->file_name;
            $fileType = explode('.', $file_name);
            $fileName = time().rand(100,999).'.'.end($fileType);

            $direction .= '/'.$fileName;
            $result = uploadLargeFile($direction, $request->file_data);

            if($result) {
                $limbo = new ReviewPic();
                $limbo->code = $code;
                $limbo->pic = $fileName;
                $limbo->isVideo = 1;
                $limbo->is360 = $data->is360;
                $limbo->save();
            }
        }

        if($result)
            return response()->json(['status' => 'ok', 'fileName' => $fileName, 'result' => $code]);
        else
            return response()->json(['status' => 'nok']);
    }

    public function getNewCodeForUploadNewReview(){
        return response()->json(['code' => \auth()->user()->id.'_'.generateRandomString(4)]);
    }

    public function deleteReviewPic(Request $request)
    {
        $code = $request->code;
        $name = $request->name;

        $pics = ReviewPic::where('code', $code)->where('pic', $name)->first();

        if ($pics != null) {
            if ($pics->isVideo == 1) {
                if($pics->thumbnail != null)
                    $videoName = $pics->thumbnail;
                else {
                    $videoArray = explode('.', $pics->pic);
                    $videoName = '';
                    for ($k = 0; $k < count($videoArray) - 1; $k++)
                        $videoName .= $videoArray[$k] . '.';
                    $videoName .= 'png';
                }

                $thumbnailLocation = $this->limboLocation.'/'.$videoName;
                if (file_exists($thumbnailLocation))
                    unlink($thumbnailLocation);
            }

            $picLocation = "{$this->limboLocation}/{$pics->pic}";
            if (file_exists($picLocation))
                unlink($picLocation);
            $pics->delete();

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'nok']);
    }

    public function doEditReviewPic(Request $request)
    {
        if (isset($request->code) && isset($request->name)) {
            $name = $request->name;
            $code = $request->code;

            $location = $this->limboLocation.'/'.$name;
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

        if (isset($request->code)) {

            $kindPlaceId = 0;
            $placeId = 0;
            $kindPlaceName = 'nonePlaces';
            if(isset($request->placeId) && $request->placeId != 0 && isset($request->kindPlaceId) && $request->kindPlaceId != 0){
                $kindPlaceId = $request->kindPlaceId;
                $placeId = $request->placeId;

                $kindPlace = Place::find($kindPlaceId);
                $place = DB::table($kindPlace->tableName)->find($placeId);
                $kindPlaceName = $kindPlace->fileName;
            }

            $uId = Auth::user()->id;

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

            if (count($reviewPic) > 0) {
                ReviewPic::where('code', $request->code)->update(['logId' => $log->id]);

                $location = __DIR__ . "/../../../../assets/userPhoto/{$kindPlaceName}";
                if (!file_exists($location))
                    mkdir($location);
                if($placeId != 0) {
                    $location .= '/' . $place->file;
                    if (!file_exists($location))
                        mkdir($location);
                }

                foreach ($reviewPic as $item) {
                    $file = "{$this->limboLocation}/{$item->pic}";
                    $dest = "{$location}/{$item->pic}";
                    if (file_exists($file))
                        rename($file, $dest);

                    if ($item->isVideo == 1) {
                        if($item->thumbnail != null)
                            $videoName = $item->thumbnail;
                        else{
                            $videoArray = explode('.', $item->pic);
                            $videoName = '';
                            for ($k = 0; $k < count($videoArray) - 1; $k++)
                                $videoName .= $videoArray[$k] . '.';
                            $videoName .= 'png';
                        }

                        $file = "{$this->limboLocation}/{$videoName}";
                        $dest = "{$location}/{$videoName}";
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
        }
        else
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


    public function getUserReviews()
    {
        $username = $_GET['username'];
        $reviewAct = Activity::where('name', 'نظر')->first();
        if(\auth()->check() && ( $username == \auth()->user()->username) ){
            $user = \auth()->user();
            $reviews = LogModel::where('activityId', $reviewAct->id)->where('visitorId', $user->id)->orderByDesc('created_at')->get();
        }
        else if(isset($username)){
            $user = User::where('username', $username)->first();
            $reviews = LogModel::where('activityId', $reviewAct->id)->where('visitorId', $user->id)->where('confirm', 1)->orderByDesc('created_at')->get();
        }
        else
            return response()->json(['status' => 'error1']);

        foreach ($reviews as $item)
            $item = reviewTrueType($item); // in common.php

        $reviews = $reviews->toArray();

        return response()->json(['status' => 'ok', 'result' => $reviews]);
    }

    public function getSingleReview()
    {
        if(isset($_GET['id'])){
            $review = LogModel::find($_GET['id']);
            if($review != null) {
                $review = reviewTrueType($review);
                return response()->json(['status' => 'ok', 'result' => $review]);
            }
            else
                return response()->json(['status' => 'nok1']);
        }
        else
            return response()->json(['status' => 'nok']);
    }

    public function getCityPageReview(Request $request)
    {
        $kind = $_GET['kind'];
        $placeId = $_GET['placeId'];
        $take = 15;
        $reviews = $this->getCityReviews($kind, $placeId, $take);
        if(count($reviews) != $take){
            $lessReview = [];
            $notIn = [];
            foreach ($reviews as $item)
                array_push($notIn, $item->id);

            if($kind == 'city'){
                $place = Cities::find($placeId);
                $less = $take - count($reviews);
                $lessReview = $this->getCityReviews('state', $place->stateId, $less, $notIn);
                foreach ($lessReview as $item)
                    array_push($reviews, $item);
            }

            $less = $take - count($reviews);
            if($less != 0){
                $notIn = [];
                foreach ($reviews as $item)
                    array_push($notIn, $item->id);

                $lessReview = $this->getCityReviews('country', 0, $less, $notIn);
                foreach ($lessReview as $item)
                    array_push($reviews, $item);
            }
        }

        foreach ($reviews as $item)
            $item = reviewTrueType($item); // in common.php

        return response()->json(['status' => 'ok', 'result' => $reviews]);
    }

    private function getCityReviews($kind, $id, $take, $notIn = [0]){
        $reviewActivity = Activity::whereName('نظر')->first();

        if($kind == 'city') {
            $allAmaken = Amaken::where('cityId', $id)->pluck('id')->toArray();
            $allMajara = Majara::where('cityId', $id)->pluck('id')->toArray();
            $allHotels = Hotel::where('cityId', $id)->pluck('id')->toArray();
            $allRestaurant = Restaurant::where('cityId', $id)->pluck('id')->toArray();
            $allMahaliFood = MahaliFood::where('cityId', $id)->pluck('id')->toArray();
            $allSogatSanaie = SogatSanaie::where('cityId', $id)->pluck('id')->toArray();
            $allBoomgardy = Boomgardy::where('cityId', $id)->pluck('id')->toArray();
        }
        else if($kind == 'state'){
            $allCities = Cities::where('stateId', $id)->where('isVillage', 0)->pluck('id')->toArray();

            $allAmaken = Amaken::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allMajara = Majara::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allHotels = Hotel::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allRestaurant = Restaurant::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allMahaliFood = MahaliFood::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allSogatSanaie = SogatSanaie::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allBoomgardy = Boomgardy::whereIn('cityId', $allCities)->pluck('id')->toArray();
        }
        else{
            if(count($notIn) == 0)
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 ORDER BY `date` DESC LIMIT ' . $take);
            else
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 AND id NOT IN (' . implode(",", $notIn) . ') ORDER BY `date` DESC LIMIT ' . $take);

            return $lastReview;
        }


        $sqlQuery = '';
        if(count($allAmaken) != 0)
            $sqlQuery .= '( kindPlaceId = 1 AND placeId IN (' . implode(",", $allAmaken) . ') )';
        if(count($allRestaurant) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 3 AND placeId IN (' . implode(",", $allRestaurant) . ') )';
        }
        if(count($allHotels) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 4 AND placeId IN (' . implode(",", $allHotels) . ') )';
        }
        if(count($allMajara) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 6 AND placeId IN (' . implode(",", $allMajara) . ') )';
        }
        if(count($allSogatSanaie) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 10 AND placeId IN (' . implode(",", $allSogatSanaie) . ') )';
        }
        if(count($allMahaliFood) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 11 AND placeId IN (' . implode(",", $allMahaliFood) . ') )';
        }
        if(count($allBoomgardy) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 12 AND placeId IN (' . implode(",", $allBoomgardy) . ') )';
        }

        $lastReview = [];

        if($sqlQuery != '') {
            if (count($notIn) == 0)
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 AND (' . $sqlQuery . ') ORDER BY `date` DESC LIMIT ' . $take);
            else
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 AND (' . $sqlQuery . ') AND id NOT IN (' . implode(",", $notIn) . ') ORDER BY `date` DESC LIMIT ' . $take);
        }

        return $lastReview;
    }


    public function deleteReview(Request $request)
    {
        if(\auth()->check()){
            $user = \auth()->user();
            if(isset($request->id)){
                $review = LogModel::find($request->id);
                if($review != null && $review->visitorId == $user->id){
                    $kindPlace = Place::find($review->kindPlaceId);
                    $place = \DB::table($kindPlace->tableName)->find($review->placeId);
                    $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlace->fileName . '/' . $place->file;
                    $reviewPics = ReviewPic::where('logId', $review->id)->get();
                    foreach ($reviewPics as $pic){
                        if(is_file($location.'/'.$pic->pic))
                            unlink($location.'/'.$pic->pic);
                        $pic->delete();
                    }

                    $userAssigned = ReviewUserAssigned::where('logId', $review->id)->get();
                    foreach ($userAssigned as $item){
                        Alert::where('referenceId', $item->id)->where('referenceTable', 'reviewUserAssigned')->delete();
                        $item->delete();
                    }

                    LogFeedBack::where('logId', $review->id)->delete();

                    $anses = LogModel::where('relatedTo', $review->id)->get();
                    foreach ($anses as $item)
                        deleteAnses($item->id);

                    QuestionUserAns::where('logId', $review->id)->delete();
                    Report::where('logId', $review->id)->delete();

                    $alert = new Alert();
                    $alert->userId = $user->id;
                    $alert->subject = 'deleteReviewByUser';
                    $alert->referenceTable = $kindPlace->tableName;
                    $alert->referenceId = $place->id;
                    $alert->save();

                    \DB::table($kindPlace->tableName)->where('id', $place->id)->update(['reviewCount' => $place->reviewCount-1]);
                    $review->delete();
                    echo 'ok';
                }
                else
                    echo 'nok2';
            }
            else
                echo 'nok1';
        }
        else
            echo 'nok';

        return;
    }

}

