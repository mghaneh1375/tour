<?php

namespace App\models\Reviews;

use Illuminate\Database\Eloquent\Model;

class ReviewUserAssigned extends Model{
    protected $guarded = [];
    protected $table = 'reviewUserAssigned';
    public $timestamps = false;
}
