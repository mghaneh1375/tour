<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'TripComments'
 *
 * @property integer $id
 * @property integer $tripPlaceId
 * @property integer $uId
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripComments whereUId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\TripComments whereTripPlaceId($value)
 */

class TripComments extends Model {

    protected $table = 'tripComments';
    public $timestamps = false;
}
