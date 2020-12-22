<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model {

    protected $table = 'level';
    public $timestamps = false;

    public static function whereId($target) {
        return Level::find($target);
    }

}
