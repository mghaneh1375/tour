<?php

namespace App\models\places;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'PlaceStyle'
 *
 * @property integer $id
 * @property string $name
 * @property integer $kindPlaceId
 */

class PlaceStyle extends Model {

    protected $table = 'placeStyle';
    public $timestamps = false;

    public static function whereId($target) {
        return PlaceStyle::find($target);
    }

}
