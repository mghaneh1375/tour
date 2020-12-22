<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HotelPassengerInfo extends Model
{
    protected $table = 'hotel_passenger_infos';

    public static function whereId($value) {
        return HotelPassengerInfo::find($value);
    }

    public $timestamps = false;
}
