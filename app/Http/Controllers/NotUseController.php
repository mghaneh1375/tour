<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\places\Hotel;
use App\models\places\HotelApi;
use App\models\LogModel;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\places\PlaceStyle;
use App\models\QuestionAns;
use App\models\places\Restaurant;
use App\models\SectionPage;
use App\models\State;
use App\models\Survey;
use App\models\Tag;
use App\models\TripMembersLevelController;
use App\models\User;
use Illuminate\Http\Request;

class NotUseController extends Controller
{
    public function showAmakenDetail($placeId, $placeName = "", $mode = "", $err = "") {
        $url = createUrl(1, $placeId, 0, 0, 0);
        return Redirect::to($url);
    }

    public function showHotelDetail($placeId, $placeName = "", $mode = "", $err = "") {
        $url = createUrl(4, $placeId, 0, 0, 0);
        return Redirect::to($url);
    }
    public function showMajaraDetail($placeId, $placeName = "", $mode = "", $err = "") {
        $url = createUrl(6, $placeId, 0, 0, 0);
        return Redirect::to($url);
    }
    public function showSogatSanaieDetails($placeId, $placeName = "", $mode = "", $err = "")
    {
        $url = createUrl(10, $placeId, 0, 0, 0);
        return Redirect::to($url);
    }
    public function showMahaliFoodDetails($placeId, $placeName = "", $mode = "", $err = "")
    {
        $url = createUrl(11, $placeId, 0, 0, 0);
        return Redirect::to($url);
    }
    public function showRestaurantDetail($placeId, $placeName = "", $mode = "", $err = "") {
        $url = createUrl(3, $placeId, 0, 0, 0);
        return Redirect::to($url);
    }

    public function showHotelDetailAllReview($placeId, $placeName = "", $mode = "", $err = "")
    {
        return \redirect(route('placeDetails', ['kindPlaceId' => 4, 'placeId' => $placeId]));
    }

    public function showHotelDetailAllQuestions($placeId, $placeName = "", $mode = "", $err = "")
    {
        return \redirect(route('placeDetails', ['kindPlaceId' => 4, 'placeId' => $placeId]));
    }

    public function changeAddFriend() {
        dd('notUeses');
        if(isset($_POST["username"]) && isset($_POST["tripId"])) {

            $uId = User::whereUserName(makeValidInput($_POST["username"]))->first()->id;

            $condition = ['uId' => $uId, 'tripId' => makeValidInput($_POST["tripId"])];
            $tripLevel = TripMembersLevelController::where($condition)->first();
            if($tripLevel->addFriend == 1)
                $tripLevel->addFriend = 0;
            else
                $tripLevel->addFriend = 1;

            $tripLevel->save();
        }
    }

    public function showHotelList($city, $mode) {
        return redirect(route('main'));
    }

    public function showRestaurantList($city, $mode) {
        return redirect(route(['place.list', ['kindPlaceId' => 3, 'mode' => $mode, 'city' => $city]]));
    }

    public function showMajaraList($city, $mode) {
        return redirect(route(['place.list', ['kindPlaceId' => 6, 'mode' => $mode, 'city' => $city]]));
    }

    public function showAmakenList($city, $mode) {
        return redirect(route(['place.list', ['kindPlaceId' => 1, 'mode' => $mode, 'city' => $city]]));
    }

    public function userQuestions()
    {
        return view('userActivities.userQuestions');
    }

    public function userPosts()
    {
        return view('userActivities.userPosts');
    }

    public function userPhotosAndVideos()
    {
        return view('userActivities.userPhotosAndVideos');
    }

    public function gardeshnameEdit()
    {
        return view('gardeshnameEdit');
    }

    public function myTripInner()
    {
        return view('myTripInner');
    }

    public function business()
    {
        return view('business');
    }

    public function userActivitiesProfile()
    {
        return view('profile.userActivitiesProfile');
    }

    public function removeReview() {

        if(isset($_POST["logId"])) {

            $logId = makeValidInput($_POST["logId"]);
            $log = LogModel::whereId($logId);

            if($log != null && (Auth::user()->level == 1 || Auth::user()->id == $log->visitorId)) {

                LogModel::whereRelatedTo($logId)->delete();
                LogModel::destroy($logId);

                echo "ok";
            }

        }

    }

}
