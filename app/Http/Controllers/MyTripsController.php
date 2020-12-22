<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\Adab;
use App\models\Alert;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\places\Majara;
use App\models\Message;
use App\models\places\Place;
use App\models\places\Restaurant;
use App\models\State;
use App\models\Trip;
use App\models\TripComments;
use App\models\TripMember;
use App\models\TripMembersLevelController;
use App\models\TripPlace;
use App\models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Stmt\Echo_;

class MyTripsController extends Controller {

    public function myTrips() {
        return view('pages.Trip.myTrip');
    }

    public function getTrips()
    {
        if(\auth()->check()){
            $user = Auth::user();
            $uId = $user->id;

            $trips = Trip::whereUId($uId)->get();

            $condition = ['uId' => $uId, 'status' => 1];
            $invitedTrips = TripMember::where($condition)->select('tripId')->get();

            foreach ($invitedTrips as $invitedTrip)
                $trips[count($trips)] = Trip::whereId($invitedTrip->tripId);

            if($trips != null && count($trips) != 0) {
                foreach ($trips as $trip) {
                    $trip->url = route('tripPlaces', ['tripId' => $trip->id]);
                    $trip->placeCount = TripPlace::whereTripId($trip->id)->count();
                    $limit = ($trip->placeCount > 4) ? 4 : $trip->placeCount;
                    $tripPlaces = TripPlace::whereTripId($trip->id)->take($limit)->get();
                    $tripPics = [];
                    foreach ($tripPlaces as $item){
                        $kindPlaceId = $item->kindPlaceId;

                        $kindPlace = Place::find($kindPlaceId);
                        $file = $kindPlace->fileName;
                        $table = $kindPlace->tableName;
                        $place = DB::table($table)->find($item->placeId);
                        if(file_exists((__DIR__ . '/../../../../assets/_images/' . $file . '/' .  $place->file . '/f-' . $place->picNumber)))
                            $pic = URL::asset('_images/' . $file . '/' . $place->file . '/f-' . $place->picNumber);
                        else
                            $pic = URL::asset('_images/nopic/blank.jpg');

                        array_push($tripPics, $pic);
                    }
                    $trip->placePic = $tripPics;

                    $trip->member = TripMember::where('tripId', $trip->id)->where('uId', '!=', $trip->uId)->count() + 1;

                    $trip->from_ = $trip->from_ == null ? '': formatDate($trip->from_);
                    $trip->to_ = $trip->to_ == null ? '': formatDate($trip->to_);

                    $carbon = Carbon::createFromTimestamp($trip->lastSeen);
                    $trip->lastSeen = $carbon->format('H:i').' '.\verta($carbon)->format('Y/m/d');
                }
            }

            return response()->json(['status' => 'ok', 'result' => $trips]);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function myTripsInner($tripId, $sortMode = "DESC") {

        $user = Auth::user();

        $trip = Trip::whereId($tripId);

        $trip->owner = 0;
        $trip->editTrip = 0;
        $trip->editPlace = 0;
        $trip->editMember = 0;

        if($user->id == $trip->uId){
            $trip->editTrip = 1;
            $trip->editPlace = 1;
            $trip->editMember = 1;
            $trip->owner = 1;
            $trip->status = 1;
        }
        else{
            $uInTrip = TripMember::where('tripId', $trip->id)->where('uId', $user->id)->first();
            if($uInTrip != null && $uInTrip->status == 1){
                $trip->editTrip = $uInTrip->editTrip;
                $trip->editPlace = $uInTrip->editPlace;
                $trip->editMember = $uInTrip->editMember;
            }
            else if($uInTrip == null)
                return Redirect::to('myTrips');
            $trip->status = $uInTrip->status;
        }

        if($trip->from_ != "")
            $trip->from_ = formatDate($trip->from_);

        if($trip->to_ != "")
            $trip->to_ = formatDate($trip->to_);

        $tripPlaces = TripPlace::whereTripId($tripId)->orderBy('date', $sortMode)->get();
        foreach ($tripPlaces as $tripPlace) {

            $kindPlace = Place::find($tripPlace->kindPlaceId);

            $tripPlace->placeInfo = createSuggestionPack($kindPlace->id, $tripPlace->placeId);

            $plc = \DB::table($kindPlace->tableName)->find($tripPlace->placeId);

            if(isset($plc->C) && isset($plc->D)) {
                $tripPlace->placeInfo->x = $plc->C;
                $tripPlace->placeInfo->y = $plc->D;
            }

            if($tripPlace->date != "")
                $tripPlace->date = formatDate($tripPlace->date);

            if(isset($plc->address))
                $tripPlace->placeInfo->address = $plc->address;
            else if(isset($plc->dastresi))
                $tripPlace->placeInfo->address = $plc->dastresi;

            $tripPlace->placeInfo->phone = isset($plc->phone) && $plc->phone != null ? $plc->phone : "";
            $tripComments = TripComments::whereTripPlaceId($tripPlace->id)->orderByDesc('id')->get();
            foreach ($tripComments as $tripComment) {
                $uInC = User::find($tripComment->uId);
                $tripComment->username = $uInC->username;
                $tripComment->userPic = getUserPic($uInC->id);
                if($tripComment->date != null)
                    $tripComment->date = formatDate($tripComment->date);
                else
                    $tripComment->date = '';

                if(\auth()->user()->id == $tripComment->uId)
                    $tripComment->yourComments = 1;
                else
                    $tripComment->yourComments = 0;
            }
            $tripPlace->comments = $tripComments;
        }

        $trueMember = [];
        $members = TripMember::where('tripId', $tripId)->get();
        foreach ($members as $item) {
            $member = User::find($item->uId);
            if ($member != null) {
                $item->username = $member->username;
                $item->pic = getUserPic($member->id);
                $item->owner = false;
                array_push($trueMember, $item->toArray());
            } else
                $item->delete();
        }
        $master = User::find($trip->uId);
        $master->pic = getUserPic($master->id);
        $master->owner = true;
        array_push($trueMember, $master->toArray());
        $trip->member = $trueMember;

        return view('pages.Trip.myTripInner', compact(['trip', 'tripPlaces', 'sortMode']));
    }

    public function addTrip() {

        if(isset($_POST["tripName"])) {

            $tripName = makeValidInput($_POST["tripName"]);
            $trip = new Trip();

            if(isset($_POST["dateInputStart"]) && $_POST["dateInputStart"] != ''){
                $dateInputStart = makeValidInput($_POST["dateInputStart"]);
                $dateInputStart = explode('/', $dateInputStart);
                if(count($dateInputStart) == 3)
                    $dateInputStart = $dateInputStart[0] . $dateInputStart[1] . $dateInputStart[2];
                $trip->from_ = $dateInputStart;
            }

            if(isset($_POST["dateInputEnd"]) && $_POST["dateInputEnd"] != ''){
                $dateInputEnd = makeValidInput($_POST["dateInputEnd"]);
                $dateInputEnd = explode('/', $dateInputEnd);
                if(count($dateInputEnd) == 3)
                    $dateInputEnd = $dateInputEnd[0] . $dateInputEnd[1] . $dateInputEnd[2];
                $trip->to_ = $dateInputEnd;
            }

            $trip->name = $tripName;
            $trip->lastSeen = time();
            $trip->uId = Auth::user()->id;
            $trip->save();

            echo "ok";
        }
    }

    public function deleteTrip() {

        if(isset($_POST["tripId"])) {
            $tripId = makeValidInput($_POST["tripId"]);
            Trip::destroy($tripId);

            echo "ok";
        }
    }

    public function addNote() {
        if(isset($_POST["tripId"]) && isset($_POST["note"])) {
            $tripId = makeValidInput($_POST["tripId"]);
            $note = makeValidInput($_POST["note"]);
            $trip = Trip::find($tripId);
            if($trip == null){
                echo 'nok1';
                return;
            }
            else{
                $trip->note = $note;
                $trip->save();
                echo 'ok';
            }
        }
        else
            echo 'nok';

        return;
    }

    public function editUserAccess(Request $request)
    {
        if(isset($request->uId) && isset($request->tripId)){
            $trip = Trip::find($request->tripId);
            $access = TripMember::where('tripId', $request->tripId)
                                  ->where('uId', \auth()->user()->id)
                                  ->where('editMember', 1)->first();

            if($access != null || $trip->uId == \auth()->user()->id){
                $uInT = TripMember::find($request->uId);
                if($uInT != null){
                    $uInT->editMember = isset($request->editMember) && $request->editMember == 'true' ? 1 : 0;
                    $uInT->editTrip = isset($request->editTrip) && $request->editTrip == 'true' ? 1 : 0;
                    $uInT->editPlace = isset($request->editPlace) && $request->editPlace == 'true' ? 1 : 0;

                    $uInT->save();
                    echo json_encode(['status' => 'ok', 'result' => $uInT]);
                }
                else
                    echo json_encode(['status' => 'notInTrip']);
            }
            else
                echo json_encode(['status' => 'cantAccess']);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function inviteFriend(Request $request) {

        if(isset($request->friendId) && isset($request->tripId)) {

            $friendId = makeValidInput($request->friendId);
            $tripId = makeValidInput($request->tripId);

            $uId = Auth::user()->id;
            $friend = User::find($friendId);
            $trip = Trip::find($tripId);

            if($friend == null){
                echo json_encode(['status' => 'notFindFriend']);
                return;
            }

            $checkAccess = TripMember::where('tripId', $tripId)->where('uId', $uId)->where('editMember', 1)->first();
            if($checkAccess != null || $trip->uId == $uId){
                if($friendId == $uId) {
                    echo json_encode(['status' => 'nok1']);
                    return;
                }

                if($trip != null){
                    $checkReg = TripMember::where('tripId', $tripId)->where('uId', $friendId)->first();
                    if($checkReg == null){
                        $newMember = new TripMember();
                        $newMember->uId = $friendId;
                        $newMember->tripId = $tripId;
                        $newMember->status = 0;
                        $newMember->editMember = isset($request->editMember) && $request->editMember == 'true' ? 1 : 0;
                        $newMember->editTrip = isset($request->editTrip) && $request->editTrip == 'true' ? 1 : 0;
                        $newMember->editPlace = isset($request->editPlace) && $request->editPlace == 'true' ? 1 : 0;
                        $newMember->save();

                        $alert = new Alert();
                        $alert->userId = $friendId;
                        $alert->subject = 'inviteToTrip';
                        $alert->referenceTable = 'trip';
                        $alert->referenceId = $trip->id;
                        $alert->save();

                        $msg = 'سلام';
                        $msg .= '<br>';
                        $msg .= 'خوشحال می شم به برنامه سفر ما ملحق بشی و یه تجربه ی جدیدی با هم بسازیم.';
                        $msg .= '<br>';
                        $msg .= 'با استفاده از لینک زیر به سفر ما ملحق شو:';
                        $msg .= '<br>';
                        $msg .= '<a href="' . route("tripPlaces", ['tripId' => $tripId]) . '">' . route("tripPlaces", ['tripId' => $tripId]) . '</a>';

                        $newMsg = new Message();
                        $newMsg->senderId = $uId;
                        $newMsg->receiverId = $friendId;
                        $newMsg->message = $msg;
                        $newMsg->date = verta()->format('Y-m-d');
                        $newMsg->time = verta()->format('H:i');
                        $newMsg->seen = 0;
                        $newMsg->save();

                        $members = TripMember::where('tripId', $tripId)->get();
                        foreach ($members as $item) {
                            $member = User::find($item->uId);
                            if ($member != null) {
                                $item->username = $member->username;
                                $item->pic = getUserPic($member->id);
                            } else
                                $item->delete();
                        }

                        echo json_encode(['status' => 'ok', 'result' => $members]);
                    }
                    else
                        echo json_encode(['status' => 'beforeRegistered']);
                }
                else
                    echo json_encode(['status' => 'nullTrip']);
            }
            else
                echo json_encode(['status' => 'notAccess']);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function inviteResult(Request $request)
    {
        if(isset($request->tripId) && isset($request->kind)){
            $user = Auth::user();
            $trip = Trip::find($request->tripId);
            $uInT = TripMember::where('tripId', $trip->id)->where('uId', $user->id)->first();
            if($trip != null){
                if($uInT != null){
                    if($request->kind == -1)
                        $uInT->delete();
                    else{
                        $uInT->status = 1;
                        $uInT->save();
                    }

                    echo 'ok';
                }
                else
                    echo 'notInTrip';
            }
            else
                echo 'notFindTrip';
        }
        else
            echo 'nok';

        return;
    }

    public function deleteMember() {
        if(isset($_POST["uId"]) && isset($_POST["tripId"])) {

            $uId = makeValidInput($_POST["uId"]);
            $tripId = makeValidInput($_POST["tripId"]);

            $currentUser = Auth::user();
            $trip = Trip::find($tripId);

            if($trip == null) {
                echo "nok";
                return;
            }

            $access = TripMember::where('uId', $currentUser->id)
                                    ->where('tripId', $trip->id)
                                    ->where('editMember', 1)
                                    ->first();

            if($trip->uId == $currentUser->id || $access != null) {
                TripMember::where('tripId', $trip->id)
                            ->where('uId', $uId)->delete();

                $alert = new Alert();
                $alert->userId = $uId;
                $alert->subject = 'deleteFromTrip';
                $alert->referenceTable = 'trip';
                $alert->referenceId = $trip->id;
                $alert->save();

                echo "ok";
            }
            else
                echo 'notAccess';
        }
        else
            echo 'nok';

        return;
    }

    public function printTrips($tripId)
    {
        $trip = Trip::find($tripId);
        $condition = ['tripId' => $tripId, 'status' => 1];
        $trip->members = TripMember::where($condition)->get();
        foreach ($trip->members as $member){
            $member = User::find($member->uId);
        }
        $trip->owner = User::find($trip->uId);

        $tripPlaces = TripPlace::whereTripId($tripId)->orderBy('date', 'DESC')->get();
        foreach ($tripPlaces as $tripPlace) {
            $kindPlaceId = $tripPlace->kindPlaceId;
            $kindPlace = Place::find($kindPlaceId);
            if($kindPlace->tableName != null){

                $target = \DB::table($kindPlace->tableName)->find($tripPlace->placeId);
                $tripPlace->pic = getPlacePic($target->id, $kindPlaceId);
                if(isset($target->C) && isset($target->D)) {
                    $tripPlace->x = $target->C;
                    $tripPlace->y = $target->D;
                }
            }

            $tripPlace->name = $target->name;
            if(isset($target->address))
                $tripPlace->address = $target->address;
            else if(isset($target->dastresi))
                $tripPlace->address = $target->dastresi;

//        $tripPlace->point = getPlacePoint();
            $city = Cities::whereId($target->cityId);
            $tripPlace->city = $city->name;
            $tripPlace->state = State::whereId($city->stateId)->name;

            $tripPlace->comments = TripComments::whereTripPlaceId($tripPlace->id)->get();
            foreach ($tripPlace->comments as $itr) {
                $itr->uId = User::whereId($itr->uId)->username;
            }
        }

        return \view('pages.Trip.tripPDF', compact(['trip', 'tripPlaces']));
    }

    public function addTripPlace(Request $request) {
        if (isset($_POST["tripId"]) && isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {

            $tripId = makeValidInput($_POST["tripId"]);
            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);

            $user = Auth::user();
            $trip = Trip::find($tripId);
            $uInT = TripMember::where('uId', $user->id)
                                ->where('tripId', $tripId)
                                ->where('editPlace', 1)
                                ->first();
            if(!($trip->uId == $user->id || $uInT != null))
                return response()->json(['status' => 'notAccess']);


            $condition = ['tripId' => $tripId, 'placeId' => $placeId, 'kindPlaceId' => $kindPlaceId];

            if (TripPlace::where($condition)->count() == 0) {
                $tripPlace = new TripPlace();
                $tripPlace->tripId = $tripId;
                $tripPlace->placeId = $placeId;
                $tripPlace->kindPlaceId = $kindPlaceId;
                $tripPlace->save();

                $trip = Trip::whereId($tripId);
                $trip->lastSeen = time();
                $trip->save();

                return response()->json(['status' => 'ok']);
            }
            else
                return response()->json(['status' => 'nok']);
        }
    }

    public function assignDateToPlace() {
        if(isset($_POST["tripPlaceId"]) && isset($_POST["date"])) {

            $date = makeValidInput($_POST["date"]);
            $date = explode('/', $date);
            if(count($date) == 3) {
                $date = $date[0] . $date[1] . $date[2];
                $tripPlaceId = makeValidInput($_POST["tripPlaceId"]);
                $tripPlace = TripPlace::whereId($tripPlaceId);
                if($tripPlace != null) {
                    $trip = Trip::whereId($tripPlace->tripId);

                    if ($trip != null) {
                        $user = Auth::user();
                        $uInT = TripMember::where('uId', $user->id)
                                            ->where('tripId', $trip->id)
                                            ->where('editPlace', 1)
                                            ->first();
                        if($trip->uId == $user->id || $uInT != null) {
                            if (($trip->from_ == null || $trip->from_ <= $date) && ($trip->to_ == null || $date <= $trip->to_)) {
                                $tripPlace->date = $date;
                                $tripPlace->save();
                                echo "ok";
                            }
                            else
                                echo "nok3";
                        }
                        else
                            echo 'notAccess';
                    }
                    else
                        echo 'notFindTrip';
                }
            }
        }
        else
            echo 'nok1';

        return;
    }

    public function editTrip() {

        if(isset($_POST["tripName"]) && isset($_POST["tripId"])) {
            $tripName = makeValidInput($_POST["tripName"]);
            $tripId = makeValidInput($_POST["tripId"]);

            $trip = Trip::whereId($tripId);

            $user = Auth::user();
            $uInT = TripMember::where('tripId', $trip->id)
                                ->where('uId', $user->id)
                                ->where('editTrip', 1)
                                ->first();
            if($trip->uId == $user->id || $uInT != null) {
                $trip->name = $tripName;

                if (isset($_POST["dateInputStart"]) && $_POST["dateInputStart"] != '') {
                    $dateInputStart = makeValidInput($_POST["dateInputStart"]);
                    $dateInputStart = explode('/', $dateInputStart);
                    if (count($dateInputStart) == 3)
                        $trip->from_ = $dateInputStart[0] . $dateInputStart[1] . $dateInputStart[2];
                } else
                    $trip->from_ = '';

                if (isset($_POST["dateInputEnd"]) && $_POST["dateInputEnd"] != '') {
                    $dateInputEnd = makeValidInput($_POST["dateInputEnd"]);

                    $dateInputEnd = explode('/', $dateInputEnd);
                    if (count($dateInputEnd) == 3)
                        $trip->to_ = $dateInputEnd[0] . $dateInputEnd[1] . $dateInputEnd[2];
                } else
                    $trip->to_ = '';

                if (isset($_POST["dateInputStart"]) && isset($_POST["dateInputEnd"]) &&
                    $_POST["dateInputStart"] != '' && $_POST["dateInputEnd"] != '' &&
                    $dateInputStart >= $dateInputEnd) {
                    echo "nok3";
                    return;
                }

                $trip->lastSeen = time();
                $trip->save();

                TripPlace::whereTripId($tripId)->update(array('date' => ''));

                echo "ok";
            }
            else
                echo 'notAccess';
        }
        else
            echo 'nok1';

        return;
    }

    public function addComment() {
        if(isset($_POST["tripPlaceId"]) && isset($_POST["comment"])) {

            $uId = Auth::user()->id;
            $tripPlace = TripPlace::find($_POST["tripPlaceId"]);
            if($tripPlace != null){
                $uInT = TripMember::where('tripId', $tripPlace->tripId)
                                    ->where('uId', $uId)->first();
                $trip = Trip::find($tripPlace->tripId);
                if($uInT != null || $trip->uId == $uId){

                    $comments = new TripComments();
                    $comments->description = makeValidInput($_POST["comment"]);
                    $comments->tripPlaceId = makeValidInput($_POST["tripPlaceId"]);
                    $comments->date = Verta::now()->format('Ymd');
                    $comments->uId = $uId;
                    $comments->save();

                    $comments->username = Auth::user()->username;
                    $comments->userPic = getUserPic($uId);
                    $comments->date = formatDate($comments->date);
                    $comments->yourComments = 1;

                    echo json_encode(['status' => "ok", 'result' => $comments]);
                }
                else
                    echo json_encode(['status' => "notInTrip"]);
            }
            else
                echo json_encode(['status' => "notFoundPlace"]);
        }
        else
            echo json_encode(['status' => "nok"]);

        return;
    }

    public function deleteComment(Request $request)
    {
        if(isset($request->id)){
            $tripComment = TripComments::find($request->id);
            if($tripComment->uId == \auth()->user()->id){
                $tripComment->delete();

                echo 'ok';
            }
            else
                echo 'notYourComment';
        }
        else
            echo 'nok';

        return;
    }

    public function deletePlace() {
        if(isset($_POST["tripPlaceId"])) {

            $tripPlaceId = makeValidInput($_POST["tripPlaceId"]);
            $uId = Auth::user()->id;
            $tripPlace = TripPlace::whereId($tripPlaceId);
            $tripId = $tripPlace->tripId;
            $condition = ['tripId' => $tripId, 'uId' => $uId, 'editPlace' => 1];
            if(Trip::whereId($tripId)->uId == $uId || TripMember::where($condition)->count() > 0){
                TripComments::where('tripPlaceId', $tripPlaceId)->delete();
                $tripPlace->delete();
                echo "ok";
            }
        }

    }


    public function placeTrips() {
        if(isset($_POST['placeId']) && isset($_POST["kindPlaceId"])) {
//            $pInT = TripPlace::find($_POST['placeId']);

            $placeIdMain = $_POST['placeId'];
            $kindPlaceIdMain = $_POST["kindPlaceId"];

            $uId = Auth::user()->id;

            $trips = Trip::whereUId($uId)->get();
            $condition = ['uId' => $uId, 'status' => 1];
            $tripIds = TripMember::where($condition)->select('tripId')->get();

            foreach ($tripIds as $tripId)
                $trips[count($trips)] = Trip::whereId($tripId->tripId);

            foreach ($trips as $trip) {
                $condition = ['tripId' => $trip->id, 'placeId' => $placeIdMain, 'kindPlaceId' => $kindPlaceIdMain];
                if (TripPlace::where($condition)->count() > 0)
                    $trip->select = "1";
                else
                    $trip->select = "0";

                $trip->placeCount = TripPlace::whereTripId($trip->id)->count();
                $limit = ($trip->placeCount > 4) ? 4 : $trip->placeCount;
                $tripPlaces = TripPlace::whereTripId($trip->id)->take($limit)->get();

                if($trip->placeCount > 0) {
                    $kindPlaceId = $tripPlaces[0]->kindPlaceId;

                    $kindPlace = Place::find($kindPlaceId);
                    $file = $kindPlace->fileName;
                    $table = $kindPlace->tableName;

                    $place = DB::table($table)->find($tripPlaces[0]->placeId);

                    if(file_exists((__DIR__ . '/../../../../assets/_images/' . $file . '/' .  $place->file . '/f-' . $place->picNumber)))
                        $trip->pic1 = URL::asset('_images/' . $file . '/' . $place->file . '/f-' . $place->picNumber);
                    else
                        $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                }
                if($trip->placeCount > 1) {
                    $kindPlaceId = $tripPlaces[1]->kindPlaceId;

                    $kindPlace = Place::find($kindPlaceId);
                    $file = $kindPlace->fileName;
                    $table = $kindPlace->tableName;
                    $place = DB::table($table)->find($tripPlaces[1]->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/' . $file . '/' .  $place->file . '/f-' . $place->picNumber)))
                        $trip->pic2 = URL::asset('_images/' . $file . '/' . $place->file . '/f-' . $place->picNumber);
                    else
                        $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                }
                if($trip->placeCount > 2) {
                    $kindPlaceId = $tripPlaces[2]->kindPlaceId;

                    $kindPlace = Place::find($kindPlaceId);
                    $file = $kindPlace->fileName;
                    $table = $kindPlace->tableName;
                    $place = DB::table($table)->find($tripPlaces[2]->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/' . $file . '/' .  $place->file . '/f-' . $place->picNumber)))
                        $trip->pic3 = URL::asset('_images/' . $file . '/' . $place->file . '/f-' . $place->picNumber);
                    else
                        $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                }
                if($trip->placeCount > 3) {
                    $kindPlaceId = $tripPlaces[3]->kindPlaceId;
                    $kindPlace = Place::find($kindPlaceId);
                    $file = $kindPlace->fileName;
                    $table = $kindPlace->tableName;
                    $place = DB::table($table)->find($tripPlaces[3]->placeId);
                    if(file_exists((__DIR__ . '/../../../../assets/_images/' . $file . '/' .  $place->file . '/f-' . $place->picNumber)))
                        $trip->pic4 = URL::asset('_images/' . $file . '/' . $place->file . '/f-' . $place->picNumber);
                    else
                        $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                }
            }

            echo json_encode($trips);
        }
    }

    public function assignPlaceToTrip() {

        $errors = [];

        if(isset($_POST["checkedValuesTrips"]) && isset($_POST["placeId"]) && isset($_POST["kindPlaceId"])) {

            $placeId = $_POST["placeId"];
            $kindPlaceId = $_POST["kindPlaceId"];
            $uId = Auth::user()->id;

            $selectedTrips = $_POST["checkedValuesTrips"];

            if($selectedTrips != 'empty') {

                for ($i = 0; $i < count($selectedTrips); $i++) {

                    $selectedTrips[$i] = makeValidInput($selectedTrips[$i]);

                    if(Trip::whereId($selectedTrips[$i])->uId != $uId) {
                        $condition = ["uId" => $uId, 'tripId' => $selectedTrips[$i]];
                        if(TripMembersLevelController::where($condition)->first()->addPlace == 0) {
                            $errors[count($errors)] = Trip::whereId($selectedTrips[$i])->name;
                            continue;
                        }
                    }

                    $condition = ["tripId" => $selectedTrips[$i], "placeId" => $placeId, 'kindPlaceId' => $kindPlaceId];
                    if(TripPlace::where($condition)->count() == 0) {
                        $tripPlaceTmp = new TripPlace();
                        $tripPlaceTmp->tripId = $selectedTrips[$i];
                        $tripPlaceTmp->placeId = $placeId;
                        $tripPlaceTmp->kindPlaceId = $kindPlaceId;
                        $tripPlaceTmp->save();

                        $tripTmp = Trip::whereId($selectedTrips[$i]);
                        $tripTmp->lastSeen = time();
                        $tripTmp->save();
                    }
                }
            }

            $tripPlaces = DB::select('select tripPlace.id, tripPlace.tripId from tripPlace, trip WHERE trip.id = tripPlace.tripId and trip.uId = ' . $uId . ' and  placeId = ' . $placeId . ' and tripPlace.kindPlaceId = ' . $kindPlaceId);

            foreach ($tripPlaces as $tripPlace) {
                $allow = true;
                if($selectedTrips != 'empty') {
                    for ($i = 0; $i < count($selectedTrips); $i++) {
                        if ($tripPlace->tripId == $selectedTrips[$i]) {
                            $allow = false;
                            break;
                        }
                    }
                }
                if($allow) {
                    TripPlace::destroy($tripPlace->id);
                    $tripTmp = Trip::whereId($tripPlace->tripId);
                    $tripTmp->lastSeen = time();
                    $tripTmp->save();
                }
            }
        }

        if(count($errors) == 0)
            echo "ok";
        else
            echo json_encode($errors);
    }

    public function placeInfo() {

        if(isset($_POST["placeId"]) && isset($_POST["kindPlaceId"]) && isset($_POST["tripPlaceId"])) {

            $placeId = makeValidInput($_POST["placeId"]);
            $kindPlaceId = makeValidInput($_POST["kindPlaceId"]);

            $out = [];

            $kindPlace = Place::find($kindPlaceId);
            $target = \DB::table($kindPlace->tableName)->find($placeId);
            $out['name'] = $target->name;
            $out['address'] = $target->address;
            $out['point'] = getRate($placeId, $kindPlaceId)[1];
            $city = Cities::whereId($target->cityId);
            $out['city'] = $city->name;
            $out['state'] = State::whereId($city->stateId)->name;
            $out['pic'] = getPlacePic($target->id, $kindPlace->id);
            $out['phone'] = isset($target->phone) && $target->phone != null ? $target->phone : "";
            $out['url'] = route('show.place.details', ['kindPlaceName' => $kindPlace->fileName, 'slug' => $target->slug]);

            $tripPlaceId = makeValidInput($_POST["tripPlaceId"]);
            if($tripPlaceId != -1) {
                $tripComments = TripComments::whereTripPlaceId($tripPlaceId)->get();
                foreach ($tripComments as $tripComment)
                    $tripComment->uId = User::whereId($tripComment->uId)->username;
                $out["comments"] = $tripComments;
            }
            else {
                $out["comments"] = [];
            }

            $tripPlaceDate = TripPlace::whereId($tripPlaceId);
            if($tripPlaceDate != null) {
                $tripPlaceDate = $tripPlaceDate->date;
                if ($tripPlaceDate == "")
                    $tripPlaceDate = "بدون تاریخ";
                else
                    $tripPlaceDate = convertStringToDate($tripPlaceDate);

                $out['date'] = $tripPlaceDate;
            }

            echo json_encode($out);
        }

    }

    public function getRecentlyViewElems() {

        if(isset($_POST["pageNum"])) {

            $page = (makeValidInput($_POST["pageNum"]) - 1) * 4;

            $user = Auth::user();
            $uId = $user->id;

            $condition = ['visitorId' => $uId, 'activityId' => 1];
            $amakens = LogModel::where($condition)->skip($page)->take(4)->get();

            foreach ($amakens as $amaken) {
                $kindPlaceId = $amaken->kindPlaceId;

                $kindPlace = Place::find($kindPlaceId);
                $target = \DB::table($kindPlace->tableName)->find($amaken->placeId);
                if($target == null){
                    $amaken->delete();
                    break;
                }
                $amaken->name = $target->name;
                if(file_exists((__DIR__ . '/../../../../assets/_images/' . $kindPlace->fileName . '/' . $target->file . '/f-1.jpg')))
                    $amaken->placePic = URL::asset('_images/' . $kindPlace->fileName . '/' . $target->file . '/f-1.jpg');
                else
                    $amaken->placePic = URL::asset('_images/nopic/blank.jpg');

                $amaken->x = $target->C;
                $amaken->y = $target->D;
                $amaken->url = route('show.place.details', ['kindPlaceName' => $kindPlace->fileName, 'slug' => $target->slug]);
            }

            echo \GuzzleHttp\json_encode(['places' => $amakens]);
        }
    }

    public function recentlyViewTotal() {

        $condition = ['visitorId' => Auth::user()->id, 'activityId' => 1];

        return view('recentlyView', array('placesCount' => LogModel::where($condition)->count()));
    }


    public function changeDateTrip() {
        if(isset($_POST["tripId"]) && isset($_POST["dateInputStart"]) && isset($_POST["dateInputEnd"])) {

            $tripId = makeValidInput($_POST["tripId"]);
            $dateInputStart = makeValidInput($_POST["dateInputStart"]);
            $dateInputEnd = makeValidInput($_POST["dateInputEnd"]);

            $trip = Trip::whereId($tripId);

            if($dateInputStart == "" || $dateInputEnd == "") {
                $trip->from_ = "";
                $trip->to_ = "";
                TripPlace::whereTripId($tripId)->update(array('date' => ''));
                $trip->save();
                echo "ok";
            }

            else {

                $dateInputStart = explode('/', $dateInputStart);

                if(count($dateInputStart) == 3) {
                    $dateInputStart = $dateInputStart[0] . $dateInputStart[1] . $dateInputStart[2];
                    $dateInputEnd = explode('/', $dateInputEnd);
                    if(count($dateInputEnd) == 3) {
                        $dateInputEnd = $dateInputEnd[0] . $dateInputEnd[1] . $dateInputEnd[2];

                        if($dateInputStart >= $dateInputEnd) {
                            echo "nok3";
                            return;
                        }

                        $trip->from_ = $dateInputStart;
                        $trip->to_ = $dateInputEnd;
                        $trip->save();
                        TripPlace::where('date', '<', $dateInputStart)->orwhere('date', '>', $dateInputEnd)->update(array('date' => ''));
                        echo "ok";
                    }
                }
            }
        }
    }

    public function tripHistory($tripId) {

        $condition = ['uId' => Auth::user()->id, 'tripId' => $tripId];
        $tripMember = TripMember::where($condition)->first();

        if($tripMember == null)
            return Redirect::to(route('msgsErr', ['err' => 'لینک دعوت از بین رفته است']));

        return $this->myTripsInner($tripId);
    }

    public function acceptTrip($tripId) {

        $uId = Auth::user()->id;

        $condition = ['uId' => $uId, 'tripId' => $tripId];
        $tripMember = TripMember::where($condition)->first();
        if($tripMember != null) {
            if($tripMember->status == 0) {
                $msg = new Message();
                $msg->senderId = $uId;
                $msg->receiverId = Trip::whereId($tripId)->uId;
                $msg->message = User::whereId($uId)->username . " دعوت شما برای سفر  " . Trip::whereId($tripId)->name . " را قبول کرد ";
                $msg->subject = "دعوت برای سفر";
                $msg->date = getToday()["date"];
                $msg->save();

            }
            $tripMember->status = 1;
            $tripMember->save();
            return Redirect::to(route('msgs'));
        }
        return Redirect::to(route('msgsErr', ['err' => 'لینک دعوت از بین رفته است']));
    }

    public function rejectInvitation($tripId) {

        $uId = Auth::user()->id;

        $condition = ['uId' => $uId, 'tripId' => $tripId];
        $tripMember = TripMember::where($condition)->first();
        if($tripMember != null) {

            $msg = new Message();
            $msg->senderId = $uId;
            $msg->receiverId = Trip::whereId($tripId)->uId;
            $msg->message = User::whereId($uId)->username . " دعوت شما برای سفر  " . Trip::whereId($tripId)->name . " را رد کرد ";
            $msg->subject = "دعوت برای سفر";
            $msg->date = getToday()["date"];
            $msg->save();

            $tripMember->delete();
            TripMembersLevelController::where($condition)->delete();
        }
        return Redirect::to(route('msgs'));
    }

    public function getTripMembers() {
        if(isset($_POST["tripId"])) {

            $uId = Auth::user()->id;
            $tripId = makeValidInput($_POST["tripId"]);

            $counter = 0;
            $owner = Trip::whereId($tripId)->uId;

            $out[$counter]["delete"] = 0;
            $out[$counter++]["username"] = User::whereId(Trip::whereId($tripId)->uId)->username;

            $condition = ['tripId' => $tripId, 'status' => 1];
            $users = TripMember::where($condition)->select('uId')->get();

            foreach ($users as $user) {
                if($user->uId == $uId || $owner == $uId) {
                    $out[$counter]["delete"] = 1;
                }
                else
                    $out[$counter]["delete"] = 0;

                $out[$counter++]["username"] = User::whereId($user->uId)->username;
            }

            echo json_encode($out);
        }
    }

    public function getMemberAccessLevel() {

        if(isset($_POST["username"]) && isset($_POST["tripId"])) {

            $uId = User::whereUserName(makeValidInput($_POST["username"]))->first()->id;

            $condition = ['uId' => $uId, 'tripId' => makeValidInput($_POST["tripId"])];

            echo json_encode(TripMembersLevelController::where($condition)->first());

        }

    }

    public function changeAddPlace() {

        if(isset($_POST["username"]) && isset($_POST["tripId"])) {

            $uId = User::whereUserName(makeValidInput($_POST["username"]))->first()->id;

            $condition = ['uId' => $uId, 'tripId' => makeValidInput($_POST["tripId"])];
            $tripLevel = TripMembersLevelController::where($condition)->first();
            if($tripLevel->addPlace == 1)
                $tripLevel->addPlace = 0;
            else
                $tripLevel->addPlace = 1;

            $tripLevel->save();
        }
    }

    public function changePlaceDate() {

        if(isset($_POST["username"]) && isset($_POST["tripId"])) {

            $uId = User::whereUserName(makeValidInput($_POST["username"]))->first()->id;

            $condition = ['uId' => $uId, 'tripId' => makeValidInput($_POST["tripId"])];
            $tripLevel = TripMembersLevelController::where($condition)->first();
            if($tripLevel->changePlaceDate == 1)
                $tripLevel->changePlaceDate = 0;
            else
                $tripLevel->changePlaceDate = 1;

            $tripLevel->save();
        }
    }

    public function changeTripDate() {

        if(isset($_POST["username"]) && isset($_POST["tripId"])) {

            $uId = User::whereUserName(makeValidInput($_POST["username"]))->first()->id;

            $condition = ['uId' => $uId, 'tripId' => makeValidInput($_POST["tripId"])];
            $tripLevel = TripMembersLevelController::where($condition)->first();
            if($tripLevel->changeTripDate == 1)
                $tripLevel->changeTripDate = 0;
            else
                $tripLevel->changeTripDate = 1;

            $tripLevel->save();
        }
    }

}
