<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;


/**
 * An Eloquent Model: 'UserTripStyles'
 *
 * @property integer $id
 * @property integer $tripStyleId
 * @property integer $uId
 */

class UserTripStyles extends Model {

    protected $table = 'userTripStyles';
    public $timestamps = false;
}
