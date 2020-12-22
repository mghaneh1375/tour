<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'cityCode'
 *
 * @property integer $id\
 * @property integer $city_id
 * @property integer $code
 * @method static \Illuminate\Database\Query\Builder|\App\models\cityCode whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\cityCode whereCode($value)
 */

class cityCode extends Model
{
    protected $table = 'city_codes';
    public $timestamps = false;

    public static function whereId($value) {
        return cityCode::find($value);
    }
}
