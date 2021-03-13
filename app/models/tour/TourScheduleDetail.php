<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int tourScheduleId
 * @property int detailKindId
 * @property string sTime
 * @property string eTime
 * @property string description
 * @property string text
 * @property int hasPlace
 */
class TourScheduleDetail extends Model
{
    protected $table = 'tourScheduleDetails';
    public $timestamps = false;
}
