<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'OpOnActivity'
 *
 * @property integer $id
 * @property integer $logId
 * @property integer $uId
 * @property boolean $like_
 * @property boolean $dislike
 * @property boolean $seen
 * @method static \Illuminate\Database\Query\Builder|\App\models\OpOnActivity whereLogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\OpOnActivity where('uId',$value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\OpOnActivity whereSeen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\OpOnActivity whereLike_($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\OpOnActivity whereDislike($value)
 */

class OpOnActivity extends Model {

    protected $table = 'opOnActivity';
    public $timestamps = false;
}
