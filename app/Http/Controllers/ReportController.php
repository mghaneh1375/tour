<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\Alert;
use App\models\places\Amaken;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\places\Majara;
use App\models\Message;
use App\models\PicItem;
use App\models\places\Place;
use App\models\Report;
use App\models\ReportsType;
use App\models\places\Restaurant;
use App\models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class ReportController extends Controller {

    public function getReports($page = 1) {
        $pageTmp = ($page - 1) * 10;
        $logs = LogModel::where('activityId',Activity::whereName('گزارش')->first()->id)->orderBy('date', 'DESC')->skip($pageTmp)->limit(10)->get();

        foreach ($logs as $log) {
            $delete = false;

            $reports = Report::whereLogId($log->id)->get();
            if($reports == null || count($reports) == 0) {
                $delete = true;
            }
            else {

                if(!empty($log->text))
                    $log->text .= ' - ';

                foreach ($reports as $itr) {
                    $text = ReportsType::whereId($itr->reportKind);
                    if($text == null) {
                        $delete = true;
                        break;
                    }
                    $log->text .= $text->description . " - ";
                }
            }

            if(!$delete) {

                $log->visitorId = User::whereId($log->visitorId)->username;

                switch ($log->kindPlaceId) {
                    case 1:
                    default:
                        $place = Amaken::whereId($log->placeId);
                        break;
                    case 3:
                        $place = Restaurant::whereId($log->placeId);
                        break;
                    case 4:
                        $place = Hotel::whereId($log->placeId);
                        break;
                    case 6:
                        $place = Majara::whereId($log->placeId);
                        break;
                    case 8:
                        $place = Adab::whereId($log->placeId);
                        break;
                }

                $log->name = $place->name;
                $log->date = convertDate($log->date);


                $tmp = LogModel::whereId($log->relatedTo);

                if ($tmp == null) {
                    $delete = true;
                } else {

                    $log->writer = User::whereId($tmp->visitorId)->username;
                    $log->publishDate = convertDate($tmp->date);
                    $log->activityName = Activity::whereId($tmp->activityId)->name;

                    if ($log->activityName == "عکس") {
                        switch ($log->kindPlaceId) {
                            case 1:
                            default:
                                $log->userPic = URL::asset('userPhoto/amaken/l-' . $log->text);
                                break;
                            case 3:
                                $log->userPic = URL::asset('userPhoto/restaurant/l-' . $log->text);
                                break;
                            case 4:
                                $log->userPic = URL::asset('userPhoto/hotels/l-' . $log->text);
                                break;
                            case 6:
                                $log->userPic = URL::asset('userPhoto/majara/l-' . $log->text);
                                break;
                            case 8:
                                $log->userPic = URL::asset('userPhoto/adab/l-' . $log->text);
                                break;
                        }

                        if (!file_exists($log->userPic))
                            $delete = true;

                        $log->photoCategory = PicItem::whereId($log->pic)->name;
                    } else {
                        $log->descText = $tmp->text;
                    }

//                    if($log->activityName == "نظر")
//                        $log->redirect = route('showReview', ['logId' => $tmp->id]);

                    $log->kindPlaceId = Place::whereId($log->kindPlaceId)->name;
                }
            }

            if($delete)
                $log->delete();
        }

        return view('reportControl', array('currPage' => $page, 'user' => Auth::user(), 'logs' => $logs, 'total' => LogModel::where('activityId',Activity::whereName('گزارش')->first()->id)->count()));

    }

    public function getReportQuestions(Request $request){
        if(isset($request->kindPlaceId)){
            $reports = ReportsType::where('kindPlaceId', $request->kindPlaceId)->get();
            echo json_encode(['status' => 'ok', 'result' => $reports]);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function getReports1() {

        $kindPlaceId = Place::whereName('پیام')->first()->id;

        echo json_encode(ReportsType::where('kindPlaceId',$kindPlaceId)->get());

    }

    public function getReports2() {

        if(isset($_POST["logId"])) {

            $logId = makeValidInput($_POST["logId"]);
            $log = LogModel::whereId($logId);
            $reports = ReportsType::where('kindPlaceId',$log->kindPlaceId)->get();

            $uId = Auth::user()->id;

            $condition = ['visitorId' => $uId, 'activityId' => Activity::whereName('گزارش')->first()->id,
                'relatedTo' => $logId, 'subject' => ''];
            $log = LogModel::where($condition)->first();

            if($log == null) {
                foreach ($reports as $report) {
                    $report->selected = false;
                }
                $reports[0]->text = "";
            }

            else {
                foreach ($reports as $report) {
                    $condition = ['logId' => $log->id, 'reportKind' => $report->id];
                    if(Report::where($condition)->count() > 0)
                        $report->selected = true;
                    else
                        $report->selected = false;
                }

                if($log->text != "")
                    $reports[0]->text = $log->text;
                else
                    $reports[0]->text = "";
            }

            echo json_encode($reports);

        }

    }

    public function report()
    {

        if (isset($_POST["logId"])) {

            $logId = makeValidInput($_POST["logId"]);

            $logTmp = LogModel::whereId($logId);
            $uId = Auth::user()->id;
            $activityId = Activity::whereName('گزارش')->first()->id;
            $condition = ["visitorId" => $uId, 'relatedTo' => $logId, 'activityId' => $activityId];

            if (LogModel::where($condition)->count() == 0) {

                $log = new LogModel();
                $log->placeId = $logTmp->placeId;
                $log->time = getToday()["time"];
                $log->kindPlaceId = $logTmp->kindPlaceId;
                $log->visitorId = $uId;
                $log->date = date('Y-m-d');
                $log->relatedTo = $logId;
                $log->activityId = $activityId;

                try {
                    $log->save();
                } catch (Exception $x) {
                }
            }
        }
    }

    public function storeReport(Request $request)
    {
        if (isset($_POST["logId"]) && isset($_POST["reports"]) && isset($_POST["customMsg"])) {
            $reportId = $_POST['reports'];
            $logId = $_POST["logId"];
            $msg = $_POST["customMsg"];
            $uId = \auth()->user()->id;

            $report = ReportsType::find($reportId);
            $log = LogModel::find($logId);

            if(($reportId == 'more' || ($reportId != 'more' && $report != null)) && $log != null){
                if($log->visitorId == $uId) {
                    echo 'nok2';
                    return;
                }

                $activity = Activity::where('name', 'گزارش')->first();
                $condition = ['visitorId' => $uId, 'activityId' => $activity->id, 'relatedTo' => $logId];
                $reportLog = LogModel::where($condition)->first();
                if($reportLog == null){
                    $reportLog = new LogModel();
                    $reportLog->placeId = $log->placeId;
                    $reportLog->kindPlaceId = $log->kindPlaceId;
                    $reportLog->visitorId = $uId;
                    $reportLog->activityId = $activity->id;
                    $reportLog->relatedTo = $logId;
                    $reportLog->text = $msg;
                    $reportLog->time = getToday()["time"];
                    $reportLog->date = date('Y-m-d');
                    $reportLog->save();

                    if($reportId != 'more') {
                        $reportTable = new Report();
                        $reportTable->reportsTypeId = $reportId;
                        $reportTable->logId = $reportLog->id;
                        $reportTable->save();
                    }
                }
                else{
                    $reportLog->text = $msg;
                    $reportLog->time = getToday()["time"];
                    $reportLog->date = date('Y-m-d');
                    $reportLog->confirm = 0;
                    $reportLog->save();

                    $reportTable = Report::where('logId', $reportLog->id)->first();
                    if($reportTable == null && $reportId != 'more'){
                        $reportTable = new Report();
                        $reportTable->reportsTypeId = $reportId;
                        $reportTable->logId = $reportLog->id;
                        $reportTable->save();
                    }
                    else{
                        $reportTable->reportsTypeId = $reportId;
                        $reportTable->logId = $reportLog->id;
                        $reportTable->save();
                    }
                }

                $alert = new Alert();
                $alert->userId = $uId;
                $alert->subject = 'addReport';
                $alert->referenceTable = 'log';
                $alert->referenceId = $reportLog->id;
                $alert->save();

                echo 'ok';
            }
            else
                echo 'nok1';
        }
        else
            echo 'nok';

        return;
    }

    public function sendReceiveReport() {

        $uId = Auth::user()->id;

        $selectedReports = $_POST["checkedValuesReports"];

        $msg = "گزارش شما به شرح زیر برای ادمین ارسال گردید";
        $msg .= "<br/>";
        for($i = 0; $i < count($selectedReports); $i++) {
            $selectedReports[$i] = makeValidInput($selectedReports[$i]);
            if($selectedReports[$i] != "-1")
                $msg .= ReportsType::whereId($selectedReports[$i])->description . "<br/>";
            else
                $msg .= makeValidInput($_POST["customMsg"]);

        }

        $message = new Message();

        $admin = User::whereUserName('admin')->first();

        $message->senderId = $admin->id;
        $message->receiverId = $uId;
        $message->message = $msg;
        $message->subject = "تحویل گزارش";
        $message->date = getToday()["date"];

        $message->save();

        echo "ok";

    }

    public function sendReport() {

        $uId = Auth::user()->id;

        $selectedMsgs = $_POST["checkedValuesMsgs"];
        $selectedReports = $_POST["checkedValuesReports"];
        $customMsg = makeValidInput($_POST["customMsg"]);
        $activityId = Activity::whereName('گزارش')->first()->id;
        $kindPlaceId = Place::whereName('پیام')->first()->id;

        foreach ($selectedMsgs as $selectedMsg) {

            $selectedMsg = makeValidInput($selectedMsg);

            $condition = ['visitorId' => $uId, 'relatedTo' => $selectedMsg,
                'activityId' => $activityId, 'subject' => 'msg'];

            $log = LogModel::where($condition)->first();
            if ($log == null) {
                $log = new LogModel();
                $log->visitorId = $uId;
                $log->time = getToday()["time"];
                $log->placeId = LogModel::first()->placeId;
                $log->kindPlaceId = $kindPlaceId;
                $log->relatedTo = $selectedMsg;
                $log->activityId = $activityId;
                $log->date = date('Y-m-d');
                $log->subject = 'msg';
                $log->save();
            }
            else {
                $log->text = "";
                $log->save();

                Report::whereLogId($log->id)->delete();
            }

            $tmpLog = LogModel::whereId($selectedMsg);
            if($tmpLog != null) {
                $tmpLog->date = date('Y-m-d');
                $tmpLog->save();
            }
        }

        for($i = 0; $i < count($selectedReports); $i++) {

            $selectedReports[$i] = makeValidInput($selectedReports[$i]);

            for($j = 0; $j < count($selectedMsgs); $j++) {

                $condition = ['visitorId' => $uId, 'relatedTo' => $selectedMsgs[$j],
                    'activityId' => $activityId, 'subject' => 'msg'];

                $log = LogModel::where($condition)->first();

                if($selectedReports[$i] == -1) {
                    $log->text = $customMsg;
                    $log->save();
                }
                else {
                    $report = new Report();
                    $report->reportKind = $selectedReports[$i];
                    $report->logId = $log->id;
                    $report->save();
                }
            }
        }

        echo "ok";

    }


}
