<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'InvitationCode'
 *
 * @property integer $id
 * @property integer $uId
 * @property string $phoneNum
 * @property string $sendTime
 * @method static \Illuminate\Database\Query\Builder|\App\models\InvitationCode where('uId',$value)
 */

class InvitationCode extends Model {

    protected $table = 'invitationCode';
    public $timestamps = false;
}
