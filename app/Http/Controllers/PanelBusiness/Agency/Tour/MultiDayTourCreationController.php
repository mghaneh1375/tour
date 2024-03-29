<?php

namespace App\Http\Controllers\PanelBusiness\Agency\Tour;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PanelBusiness\Agency\tourCreations;
use App\models\Cities;
use App\models\MainEquipment;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\SubEquipment;
use App\models\tour\Tour;
use App\models\tour\TourDifficult;
use App\models\tour\TourDifficult_Tour;
use App\models\tour\TourDiscount;
use App\models\tour\TourEquipment;
use App\models\tour\TourFeature;
use App\models\tour\TourFitFor;
use App\models\tour\TourFitFor_Tour;
use App\models\tour\TourFocus_Tour;
use App\models\tour\TourKind;
use App\models\tour\TourKind_Tour;
use App\models\tour\TourNotice;
use App\models\tour\TourPic;
use App\models\tour\TourPlaceRelation;
use App\models\tour\TourPrices;
use App\models\tour\TourSchedule;
use App\models\tour\TourScheduleDetail;
use App\models\tour\TourScheduleDetailKind;
use App\models\tour\TourStyle;
use App\models\tour\TourStyle_Tour;
use App\models\tour\TourTimes;
use App\models\tour\Transport_Tour;
use App\models\tour\TransportKind;
use App\models\FormCreator\Asset;

use App\User;
use Illuminate\Http\Request;

class MultiDayTourCreationController extends Controller implements tourCreations
{
    public $defaultViewLocation = 'panelBusiness.pages.Agency';

    public function storeStep_1($request, $business){
        $isNewTour = true;
        if(isset($request->tourId) && $request->tourId != 0){
            $newTour = Tour::find($request->tourId);
            if($newTour != null)
                $isNewTour = false;
        }
        $assets = Asset::all();
        
        foreach($assets as $asset) {
            
            $userAssetss = $asset->user_assets()->where('id', $request->businessId)->get();
            if(count($userAssetss) == 0)
                continue;
            foreach($userAssetss as $userAssets) {
                $businessName = $userAssets->title;
            }
            
        }
        if($isNewTour) {
            $newTour = new Tour();
            $newTour->userId = auth()->user()->_id;
            $newTour->businessId = $business->id;
            $newTour->type = $request->tourType;
            $newTour->businessName = $businessName;


            do
                $code = generateRandomString('10');
            while(Tour::where('code', $code)->first() != null);

            $newTour->code = $code;
            $newTour->isPublished = 0;

            // tour-tourKind-agencyId-randomNumber
            do
                $codeNumber = '1'.'-'.'3'.'-'.$business->id.'-'.rand(10000, 99999);
            while(Tour::where('codeNumber', $code)->first() != null);
            $newTour->codeNumber = $codeNumber;
        }
        else{
            
            if($newTour->userId != auth()->user()->_id)
                return ['status' => 'nokUserAccess'];
        }

        $newTour->name = $request->tourName;
        $newTour->srcId = $request->srcCityId;
        $newTour->destId = $request->destPlaceId;
        $newTour->kindDest = $request->kindDest;
        $newTour->day = $request->tourDay;
        $newTour->night = $request->tourNight;
        $newTour->maxCapacity = $request->maxCapacity;
        $newTour->minCapacity = $request->minCapacity;
        $newTour->anyCapacity = $request->anyCapacity == 'true' ? 1 : 0;
        $newTour->isLocal = $request->sameSrcDestInput == 'true' ? 1 : 0;
        $newTour->userInfoNeed = json_encode($request->userInfoNeed);
        $newTour->allUserInfoNeed = (int)$request->isAllUserInfoNeed;
        $newTour->private = $request->private;
        $newTour->save();


        TourTimes::where('tourId', $newTour->id)->where('registered', 0)->delete();
        foreach($request->dates as $date){
            $sDate = convertDateToString(convertNumber('en', $date['sDate']), '/');
            $eDate = convertDateToString(convertNumber('en', $date['eDate']), '/');

            $check = \DB::select("SELECT * FROM `tourTimes` WHERE `tourId` = {$newTour->id} AND (`sDate` LIKE '{$sDate}' OR `eDate` LIKE '{$eDate}')");
            if(count($check) == 0) {
                $code = rand(10000, 99999);
                while (TourTimes::where('code', $code)->count() > 0)
                    $code = rand(10000, 99999);

                $tourTime = new TourTimes();
                $tourTime->tourId = $newTour->id;
                $tourTime->code = $code;
                $tourTime->sDate = $sDate;
                $tourTime->eDate = $eDate;
                $tourTime->save();
            }
        }
        return ['status' => 'ok', 'result' => $newTour];
    }


    public function showStep_2($tour){
        $tourScheduleKinds = TourScheduleDetailKind::all();
        $transport = TransportKind::all();

        $tour->schedules = TourSchedule::where('tourId', $tour->id)->orderBy('day')->get();
        foreach($tour->schedules as $schedule){
            $schedule->events = TourScheduleDetail::join('tourScheduleDetailKinds', 'tourScheduleDetailKinds.id', 'tourScheduleDetails.detailKindId')
                ->where('tourScheduleDetails.tourScheduleId', $schedule->id)
                ->select(['tourScheduleDetails.*', 'tourScheduleDetailKinds.code'])
                ->orderBy('tourScheduleDetails.sTime')->get();

            foreach($schedule->events as $event){
                $placesArr = [];
                if($event->hasPlace == 1){
                    $eventPlaces = TourPlaceRelation::where('tourScheduleDetailId', $event->id)->get();
                    foreach ($eventPlaces as $item){
                        $kindPlace = Place::find($item->kindPlaceId);
                        $tabNaPl = $kindPlace->tableName;
                        $place = \DB::table($tabNaPl)
                            ->join('cities', 'cities.id', "$tabNaPl.cityId")
                            ->join('state', 'state.id', "cities.stateId")
                            ->where("$tabNaPl.id", $item->placeId)
                            ->select(["$tabNaPl.id", "$tabNaPl.name", "$tabNaPl.cityId", "state.name AS stateName", "cities.name AS cityName"])
                            ->first();

                        if($place != null){
                            $place->pic = getPlacePic($place->id, $kindPlace->id);
                            $place->stateAndCity = ' در شهر '.$place->cityName.' ، استان '.$place->stateName;
                            $place->kindPlaceId = $kindPlace->id;
                            array_push($placesArr, $place);
                        }
                    }
                }

                $event->places = $placesArr;
            }

            $tableName = $schedule->isBoomgardi == 1 ? 'boomgardies' : 'hotels';
            $schedule->hotel = \DB::table($tableName)->select(['id', 'name', 'cityId'])->find($schedule->hotelId);

            if($schedule->hotel != null){
                $cit = Cities::join('state', 'state.id', 'cities.stateId')
                    ->where('cities.id', $schedule->hotel->cityId)
                    ->select(['state.name AS stateName', 'cities.name AS cityName'])->first();
                if($cit != null)
                    $schedule->hotel->cityAndState = 'در شهر '.$cit->cityName.' ، استان '.$cit->stateName;
                else
                    $schedule->hotel->cityAndState = '';

                $schedule->hotel->pic = getPlacePic($schedule->hotel->id, $schedule->isBoomgardi == 1 ? 12 : 4);
            }
        }

        $view = "{$this->defaultViewLocation}.tour.create.createTour_stage_2";

        return view($view, compact(['tour', 'tourScheduleKinds']));
    }
    public function storeStep_2($request, $tour){
        $detail = json_decode($request->planDate);

        TourPlaceRelation::where('tourId', $tour->id)->delete();
        $lastSchedule = TourSchedule::where('tourId', $tour->id)->get();
        foreach ($lastSchedule as $item){
            TourScheduleDetail::where('tourScheduleId', $item->id)->delete();
            $item->delete();
        }

        foreach ($detail as $index => $item){
            $newDay = new TourSchedule();
            $newDay->tourId = $tour->id;
            $newDay->day = $index+1;
            $newDay->hotelId = $item->hotelId;
            $newDay->isBoomgardi = $item->hotelKindPlaceId == 12 ? 1 : 0;
            $newDay->description = $item->description;
            $newDay->save();

            foreach ($item->events as $event){
                $newEvent = new TourScheduleDetail();
                $newEvent->tourScheduleId = $newDay->id;
                $newEvent->detailKindId = TourScheduleDetailKind::where('code', $event->eventCode)->first()->id;
                $newEvent->sTime = $event->sTime;
                $newEvent->eTime = $event->eTime;
                $newEvent->description = $event->description;
                if(!is_array($event->moreData)){
                    $newEvent->title = $event->moreData;
                    $newEvent->hasPlace = 0;
                }
                else
                    $newEvent->hasPlace = 1;

                $newEvent->save();

                if(is_array($event->moreData)){
                    $places = $event->moreData;
                    foreach ($places as $place){
                        $newPlace = new TourPlaceRelation();
                        $newPlace->tourId = $tour->id;
                        $newPlace->tourScheduleDetailId = $newEvent->id;
                        $newPlace->placeId = $place->id;
                        $newPlace->kindPlaceId = $place->kindPlaceId;
                        $newPlace->save();
                    }
                }
            }

        }

        return 'ok';
    }


    public function showStep_3($tour){
        $tourStartCity = Cities::find($tour->srcId);
        if($tourStartCity != null)
            $tour->srcCityLocation = ['lat' => $tourStartCity->x, 'lng' => $tourStartCity->y];

        if($tour->kindDest === 'city'){
            $tourDestination = Cities::find($tour->destId);
            if($tourDestination != null)
                $tour->destCityLocation = ['lat' => $tourDestination->x, 'lng' => $tourDestination->y];
        }
        else{
            $tourDestination = Majara::find($tour->destId);
            if($tourDestination != null)
                $tour->destCityLocation = ['lat' => $tourDestination->C, 'lng' => $tourDestination->D];
        }

        $transport = TransportKind::all();

        $tour->transports = Transport_Tour::where('tourId', $tour->id)->first();
        $tour->hasTransport = $tour->transports == null ? false : true;
        if($tour->hasTransport){
            $tour->transports->sLatLng = json_decode($tour->transports->sLatLng);
            $tour->transports->eLatLng = json_decode($tour->transports->eLatLng);
        }
        $tour->language = json_decode($tour->language);
        $tour->sideTransport = json_decode($tour->sideTransport);
        $tour->meals = json_decode($tour->meals);

        if($tour->tourGuidKoochitaId != 0){
            $tourGuid = User::find($tour->tourGuidKoochitaId);
            if($tourGuid != null)
                $tour->koochitaUserUsername = $tourGuid->username;
        }

        $view = "{$this->defaultViewLocation}.tour.create.createTour_stage_3";
        return view($view, compact(['tour', 'transport']));
    }
    public function storeStep_3($request, $tour){

        $data = json_decode($request->data);

        $transport = Transport_Tour::where('tourId', $tour->id)->first();

        if($data->isTransportTour == 1){
            $tour->isTransport = 1;

            if($transport == null)
                $transport = new Transport_Tour();
            $transport->tourId = $tour->id;
            $transport->sTransportId = $data->sTransportKind;
            $transport->eTransportId = $tour->isLocal == 0 ? $data->eTransportKind : $data->sTransportKind;
            $transport->sTime = $data->sTime;
            $transport->eTime = $data->eTime;
            $transport->sDescription = $data->sDescription;
            $transport->eDescription = $data->eDescription;
            $transport->sAddress = $data->sAddress;
            $transport->eAddress = $data->eAddress;
            $transport->sLatLng = json_encode([$data->sLat, $data->sLng]);
            $transport->eLatLng = json_encode([$data->eLat, $data->eLng]);
            $transport->save();
        }
        else {
            $tour->isTransport = 0;
            if($transport != null)
                $transport->delete();
        }

        $tour->sideTransportCost = null;
        $tour->sideTransport = json_encode($data->sideTransport);

        if($data->isMeal == 1){
            $tour->isMeal = 1;
            $tour->isMealAllDay = $data->isMealsAllDay;
            if($data->isMealsAllDay == 1)
                $tour->meals = json_encode($data->allDayMeals);
            else
                $tour->meals = json_encode($data->sepecificDayMeals);
        }
        else {
            $tour->isMeal = 0;
            $tour->isMealAllDay = 0;
            $tour->isMealCost = 0;
            $tour->mealMoreCost = 0;
            $tour->meals = null;
        }

        if($data->hasTourGuid == 1){
            $tour->isTourGuide = 1;
            $tour->isLocalTourGuide = $data->isLocalTourGuide;
            $tour->isSpecialTourGuid = $data->isSpecialTourGuid;
            $tour->isTourGuidDefined = $data->isTourGuidDefined;

            if($data->isTourGuidDefined == 1){
                $tour->isTourGuideInKoochita = $data->isTourGuidInKoochita;
                if($data->isTourGuidInKoochita == 1){
                    $tour->tourGuidKoochitaId = $data->koochitaUserId;
                    $tour->tourGuidName = null;
                    $tour->tourGuidSex = 1;
                }
                else{
                    $tour->tourGuidName = $data->tourGuidName;
                    $tour->tourGuidSex = $data->tourGuidSex;
                    $tour->tourGuidKoochitaId = 0;
                }
            }
            else {
                $tour->tourGuidKoochitaId = 0;
                $tour->tourGuidName = null;
                $tour->tourGuidSex = 1;
            }
        }
        else{
            $tour->isTourGuide = 0;
            $tour->isLocalTourGuide = 0;
            $tour->isSpecialTourGuid = 0;
            $tour->isTourGuidDefined = 0;
            $tour->isTourGuideInKoochita = 0;
            $tour->tourGuidKoochitaId = 0;
            $tour->tourGuidName = '';
            $tour->tourGuidSex = 0;
        }

        $tour->backupPhone = $data->isBackUpPhone == 1 ? $data->backUpPhone : null;
        $tour->language = json_encode($data->otherLanguage);
        $tour->save();

        return 'ok';
    }


    public function showStep_4($tour){
        $tour->features = $tour->GetFeatures;
        $tour->groupDiscount = TourDiscount::where('tourId', $tour->id)->whereNull('remainingDay')->get();
        foreach ($tour->groupDiscount as $item){
            $item->min = $item->minCount;
            $item->max = $item->maxCount;
        }

        $tour->lastDays = TourDiscount::where('tourId', $tour->id)->whereNotNull('remainingDay')->orderBy('remainingDay')->get();

        $tour->prices = TourPrices::where('tourId', $tour->id)->orderBy('ageFrom')->get();

        $view = "{$this->defaultViewLocation}.tour.create.createTour_stage_4";
        return view($view, compact(['tour']));
    }
    public function storeStep_4($request, $tour){

        $data = json_decode($request->data);
        $tour->minCost = (int)$data->cost;
        $tour->isInsurance = (int)$data->isInsurance;
        $tour->save();

        $counter = 0;
        $prices = TourPrices::where('tourId', $tour->id)->get();
        $tourTimes=TourTimes::where('tourId',  $tour->id)->get();
        foreach($tourTimes as $tourTime){
            $tourTime->cost = $tour->minCost;
            $tourTime->save();
        }
        if(count($prices) > count($data->prices)){
            for(; $counter < count($data->prices); $counter++){
                $pri = $data->prices[$counter];

                $prices[$counter]->ageFrom = $pri->ageFrom;
                $prices[$counter]->ageTo = $pri->ageTo;
                $prices[$counter]->inCapacity = (int)$pri->inCapacity;
                $prices[$counter]->isFree = (int)$pri->isFree;
                $prices[$counter]->cost = (int)$pri->isFree == 1 ? null : $pri->cost;
                $prices[$counter]->save();
            }

            for(; $counter < count($prices); $counter++)
                $prices[$counter]->delete();
        }
        else if(count($prices) <= count($data->prices)){
            for(; $counter < (count($data->prices) - count($prices)); $counter++){
                $pri = $data->prices[$counter];

                $nPrice = new TourPrices();
                $nPrice->tourId = $tour->id;
                $nPrice->ageFrom = $pri->ageFrom;
                $nPrice->ageTo = $pri->ageTo;
                $nPrice->inCapacity = (int)$pri->inCapacity;
                $nPrice->isFree = (int)$pri->isFree;
                $nPrice->cost = (int)$pri->isFree == 1 ? null : $pri->cost;
                $nPrice->save();
            }
            for($i = 0; $i < count($prices); $i++){
                $pri = $data->prices[$counter + $i];

                $prices[$i]->ageFrom = $pri->ageFrom;
                $prices[$i]->ageTo = $pri->ageTo;
                $prices[$i]->inCapacity = (int)$pri->inCapacity;
                $prices[$i]->isFree = (int)$pri->isFree;
                $prices[$i]->cost = (int)$pri->isFree == 1 ? null : $pri->cost;
                $prices[$i]->save();
            }
        }

        TourFeature::where('tourId', $tour->id)->delete();
        foreach ($data->features as $feat){
            $newFeat = new TourFeature();
            $newFeat->tourId = $tour->id;
            $newFeat->name = $feat->name;
            $newFeat->description = $feat->description;
            $newFeat->cost = (int)$feat->cost;
            $newFeat->save();
        }

        TourDiscount::where('tourId', $tour->id)->delete();
        foreach ($data->discounts as $discount){
            $newDiscount = new TourDiscount();
            $newDiscount->tourId = $tour->id;
            $newDiscount->discount = $discount->discount;
            $newDiscount->minCount = $discount->min;
            $newDiscount->maxCount = $discount->max;
            $newDiscount->save();
        }

        foreach($data->lastDays as $dayDiscount){
            $newDiscount = new TourDiscount();
            $newDiscount->tourId = $tour->id;
            $newDiscount->discount = $dayDiscount->discount;
            $newDiscount->remainingDay = $dayDiscount->remainingDay;
            $newDiscount->save();
        }

        return response()->json(['status' => 'ok']);
    }


    public function showStep_5($tour){
        $tour->euipment = (object)['necessary' => [], 'suggest' => []];
        $tour->euipment->necessary = TourEquipment::where('tourId', $tour->id)->where('isNecessary', 1)->pluck('id')->toArray();
        $tour->euipment->suggest = TourEquipment::where('tourId', $tour->id)->where('isNecessary', 0)->pluck('id')->toArray();

        $tour->levels = TourDifficult_Tour::where('tourId', $tour->id)->pluck('difficultId')->toArray();
        $tour->kinds = TourKind_Tour::where('tourId', $tour->id)->pluck('kindId')->toArray();
        $tour->focus = TourFocus_Tour::where('tourId', $tour->id)->pluck('focusId')->toArray();
        $tour->style = TourStyle_Tour::where('tourId', $tour->id)->pluck('styleId')->toArray();
        $tour->fitFor = TourFitFor_Tour::where('tourId', $tour->id)->pluck('fitForId')->toArray();

        $tour->sideDescription = TourNotice::where('tourId', $tour->id)->pluck('text')->toArray();

        $mainEquipment = MainEquipment::all();
        foreach ($mainEquipment as $item)
            $item->side = SubEquipment::where('equipmentId', $item->id)->get();

        $tourKind = TourKind::all();
        $tourDifficult = TourDifficult::all();
        $tourStyle = TourStyle::all();
        $tourFitFor = TourFitFor::all();
//            $tourFocus = TourFocus::all();

        $pics = TourPic::where('tourId', $tour->id)->get();
        foreach($pics as $pic)
            $pic->url = URL::asset("_images/tour/{$tour->id}/{$pic->pic}");
        $tour->pics = $pics;

        $view = "{$this->defaultViewLocation}.tour.create.createTour_stage_5";
        return view($view,  compact(['tour', 'mainEquipment', 'tourKind', 'tourDifficult', 'tourFitFor', 'tourStyle']));
    }
    public function storeStep_5($request, $tour){

        $data = json_decode($request->data);
        $tour->description = $data->mainDescription;
        $tour->textExpectation = $data->textExpectation;
        $tour->specialInformation = $data->specialInformation;
        $tour->opinion = $data->opinion;
        $tour->tourLimit = $data->tourLimit;
        $tour->cancelAble = $data->isCancelAbel == 1;
        $tour->cancelDescription = $data->isCancelAbel == 1 ? $data->cancelDescription : '';
        $tour->save();

        TourNotice::where('tourId', $tour->id)->delete();
        foreach ($data->sideDescription as $item) {
            if($item != '' && $item != null){
                $newNotice = new TourNotice();
                $newNotice->tourId = $tour->id;
                $newNotice->text = $item;
                $newNotice->save();
            }
        }

        TourDifficult_Tour::where('tourId', $tour->id)->delete();
        foreach ($data->levels as $level)
            TourDifficult_Tour::firstOrCreate(['tourId' => $tour->id, 'difficultId' => $level]);

        TourKind_Tour::where('tourId', $tour->id)->delete();
        foreach ($data->kinds as $kind)
            TourKind_Tour::firstOrCreate(['tourId' => $tour->id, 'kindId' => $kind]);

        TourFitFor_Tour::where('tourId', $tour->id)->delete();
        foreach ($data->fitFor as $fitFor)
            TourFitFor_Tour::firstOrCreate(['tourId' => $tour->id, 'fitForId' => $fitFor]);

        //            TourFocus_Tour::where('tourId', $tour->id)->delete();
        //            foreach ($data->focus as $focus)
        //                TourFocus_Tour::firstOrCreate(['tourId' => $tour->id, 'focusId' => $focus]);

        TourStyle_Tour::where('tourId', $tour->id)->delete();
        foreach ($data->style as $style)
            TourStyle_Tour::firstOrCreate(['tourId' => $tour->id, 'styleId' => $style]);


        $equipmentId = [];
        foreach ($data->equipment->necessary as $item){
            $id = TourEquipment::firstOrCreate(['tourId' => $tour->id, 'subEquipmentId' => $item, 'isNecessary' => 1]);
            array_push($equipmentId, $id->id);
        }
        foreach ($data->equipment->suggest as $item){
            $id = TourEquipment::firstOrCreate(['tourId' => $tour->id, 'subEquipmentId' => $item, 'isNecessary' => 0]);
            array_push($equipmentId, $id->id);
        }
        TourEquipment::where('tourId', $tour->id)->whereNotIn('id', $equipmentId)->delete();

        return 'ok';
    }

    public function showStep_1($tour)
    {
        // TODO: Implement showStep_1() method.
    }

    public function deleteTour($tour)
    {
        $response = $tour->fullyDeleted();
        return $response;
    }
}
