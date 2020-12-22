<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'HotelApi'
 *
 * @property integer $id\
 * @property string name
 * @property string $facility
 * @property string $rph
 * @property string $userName
 * @property string room_facility
 * @property string policy
 * @property integer $cityName
 * @method static \Illuminate\Database\Query\Builder|\App\models\HotelApi whereCityName($value)
 */

class HotelApi extends Model
{
    protected $table = 'hotel_apis';
    public $timestamps = false;

    public static function whereId($value) {
        return HotelApi::find($value);
    }

    protected $casts = [
        'facility' => 'array',
        'room_facility' => 'array',
    ];
}
