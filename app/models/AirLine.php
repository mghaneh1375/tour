<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'AirLine'
 *
 * @property integer $id
 * @property string $name
 * @property string $abbreviation
 * @method static \Illuminate\Database\Query\Builder|\App\models\AirLine whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\AirLine whereAbbreviation($value)
 */


class AirLine extends Model {

    protected $table = 'airLine';
    public $timestamps = false;

    public static function whereId($target) {
        return AirLine::find($target);
    }
}
