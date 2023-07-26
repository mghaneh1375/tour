<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int tourScheduleId
 * @property int detailKindId
 * @property enum type
 * @property string title
 * @property string sTime
 * @property string eTime
 * @property string lat
 * @property string lng
 * @property string description
 * @property string text
 * @property int hasPlace
 * @property int placeId
 * @property int kindPlaceId
 * @property int sortNumber
 */
class TourScheduleDetail extends Model
{
    protected $table = 'tourScheduleDetails';
    public $timestamps = false;
}
