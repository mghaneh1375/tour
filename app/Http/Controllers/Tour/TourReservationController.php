<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\tour\Tour;
use App\models\tour\TourPrices;
use App\models\tour\TourTimes;
use App\models\tour\TourUserReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TourReservationController extends Controller
{
    public function checkReservationCapacity(Request $request){
        $tour = Tour::youCanSee()->where('code', $request->tourCode)->first();
        if($tour == null)
            return response()->json(['status' => 'notFound']);

        $tourTime = TourTimes::where('code', $request->tourTimeCode)->where('tourId', $tour->id)->where('isPublished', 1)->first();
        if($tourTime == null)
            return response()->json(['status' => 'notFoundTime']);


        $yourPassengerInCapacity = 0;
        $yourPassengerInNoneCapacity = 0;
        $passengerCount = $request->userCount;
        foreach ($passengerCount as $item){
            if($item['id'] == 0)
                $yourPassengerInCapacity += $item['count'];
            else{
                $pr = TourPrices::where('id', $item['id'])->where('tourId', $tour->id)->first();
                if($pr != null && $pr->inCapacity == 1)
                    $yourPassengerInCapacity += $item['count'];
                else
                    $yourPassengerInNoneCapacity += $item['count'];
            }
        }

        if($tour->anyCapacity == 0){
            $capacity = $tourTime->registered + $yourPassengerInCapacity;
            if($capacity > $tour->maxCapacity)
                return response()->json(['status' => 'fullCapacity', 'remaining' => ($tour->maxCapacity - $tourTime->registered)]);
        }

        $code = generateRandomString(20);
        while(TourUserReservation::where('code', $code)->count() > 0)
            $code = generateRandomString(20);

        $newReserve = new TourUserReservation();
        $newReserve->tourTimeId = $tourTime->id;
        $newReserve->code = $code;
        $newReserve->inCapacityCount = $yourPassengerInCapacity;
        $newReserve->noneCapacityCount = $yourPassengerInNoneCapacity;
        $newReserve->features = json_encode($request->featureCount);
        $newReserve->save();

        $tourTime->registered += $yourPassengerInCapacity;
        $tourTime->save();

        return response()->json(['status' => 'ok', 'result' => $code]);

    }

    public function getPassengerInfo()
    {
        if(isset($_GET['code'])){
            $userReservation = TourUserReservation::where('code', $_GET['code'])->first();
            if($userReservation != null) {
                $tour = Tour::join('tourTimes', 'tourTimes.tourId', 'tour.id')
                    ->where('tourTimes.id', $userReservation->tourTimeId)
                    ->select(['tour.name', 'tour.allUserInfoNeed', 'tour.userInfoNeed', 'tour.code AS tourCode', 'tourTimes.code AS timeCode', 'tourTimes.sDate', 'tourTimes.eDate'])
                    ->first();

                $tour->url = route('tour.show', ['code' => $tour->tourCode]);

                $diffInSeconds = Carbon::now()->diffInSeconds($userReservation->created_at);
                $timeRemaining = 1200 - $diffInSeconds;
                if($timeRemaining < 0) {
                    $tourTimer = TourTimes::find($userReservation->tourTimeId);
                    $tourTimer->registered -= $userReservation->inCapacityCount;
                    $tourTimer->save();
                    $userReservation->delete();

                    return redirect($tour->url);
                }

                $tour->getInfoNumber = $tour->allUserInfoNeed == 0 ? 1 : $userReservation->inCapacityCount + $userReservation->noneCapacityCount;

                $tour->userInfoNeed = json_decode($tour->userInfoNeed);

                return view('pages.tour.buy.tourBuyPage', compact(['mode', 'timeRemaining', 'userReservation', 'tour']));
            }
        }

        return redirect(route('tour.main'));

    }

    public function cancelReservation()
    {
        $code = $_GET['code'];
        $reservation = TourUserReservation::where('code', $code)->first();
        if($reservation != null){
            $tourTime = TourTimes::find($reservation->tourTimeId);
            $tourTime->registered -= $reservation->inCapacityCount;
            $tourTime->save();

            $reservation->delete();

            $tour = Tour::find($tourTime->tourId);
            $url = route('tour.show', ['code' => $tour->code]).'?timeCode='.$tourTime->code;
            return redirect($url);
        }

        return redirect(route('tour.main'));
    }
}
