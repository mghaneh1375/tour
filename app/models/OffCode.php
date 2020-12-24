<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'OffCode'
 *
 * @property integer $id
 * @property string $code
 * @property integer $amount
 * @property integer $uId
 * @property boolean $kind
 * @property string $expire
 * @method static \Illuminate\Database\Query\Builder|\App\models\OffCode where('uId',$value)
 */

class OffCode extends Model {

    protected $table = 'offCode';
    public $timestamps = false;
}
