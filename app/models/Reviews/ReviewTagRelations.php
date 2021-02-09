<?php

namespace App\models\Reviews;

use Illuminate\Database\Eloquent\Model;

class ReviewTagRelations extends Model
{
    protected $guarded = [];
    protected $table = "reviewTagRelations";
    public $timestamps = false;
}
