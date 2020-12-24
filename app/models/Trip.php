<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Trip'
 *
 * @property integer $id
 * @property integer $uId
 * @property string $name
 * @property string $from_
 * @property string $to_
 * @property string $lastSeen
 * @method static \Illuminate\Database\Query\Builder|\App\models\Trip where('uId',$value)
 */

class Trip extends Model {

    protected $table = 'trip';
    public $timestamps = false;

    public static function whereId($value) {
        return Trip::find($value);
    }
}
