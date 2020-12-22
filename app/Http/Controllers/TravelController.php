<?php

namespace App\Http\Controllers;



use App\models\User;
use Illuminate\Support\Facades\View;

class TravelController extends Controller {

    public function showTravel($city, $uId) {

        $user = User::whereId($uId);

        return view('travel', array('city' => $city, 'user' => $user));

    }
}