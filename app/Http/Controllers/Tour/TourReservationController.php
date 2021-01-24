<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\tour\Tour;
use App\models\tour\TourFeature;
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
        $passengerInfo = [];
        $passengerCount = $request->userCount;
        foreach ($passengerCount as $item){

            array_push($passengerInfo, [
                'id' => $item['id'],
                'count' => $item['count']
            ]);

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
        $newReserve->passengerCountInfos = json_encode($passengerInfo);
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
                                ->select(['tour.id', 'tour.name', 'tour.minCost', 'tour.allUserInfoNeed', 'tour.userInfoNeed', 'tour.code AS tourCode', 'tourTimes.code AS timeCode', 'tourTimes.sDate', 'tourTimes.eDate'])
                                ->first();

                $tour->url = route('tour.show', ['code' => $tour->tourCode]);

                $diffInSeconds = Carbon::now()->diffInSeconds($userReservation->created_at);
                $timeRemaining = 1200 - $diffInSeconds;
                if($timeRemaining < 0) {
                    $userReservation->deleteAndReturnCapacity();
//                    return redirect($tour->url);
                }

                $timeRemaining = 900;

                $tour->getInfoNumber = $tour->allUserInfoNeed == 0 ? 1 : $userReservation->inCapacityCount + $userReservation->noneCapacityCount;

                $tour->userInfoNeed = json_decode($tour->userInfoNeed);

                $features = json_decode($userReservation->features);
                $featuresArray = [];
                $featIdIn = [];
                $featureTotalCost = 0;
                foreach ($features as $item){
                    $feat = TourFeature::find($item->id);
                    if($feat != null){
                        $feat->count = $item->count == null ? 0 : $item->count ;
                        $feat->showCost = number_format($feat->cost);
                        $feat->totalCostShow = number_format($feat->cost * $feat->count);
                        $featureTotalCost += ($feat->cost * $item->count);
                        array_push($featuresArray, $feat);
                        array_push($featIdIn, $feat->id);
                    }
                }

                $userReservation->featuers = $featuresArray;
                $userReservation->featuersTotalCost = ['cost' => $featureTotalCost, 'showCost' => number_format($featureTotalCost)];


                $userCountInfos = json_decode($userReservation->passengerCountInfos);
                $passengerInfosArr = [];
                $passengerTotalCost = 0;
                foreach($userCountInfos as $item){
                    $id = null;
                    if($item->id == 0){
                        $passengerTotalCost += ($tour->minCost*$item->count);
                        array_push($passengerInfosArr, (object)[
                            'id' => 0,
                            'count' => $item->count,
                            'cost' => $tour->minCost,
                            'totalCost' => ($tour->minCost*$item->count),
                            'costShow' => number_format($tour->minCost),
                            'totalCostShow' => number_format($tour->minCost*$item->count),
                            'text' => 'بزرگسال',
                        ]);
                    }
                    else {
                        $passInfo = TourPrices::find($item->id);
                        if($passInfo != null){
                            $passengerTotalCost += ($passInfo->cost*$item->count);
                            array_push($passengerInfosArr, (object)[
                                'id' => $passInfo->id,
                                'count' => $item->count,
                                'cost' => $passInfo->cost,
                                'totalCost' => ($passInfo->cost*$item->count),
                                'costShow' => $passInfo->isFree == 1 ? ' رایگان ' : number_format($passInfo->cost),
                                'totalCostShow' => number_format($passInfo->cost*$item->count),
                                'text' => 'از سن '.$passInfo->ageFrom.' تا '.$passInfo->ageTo,
                            ]);
                        }
                    }
                }
                $userReservation->passengerInfos = $passengerInfosArr;
                $userReservation->passengerTotalCost = (object)['cost' => $passengerTotalCost, 'costShow' => number_format($passengerTotalCost)];

                $fullyTotalCost = $passengerTotalCost+$featureTotalCost;
                $userReservation->fullyTotalCost = (object)['cost' => $fullyTotalCost, 'costShow' => number_format($fullyTotalCost)];


                return view('pages.tour.buy.tourBuyPage', compact(['mode', 'timeRemaining', 'userReservation', 'tour']));
            }
        }

        return redirect(route('tour.main'));

    }

    public function cancelReservation(){

        $code = $_GET['code'];
        $reservation = TourUserReservation::where('code', $code)->first();
        if($reservation != null){
            $tourTime = $reservation->deleteAndReturnCapacity();
            $tour = Tour::find($tourTime->tourId);
            $url = route('tour.show', ['code' => $tour->code]).'?timeCode='.$tourTime->code;
            return redirect($url);
        }

        return redirect(route('tour.main'));
    }

    public function submitReservation(Request $request)
    {
        dd($request->all());
    }
}
