<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

class TourPlaceRelation extends Model
{
    protected $guarded = [];
    protected $table = 'tourPlaceRelations';
    public $timestamps = false;
}
