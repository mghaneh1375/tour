<?php

namespace App\models\tour;

use App\models\Cities;
use App\models\places\Place;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model {
    protected $table = 'tour';

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

    public function scopeYouCanSee($query)
    {
        return $query->where('isPublished', 1)->where('confirm', 1);
    }


    public function getFullySchedule(){
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
                        $kindPlace = Place::find($item->kindPlaceId);
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
}
