<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int tourId
 * @property int tourScheduleDetailId
 * @property int placeId
 * @property int kindPlaceId
 */
class TourPlaceRelation extends Model
{
    protected $guarded = [];
    protected $table = 'tourPlaceRelations';
    public $timestamps = false;
}
