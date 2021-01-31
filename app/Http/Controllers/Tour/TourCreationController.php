<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\FestivalLimboContent;
use App\models\MainEquipment;
use App\models\places\Amaken;
use App\models\places\Boomgardy;
use App\models\places\Hotel;
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
use App\models\tour\TourFocus;
use App\models\tour\TourFocus_Tour;
use App\models\tour\TourGuid;
use App\models\tour\TourHotel;
use App\models\tour\TourKind;
use App\models\tour\TourKind_Tour;
use App\models\tour\TourNotice;
use App\models\tour\TourPeriod;
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
use App\models\users\UserInfoNeeded;
use App\User;
use Carbon\Carbon;
use ClassesWithParents\CInterface;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class TourCreationController extends Controller{

    public function beforeCreateStart()
    {
        return view('pages.tour.create.createTour_0_BeforeStart');
    }
    public function stageOneTour($id = 0)
    {
        $tour = Tour::find($id);
        $states = State::all();

        if($tour != null){
            $tour->src = Cities::find($tour->srcId);
            if($tour->kindDest == 'city') {
                $tour->dest = Cities::find($tour->destId);
                $tour->dest->kind = 'city';
            }
            else{
                $tour->dest = Majara::select(['id', 'name'])->find($tour->destId);
                $tour->dest->kind = 'tabiatgardy';
            }

            $tour->userInfoNeed = json_decode($tour->userInfoNeed);
            $tour->times = TourTimes::where('tourId', $tour->id)->orderBy('sDate')->get();
        }

        return view('pages.tour.create.createTour_1_GeneralInfo', compact(['tour', 'states']));
    }
    public function stageTwoTour($id){
        $tour = Tour::select(['id', 'updated_at', 'day'])->find($id);
        $tour->lastUpdate = convertDate($tour->updated_at);
        $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

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
        return view('pages.tour.create.createTour_2_datePlan', compact(['tour', 'tourScheduleKinds']));
    }
    public function stageThreeTour($id){
        $tour = Tour::find($id);
        if(auth()->user()->id == $tour->userId){
            if($tour != null){
                $tour->lastUpdate = convertDate($tour->updated_at);
                $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;
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

                return view('pages.tour.create.createTour_3_Options', compact(['tour', 'transport']));
            }
        }
    }
    public function stageFourTour($id){
        $tour = Tour::find($id);
        if(auth()->user()->id == $tour->userId){
            if($tour != null){
                $tour->lastUpdate = convertDate($tour->updated_at);
                $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

                $tour->features = $tour->GetFeatures;
                $tour->groupDiscount = TourDiscount::where('tourId', $tour->id)->whereNull('remainingDay')->get();
                foreach ($tour->groupDiscount as $item){
                    $item->min = $item->minCount;
                    $item->max = $item->maxCount;
                }

                $tour->lastDays = TourDiscount::whereNotNull('remainingDay')->orderBy('remainingDay')->get();

                $tour->prices = TourPrices::where('tourId', $tour->id)->orderBy('ageFrom')->get();

                return view('pages.tour.create.createTour_4_Financial', compact(['tour']));
            }
        }
    }
    public function stageFiveTour($id)
    {
        $tour = Tour::find($id);
        if($tour->userId == auth()->user()->id){

            $tour->lastUpdate = convertDate($tour->updated_at);
            $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

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
                $pic->url = URL::asset('_images/tour/'.$tour->id.'/'.$pic->pic);
            $tour->pics = $pics;

            return view('pages.tour.create.createTour_5_ExplanatoryInfo', compact(['tour', 'mainEquipment', 'tourKind', 'tourDifficult', 'tourFitFor', 'tourStyle']));
        }
        else
            return redirect()->back();
    }
    public function completeCreationTour($id){
        $tour = Tour::find($id);

        if($tour->userId == auth()->user()->id){

            $tour->lastUpdate = convertDate($tour->updated_at);
            $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

            return view('pages.tour.create.createTour_6_Complete', compact(['tour']));
        }
        else
            return redirect()->back();
    }

    public function storeStageOneTour(Request $request)
    {
        $isNewTour = true;
        if(isset($request->id) && $request->id != 0){
            $newTour = Tour::find($request->id);
            if($newTour != null)
                $isNewTour = false;
        }

        if($isNewTour) {
            $newTour = new Tour();
            $newTour->userId = auth()->user()->id;

            $code = generateRandomString('10');
            while(Tour::where('code', $code)->first() != null)
                $code = generateRandomString('10');

            $newTour->code = $code;
        }

        $newTour->name = $request->name;
        $newTour->srcId = $request->src;
        $newTour->destId = $request->destId;
        $newTour->kindDest = $request->destKind;
        $newTour->day = $request->tourDay;
        $newTour->night = $request->tourNight;
        $newTour->maxCapacity = $request->maxCapacity;
        $newTour->minCapacity = $request->minCapacity;
        $newTour->anyCapacity = $request->anyCapacity;
        $newTour->private = $request->private;
        $newTour->isLocal = $request->sameSrcDestInput ?? 0;
        $newTour->userInfoNeed = json_encode($request->userInfoNeed);
        $newTour->allUserInfoNeed = (int)$request->isAllUserInfo;
        $newTour->save();


        TourTimes::where('tourId', $newTour->id)->where('registered', 0)->delete();

        for($i = 0; $i < count($request->sDateNotSame) && $i < count($request->eDateNotSame); $i++){
            if($request->sDateNotSame[$i] != null && $request->sDateNotSame[$i] != '' && $request->eDateNotSame[$i] != null && $request->eDateNotSame[$i] != ''){
                $sDate = convertDateToString(convertNumber('en', $request->sDateNotSame[$i]), '/');
                $eDate = convertDateToString(convertNumber('en', $request->eDateNotSame[$i]), '/');

                $check = \DB::select("SELECT * FROM `tourtimes` WHERE `tourId` = {$newTour->id} AND (`sDate` LIKE '{$sDate}' OR `eDate` LIKE '{$eDate}')");
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
        }

        return redirect(route('tour.create.stage.two', ['id' => $newTour->id]));
    }
    public function stageTwoTourStore(Request $request){

        $detail = json_decode($request->planDate);
        $tour = Tour::find($request->tourId);
        if($tour != null && $tour->userId == auth()->user()->id){

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
                        $newEvent->text = $event->moreData;
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

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'notYours']);
    }
    public function stageThreeTourStore(Request $request)
    {
        $data = json_decode($request->data);
        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){
            if($data->isTransportTour == 1){
                $tour->isTransport = 1;

                $transport = new Transport_Tour();
                $transport->tourId = $tour->id;
                $transport->sTransportId = $data->sTransportKind;
                $transport->eTransportId = $data->eTransportKind;
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
                Transport_Tour::where('tourId', $tour->id)->delete();
            }

//            $tour->sideTransportCost = $data->isSideTransportCost;
//            if($data->isSideTransportCost == 1)
//                $tour->sideTransportCost = (int)$data->sideTransportCost;
//            else
                $tour->sideTransportCost = null;

            $tour->sideTransport = json_encode($data->sideTransport);

            if($data->isMeal == 1){
                $tour->isMeal = 1;
                $tour->isMealAllDay = $data->isMealsAllDay;
//                $tour->isMealCost = $data->isMealCost;

//                if($data->isMealCost == 1)
//                    $tour->mealMoreCost = (int)$data->mealMoreCost;

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
                $tour->isTourGuideInKoochita = $data->isTourGuidInKoochita;
                $tour->tourGuidKoochitaId = $data->koochitaUserId;
                $tour->tourGuidName = $data->tourGuidName;
                $tour->tourGuidSex = $data->tourGuidSex;
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

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function stageFourTourStore(Request $request)
    {
        $data = json_decode($request->data);
        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){
//            $tour->ticketKind = $data->ticketKind;
            $tour->minCost = (int)$data->cost;
            $tour->isInsurance = (int)$data->isInsurance;
            $tour->save();

            $counter = 0;
            $prices = TourPrices::where('tourId', $tour->id)->get();
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
        else
            return response()->json(['status' => 'error1']);
    }
    public function stageFiveTourStore(Request $request)
{
    $data = json_decode($request->data);
    $tour = Tour::find($request->tourId);

    if($tour->userId == auth()->user()->id){
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
            array_push($equipmentId, $id->$id);
        }
        foreach ($data->equipment->suggest as $item){
            $id = TourEquipment::firstOrCreate(['tourId' => $tour->id, 'subEquipmentId' => $item, 'isNecessary' => 0]);
            array_push($equipmentId, $id->$id);
        }
        TourEquipment::where('tourId', $tour->id)->whereNotIn('id', $equipmentId)->delete();

        return response()->json(['status' => 'ok']);
    }
    else
        return response()->json(['status' => 'error1']);
}


    public function storeTourPics(Request $request){

        $start = microtime(true);
        $data = json_decode($request->data);

        $tour = Tour::find($data->tourId);
        if($tour->userId == auth()->user()->id){
            $direction = __DIR__.'/../../../../../assets/_images/tour';
            if(!is_dir($direction))
                mkdir($direction);

            $direction .= '/'.$tour->id;
            if(!is_dir($direction))
                mkdir($direction);

            if(isset($request->cancelUpload) && $request->cancelUpload == 1){
                $direction .= '/'.$request->storeFileName;
                if(is_file($direction))
                    unlink($direction);

                TourPic::where('tourId', $tour->id)
                    ->where('pic', $request->storeFileName)
                    ->delete();

                return response()->json(['status' => 'canceled']);
            }

            if(isset($request->storeFileName) && isset($request->file_data) && $request->storeFileName != 0){
                $fileName = $request->storeFileName;
                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->file_data);
            }
            else{
                $fileType = explode('.', $request->file_name);
                $fileName = time().'_'.rand(100, 999).'_'.$tour->id.'.'.end($fileType);

                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->file_data);

                if($result) {
                    $limbo = new TourPic();
                    $limbo->tourId = $tour->id;
                    $limbo->pic = $fileName;
                    $limbo->save();
                }
            }

//            if(isset($request->last) && $request->last == 'true' && $data->kind == 'photo'){
//                $location = __DIR__.'/../../../../assets/_images/festival/limbo';
//                $size = [[ 'width' => 250, 'height' => 250, 'name' => 'thumb_', 'destination' => $location ]];
//                $result = resizeUploadedImage(file_get_contents($direction), $size, $fileName);
//            }

            if($result)
                return response()->json(['status' => 'ok', 'fileName' => $fileName, 'time' => microtime(true)-$start]);
            else
                return response()->json(['status' => 'nok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function deleteTourPics(Request $request)
    {
        $tour = Tour::find($request->tourId);
        $picName = $request->fileName;
        if($tour->userId == auth()->user()->id){
            $location = __DIR__.'/../../../../../assets/_images/tour/'.$tour->id;
            $pic = TourPic::where('tourId', $tour->id)->where('pic', $picName)->first();
            if($pic != null){
                if(is_file($location.'/'.$picName))
                    unlink($location.'/'.$picName);
                $pic->delete();
                return response()->status(['status' => 'ok']);
            }
            else
                return response()->status(['status' => 'error2']);
        }
        else
            return response()->status(['status' => 'error1']);
    }
}
