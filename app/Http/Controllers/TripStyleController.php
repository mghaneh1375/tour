<?php

namespace App\Http\Controllers;

use App\models\Trip;
use App\models\TripStyle;
use App\models\UserTripStyles;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class TripStyleController extends Controller {

    public function getTripStyles(Request $request) {
        if ($request->uId == 0)
            $uId = Auth::user()->id;
        else
            $uId = makeValidInput($_POST['uId']);

        $trips = TripStyle::all();

        for($i = 0; $i < count($trips); $i++) {
            $condition = ["uId" => $uId, "tripStyleId" => $trips[$i]->id];
            $trips[$i]->selected = false;
            if(UserTripStyles::where($condition)->count() > 0)
                $trips[$i]->selected = true;
        }

        echo json_encode($trips);

    }

    public function updateTripStyles() {
        $user = Auth::user();
        $tripStyles = $_POST["tripStyles"];
        UserTripStyles::where('uId', $user->id)->delete();

        for($i = 0; $i < count($tripStyles); $i++) {
            if($tripStyles[$i] != 0) {
                $userTripStyle = new UserTripStyles();
                $userTripStyle->uId = $user->id;
                $userTripStyle->tripStyleId = $tripStyles[$i];
                $userTripStyle->save();
            }
        }
        $tripStyles = UserTripStyles::join('tripStyle', 'tripStyle.id', 'userTripStyles.tripStyleId')
                                      ->where('uId', $user->id)->get();

        echo json_encode(['status' => 'ok', 'tripStyles' => $tripStyles]);
        return;

    }

}