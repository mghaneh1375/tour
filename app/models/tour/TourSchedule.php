<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int tourId
 * @property int day
 * @property int hotelId
 * @property int isBoomgardi
 * @property string description
 */
class TourSchedule extends Model
{
    protected $table = 'tourSchedules';

    public function fullyDelete(){
        $scheduleDetails = TourScheduleDetail::where('tourScheduleId', $this->id)->get();
        if($scheduleDetails != null) {
            $scheduleDetailsIds = $scheduleDetails->pluck('id')->toArray();
            TourPlaceRelation::whereIn('tourScheduleDetailId', $scheduleDetailsIds)->delete();
            TourScheduleDetail::where('tourScheduleId', $this->id)->delete();
        }
        $this->delete();

        return;
    }
}
