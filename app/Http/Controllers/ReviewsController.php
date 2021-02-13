<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\Alert;
use App\models\Followers;
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
use App\models\Reviews\ReviewPic;
use App\models\Reviews\ReviewTagRelations;
use App\models\Reviews\ReviewTags;
use App\models\Reviews\ReviewUserAssigned;
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
    public $assetLocation = __DIR__ . '/../../../../assets';

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

    public function reviewUploadFile(Request $request)
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
            $fileType = end($fileType);

            if(strlen($fileType) == 0)
                $fileType = 'png';

            $fileName = time().rand(100,999).'.'.$fileType;

            $direction .= '/'.$fileName;
            $result = uploadLargeFile($direction, $request->file_data);

            if($result) {
                $limbo = new ReviewPic();
                $limbo->code = $code;
                $limbo->pic = $fileName;
                $limbo->isVideo = $data->isVideo;
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
            if(isset($request->placeId) && $request->placeId != 0 && isset($request->kindPlaceId) && $request->kindPlaceId != 0){
                $kindPlaceId = $request->kindPlaceId;
                $placeId = $request->placeId;

                $kindPlace = Place::find($kindPlaceId);
                $place = DB::table($kindPlace->tableName)->find($placeId);

                $location = $this->assetLocation."/userPhoto/{$kindPlace->fileName}";
                if (!file_exists($location))
                    mkdir($location);

                $location .= '/' . $place->file;
                if (!file_exists($location))
                    mkdir($location);
            }
            else
                $location = $this->assetLocation."/userPhoto/nonePlaces";

            $reviewText = $request->text != null ? $request->text : '';

            $uId = Auth::user()->id;

            $review = new LogModel();
            $review->placeId = $placeId;
            $review->kindPlaceId = $kindPlaceId;
            $review->visitorId = $uId;
            $review->date = Carbon::now()->format('Y-m-d');
            $review->time = getToday()['time'];
            $review->activityId = $activity->id;
            $review->text = $reviewText;
            $review->save();

            $this->storeReviewTags($reviewText, $review->id);
            $this->storeReviewUserTagInText($reviewText, $review->id);

            $reviewPic = ReviewPic::where('code', $request->code)->get();

            if (count($reviewPic) > 0) {
                ReviewPic::where('code', $request->code)->update(['logId' => $review->id, 'code' => null]);
                foreach ($reviewPic as $item) {
                    $file = "{$this->limboLocation}/{$item->pic}";
                    $dest = "{$location}/{$item->pic}";
                    if (file_exists($file))
                        rename($file, $dest);

                    if ($item->isVideo == 1) {
                        if($item->thumbnail != null)
                            $thumbnail = $item->thumbnail;
                        else{
                            $thumbnail = explode('.', $item->pic);
                            $thumbnail[count($thumbnail)-1] = '.png';
                            $thumbnail = implode('', $thumbnail);
                        }

                        $file = "{$this->limboLocation}/{$thumbnail}";
                        $dest = "{$location}/{$thumbnail}";
                        if (file_exists($file))
                            rename($file, $dest);
                    }
                    else{
                        try{
                            $size = [['width' => 800, 'height' => null, 'name' => '', 'destination' => $location]];
                            $image = file_get_contents($dest);
                            resizeUploadedImage($image, $size, $item->pic);
                        }
                        catch (\Exception $exception){
                            continue;
                        }
                    }
                }
            }
            else if ($request->text == null) {
                $review->subject = 'dontShowThisText';
                $review->confirm = 1;
                $review->save();
            }

            $assignedUser = json_decode($request->assignedUser);
            if ($assignedUser != null) {
                foreach ($assignedUser as $item) {
                    $newAssigned = new ReviewUserAssigned();
                    $newAssigned->logId = $review->id;

                    $user = User::where('username', $item)->first();
                    if ($user != null) {
                        $newAssigned->userId = $user->id;
                        $findUser = ReviewUserAssigned::where('logId', $review->id)->where('userId', $user->id)->first();
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
                        $newAns->logId = $review->id;
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
                        $newAns->logId = $review->id;
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
                        $newAns->logId = $review->id;
                        $newAns->questionId = $rateQuestion[$i];
                        $newAns->ans = $rateAns[$i];
                        $newAns->save();
                    }
                }
            }

            $newAlert = new Alert();
            $newAlert->subject = 'addReview';
            $newAlert->referenceTable = 'log';
            $newAlert->referenceId = $review->id;
            $newAlert->userId = $uId;
            $newAlert->seen = 0;
            $newAlert->click = 0;
            $newAlert->save();

            $code = $uId.'_'.generateRandomString(4);

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

            $ques = [];
            $ans = [];
            $isFilter = false;
            $isPicFilter = false;
            $onlyPic = 0;

            $count = isset($request->count) ? $request->count : 0;
            $num = isset($request->num) ? $request->num : 0;

            $uId = \auth()->check() ? \auth()->user()->id : 0;

            $sqlQuery = '(subject != "dontShowThisText" OR subject IS NULL) AND activityId = ' . $activity->id . ' AND placeId = ' . $request->placeId . ' AND kindPlaceId = ' . $request->kindPlaceId . ' AND relatedTo = 0 AND (visitorId = ' . $uId . ' OR confirm = 1) ';

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
                $logs = LogModel::whereRaw($sqlQuery)->orderByDesc('created_at')->get();
            else
                $logs = LogModel::whereRaw($sqlQuery)->orderByDesc('created_at')->skip(($num - 1) * $count)->take($count)->get();

            if (count($logs) == 0)
                echo 'nok1';
            else {
                for($i = 0; $i < count($logs); $i++)
                    $logs[$i] = reviewTrueType($logs[$i]); // in common.php

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

        $revIds = $reviews->pluck('id')->toArray();

        $reviews = reviewTrueTypeIdArray($revIds);
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
        $take = 10;
        $kind = $_GET['kind'];
        $placeId = $_GET['placeId'];
        $reviewIds = $this->getCityReviews($kind, $placeId, $take);

        if(count($reviewIds) != $take){
            $lessReview = [];
            $notIn = [];
            foreach ($reviewIds as $item)
                array_push($notIn, $item->id);

            if($kind == 'city'){
                $place = Cities::find($placeId);
                $less = $take - count($reviewIds);
                $lessReview = $this->getCityReviews('state', $place->stateId, $less, $notIn);
                foreach ($lessReview as $item)
                    array_push($reviewIds, $item);
            }

            $less = $take - count($reviewIds);
            if($less != 0){
                $notIn = [];
                foreach ($reviewIds as $item)
                    array_push($notIn, $item->id);

                $lessReview = $this->getCityReviews('country', 0, $less, $notIn);
                foreach ($lessReview as $item)
                    array_push($reviewIds, $item);
            }
        }

        $reviews = reviewTrueTypeIdArray($reviewIds);

        return response()->json(['status' => 'ok', 'result' => $reviews]);
    }

    public function searchInReviewTags()
    {
        $tag = $_GET['value'];
        $dbTag = \DB::select("SELECT RT.tag AS tag, COUNT(RTR.id) AS tagCount FROM reviewTags RT LEFT JOIN reviewTagRelations RTR on RTR.tagId = RT.id WHERE RT.tag LIKE '%{$tag}%' AND RT.tag <> '{$tag}' GROUP BY RT.tag");
        $feetTag = ReviewTags::where('tag', $tag)->first();
        if($feetTag == null)
            $hasInDB = 0;
        else{
            $hasInDB = 1;
            $count = ReviewTagRelations::where('tagId', $feetTag->id)->count();
            array_unshift($dbTag, ['tag' => $feetTag->tag, 'tagCount' => $count]);
        }

        return response()->json(['status' => 'ok', 'result' => $dbTag, 'hasInDB' => $hasInDB]);
    }

    private function getCityReviews($kind, $id, $take, $notIn = [0]){
        $reviewActivity = Activity::whereName('نظر')->first();
        $lastReview = [];
        $ids = [];
        $sqlQuery = '';

        if($kind == 'city' || $kind == 'state') {
            if ($kind == 'city') {
                $allAmaken = Amaken::where('cityId', $id)->pluck('id')->toArray();
                $allMajara = Majara::where('cityId', $id)->pluck('id')->toArray();
                $allHotels = Hotel::where('cityId', $id)->pluck('id')->toArray();
                $allRestaurant = Restaurant::where('cityId', $id)->pluck('id')->toArray();
                $allMahaliFood = MahaliFood::where('cityId', $id)->pluck('id')->toArray();
                $allSogatSanaie = SogatSanaie::where('cityId', $id)->pluck('id')->toArray();
                $allBoomgardy = Boomgardy::where('cityId', $id)->pluck('id')->toArray();
            } else if ($kind == 'state') {
                $allCities = Cities::where('stateId', $id)->where('isVillage', 0)->pluck('id')->toArray();

                $allAmaken = Amaken::whereIn('cityId', $allCities)->pluck('id')->toArray();
                $allMajara = Majara::whereIn('cityId', $allCities)->pluck('id')->toArray();
                $allHotels = Hotel::whereIn('cityId', $allCities)->pluck('id')->toArray();
                $allRestaurant = Restaurant::whereIn('cityId', $allCities)->pluck('id')->toArray();
                $allMahaliFood = MahaliFood::whereIn('cityId', $allCities)->pluck('id')->toArray();
                $allSogatSanaie = SogatSanaie::whereIn('cityId', $allCities)->pluck('id')->toArray();
                $allBoomgardy = Boomgardy::whereIn('cityId', $allCities)->pluck('id')->toArray();
            }

            if (count($allAmaken) != 0)
                $sqlQuery .= '( kindPlaceId = 1 AND placeId IN (' . implode(",", $allAmaken) . ') )';
            if (count($allRestaurant) != 0) {
                if ($sqlQuery != '')
                    $sqlQuery .= ' OR ';
                $sqlQuery .= '( kindPlaceId = 3 AND placeId IN (' . implode(",", $allRestaurant) . ') )';
            }
            if (count($allHotels) != 0) {
                if ($sqlQuery != '')
                    $sqlQuery .= ' OR ';
                $sqlQuery .= '( kindPlaceId = 4 AND placeId IN (' . implode(",", $allHotels) . ') )';
            }
            if (count($allMajara) != 0) {
                if ($sqlQuery != '')
                    $sqlQuery .= ' OR ';
                $sqlQuery .= '( kindPlaceId = 6 AND placeId IN (' . implode(",", $allMajara) . ') )';
            }
            if (count($allSogatSanaie) != 0) {
                if ($sqlQuery != '')
                    $sqlQuery .= ' OR ';
                $sqlQuery .= '( kindPlaceId = 10 AND placeId IN (' . implode(",", $allSogatSanaie) . ') )';
            }
            if (count($allMahaliFood) != 0) {
                if ($sqlQuery != '')
                    $sqlQuery .= ' OR ';
                $sqlQuery .= '( kindPlaceId = 11 AND placeId IN (' . implode(",", $allMahaliFood) . ') )';
            }
            if (count($allBoomgardy) != 0) {
                if ($sqlQuery != '')
                    $sqlQuery .= ' OR ';
                $sqlQuery .= '( kindPlaceId = 12 AND placeId IN (' . implode(",", $allBoomgardy) . ') )';
            }
        }

        if (count($notIn) == 0)
            $notIn = [0];

        $notIn = implode(',', $notIn);

        if($sqlQuery != '')
            $sqlQuery = '1';

        $lastReview = \DB::select("SELECT id FROM log WHERE {$sqlQuery} AND `subject` != 'dontShowThisText' AND `confirm` = 1 AND `activityId` = {$reviewActivity->id} AND `id` NOT IN ({$notIn}) ORDER BY `created_at` DESC LIMIT {$take}");
        foreach($lastReview as $i)
            array_push($ids, $i->id);

        return $ids;
    }

    private function storeReviewTags($text, $id){
        $tags = [];
        $nowIndex = -1;
        $textLength = strlen($text);

        while(1){
            $nowIndex = strpos($text, '#', $nowIndex+1);
            if($nowIndex === false)
                break;
            else{
                $word = '';
                for($i = $nowIndex+1; $i < $textLength; $i++) {
                    if($text[$i] == ' '){
                        $text = substr_replace($text, "</a>", $i, 0);
                        for($j = $i+3; $j < $textLength; $j++){
                            if($text[$j] == '<' && $text[$j+1] == '/' && $text[$j+2] == 'a' && $text[$j+3] == '>'){
                                $text = substr_replace($text, "", $j, 4);
                                break;
                            }
                        }
                        break;
                    }
                    else if($text[$i] == '<' && $text[$i+1] == '/' && $text[$i+2] == 'a' && $text[$i+3] == '>')
                        break;
                    $word .= $text[$i];
                }
                array_push($tags, $word);
            }
        }

        $tagIds = [];
        foreach($tags as $tag)
            array_push($tagIds, ReviewTags::firstOrCreate(['tag' => $tag])->id);

        $revTagIds = [];
        foreach($tagIds as $item)
            array_push($revTagIds, ReviewTagRelations::firstOrCreate(['reviewId' => $id, 'tagId' => $item])->id);

        ReviewTagRelations::whereNotIn('id', $revTagIds)->delete();
        return true;
    }
    private function storeReviewUserTagInText($text, $id){
        $users = [];
        $nowIndex = -1;
        $textLength = strlen($text);
        $skipLength = strlen('data-username="');

        while(1){
            $nowIndex = strpos($text, 'data-username', $nowIndex+1);
            if($nowIndex === false)
                break;
            else{
                $word = '';
                for($i = $nowIndex+$skipLength; $i < $textLength && $text[$i] != '"'; $i++)
                    $word .= $text[$i];
                array_push($users, $word);
            }
        }

        $usersId = User::whereIn('username', $users)->pluck('id')->toArray();

        foreach($usersId as $item){
            $assignedId = ReviewUserAssigned::create(['userId' => $item, 'logId' => $id]);

            $newAlert = new Alert();
            $newAlert->subject = 'assignedUserToReview';
            $newAlert->referenceTable = 'reviewUserAssigned';
            $newAlert->referenceId = $assignedId->id;
            $newAlert->userId = $item;
            $newAlert->save();
        }

        return true;
    }

    public function deleteReview(Request $request)
    {
        if(\auth()->check()){
            $user = \auth()->user();
            if(isset($request->id)){
                $review = LogModel::find($request->id);
                if($review != null && $review->visitorId == $user->id){

                    $placeId = 0;
                    $kindPlaceTableName = null;
                    if($review->kindPlaceId != 0 && $review->placeId != 0) {
                        $kindPlace = Place::find($review->kindPlaceId);
                        $kindPlaceTableName = $kindPlace->tableName;
                        $placeId = $review->placeId;
                        $place = \DB::table($kindPlaceTableName)->find($review->placeId);
                        $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlace->fileName . '/' . $place->file;
                    }
                    else
                        $location = __DIR__ . '/../../../../assets/userPhoto/nonePlaces';

                    $reviewPics = ReviewPic::where('logId', $review->id)->get();
                    foreach ($reviewPics as $pic){
                        if($pic->isVideo == 1){
                            if($pic->thumbnail != null)
                                $thumbnail = $pic->thumbnail;
                            else{
                                $thumbnail = explode('.', $pic->pic);
                                $thumbnail[count($thumbnail)-1] = '.png';
                                $thumbnail = implode('', $thumbnail);
                            }
                            if(is_file($location.'/'.$thumbnail))
                                unlink($location.'/'.$thumbnail);
                        }


                        if(is_file($location.'/'.$pic->pic))
                            unlink($location.'/'.$pic->pic);
                        $pic->delete();
                    }

                    $userAssigned = ReviewUserAssigned::where('logId', $review->id)->get();
                    foreach ($userAssigned as $item){
                        Alert::where('referenceId', $item->id)->where('referenceTable', 'reviewUserAssigned')->delete();
                        $item->delete();
                    }

                    ReviewTagRelations::where('reviewId', $review->id)->delete();
                    LogFeedBack::where('logId', $review->id)->delete();

                    $anses = LogModel::where('relatedTo', $review->id)->get();
                    foreach ($anses as $item)
                        deleteAnses($item->id);

                    QuestionUserAns::where('logId', $review->id)->delete();
                    Report::where('logId', $review->id)->delete();

                    $alert = new Alert();
                    $alert->userId = $user->id;
                    $alert->subject = 'deleteReviewByUser';
                    $alert->referenceTable = $kindPlaceTableName;
                    $alert->referenceId = $placeId;
                    $alert->save();

                    if($kindPlaceTableName)
                        \DB::table($kindPlaceTableName)->where('id', $place->id)->update(['reviewCount' => $place->reviewCount-1]);

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


    public function getReviewExplore()
    {
        $take = $_GET['take'];
        $page = $_GET['page'];
        $kind = $_GET['kind'];

        $reviewAct = Activity::where('name', 'نظر')->first();

        if($kind == 'all'){
            $reviewIds = LogModel::where('activityId', $reviewAct->id)
                                ->where('confirm', 1)
                                ->where(function($query){
                                    $query->where("subject", '<>', "dontShowThisText")->orWhereNull('subject');
                                })->orderBy('created_at', 'DESC')
                                ->skip(($page-1) * $take)
                                ->take($take)
                                ->pluck('id')
                                ->toArray();
        }
        else if($kind == 'followers'){
            $followers = Followers::where('userId', \auth()->user()->id)->pluck('followedId')->toArray();
            $reviewIds = LogModel::where('activityId', $reviewAct->id)
                                ->where('confirm', 1)
                                ->where(function($query){
                                    $query->where("subject", '<>', "dontShowThisText")->orWhereNull('subject');
                                })->whereIn('visitorId', $followers)
                                ->orderByDesc('created_at')
                                ->skip(($page-1) * $take)
                                ->take($take)
                                ->pluck('id')
                                ->toArray();
        }

        $reviews = reviewTrueTypeIdArray($reviewIds); // in common.php

        return response()->json(['status' => 'ok', 'result' => $reviews]);
    }
}

