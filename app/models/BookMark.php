<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class BookMark extends Model
{
    protected $guarded = [];
    protected $table = 'bookMarks';
    public $timestamps = false;
}
