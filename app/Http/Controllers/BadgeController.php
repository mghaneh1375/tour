<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\LogModel;
use App\models\Medal;
use App\models\places\Place;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class BadgeController extends Controller {

    public function showBadges() {

        $badges = Medal::all();

        $uId = Auth::user()->id;

        foreach ($badges as $badge) {

            if(checkBadge($uId, $badge))
                $badge->status = 1;
            else
                $badge->status = 0;

            $badge->activityId = Activity::whereId($badge->activityId)->actualName;
            if($badge->kindPlaceId != -1)
                $badge->kindPlaceId = Place::whereId($badge->kindPlaceId)->name;
        }

        return view('badge', array('badges' => $badges, 'mode2' => 'owner'));

    }

    public function showOtherBadge($username) {

        $uId = User::whereUserName($username)->first();

        if($uId == null)
            return Redirect::to('profile');

        $badges = Medal::all();
        $uId = $uId->id;

        foreach ($badges as $badge) {

            if(checkBadge($uId, $badge))
                $badge->status = 1;
            else
                $badge->status = 0;

            $badge->activityId = Activity::whereId($badge->activityId)->name;

        }

        $user = User::whereId($uId);

        return view('badgeOther', array('badges' => $badges, 'user' => $user, 'mode2' => 'other'));

    }
}
