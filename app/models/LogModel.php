<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'LogModel'
 *
 * @property integer $id
 * @property integer $activityId
 * @property integer $visitorId
 * @property integer $relatedTo
 * @property boolean $seen
 * @property boolean $confirm
 * @method static \Illuminate\Database\Query\Builder|\App\models\LogModel whereRelatedTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\LogModel where('activityId',$value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\LogModel whereVisitorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\LogModel whereSeen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\LogModel whereConfirm($value)
 */

class LogModel extends Model {

    protected $guarded = [];
    protected $table = 'log';

    public static function whereId($value) {
        return LogModel::find($value);
    }

}
