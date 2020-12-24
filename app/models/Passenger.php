<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;


/**
 * An Eloquent Model: 'Passenger'
 *
 * @property integer $id
 * @property integer $countryCodeId
 * @property integer $uId
 * @property integer $ageType
 * @property string $nameFa
 * @property string $nameEn
 * @property string $familyFa
 * @property string $familyEn
 * @property string $NID
 * @property string $birthDay
 * @property string $expire
 * @property boolean $sex
 * @property boolean $NIDType
 * @property boolean $self
 * @method static \Illuminate\Database\Query\Builder|\App\models\Passenger whereNID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Passenger where('uId',$value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Passenger whereSelf($value)
 */

class Passenger extends Model {

    protected $table = 'passenger';
    public $timestamps = false;

    public static function whereId($target) {
        return Passenger::find($target);
    }
}
