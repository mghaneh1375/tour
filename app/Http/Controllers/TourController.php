<?php

namespace App\Http\Controllers;

use App\models\Cities;
use App\models\MainEquipment;
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
use App\models\tour\TourStyle;
use App\models\tour\TourStyle_Tour;
use App\models\Transport_Tour;
use App\models\TransportKind;
use App\User;
use Carbon\Carbon;
use ClassesWithParents\CInterface;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function afterStart()
    {
        return view('tour.tourCreationFirstPage');
    }

    public function stageOneTour(Request $request)
    {
        if($request->method() == 'POST'){

            $newTour = new Tour();
            $newTour->userId = 1;
            $newTour->name = $request->name;
            $newTour->srcId = $request->src;
            $newTour->destId = $request->dest;
            if($request->src == $request->dest)
                $newTour->kindDest = 0;
            else
                $newTour->kindDest = -1;
            $newTour->private = $request->private;

            $bestSesson = '';
            for($i = 0; $i < count($request->season); $i++){
                if($i != 0)
                    $bestSesson .= '-';

                $bestSesson .= $request->season[$i] ;
            }

            $newTour->bestSeason = $bestSesson;
            $newTour->save();

            foreach (json_decode($request->kind) as $item){
                $newKind = new TourKind_Tour();
                $newKind->kindId = $item;
                $newKind->tourId = $newTour->id;
                $newKind->save();
            }
            foreach ($request->difficult as $item){
                $newdifficult = new TourDifficult_Tour();
                $newdifficult->difficultId = $item;
                $newdifficult->tourId = $newTour->id;
                $newdifficult->save();
            }
            foreach ($request->focus as $item){
                $newFocus = new TourFocus_Tour();
                $newFocus->focusId = $item;
                $newFocus->tourId = $newTour->id;
                $newFocus->save();
            }
            foreach ($request->style as $item){
                $newStyle = new TourStyle_Tour();
                $newStyle->styleId = $item;
                $newStyle->tourId = $newTour->id;
                $newStyle->save();
            }

            return redirect(url('/tour/create/stageTwo/' . $newTour->id));

        }
        else{
            $tourDifficult = TourDifficult::all();
            $tourStyle = TourStyle::all();
            $tourFocus = TourFocus::all();
            $tourKind = TourKind::all();

            $states = State::all();
            return view('tour.tourCreationGeneralInfo', compact(['tourDifficult', 'tourStyle', 'tourFocus', 'tourKind', 'states']));
        }
    }

    public function stageTwoTour($id)
    {

        $tour = Tour::find($id);

        if(auth()->user()->id == $tour->userId) {
            if($tour == null)
                return redirect(route('tour.create.stage.one'));
            else{
                $tour->lastUpdate = convertDate($tour->updated_at);
                $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

                $transport = TransportKind::all();
                $src = Cities::find($tour->srcId);
                $dest = Cities::find($tour->destId);
                $tour->srcLatLng = [$src->x, $src->y];
                $tour->destLatLng = [$dest->x, $dest->y];

                $ostan = State::all();

                $tourLocalId = TourKind::where('name', 'محلی')->first();
                if($tourLocalId != null)
                    $tourLocalId = $tourLocalId->id;

                $local = TourKind_Tour::where(['tourId' => $tour->id, 'kindId' => $tourLocalId])->first();
                if($local == null)
                    $tour->local = false;
                else
                    $tour->local = true;

                return view('tour.tourCreationSpecificInfo', compact(['tour', 'transport', 'ostan']));
            }
        }
        else
            return redirect(url('/'));
    }

    public function stageTwoTourStore(Request $request)
    {
        $tour = Tour::find($request->tourId);

        if(auth()->user()->id == $tour->userId) {
            if($tour != null){
                if($request->isTransportTour == 1){
                    $tour->isTransport = true;

                    $newSTransport = new Transport_Tour();
                    $newSTransport->tourId = $tour->id;
                    $newSTransport->sTransportId = makeValidInput($request->sTransport);
                    $newSTransport->eTransportId = makeValidInput($request->eTransport);
                    $newSTransport->sTime = makeValidInput($request->sTime);
                    $newSTransport->eTime = makeValidInput($request->eTime);
                    $newSTransport->sDescription = makeValidInput($request->sDescription);
                    $newSTransport->eDescription = makeValidInput($request->eDescription);
                    $newSTransport->sAddress = makeValidInput($request->sAddress);
                    $newSTransport->eAddress = makeValidInput($request->eAddress);
                    $newSTransport->sLatlng = json_encode(array($request->sLat, $request->sLng));
                    $newSTransport->eLatlng = json_encode(array($request->eLat, $request->eLng));
                    $newSTransport->save();
                }
                else{
                    $tour->isTransport = true ;
                }

                $inTransport = '';
                $side = json_decode($request->sideTransport) ;
                for($i = 0; $i < count($side); $i++){
                    if($i != 0)
                        $inTransport .= '-';
                    $inTransport .= $side[$i];
                }
                $tour->inTransport = $inTransport;

                if($request->isMeal == 1)
                    $tour->isMeal = true;
                else
                    $tour->isMeal = false;

                if($request->isMealsAllDay == 1)
                    $tour->isMealAllDay = true;
                else
                    $tour->isMealAllDay = false;

                if($request->isMealCost == 1)
                    $tour->isMealMoney = true;
                else
                    $tour->isMealMoney = false;

                $meals = $request->meals;
                $mealText = '';
                for($i = 0; $i < count($meals); $i++){
                    if($i != 0)
                        $mealText .= '-';

                    $mealText .= $meals[$i];
                }
                $tour->meals = $mealText;
                $tour->save();

                $restaurant = json_decode($request->restaurantList);
                $kindPlaceId = Place::where('name', 'رستوران')->first();
                if($kindPlaceId != null) {
                    $kindPlaceId = $kindPlaceId->id;
                    foreach ($restaurant as $item) {
                        $newPlace = new TourPlace();
                        $newPlace->tourId = $tour->id;
                        $newPlace->placeId = $item;
                        $newPlace->kindPlaceId = $kindPlaceId;
                        $newPlace->save();
                    }
                }

                $amaken = json_decode($request->amakenList);
                $kindPlaceId = Place::where('name', 'اماکن')->first();
                if($kindPlaceId != null) {
                    $kindPlaceId = $kindPlaceId->id;
                    foreach ($amaken as $item) {
                        $newPlace = new TourPlace();
                        $newPlace->tourId = $tour->id;
                        $newPlace->placeId = $item;
                        $newPlace->kindPlaceId = $kindPlaceId;
                        $newPlace->save();
                    }
                }

                $city = json_decode($request->cityList);
                foreach ($city as $item) {
                    $newPlace = new TourPlace();
                    $newPlace->tourId = $tour->id;
                    $newPlace->placeId = $item;
                    $newPlace->kindPlaceId = 0;
                    $newPlace->save();
                }

                return redirect(url('/tour/create/stageThree/' . $tour->id));
            }
        }
        else
            return redirect(url('/'));
    }

    public function stageThreeTour($id)
    {
        $tour = Tour::find($id);
        if(auth()->user()->id == $tour->userId){
                if($tour != null){

                    $tour->lastUpdate = convertDate($tour->updated_at);
                    $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

                    $ostan = State::all();

                    return view('tour.tourCreationFinancialInfo', compact(['tour', 'ostan']));
                }
            }
    }

    public function stageThreeTourStore(Request $request)
    {
        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){
            $tour->minCost = $request->minCost;
            $tour->isInsurance = $request->isInsurance;
            if($request->ticketKind == 'fast')
                $tour->ticketKind = 0;
            else
                $tour->ticketKind = 1;
            $tour->maxCapacity = $request->maxCapacity;
            $tour->minCapacity = $request->minCapacity;

            if($tour->private)
                $tour->maxGroup = $request->maxGroupCapacity;
            else
                $tour->anyCapacity = $request->anyCapacity;

            $tour->save();

            if($request->isHotel){
                $hotelList = json_decode($request->hotelList);
                $roomCosts = json_decode($request->roomCosts);
                $roomKinds = json_decode($request->roomKinds);
                $roomPacks = json_decode($request->roomPacks);

                for($i = 0; $i < count($hotelList); $i++){
                    if(isset($hotelList[$i]) && isset($roomCosts[$i]) && isset($roomKinds[$i]) && isset($roomPacks[$i])){
                        $newHotel = new TourHotel();
                        $newHotel->tourId = $tour->id;
                        $newHotel->hotelId = $hotelList[$i];
                        $newHotel->roomKind = $roomKinds[$i];
                        $newHotel->cost = $roomCosts[$i];
                        $newHotel->sameGroup = $roomPacks[$i];
                        $newHotel->save();
                    }
                }
            }

            if (isset($request->featureName)){
                $featuresName = $request->featureName;
                $featuresDesc = $request->featureDesc;
                $featuresGroup = $request->featureGroup;
                $featuresCost = $request->featureCost;

                for($i = 0; $i < count($featuresName); $i++){
                    if(isset($featuresCost[$i]) && isset($featuresDesc[$i]) && isset($featuresGroup[$i])){
                        $newFeature = new TourFeature();
                        $newFeature->tourId = $tour->id;
                        $newFeature->name = $featuresName[$i];
                        $newFeature->description = $featuresDesc[$i];
                        $newFeature->cost = $featuresCost[$i];
                        $newFeature->group = $featuresGroup[$i];
                        $newFeature->save();
                    }
                }

            }

            if(isset($request->disCountFrom)){
                $from = $request->disCountFrom;
                $to = $request->disCountTo;
                $dis = $request->disCountCap;

                for($i = 0; $i < count($from); $i++){
                    if(isset($from[$i]) && isset($to[$i]) && isset($dis[$i]) && (int)$dis[$i] > 0){
                        $f = (int)$from[$i];
                        $t = (int)$to[$i];
                        $d = (int)$dis[$i];
                        $error = false;

                        for($j = $i+1; $j < count($from); $j++){
                            if(isset($from[$j]) && isset($to[$j]) && isset($dis[$j]) && (int)$dis[$j] > 0) {
                                if(($f >= $from[$j] && $f <= $to[$j]) || ($t >= $from[$j] && $t <= $to[$j])){
                                    $error = true;
                                }
                            }
                        }
                        if(!$error){
                            $newDiscount = new TourDiscount();
                            $newDiscount->tourId = $tour->id;
                            $newDiscount->discount = $d;
                            $newDiscount->minCount = $f;
                            $newDiscount->maxCount = $t;
                            $newDiscount->isChildren = 0;
                            $newDiscount->isReason = 0;
                            $newDiscount->save();
                        }

                    }
                }
            }

            if(isset($request->babyDisCount) && $request->babyDisCount != '' && $request->babyDisCount != null && (int)$request->babyDisCount != 0){

                $newDiscount->tourId = $tour->id;
                $newDiscount->discount = (int)$request->babyDisCount;
                $newDiscount->isChildren = 1;
                $newDiscount->isReason = 0;
                $newDiscount->save();

            }

            if(isset($request->disCountReason) && $request->disCountReason != '' && $request->disCountReason != null && (int)$request->disCountReason != 0){

                $newDiscount->tourId = $tour->id;
                $newDiscount->discount = (int)$request->disCountReason;
                $newDiscount->isChildren = 0;
                $newDiscount->isReason = 1;
                $newDiscount->eReasonDate = convertDateToString($request->eDate);
                $newDiscount->sReasonDate = convertDateToString($request->sDate);
                $newDiscount->save();

            }

            return redirect(url('/tour/create/stageFour/' . $tour->id));

        }
        else
            dd('nok');
//            return redirect()->back();
    }

    public function stageFourTour($id)
    {
        $tour = Tour::find($id);
        if($tour->userId == auth()->user()->id){

            $tour->lastUpdate = convertDate($tour->updated_at);
            $tour->lastUpdateTime = $tour->updated_at->hour . ':' . $tour->updated_at->minute;

            return view('tour.tourCreationLanguage&Schedule', compact(['tour']));
        }

    }

    public function stageFourTourStore(Request $request)
    {
        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){

            if($request->tourKind == 'oneTime'){
                if((isset($request->sDate) && $request->sDate != '' && $request->sDate != '') && (isset($request->eDate) && $request->eDate != '' && $request->eDate != '')) {
                    $tour->period = 0;
                    $sDate = convertNumber('en', $request->sDate);

                    $tour->sDate = convertDateToString($sDate);

                    $eDate = convertNumber('en', $request->eDate);
                    $tour->eDate = convertDateToString($eDate);
                }
            }
            elseif($request->tourKind == 'sameTime'){
                if((isset($request->sDateSame) && $request->sDateSame != '' && $request->sDateSame != '') && (isset($request->eDateSame) && $request->eDateSame != '' && $request->eDateSame != '') && (isset($request->priod))) {
                    $tour->period = 1;

                    $sDate = convertNumber('en', $request->sDateSame);
                    $tour->sDateSame = convertDateToString($sDate);

                    $eDate = convertNumber('en', $request->eDateSame);
                    $tour->eDateSame = convertDateToString($eDate);

                    $newPeriod = new TourPeriod();
                    $newPeriod->tourId = $tour->id;
                    $newPeriod->priodTime = $request->priod;
                    $newPeriod->save();
                }
            }
            else if($request->tourKind == 'notSameTime'){
                $tour->period = 2;
                $first = false;
                for($i = 0; $i < count($request->sDateNotSame) && $i < count($request->eDateNotSame); $i++){
                    if($request->sDateNotSame[$i] != null && $request->sDateNotSame[$i] != '' && $request->eDateNotSame[$i] != null && $request->eDateNotSame[$i] != ''){
                        if(!$first){
                            $tour->sDate = convertDateToString(convertNumber('en', $request->sDateNotSame[$i]));
                            $tour->eDate = convertDateToString(convertNumber('en', $request->eDateNotSame[$i]));
                            $first = true;
                        }
                        else{
                            $newPeriod = new TourPeriod();
                            $newPeriod->tourId = $tour->id;
                            $newPeriod->sDate = convertDateToString(convertNumber('en', $request->sDateNotSame[$i]));
                            $newPeriod->eDate = convertDateToString(convertNumber('en', $request->eDateNotSame[$i]));
                            $newPeriod->save();
                        }
                    }
                }
            }

            if($tour->sDate == null || $tour->sDate == '')
                return redirect()->back();
            else{
                $language = json_decode($request->language);
                $langText = '';

                for($i = 0; $i < count($language); $i++){
                    if($i != 0)
                        $langText .= '-';
                    $langText .= $language[$i];
                }
                $tour->language = $langText;

                if(isset($request->isTourGuide) && $request->isTourGuide == 1) {
                    $tour->isTourGuide = true;

                    if(isset($request->isLocalTourGuide) && $request->isLocalTourGuide == 1)
                        $tour->isLocalTourGuide = true;
                    else
                        $tour->isLocalTourGuide = false;

                    if(isset($request->isSpecialTourGuid) && $request->isSpecialTourGuid == 1)
                        $tour->isSpecialTourGuid = true;
                    else
                        $tour->isSpecialTourGuid = false;

                    if(isset($request->isTourGuidDefined) && $request->isTourGuidDefined == 1){
                        $tour->isTourGuidDefined = true;

                        if(isset($request->isTourGuideInKoochita) && $request->isTourGuideInKoochita == 1){
                            if(isset($request->tourGuidKoochitaEmail)) {
                                $account = User::where('email', $request->tourGuidKoochitaEmail)->first();

                                if($account != null)
                                    $tour->isTourGuideInKoochita = $account->id;
                            }
                        }
                        else {
                            $tour->isTourGuideInKoochita = 0;
                            if((isset($request->tourGuidFirstName) && $request->tourGuidFirstName != '' && $request->tourGuidFirstName != null) && (isset($request->tourGuidLastName) && $request->tourGuidLastName != '' && $request->tourGuidLastName != null) ) {
                                $newGuid = new TourGuid();
                                $newGuid->tourId = $tour->id;
                                $newGuid->firstName = $request->tourGuidFirstName;
                                $newGuid->lastName = $request->tourGuidLastName;
                                $newGuid->sex = $request->tourGuidSex;
                                $newGuid->save();
                            }
                        }
                    }
                    else
                        $tour->isTourGuidDefined = false;
                }
                else
                    $tour->isTourGuide = false;

                if(isset($request->backUpPhone) && $request->backUpPhone != null)
                    $tour->backupPhone = $request->backUpPhone;

                $tour->save();

                return redirect(url('/tour/create/stageFive/' . $tour->id));
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
            foreach ($mainEquipment as $item){
                $item->side = SubEquipment::where('equipmentId', $item->id)->get();
            }
            return view('tour.tourCreationExplanatoryInfo', compact(['tour', 'mainEquipment']));
        }
        else{
            return redirect()->back();
        }
    }

    public function stageFiveTourStore(Request $request)
    {

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

            return view('tour.tourCreationFinalStep', compact(['tour']));
        }
        else
            return redirect()->back();
    }

}
