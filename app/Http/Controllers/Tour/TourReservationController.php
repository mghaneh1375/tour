<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\PassengerInfos;
use App\models\tour\Tour;
use App\models\tour\TourDiscount;
use App\models\tour\TourFeature;
use App\models\tour\TourPrices;
use App\models\tour\TourPurchased;
use App\models\tour\TourPurchasedFeatures;
use App\models\tour\TourPurchasedPassengerInfo;
use App\models\tour\TourTimes;
use App\models\tour\TourUserReservation;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use http\Env\Response;
use Illuminate\Http\Request;

class TourReservationController extends Controller
{
    public function checkReservationCapacity(Request $request){
        $tour = Tour::youCanSee()->where('code', $request->tourCode)->first();
        if($tour == null)
            return response()->json(['status' => 'notFound']);

        $tourTime = TourTimes::youCanSee()->where('code', $request->tourTimeCode)->where('tourId', $tour->id)->first();
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

    public function getPassengerInfo(){
        if(isset($_GET['code'])){
            $userReservation = TourUserReservation::where('code', $_GET['code'])->first();
            if($userReservation != null) {
                $tour = Tour::join('tourTimes', 'tourTimes.tourId', 'tour.id')
                                ->where('tourTimes.id', $userReservation->tourTimeId)
                                ->select(['tour.id', 'tour.name', 'tour.minCost', 'tour.allUserInfoNeed', 'tour.userInfoNeed',
                                          'tour.code AS tourCode', 'tourTimes.code AS timeCode', 'tourTimes.sDate', 'tourTimes.eDate'])
                                ->first();

                $tour->url = route('tour.show', ['code' => $tour->tourCode]);

                $diffInSeconds = Carbon::now()->diffInSeconds($userReservation->created_at);
                $timeRemaining = 1200 - $diffInSeconds;
                if($timeRemaining < 0) {
                    $userReservation->deleteAndReturnCapacity();
                    return redirect($tour->url);
                }

                $tour->getInfoNumber = $tour->allUserInfoNeed == 0 ? 1 : $userReservation->inCapacityCount + $userReservation->noneCapacityCount;

                $tour->userInfoNeed = json_decode($tour->userInfoNeed);

                $features = [];
                $featuresArray = json_decode($userReservation->features);
                if($featuresArray != null) {
                    foreach ($featuresArray as $item) {
                        $feat = TourFeature::find($item->id);
                        if ($feat != null) {
                            $feat->count = $item->count == null ? 0 : $item->count;
                            $feat->showCost = number_format($feat->cost);
                            $feat->totalCostShow = number_format($feat->cost * $item->count);
                            array_push($features, $feat);
                        }
                    }
                }

                $dailyDiscount = TourTimes::find($userReservation->tourTimeId)->getDailyDiscount()['discount'];

                $passengerInfos = [];
                $userCountInfos = json_decode($userReservation->passengerCountInfos);
                foreach($userCountInfos as $item){
                    $id = null;
                    if($item->id == 0){
                        array_push($passengerInfos, (object)[
                            'id' => 0,
                            'inCapacity' => 1,
                            'count' => $item->count,
                            'mainCost' => $tour->minCost,
                            'mainCostShow' => number_format($tour->minCost),
                            'payAbleCost' => $tour->minCost * (100 - $dailyDiscount) / 100,
                            'payAbleCostShow' => number_format($tour->minCost * (100 - $dailyDiscount) / 100),
                            'ageFrom' => null,
                            'ageTo' => null,
                            'text' => 'بزرگسال',
                        ]);
                    }
                    else {
                        $passInfo = TourPrices::find($item->id);
                        if($passInfo != null){
                            array_push($passengerInfos, (object)[
                                'id' => $passInfo->id,
                                'inCapacity' => $passInfo->inCapacity,
                                'count' => $item->count,
                                'mainCost' => $passInfo->cost,
                                'mainCostShow' => $passInfo->isFree == 1 ? ' رایگان ' : number_format($passInfo->cost),
                                'payAbleCost' => $passInfo->cost * (100 - $dailyDiscount) / 100,
                                'payAbleCostShow' => number_format($passInfo->cost * (100 - $dailyDiscount) / 100),
                                'ageFrom' => $passInfo->ageFrom,
                                'ageTo' => $passInfo->ageTo,
                                'text' => 'از سن '.$passInfo->ageFrom.' تا '.$passInfo->ageTo,
                            ]);
                        }
                    }
                }
                $groupDiscount = TourDiscount::where('tourId', $tour->id)->where('minCount', '>=', 0)->select(['discount', 'minCount', 'maxCount'])->get();

                return view('pages.tour.buy.tourBuyPage', compact(['timeRemaining', 'userReservation', 'passengerInfos', 'groupDiscount', 'dailyDiscount', 'features', 'tour']));
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

    public function editPassengerCounts(Request $request)
    {
        $reserveCode = $request->reservationCode;

        $userReservation = TourUserReservation::where('code', $reserveCode)->first();
        if($userReservation == null)
            return response()->json(['status' => 'error1']);

        $tourTime = TourTimes::find($userReservation->tourTimeId);
        if($tourTime == null)
            return response()->json(['status' => 'error2']);

        $inCapacity = 0;
        $noneCapacity = 0;
        $tourPrices = TourPrices::where('tourId', $tourTime->tourId)->get();
        foreach ($request->passengers as $pass){
            if($pass['id'] == 0)
                $inCapacity += $pass['count'];
            else{
                foreach ($tourPrices as $pp){
                    if($pp->id == $pass['id']){
                        if($pp->inCapacity == 1)
                            $inCapacity += $pass['count'];
                        else
                            $noneCapacity += $pass['count'];
                        break;
                    }
                }
            }
        }

        $addedCount = $inCapacity - $userReservation->inCapacityCount;
        if($addedCount > 0){
            $tour = Tour::select(['id', 'anyCapacity', 'maxCapacity'])->find($tourTime->tourId);
            if($tour->anyCapacity != 1 && ($tourTime->registered + $addedCount > $tour->maxCapacity))
                return response()->json(['status' => 'maxCap']);
        }

        $tourTime->registered += $addedCount;
        $tourTime->save();

        $userReservation->inCapacityCount = $inCapacity;
        $userReservation->noneCapacityCount = $noneCapacity;
        $userReservation->passengerCountInfos = json_encode($request->passengers);
        $userReservation->features = json_encode($request->features);
        $userReservation->save();

        return response()->json(['status' => 'ok']);
    }

    public function checkDiscountCode(Request $request){
        $userReservation = TourUserReservation::where('code', $request->userCode)->first();
        if($userReservation == null)
            return \response()->json(['status' => 'error1']);
        $tourTime = TourTimes::find($userReservation->tourTimeId);
        $tourDiscount = TourDiscount::where('tourId', $tourTime->tourId)->where('code', $request->code)->first();
        if($tourDiscount != null)
            return \response()->json(['status' => 'ok', 'result' => $tourDiscount->discount]);
        else
            return \response()->json(['status' => 'wrong']);
    }

    public function checkPassengerAges(Request $request)
    {
        $reservationCode = $request->reservationCode;
        $passengers = $request->passengers;

        $userReservation = TourUserReservation::join('tourTimes', 'tourTimes.id', 'tourUserReservations.tourTimeId')
            ->join('tour', 'tour.id', 'tourTimes.tourId')
            ->where('tourUserReservations.code', $reservationCode)
            ->select(['tourTimes.id AS tourTimeId', 'tourTimes.code AS tourTimeCode',
                'tourTimes.tourId AS tourId', 'tourTimes.sDate AS sDate',
                'tourUserReservations.features', 'tour.minCost'])->first();

        $tourPricesDB = TourPrices::where('tourId', $userReservation->tourId)->get();
        $tourPrices = [[
            'id' => 0,
            'inCapacity' => 1,
            'ageFrom' => 'all',
            'ageTo' => 'all',
            'count' => 0
        ]];
        foreach ($tourPricesDB as $item){
            array_push($tourPrices, [
                'id' => $item->id,
                'inCapacity' => $item->inCapacity,
                'ageFrom' => $item->ageFrom,
                'ageTo' => $item->ageTo,
                'count' => 0
            ]);
        }

        $inCapacityCount = 0;
        $noneCapacityCount = 0;
        foreach ($passengers as $pass){
            $find = 0;
            $stt = explode('/', $pass->birthDay);
            $age = Verta::createJalali($stt[0], $stt[1], $stt[2])->diffYears(\verta());

            for($j = 1; $j < count($tourPrices); $j++){
                if($age <= $tourPrices[$j]['ageTo'] && $age >= $tourPrices[$j]['ageFrom']){
                    $tourPrices[$j]['inCapacity'] == 1 ? $inCapacityCount++ : $noneCapacityCount++;
                    $tourPrices[$j]['count']++;
                    $find = $tourPrices[$j]['id'];
                    break;
                }
            }

            if($find == 0) {
                $tourPrices[0]['count']++;
                $inCapacityCount++;
            }
        }

        dd($tourPrices);
    }

    public function submitReservation(Request $request)
    {
//        dd($request->all());

        $reservationCode = $request->reservationCode;
        $passengers = $request->passengers;

        $sick = [];
        foreach($passengers as $pass){
            if(isset($pass['codeMeli'])){
                $code = convertNumber('en', $pass['codeMeli']);
                $isSick = self::checkCoronaVirus($code);
                if($isSick === 'sick')
                    array_push($sick, $code);
            }
        }

        if(count($sick) != 0)
            return \response()->json(['status' => 'sick', 'result' => $sick]);


        \DB::beginTransaction();

        $userReservation = TourUserReservation::join('tourTimes', 'tourTimes.id', 'tourUserReservations.tourTimeId')
                                                ->join('tour', 'tour.id', 'tourTimes.tourId')
                                                ->where('tourUserReservations.code', $reservationCode)
                                                ->select(['tourTimes.id AS tourTimeId', 'tourTimes.code AS tourTimeCode',
                                                          'tourTimes.tourId AS tourId', 'tourTimes.sDate AS sDate',
                                                          'tourUserReservations.features', 'tour.minCost'])->first();

        try{
            $codeDiscountId = null;
            $koochitaScoreDiscount = null;
            if($request->discountType == 'code')
                $codeDiscountId = TourDiscount::where('tourId', $userReservation->tourId)->where('code', $request->discount)->first();
            else if($request->discountType == 'koochitaScore'){
                // check koochita score
                $koochitaScoreDiscount = $request->discount;
            }

            $trackingCode = generateRandomString(20);
            while(TourPurchased::where('koochitaTrackingCode', $trackingCode)->first() != null)
                $trackingCode = generateRandomString(20);

            $dailyDiscount = TourTimes::find($userReservation->tourTimeId)->getDailyDiscount();

            $tourBuy = new TourPurchased();
            $tourBuy->userId = auth()->user()->_id;
            $tourBuy->koochitaTrackingCode = $trackingCode;
            $tourBuy->phone = $request->phone;
            $tourBuy->email = $request->email;
            $tourBuy->tourTimeId = $userReservation->tourTimeId;
            $tourBuy->description = $request->description;
            $tourBuy->importantInformation = $request->importantInformation;
            $tourBuy->otherOffer = $request->otherOffer;
            $tourBuy->dailyDiscountId = $dailyDiscount['id'];

            $tourBuy->mainInfoId = 0;
            $tourBuy->inCapacityCount = 0;
            $tourBuy->noneCapacityCount = 0;
            $tourBuy->fullyPrice = 0;
            $tourBuy->payable = 0;
            $tourBuy->groupDiscountId = 0;
            $tourBuy->codeDiscountId = $codeDiscountId == null ? 0 : $codeDiscountId->id;
            $tourBuy->koochitaScoreDiscount = $koochitaScoreDiscount;
            $tourBuy->save();

        }
        catch (\Exception $exception){
            \DB::rollback();
            return \response()->json(['status' => 'error1']);
        }

        $totalCost = 0;
        $payAbleTotalCost = 0;
        $inCapacityCount = 0;
        $noneCapacityCount = 0;

        try {
            $tourPricesDB = TourPrices::where('tourId', $userReservation->tourId)->get();
            $tourPrices = [[
                'id' => 0,
                'inCapacity' => 1,
                'ageFrom' => 'all',
                'ageTo' => 'all',
                'cost' => $userReservation->minCost,
                'payable' => $userReservation->minCost * (100 - $dailyDiscount['discount'])/100,
                'count' => 0
            ]];
            foreach ($tourPricesDB as $item){
                array_push($tourPrices, [
                    'id' => $item->id,
                    'inCapacity' => $item->inCapacity,
                    'ageFrom' => $item->ageFrom,
                    'ageTo' => $item->ageTo,
                    'cost' => $item->cost == null ? 0 : $item->cost,
                    'payable' => $item->cost * (100 - $dailyDiscount['discount'])/100,
                    'count' => 0
                ]);
            }

            $mainUserInfoId = 0;
            foreach ($passengers as $pass){
                $saveInfo = 0;
                $newPassenger = null;
                if($pass['saveInformation'] == 1){
                    $saveInfo = 1;
                    $passportNumberForSearch = $pass['passport'];
                    if($passportNumberForSearch == null)
                        $passportNumberForSearch = 0;

                    $findPassLastInfoId = \DB::table('passengerInfos')
                        ->where('userId', auth()->user()->_id)
                        ->whereRaw("meliCode = '{$pass['codeMeli']}' OR (passportNum IS NOT NULL AND passportNum = '{$passportNumberForSearch}')")
                        ->select('id')
                        ->first();
                    if($findPassLastInfoId != null && $findPassLastInfoId->id != 0)
                        $newPassenger = PassengerInfos::find($findPassLastInfoId->id);
                }

                if($newPassenger == null)
                    $newPassenger = new PassengerInfos();

                if($pass['firstNameFa'] != null) $newPassenger->firstNameFa = $pass['firstNameFa'];
                if($pass['lastNameFa'] != null) $newPassenger->lastNameFa = $pass['lastNameFa'];
                if($pass['firstNameEn'] != null) $newPassenger->firstNameEn = $pass['firstNameEn'];
                if($pass['lastNameEn'] != null) $newPassenger->lastNameEn = $pass['lastNameEn'];
                if($pass['birthDay'] != null) $newPassenger->birthDay = convertDateToString(convertNumber('en', $pass['birthDay']), '/');
                if($pass['codeMeli'] != null) $newPassenger->meliCode = $pass['codeMeli'];
                if($pass['sex'] != null) $newPassenger->sex = $pass['sex'];
                if($pass['isForeign'] != null) $newPassenger->iForeign = $pass['isForeign'];
                if($pass['passport'] != null) $newPassenger->passportNum = $pass['passport'];
                if($pass['passportExpire'] != null) $newPassenger->passportExp = convertDateToString(convertNumber('en', $pass['passportExpire']), '/');
                if($pass['countryCodeId'] != null) $newPassenger->countryId = $pass['countryCodeId'];
                if($saveInfo == 1) $newPassenger->userId = auth()->user()->_id;
                $newPassenger->save();

                if($pass['isMain'] == 1 && $mainUserInfoId == 0)
                    $mainUserInfoId = $newPassenger->id;


                $find = 0;
                $stt = explode('/', $newPassenger->birthDay);
                $age = Verta::createJalali($stt[0], $stt[1], $stt[2])->diffYears(\verta());

                for($j = 1; $j < count($tourPrices); $j++){
                    if($age <= $tourPrices[$j]['ageTo'] && $age >= $tourPrices[$j]['ageFrom']){
                        $tourPrices[$j]['inCapacity'] == 1 ? $inCapacityCount++ : $noneCapacityCount++;
                        $tourPrices[$j]['count']++;
                        $find = $tourPrices[$j]['id'];

                        $totalCost += $tourPrices[$j]['cost'];
                        $payAbleTotalCost += $tourPrices[$j]['payable'];
                        break;
                    }
                }

                if($find == 0) {
                    $tourPrices[0]['count']++;
                    $inCapacityCount++;

                    $totalCost += $tourPrices[0]['cost'];
                    $payAbleTotalCost += $tourPrices[0]['payable'];
                }


                $passInTour = new TourPurchasedPassengerInfo();
                $passInTour->tourPurchasedId = $tourBuy->id;
                $passInTour->tourPriceId = $find;
                $passInTour->passengerInfoId = $newPassenger->id;
                $passInTour->save();
            }
        }
        catch (\Exception $exception){
            \DB::rollback();
            return \response()->json(['status' => 'error2']);
        }

        try{
            $groupDiscount = TourDiscount::where('tourId', $userReservation->tourId)
                ->where('minCount', '<=', $inCapacityCount)
                ->where('maxCount', '>=', $inCapacityCount)
                ->first();

            $featCost = 0;
            $featuresDecode = json_decode($userReservation->features);
            if($featuresDecode != null) {
                foreach ($featuresDecode as $item) {
                    if ($item->count > 0) {
                        $tourFeat = TourFeature::find($item->id);
                        if ($tourFeat != null) {
                            $featPurchesed = new TourPurchasedFeatures();
                            $featPurchesed->featureId = $tourFeat->id;
                            $featPurchesed->count = $item->count;
                            $featPurchesed->tourPurchasedId = $tourBuy->id;
                            $featPurchesed->save();

                            $featCost += (int)$tourFeat->cost * $item->count;
                        }
                    }
                }
            }

            $totalCost += $featCost;
            $payAbleTotalCost += $featCost;

            if($codeDiscountId != null)
                $payAbleTotalCost = $payAbleTotalCost * (100 - $codeDiscountId->discount) / 100;
        }
        catch (\Exception $exception){
            \DB::rollback();
            return \response()->json(['status' => 'error3']);
        }

        try {
            $tourBuy->mainInfoId = $mainUserInfoId;
            $tourBuy->fullyPrice = $totalCost;
            $tourBuy->payable = $payAbleTotalCost;
            $tourBuy->inCapacityCount = $inCapacityCount;
            $tourBuy->noneCapacityCount = $noneCapacityCount;
            $tourBuy->dailyDiscountId = $dailyDiscount['id'];
            $tourBuy->groupDiscountId = $groupDiscount == null ? 0 : $groupDiscount->id;
            $tourBuy->save();

            TourUserReservation::where('code', $reservationCode)->first()->deleteAndReturnCapacity();
            $tourTime = TourTimes::find($userReservation->tourTimeId);
            $tourTime->registered += $inCapacityCount;
            $tourTime->save();
        }
        catch (\Exception $exception){
            \DB::rollback();
            return \response()->json(['status' => 'error4']);
        }

        \DB::commit();
        $nextUrl = route('tour.reservation.paymentPage')."?code={$tourBuy->koochitaTrackingCode}";
        return \response()->json(['status' => 'ok', 'result' => $nextUrl]);
    }

    public function goToPaymentPage(){
        dd('انتقال به صفحه ی پرداخت', $_GET);
    }
}
