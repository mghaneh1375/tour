<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;


/**
 * An Eloquent Model: 'UserOpinion'
 *
 * @property integer $id
 * @property integer $logId
 * @property integer $rate
 * @property integer $opinionId
 */

class UserOpinion extends Model {

    protected $table = 'userOpinions';
    public $timestamps = false;
}
