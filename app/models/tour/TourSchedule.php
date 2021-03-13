<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int tourId
 * @property int day
 * @property int hotelId
 * @property int isBoomgardi
 * @property string description
 */
class TourSchedule extends Model
{
    protected $table = 'tourSchedules';

}
