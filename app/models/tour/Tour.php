<?php

namespace App\models\tour;

use App\Helpers\DefaultDataDB;
use App\models\Cities;
use App\models\places\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int isPublished
 * @property int userId
 * @property int businessId
 * @property string type
 * @property string code
 * @property string codeNumber
 * @property string name
 * @property string remainingStage
 * @property int srcId
 * @property int maxCapacity
 * @property int minCapacity
 * @property int anyCapacity
 * @property int minCost
 * @property int allUserInfoNeed
 * @property int userInfoNeed
 * @property int private
 * @property int isInsurance
 */
class Tour extends Model {
    protected $table = 'tour';

//    type = ['cityTourism','onDay','multiDay','package'];

    public function kinds()
    {
        return $this->belongsToMany(TourKind::class, 'tourKind_tour', 'tourId', 'kindId');
    }
    public function Styles()
    {
        return $this->belongsToMany(TourStyle::class, 'tourStyle_tour', 'tourId', 'styleId');
    }
    public function Difficults()
    {
        return $this->belongsToMany(TourDifficult::class, 'tourDifficult_tours', 'tourId', 'difficultId');
    }
    public function Focus()
    {
        return $this->belongsToMany(TourFocus::class, 'tourFocus_tour', 'tourId', 'focusId');
    }
    public function FitFor()
    {
        return $this->belongsToMany(TourFitFor::class, 'tourFitFor_Tours', 'tourId', 'fitForId');
    }

    public function GetFeatures(){
        return $this->hasMany(TourFeature::class, 'tourId', 'id');
    }
    public function GetDiscounts(){
        return $this->hasMany(TourDiscount::class, 'tourId', 'id');
    }

    public function scopeYouCanSee($query){
        return $query->where('isPublished', 1)->where('confirm', 1);
    }

    public function updateRemainingStage($stage){
        $remainingStage = $this->remainingStage;
        if($remainingStage != null){
            $remainingStage = json_decode($remainingStage);
            $pos = array_search($stage, $remainingStage);
            if($pos !== false) {
                array_splice($remainingStage, $pos, 1);

                if(count($remainingStage) == 0)
                    $this->remainingStage = null;
                else
                    $this->remainingStage = json_encode($remainingStage);

                $this->save();
            }
        }
        return true;
    }

    public function checkAccessToThisStage($stage){
        $remainingStage = $this->remainingStage;
        if($remainingStage != null){
            $remainingStage = json_decode($remainingStage);
            $minStage = min($remainingStage);
            if((int)$minStage < (int)$stage)
                return route("businessManagement.tour.create.stage_{$minStage}", ['business' => $this->businessId, 'tourId' => $this->id]);
        }
        return true;
    }

    public function getAllPlaces(){
//        $allKindPlaces = DefaultDataDB::getPlaceDB();

        $allPlaces = [];
        $schedules = TourSchedule::where('tourId', $this->id)->orderBy('day')->get();
        foreach($schedules as $index => $schedule){
            $placesWithKindPlaceIds = TourPlaceRelation::where('tourId', $this->id)->get()->groupBy('kindPlaceId');
            foreach($placesWithKindPlaceIds as $kindPlaceId => $plki){
                if(isset($allKindPlaces[$kindPlaceId])) {
                    $kindPlace = $allKindPlaces[$kindPlaceId];
                    $allPlaceIds = $plki->pluck('placeId')->toArray();
                    $places = DB::table($kindPlace->tableName)->whereIn('id', $allPlaceIds)->get();

                    foreach($places as $pl){
                        array_push($allPlaces, [
                            'url' => route('placeDetails', ['kindPlaceId' => $kindPlace->id, 'placeId' => $pl->id]),
                            'name' => $pl->name,
                            'rate' => (int)$pl->fullRate,
                            'reviewCount' => $pl->reviewCount,
                            'img' => getPlacePic($pl->id, $kindPlace->id, 'f')
                        ]);
                    }
                }
            }
        }

        return $allPlaces;
    }

    public function getFullySchedule(){
        $allKindPlaces = DefaultDataDB::getPlaceDB();
        $schedules = TourSchedule::where('tourId', $this->id)->orderBy('day')->get();

        $isFullDayMeals = $this->isMealAllDay;
        $meals = json_decode($this->meals);

        foreach($schedules as $index => $schedule){
            $schedule->events = TourScheduleDetail::join('tourScheduleDetailKinds', 'tourScheduleDetailKinds.id', 'tourScheduleDetails.detailKindId')
                                                ->where('tourScheduleDetails.tourScheduleId', $schedule->id)
                                                ->select(['tourScheduleDetails.*', 'tourScheduleDetailKinds.color', 'tourScheduleDetailKinds.icon', 'tourScheduleDetailKinds.name AS kindName'])
                                                ->orderBy('tourScheduleDetails.sTime')->get();
            foreach($schedule->events as $event){
                $placesArr = [];
                if($event->hasPlace == 1){
                    $eventPlaces = TourPlaceRelation::where('tourScheduleDetailId', $event->id)->get();
                    foreach ($eventPlaces as $item){
                        if(isset($allKindPlaces[$item->kindPlaceId])){
                            $kindPlace = $allKindPlaces[$item->kindPlaceId];
                            $tabNaPl = $kindPlace->tableName;
                            $place = \DB::table($tabNaPl)
                                ->join('cities', 'cities.id', "$tabNaPl.cityId")
                                ->join('state', 'state.id', "cities.stateId")
                                ->where("$tabNaPl.id", $item->placeId)
                                ->select(["$tabNaPl.id", "$tabNaPl.name", "$tabNaPl.cityId", "state.name AS stateName", "cities.name AS cityName"])
                                ->first();

                            if($place != null){
                                $place->url = route('placeDetails', ['kindPlaceId' => $kindPlace->id, 'placeId' => $place->id]);
                                $place->pic = getPlacePic($place->id, $kindPlace->id);
                                $place->stateAndCity = ' در شهر '.$place->cityName.' ، استان '.$place->stateName;
                                $place->kindPlaceId = $kindPlace->id;
                                array_push($placesArr, $place);
                            }
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
                $kindPlaceId = $schedule->isBoomgardi == 1 ? 12 : 4;
                $schedule->hotel->cityAndState = $cit == null ? 'در شهر '.$cit->cityName.' ، استان '.$cit->stateName : '';
                $schedule->hotel->pic = getPlacePic($schedule->hotel->id, $kindPlaceId);
                $schedule->hotel->url = route('placeDetails', ['kindPlaceId' => $kindPlaceId, 'placeId' => $schedule->hotel->id]);
            }

            if($isFullDayMeals == 1)
                $schedule->meals = $meals;
            else
                $schedule->meals = isset($meals[$index]) ? $meals[$index] : [];
        }

        return $schedules;
    }


    public function fullyDeleted(){
        $tour = $this;
        $condition = ['tourId' => $tour->id];
        $tourTimeCheck = TourTimes::where($condition)->where('registered', '>', 0)->count();
        if($tourTimeCheck != 0)
            return ['status' => 'hasRegistered', 'results' => $tourTimeCheck];

        $tourTimes = TourTimes::where($condition)->get();
        $tourTimesId = $tourTimes->pluck('id')->toArray();

        $tourReservation = TourUserReservation::whereIn('tourTimeId', $tourTimesId)->count();
        if($tourReservation != 0)
            return ['status' => 'hasRegistered'];

        $tourPruchCkeck = TourPurchased::whereIn('tourTimeId', $tourTimesId)->count();
        if($tourPruchCkeck != 0)
            return ['status' => 'hasRegistered'];

        TourDifficult_Tour::where($condition)->delete();
        TourFitFor_Tour::where($condition)->delete();
        TourFocus_Tour::where($condition)->delete();
        TourStyle_Tour::where($condition)->delete();
        TourKind_Tour::where($condition)->delete();
        TourDiscount::where($condition)->delete();
        TourEquipment::where($condition)->delete();
        TourFeature::where($condition)->delete();
        TourGuid::where($condition)->delete();
        TourNotice::where($condition)->delete();
        Transport_Tour::where($condition)->delete();

        TourPrices::where($condition)->delete();

        $schedule = TourSchedule::where($condition)->get();
        foreach ($schedule as $item)
            $item->fullyDelete();

        $folderLocation = __DIR__."/../../../../assets/_images/tour/{$this->id}";
        if(is_dir($folderLocation)) {
            $filesInFolder = scandir($folderLocation);
            foreach ($filesInFolder as $file) {
                if ($filesInFolder != '.' && $filesInFolder != '..' && is_file("{$folderLocation}/{$file}"))
                    unlink("{$folderLocation}/{$file}");
            }
        }
        TourPic::where($condition)->delete();

        $this->delete();
        return ['status' => 'ok'];
    }
}
