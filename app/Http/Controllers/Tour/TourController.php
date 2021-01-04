<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\FestivalLimboContent;
use App\models\MainEquipment;
use App\models\places\Amaken;
use App\models\places\Place;
use App\models\State;
use App\models\SubEquipment;
use App\models\tour\Tour;
use App\models\tour\TourDifficult;
use App\models\tour\TourDifficult_Tour;
use App\models\tour\TourDiscount;
use App\models\tour\TourFeature;
use App\models\tour\TourFocus;
use App\models\tour\TourFocus_Tour;
use App\models\tour\TourGuid;
use App\models\tour\TourHotel;
use App\models\tour\TourKind;
use App\models\tour\TourKind_Tour;
use App\models\tour\TourNotice;
use App\models\tour\TourPeriod;
use App\models\tour\TourPic;
use App\models\tour\TourPlace;
use App\models\tour\TourSchedule;
use App\models\tour\TourScheduleDetail;
use App\models\tour\TourScheduleDetailKind;
use App\models\tour\TourStyle;
use App\models\tour\TourStyle_Tour;
use App\models\tour\Transport_Tour;
use App\models\tour\TransportKind;
use App\User;
use Carbon\Carbon;
use ClassesWithParents\CInterface;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function afterStart()
    {
        return view('pages.tour.create.tourCreationFirstPage');
    }
    public function stageOneTour($id = 0)
    {
        $tour = Tour::find($id);
        $tourDifficult = TourDifficult::all();
        $tourStyle = TourStyle::all();
        $tourFocus = TourFocus::all();
        $tourKind = TourKind::all();
        $states = State::all();

        return view('pages.tour.create.createTour_GeneralInfo', compact(['tour', 'states']));
//        return view('pages.tour.create.tourCreationGeneralInfo', compact(['tourDifficult', 'tourStyle', 'tourFocus', 'tourKind', 'states', 'tour']));
    }
    public function stageTwoTour($id){
        $tour = Tour::find($id);
        $tour->lastUpdate = convertDate($tour->updated_at);
        $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;
        $tourScheduleKinds = TourScheduleDetailKind::all();

        $transport = TransportKind::all();
        $ostan = State::all();


//        return view('pages.tour.create.createTour_datePlan', compact(['tour', 'tourScheduleKinds']));
        return view('pages.tour.create.tourCreationSpecificInfo', compact(['tour', 'tourScheduleKinds', 'transport', 'ostan']));
    }
    public function stageThreeTour($id){
        $tour = Tour::find($id);
        if(auth()->user()->id == $tour->userId){
            if($tour != null){
                $tour->lastUpdate = convertDate($tour->updated_at);
                $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;
                $transport = TransportKind::all();
                return view('pages.tour.create.createTour_Options', compact(['tour', 'transport']));

//                $ostan = State::all();
//                return view('pages.tour.create.tourCreationFinancialInfo', compact(['tour', 'transport', 'ostan']));
            }
        }
    }
    public function stageFourTour($id){
        $tour = Tour::find($id);
        if(auth()->user()->id == $tour->userId){
            if($tour != null){
                $tour->lastUpdate = convertDate($tour->updated_at);
                $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;
                return view('pages.tour.create.createTour_Financial', compact(['tour']));
            }
        }
    }
    public function stageFiveTour($id)
    {
        $tour = Tour::find($id);
        if($tour->userId == auth()->user()->id){

            $tour->lastUpdate = convertDate($tour->updated_at);
            $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

            $mainEquipment = MainEquipment::all();
            foreach ($mainEquipment as $item)
                $item->side = SubEquipment::where('equipmentId', $item->id)->get();

            $tourKind = TourKind::all();
            $tourDifficult = TourDifficult::all();
            $tourFocus = TourFocus::all();
            $tourStyle = TourStyle::all();

            return view('pages.tour.create.createTour_ExplanatoryInfo', compact(['tour', 'mainEquipment', 'tourKind', 'tourDifficult', 'tourFocus', 'tourStyle']));
        }
        else{
            return redirect()->back();
        }
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
        $newTour->save();


        if($request->tourTimeKind == 'notSameTime'){
            TourPeriod::where('tourId', $newTour->id)->delete();
            $newTour->period = 2;
            $first = true;
            for($i = 0; $i < count($request->sDateNotSame) && $i < count($request->eDateNotSame); $i++){
                if($request->sDateNotSame[$i] != null && $request->sDateNotSame[$i] != '' && $request->eDateNotSame[$i] != null && $request->eDateNotSame[$i] != ''){
                    if($first){
                        $newTour->sDate = convertDateToString(convertNumber('en', $request->sDateNotSame[$i]), '/');
                        $newTour->eDate = convertDateToString(convertNumber('en', $request->eDateNotSame[$i]), '/');
                        $first = false;
                    }
                    else{
                        $newPeriod = new TourPeriod();
                        $newPeriod->tourId = $newTour->id;
                        $newPeriod->sDate = convertDateToString(convertNumber('en', $request->sDateNotSame[$i]), '/');
                        $newPeriod->eDate = convertDateToString(convertNumber('en', $request->eDateNotSame[$i]), '/');
                        $newPeriod->save();
                    }
                }
            }
        }
        else{
            if($request->tourTimeKind == 'sameTime'){
                TourPeriod::where('tourId', $newTour->id)->delete();

                $newTour->period = 1;
                $newPeriod = new TourPeriod();
                $newPeriod->tourId = $newTour->id;
                $newPeriod->priodTime = $request->priod;
                $newPeriod->save();
            }
            else
                $newTour->period = 0;

            $newTour->sDate = convertDateToString(convertNumber('en', $request->sDate), '/');
            $newTour->eDate = convertDateToString(convertNumber('en', $request->eDate), '/');
        }

        $newTour->save();

        return redirect(route('tour.create.stage.two', ['id' => $newTour->id]));
    }
    public function stageTwoTourStore(Request $request){

        $detail = json_decode($request->planDate);
        $tour = Tour::find($request->tourId);
        if($tour != null && $tour->userId == auth()->user()->id){
            foreach ($detail as $index => $item){
                $newDay = new TourSchedule();
                $newDay->tourId = $tour->id;
                $newDay->day = $index+1;
                $newDay->hotelId = $item->hotelId;
                $newDay->isBoomgardi = 0;
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
                            $newPlace = new TourPlace();
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
            else
                $tour->isTransport = 0;

            $tour->sideTransportCost = $data->isSideTransportCost;
            if($data->isSideTransportCost == 1)
                $tour->sideTransportCost = (int)$data->sideTransportCost;

            $tour->sideTransport = json_encode($data->sideTransport);

            if($data->isMeal == 1){
                $tour->isMeal = 1;
                $tour->isMealAllDay = $data->isMealsAllDay;
                $tour->isMealCost = $data->isMealCost;

                if($data->isMealCost == 1)
                    $tour->mealMoreCost = (int)$data->mealMoreCost;

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

            if($data->isBackUpPhone == 1)
                $tour->backupPhone = $data->backUpPhone;
            else
                $tour->backupPhone = null;

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
            $tour->minCost = (int)$data->cost;
            $tour->isInsurance = (int)$data->isInsurance;
            $tour->ticketKind = $data->ticketKind;
            $tour->save();

            foreach ($data->features as $feat){
                $newFeat = new TourFeature();
                $newFeat->tourId = $tour->id;
                $newFeat->name = $feat->name;
                $newFeat->description = $feat->description;
                $newFeat->cost = (int)$feat->cost;
                $newFeat->save();
            }

            foreach ($data->discounts as $discount){
                $newDiscount = new TourDiscount();
                $newDiscount->tourId = $tour->id;
                $newDiscount->discount = $discount->discount;
                $newDiscount->minCount = $discount->min;
                $newDiscount->maxCount = $discount->max;
                $newDiscount->isChildren = 0;
                $newDiscount->isReason = 0;
                $newDiscount->save();
            }

            if($data->childDisCount > 0){
                $newDiscount = new TourDiscount();
                $newDiscount->tourId = $tour->id;
                $newDiscount->discount = $data->childDisCount;
                $newDiscount->isChildren = 1;
                $newDiscount->isReason = 0;
                $newDiscount->save();
            }

            if($data->disCountReason > 0 && $data->sDiscountDate > 0 && $data->eDiscountDate > 0){
                $newDiscount = new TourDiscount();
                $newDiscount->tourId = $tour->id;
                $newDiscount->discount = $data->disCountReason;
                $newDiscount->isChildren = 0;
                $newDiscount->isReason = 1;
                $newDiscount->sReasonDate = $data->sDiscountDate;
                $newDiscount->eReasonDate = $data->eDiscountDate;
                $newDiscount->save();
            }

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function stageFiveTourStore(Request $request)
    {
        dd('store stage five');
        $tour = Tour::find($request->tourId);
        if($tour->userId == auth()->user()->id){

            $tour->description = $request->mainDescription;
            $tour->textExpectation = $request->textExpectation;
            $tour->specialInformation = $request->specialInformation;
            $tour->opinion = $request->opinion;
            $tour->tourLimit = $request->tourLimit;
            if($request->isCancelAbel == 1) {
                $tour->cancelDescription = $request->cancelDescription;
                $tour->cancelAble = true;
            }
            else
                $tour->cancelAble = false;
            $tour->save();

            for($i = 0; $i < count($_FILES['pics']); $i++){
                if(isset($_FILES["pics"]["name"][$i]) && $_FILES["pics"]["name"][$i] != '' && $_FILES["pics"]["size"][$i] != 0 && $_FILES["pics"]['error'][$i] == 0) {
                    $name = time() . '_' . $_FILES["pics"]["name"][$i];

                    $pic = __DIR__ . '/../../../../assets/_images/tour/' . $name;

                    $err = uploadCheckArray($pic, "pics", "افزودن عکس جدید", 3000000, -1, $i);
                    if(empty($err)) {
                        $err = uploadArray($pic, "pics", "افزودن عکس جدید", $i);
                        if (!empty($err))
                            dd($err);
                        else{
                            $newPic = new TourPic();
                            $newPic->tourId = $tour->id;
                            $newPic->pic = $name;
                            $newPic->save();
                        }
                    }
                    else {
                        dd($err);
                    }
                }
            }

            foreach ($request->sideDescription as $item) {
                if($item != '' && $item != null){
                    $newNotice = new TourNotice();
                    $newNotice->tourId = $tour->id;
                    $newNotice->text = $item;
                    $newNotice->save();
                }
            }

            return redirect(url('/tour/create/complete/' . $tour->id));

        }
        else
            return redirect()->back();
    }
    public function completeCreationTour($id)
    {
        $tour = Tour::find($id);

        if($tour->userId == auth()->user()->id){

            $tour->lastUpdate = convertDate($tour->updated_at);
            $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

            return view('pages.tour.tourCreationFinalStep', compact(['tour']));
        }
        else
            return redirect()->back();
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

//            if(isset($request->thumbnail) && $request->thumbnail != ''){
//                $fileName = explode('.', $request->fileName);
//                $fileName = $fileName[0].'.png';
//
//                $direction .= '/'.$fileName;
//                $result = uploadLargeFile($direction, $request->thumbnail);
//
//                if($result) {
//                    $location = __DIR__ . '/../../../../assets/_images/festival/limbo';
//                    $size = [['width' => 250, 'height' => 250, 'name' => 'thumb_', 'destination' => $location]];
//                    $result = resizeUploadedImage(file_get_contents($direction), $size, $fileName);
//                    if(is_file($location.'/'.$fileName))
//                        unlink($location.'/'.$fileName);
//
//                    $fileName = 'thumb_'.$fileName;
//
//                    $limbo = new FestivalLimboContent();
//                    $limbo->userId = $user->id;
//                    $limbo->content = $fileName;
//                    $limbo->save();
//                }
//            }

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
