<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;



class TourUserReservation extends Model
{
    protected $table = 'tourUserReservations';

    public function deleteAndReturnCapacity(){
        return;

        $tourTime = TourTimes::find($this->tourTimeId);
        $tourTime->registered -= $this->inCapacityCount;
        $tourTime->save();

        $this->delete();

        return $tourTime;
    }
}
