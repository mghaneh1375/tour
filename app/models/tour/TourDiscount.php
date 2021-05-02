<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int tourId
 * @property int tourTimeId
 * @property string code
 * @property int discount
 * @property int maxCount
 * @property int minCount
 * @property int remainingDay
 * @property int status
 */
class TourDiscount extends Model
{
    protected $table = 'tourDiscounts';
    public $timestamps = false;
}
