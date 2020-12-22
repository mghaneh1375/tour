<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Majara'
 *
 * @property integer $id
 * @property string $name
 */

class Majara extends Model {

    protected $table = 'majara';
    public $timestamps = false;


    public static function whereId($value) {
        return Majara::find($value);
    }
}
