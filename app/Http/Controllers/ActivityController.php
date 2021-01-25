<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\places\Amaken;
use App\models\BookMark;
use App\models\BookMarkReference;
use App\models\Cities;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\places\Restaurant;
use App\models\places\SogatSanaie;
use App\models\State;
use App\models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ActivityController extends Controller {
    public function getActivities() {

        $activityId = makeValidInput($_POST["activityId"]);
        $uId = makeValidInput($_POST["uId"]);
        $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);
        $page = makeValidInput($_POST["page"]);
        $rateActivityId = Activity::whereName('امتیاز')->first()->id;
        $reviewActivityId = Activity::whereName('نظر')->first()->id;
        $page = ($page - 1) * 5;


        if($kindPlaceId != -1)
            $condition = ["visitorId" => $uId, "activityId" => $activityId, "kindPlaceId" => $kindPlaceId, 'confirm' => 1];
        else
            $condition = ["visitorId" => $uId, "activityId" => $activityId, 'confirm' => 1];

        $out = LogModel::where($condition)->skip($page)->limit(5)->get();

        if($out == null || count($out) == 0) {
            echo "empty";
        }
        else {

            foreach($out as $itr) {
                if($itr->pic == 0)
                    $itr->pic = "";
                $itr->visitorId = User::whereId($itr->visitorId)->username;

                $kindPlace = Place::find($itr->kindPlaceId);
                $tmp = DB::table($kindPlace->tableName)->find($itr->placeId);
                if(file_exists((__DIR__ . '/../../../../assets/_images/' . $kindPlace->fileName . '/' . $tmp->file . "/f-1.jpg")))
                    $itr->placePic = URL::asset("_images/" . $kindPlace->fileName . "/" . $tmp->file . "/f-1.jpg");
                else
                    $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");

                $itr->placeRedirect = route('show.place.details', ['kindPlaceName' => $kindPlace->fileName, 'slug' => $tmp->slug]);
                if($itr->pic != "")
                    $itr->pic = URL::asset("userPhoto/" . $kindPlace->fileName . "/l-" . $itr->text);

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

            echo json_encode($out);
        }

    }

    function getNumsActivities() {

        $activityId = makeValidInput($_POST["activityId"]);
        $uId = makeValidInput($_POST["uId"]);

        $nums = DB::select("SELECT place.name as placeName, place.id as placeId, COUNT(kindPlaceId) as nums FROM log, place WHERE confirm = 1 and kindPlaceId = place.id and visitorId = " . $uId . " and activityId = " . $activityId . " GROUP BY(kindPlaceId)");

        echo json_encode($nums);
    }

    function getRecentlyActivities() {
        if(Auth::check()) {
            $uId = Auth::user()->id;
            $activities = DB::select("SELECT * FROM log WHERE log.activityId = 1 and log.visitorId = " . $uId . " order by `id` DESC limit 0, 8");
        }
        else{
            $lastWeek = Carbon::now()->subWeek()->format('Y-m-d');
            $activities = DB::select("SELECT kindPlaceId, placeId, COUNT(*) as num FROM log WHERE log.activityId = 1 AND `date` > '" . $lastWeek . "' GROUP BY kindPlaceId, placeId ORDER BY num DESC limit 0, 8");
        }
        $activityId = Activity::whereName('نظر')->first()->id;
        foreach($activities as $itr) {

            if($itr->placeId == -1)
                continue;
            $kindPlace = Place::find($itr->kindPlaceId);
            $tmp = DB::table($kindPlace->tableName)->find($itr->placeId);
            if(file_exists((__DIR__ . '/../../../../assets/_images/' . $kindPlace->fileName . '/' . $tmp->file . "/f-1.jpg")))
                $itr->placePic = URL::asset("_images/" . $kindPlace->fileName . "/" . $tmp->file . "/f-1.jpg");
            else
                $itr->placePic = URL::asset("images/mainPics/noPicSite.jpg");
            $itr->placeRedirect = createUrl($kindPlace->id, $tmp->id, 0, 0);

            $city = Cities::whereId($tmp->cityId);
            $itr->placeCity = $city->name;
            $itr->placeState = State::whereId($city->stateId)->name;
            $itr->placeName = $tmp->name;
            $itr->placeRate = getRate($itr->placeId, $itr->kindPlaceId)[1];

            $itr->placeReviews = DB::select('select count(*) as countNum from log, comment WHERE logId = log.id and status = 1 and placeId = ' . $itr->placeId .
                ' and kindPlaceId = ' . $itr->kindPlaceId . ' and activityId = ' . $activityId)[0]->countNum;

        }

        echo json_encode($activities);
    }
}
