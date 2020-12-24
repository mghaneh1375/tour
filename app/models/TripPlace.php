<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;


/**
 * An Eloquent Model: 'TripPlace'
 *
 * @property integer $id
 * @property integer $tripId
 * @property integer $placeId
 * @property integer $kindPlaceId
 * @property string $date
 */

class TripPlace extends Model {

    protected $table = 'tripPlace';
    public $timestamps = false;

    public static function whereId($value) {
        return TripPlace::find($value);
    }
}
