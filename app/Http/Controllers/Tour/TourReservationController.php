<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\tour\Tour;
use App\models\tour\TourTimes;
use Illuminate\Http\Request;

class TourReservationController extends Controller
{
    public function firstTimeReservationTour(Request $request){
        dd($request->all());

        $tour = Tour::youCanSee()->where('code', $request->tourCode)->first();
        if($tour == null)
            return response()->json(['status' => 'notFound']);

        $tourTime = TourTimes::where('code', $request->tourTimeCode)->where('tourId', $tour->id)->where('isPublished', 1)->first();
        if($tourTime == null)
            return response()->json(['status' => 'notFoundTime']);

        if($tour->anyCapacity == 0){
            $capacity = $tourTime->registered + (int)$request->adultCount + (int)$request->childCount;
            if($capacity > $tourTime->maxCapacity)
                return response()->json(['status' => 'fullCapacity', 'remaining' => ($tourTime->maxCapacity - $tourTime->registered)]);
        }



    }
}
