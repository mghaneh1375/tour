<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'CountryCode'
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $nameEn
 * @method static \Illuminate\Database\Query\Builder|\App\models\CountryCode whereCode($value)
 */


class CountryCode extends Model {

    protected $table = 'countryCode';
    public $timestamps = false;


    public static function whereId($value) {
        return CountryCode::find($value);
    }
}
