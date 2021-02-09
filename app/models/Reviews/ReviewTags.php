<?php

namespace App\models\Reviews;

use Illuminate\Database\Eloquent\Model;

class ReviewTags extends Model
{
    protected $guarded = [];
    protected $table = "reviewTags";
    public $timestamps = false;
}
