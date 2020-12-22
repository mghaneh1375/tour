<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    public $timestamps = false;

    public static function whereId($value) {
        return Company::find($value);
    }
}
