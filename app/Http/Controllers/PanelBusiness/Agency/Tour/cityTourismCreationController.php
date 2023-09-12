<?php

namespace App\Http\Controllers\PanelBusiness\Agency\Tour;

use App\Helpers\DefaultDataDB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PanelBusiness\Agency\tourCreations;
use App\models\Cities;
use App\models\MainEquipment;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\State;
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
use App\models\tour\TourGuid;
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
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\Transport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Finder\Iterator\FileTypeFilterIterator;

class cityTourismCreationController extends Controller implements tourCreations
{
    public $defaultViewLocation = 'panelBusiness.pages.Agency';

    public $tourKindInfo = ['cityTourism' => ['code' => 1]];

    public function showStep_1($tour){
        $tour->src = Cities::find($tour->srcId);
        $tour->userInfoNeed = json_decode($tour->userInfoNeed);
        $times = TourTimes::where('tourId', $tour->id)->orderBy('sDate')->get();
        foreach ($times as $time){
            $time->canEdit = true;

            if($time->registered > 0)
                $time->canEdit = false;

            $time->groupDiscount = TourDiscount::where('tourTimeId', $time->id)->get();
        }

        $tour->times = $times;
        return $tour;
    }
    public function storeStep_1($request, $business){
        $errors = [];
        $tour = null;

        if(isset($request->tourId) && $request->tourId != 0){
            $tour = Tour::find($request->tourId);

            if($tour != null && $tour->userId != auth()->user()->_id)
                return response()->json(['status' => 'nokUserAccess']);
        }

        if($tour == null) {
            do
                $code = generateRandomString('10');
            while(Tour::where('code', $code)->first() != null);

            do
                // tour-tourKind-agencyId-randomNumber
                $codeNumber = "1-{$this->tourKindInfo['cityTourism']['code']}-{$business->id}-".rand(10000, 99999);
            while(Tour::where('codeNumber', $code)->first() != null);

            $tour = new Tour();
            $tour->userId = auth()->user()->_id;
            $tour->businessId = $business->id;
            $tour->type = 'cityTourism';
            $tour->code = $code;
            $tour->codeNumber = $codeNumber;
            $tour->isPublished = 1;
            $tour->remainingStage = json_encode(['2', '3', '4']);
        }

        $cancelDescription = makeValidInput($request->cancelDescription);

        $tourName = makeValidInput($request->tourName);
        if(empty($tourName))
            array_push($errors, ['status' => 3,'text' => 'tour name is empty']);

        $city = Cities::find($request->srcCityId);
        if($city == null)
            array_push($errors, ['status' => 4,'text' => 'city not found']);

        if($tour->cancelAble == 1 && empty($cancelDescription))
            array_push($errors, ['status' => 5,'text' => 'cancel description is empty']);

        $tour->name = $tourName;
        $tour->srcId = $city->id;
        $tour->allUserInfoNeed = 1;
        $tour->userInfoNeed = json_encode($request->userInfoNeed);
        $tour->private = (int)$request->private;
        $tour->cancelAble = (int)$request->cancelAble;
        $tour->cancelDescription = $cancelDescription;
        $tour->save();

        foreach($request->dates as $index => $item){
            $item = (object)$item;

            if(isset($item->delete) && $item->delete == 1){
                if($item->id != 0){
                    $tourTimeDelete = TourTimes::find($item->id);
                    if($tourTimeDelete == null || $tourTimeDelete->tourId != $tour->id)
                        array_push($errors, ['status' => 6, 'text' => 'cant delete this date', 'result' => ['date' => $item->date]]);
                    else{
                        if($tourTimeDelete->registered == 0){
                            TourDiscount::where('tourTimeId', $tourTimeDelete->id)->delete();
                            $tourTimeDelete->delete();
                        }
                        else
                            array_push($errors, ['status' => 6, 'text' => 'cant delete this date', 'result' => ['date' => $item->date]]);
                    }
                }

                continue;
            }

            if($item->id == 0){
                do
                    $code = generateRandomString(6);
                while (TourTimes::where('code', $code)->count() > 0);

                $date = convertDateToString(convertNumber('en', $item->date), '/');

                $checkDate = TourTimes::where('tourId', $tour->id)->where('sDate', $date)->first();
                if($checkDate === null) {
                    $tourTime = new TourTimes();
                    $tourTime->tourId = $tour->id;
                    $tourTime->code = $code;
                    $tourTime->sDate = $date;
                    $tourTime->canRegister = 1;
                    $tourTime->isPublished = 1;
                    $tourTime->registered = 0;
                }
                else{
                    array_push($errors, ['status' => 0,'text' => "duplicate date", 'result' => ['date' => $date]]);
                    continue;
                }
            }
            else{
                $tourTime = TourTimes::find($item->id);
                if($tourTime == null || $tourTime->tourId != $tour->id){
                    array_push($errors, ['status' => 1, 'text' => "wrong date info", 'result' => ['date' => $item->date]]);
                    continue;
                }
            }

            $tourTime->cost = $item->cost;
            $tourTime->isInsurance = (int)$item->isInsurance;
            $tourTime->minCapacity = (int)$item->minCapacity;
            $tourTime->maxCapacity = (int)$item->maxCapacity;
            $tourTime->save();

            if(isset($item->groupDiscount)) {
                $groupDiscount = $item->groupDiscount;
                foreach ($groupDiscount as $disIndex => $gd) {
                    $gd = (object)$gd;

                    if($gd->id == 0){
                        $newGroupDiscount = new TourDiscount();
                        $newGroupDiscount->tourId = $tour->id;
                        $newGroupDiscount->tourTimeId = $tourTime->id;
                        $newGroupDiscount->discount = $gd->discount;
                        $newGroupDiscount->minCount = $gd->minCount;
                        $newGroupDiscount->maxCount = $gd->maxCount;
                        $newGroupDiscount->remainingDay = null;
                        $newGroupDiscount->code = null;
                    }
                    else{
                        $newGroupDiscount = TourDiscount::find($gd->id);
                        if($newGroupDiscount == null || $newGroupDiscount->tourId != $tour->id || $newGroupDiscount->tourTimeId != $tourTime->id){
                            array_push($errors, ['status' => 2, 'text' => "wrong discount info", 'result' => ['discountId' => $gd->id, 'tourTimeId' => $tourTime->id]]);
                            continue;
                        }
                    }

                    $newGroupDiscount->status = $gd->status;
                    $newGroupDiscount->save();
                }
            }
        }

        if(count($errors) != 0)
            return ['status' => 'error', 'errors' => $errors];
        else
            return ['status' => 'ok', 'result' => $tour];
    }

    public function showStep_2($tour){
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

        $transport = TransportKind::all();
        $view = "{$this->defaultViewLocation}.tour.create.cityTourism.createTour_cityTourism_stage_2";
        return view($view, compact(['tour', 'transport']));
    }
    public function storeStep_2($request, $tour){

        $request = (object)$request->data;
        $transport = Transport_Tour::where('tourId', $tour->id)->first();
        if($transport == null)
            $transport = new Transport_Tour();

        $transport->tourId = $tour->id;
        $transport->sTransportId = $request->sTransportKind;
        $transport->eTransportId = $request->sTransportKind;
        $transport->sTime = $request->sTime;
        $transport->eTime = $request->eTime;
        $transport->sDescription = $request->sDescription;
        $transport->eDescription = $request->eDescription;
        $transport->sAddress = $request->sAddress;
        $transport->eAddress = $request->eAddress;
        $transport->sLatLng = json_encode([$request->sLat, $request->sLng]);
        $transport->eLatLng = json_encode([$request->eLat, $request->eLng]);
        $transport->save();

        $tour->isTransport = 1;
        $tour->sideTransportCost = null;
        $tour->sideTransport = null;

        $tour->isMeal = 0;
        $tour->isMealAllDay = 0;
        $tour->isMealCost = 0;
        $tour->mealMoreCost = 0;
        $tour->meals = null;

        if($request->hasTourGuid == 1){
            $tour->isTourGuide = 1;
            $tour->isLocalTourGuide = $request->isLocalTourGuide;
            $tour->isSpecialTourGuid = $request->isSpecialTourGuid;
            $tour->isTourGuidDefined = $request->isTourGuidDefined;

            if($request->isTourGuidDefined == 1){
                $tour->isTourGuideInKoochita = $request->isTourGuidInKoochita;
                if($request->isTourGuidInKoochita == 1){
                    $tour->tourGuidKoochitaId = $request->koochitaUserId;
                    $tour->tourGuidName = null;
                    $tour->tourGuidPhone = null;
                    $tour->tourGuidSex = 1;
                }
                else{
                    $tour->tourGuidName = $request->tourGuidName;
                    $tour->tourGuidSex = $request->tourGuidSex;
                    $tour->tourGuidPhone = $request->tourGuidPhone;
                    $tour->tourGuidKoochitaId = 0;
                }
            }
            else {
                $tour->tourGuidKoochitaId = 0;
                $tour->tourGuidName = null;
                $tour->tourGuidPhone = null;
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
            $tour->tourGuidName = null;
            $tour->tourGuidPhone = null;
            $tour->tourGuidSex = 0;
        }

        $tour->backupPhone = $request->backUpPhone;
        if(isset($request->otherLanguage))
            $tour->language = json_encode($request->otherLanguage);
        else
            $tour->language = null;
        $tour->save();

        return 'ok';
    }

    public function showStep_3($tour){
        $transport = DB::table('transportTours AS TT')
                        ->join('transportKind AS TK', 'TK.id', 'TT.sTransportId')
                        ->where('TT.tourId', $tour->id)
                        ->first();

        $events = TourScheduleDetail::join('tourSchedules', 'tourSchedules.id', 'tourScheduleDetails.tourScheduleId')
                                    ->where('tourSchedules.tourId', $tour->id)
                                    ->select(['tourScheduleDetails.*'])
                                    ->orderBy('tourScheduleDetails.sortNumber')
                                    ->get();

        $allKindPlaces = DefaultDataDB::getPlaceDB();
        foreach($events as $event){

            $event->place = null;
            $event->picture = getPlacePic(0, 0, 'f');
            $event->url = null;

            if($event->placeId != null && $event->kindPlaceId != null){
                if(isset($allKindPlaces[$event->kindPlaceId])){
                    $kindPlace = $allKindPlaces[$event->kindPlaceId];
                    $place = DB::table($kindPlace->tableName)->find($event->placeId);
                    $event->picture = getPlacePic($place->id, $kindPlace->id, 'f');
                    $event->place = ['rate' => (int)$place->fullRate, 'reviewCount' => $place->reviewCount, 'name' => $place->name, 'id' => $place->id];
                    $event->url = createUrl($kindPlace->id, $place->id, 0, 0, 0);
                }
            }

            if($event->sTime == null)
                $event->sTime = '';

            if($event->eTime == null)
                $event->eTime = '';

            if($event->title == null)
                $event->title = '';

            if($event->description == null)
                $event->description = '';

            if($event->lat == null)
                $event->lat = 0;

            if($event->lng == null)
                $event->lng = 0;
        }

        $tour->start = [
            'actualName' => $transport->actualName,
            'icon' => $transport->icon,
            'location' => $transport->sLatLng,
            'time' => $transport->sTime,
            'title' => 'شروع حرکت',
            'description' => $transport->sDescription,
        ];

        $tour->end = [
            'actualName' => $transport->actualName,
            'icon' => $transport->icon,
            'location' => $transport->eLatLng,
            'time' => $transport->eTime,
            'title' => 'پایان حرکت',
            'description' => $transport->eDescription,
        ];

        $view = "{$this->defaultViewLocation}.tour.create.cityTourism.createTour_cityTourism_stage_3";

        return view($view, compact(['tour', 'events']));
    }
    public function storeStep_3($request, $tour){
        $events = $request->events;

        $tourSC = TourSchedule::where('tourId', $tour->id)->first();
        if($tourSC == null){
            $tourSC = new TourSchedule();
            $tourSC->tourId = $tour->id;
            $tourSC->day = 1;
            $tourSC->hotelId = 0;
            $tourSC->isBoomgardi = 0;
            $tourSC->description = null;
            $tourSC->save();
        }

        TourScheduleDetail::where('tourScheduleId', $tourSC->id)->delete();
        foreach ($events as $index => $event) {
            $event = (object)$event;

            $nEvent = new TourScheduleDetail();
            $nEvent->tourScheduleId = $tourSC->id;
            $nEvent->type = $event->type;
            $nEvent->title = $event->title;
            $nEvent->sTime = $event->sTime;
            $nEvent->eTime = $event->eTime;
            $nEvent->description = $event->description;
            $nEvent->lat = $event->lat != 0 ? $event->lat : null;
            $nEvent->lng = $event->lng != 0 ? $event->lng : null;
            $nEvent->placeId = $event->placeId != 0 ? $event->placeId : null;
            $nEvent->kindPlaceId = $event->kindPlaceId != 0 ? $event->kindPlaceId : null;
            $nEvent->hasPlace = $event->placeId != 0 ? 1 : 0;
            $nEvent->sortNumber = $index+1;
            $nEvent->save();
        }


        return "ok";
    }

    public function showStep_4($tour){
        $tour->euipment = (object)['necessary' => [], 'suggest' => []];
        $tour->euipment->necessary = TourEquipment::where('tourId', $tour->id)->where('isNecessary', 1)->pluck('id')->toArray();
        $tour->euipment->suggest = TourEquipment::where('tourId', $tour->id)->where('isNecessary', 0)->pluck('id')->toArray();

        $tour->levels = TourDifficult_Tour::where('tourId', $tour->id)->pluck('difficultId')->toArray();
        $tour->kinds = TourKind_Tour::where('tourId', $tour->id)->pluck('kindId')->toArray();
        $tour->style = TourStyle_Tour::where('tourId', $tour->id)->pluck('styleId')->toArray();
        $tour->fitFor = TourFitFor_Tour::where('tourId', $tour->id)->pluck('fitForId')->toArray();

        $pics = TourPic::where('tourId', $tour->id)->get();
        foreach($pics as $pic)
            $pic->url = URL::asset("_images/tour/{$tour->id}/{$pic->pic}");
        $tour->pics = $pics;

        $tourKind = TourKind::all();
        $tourDifficult = TourDifficult::all();
        $tourStyle = TourStyle::all();
        $tourFitFor = TourFitFor::all();
        $mainEquipment = MainEquipment::all();
        foreach ($mainEquipment as $item)
            $item->side = SubEquipment::where('equipmentId', $item->id)->get();

        $view = "{$this->defaultViewLocation}.tour.create.cityTourism.createTour_cityTourism_stage_4";
        return view($view, compact(['tour', 'mainEquipment', 'tourKind', 'tourDifficult', 'tourFitFor', 'tourStyle']));
    }
    public function storeStep_4($request, $tour){

        try {
            $data = (object)$request->data;

            $existTourDifficult = [];
            if(isset($data->levels)) {
                foreach ($data->levels as $level) {
                    $diff = TourDifficult_Tour::firstOrCreate(['tourId' => $tour->id, 'difficultId' => $level]);
                    array_push($existTourDifficult, $diff->id);
                }
            }
            TourDifficult_Tour::where('tourId', $tour->id)->whereNotIn('id', $existTourDifficult)->delete();

            $existTourKind = [];
            if(isset($data->kinds)) {
                foreach ($data->kinds as $kind) {
                    $kind = TourKind_Tour::firstOrCreate(['tourId' => $tour->id, 'kindId' => $kind]);
                    array_push($existTourKind, $kind->id);
                }
            }
            TourKind_Tour::where('tourId', $tour->id)->whereNotIn('id', $existTourKind)->delete();

            $existTourFitFor = [];
            if(isset($data->fitFor)) {
                foreach ($data->fitFor as $fitFor) {
                    $fit = TourFitFor_Tour::firstOrCreate(['tourId' => $tour->id, 'fitForId' => $fitFor]);
                    array_push($existTourFitFor, $fit->id);
                }
            }
            TourFitFor_Tour::where('tourId', $tour->id)->whereNotIn('id', $existTourFitFor)->delete();

            $existTourStyle = [];
            if(isset($data->style)) {
                foreach ($data->style as $style) {
                    $style = TourStyle_Tour::firstOrCreate(['tourId' => $tour->id, 'styleId' => $style]);
                    array_push($existTourStyle, $style->id);
                }
            }
            TourStyle_Tour::where('tourId', $tour->id)->whereNotIn('id', $existTourStyle)->delete();

            $equipmentId = [];
            if(isset($data->equipment)) {
                $equips = (object)$data->equipment;
                foreach ($equips->necessary as $item) {
                    $id = TourEquipment::firstOrCreate(['tourId' => $tour->id, 'subEquipmentId' => $item, 'isNecessary' => 1]);
                    array_push($equipmentId, $id->id);
                }
                foreach ($equips->suggest as $item) {
                    $id = TourEquipment::firstOrCreate(['tourId' => $tour->id, 'subEquipmentId' => $item, 'isNecessary' => 0]);
                    array_push($equipmentId, $id->id);
                }
            }
            TourEquipment::where('tourId', $tour->id)->whereNotIn('id', $equipmentId)->delete();

        }
        catch(\Exception $x) {
            dd($x->getMessage());
        }
        
        return 'ok';
    }

    public function showStep_5($tour){
        $view = "{$this->defaultViewLocation}.tour.create.cityTourism.createTour_cityTourism_stage_end";
        return view($view, compact(['tour']));
    }
    public function storeStep_5($request, $tour){
        dd('null');
    }

    public function deleteTour($tour){
        $response = $tour->fullyDeleted();
        return $response;
    }
}
