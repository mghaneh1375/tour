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
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripPlace whereTripId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripPlace wherePlaceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripPlace whereKindPlaceId($value)
 */

class TripPlace extends Model {

    protected $table = 'tripPlace';
    public $timestamps = false;

    public static function whereId($value) {
        return TripPlace::find($value);
    }
}
