<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'TripMember'
 *
 * @property integer $id
 * @property integer $tripId
 * @property integer $uId
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripMember where('tripId',$value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripMember where('uId',$value)
 */

class TripMember extends Model {

    protected $table = 'tripMembers';
    public $timestamps = false;

    public static function whereId($value) {
        return TripMember::find($value);
    }
}
