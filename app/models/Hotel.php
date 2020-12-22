<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Hotel'
 *
 * @property integer $id
 * @property string $name
 */

class Hotel extends Model {

    protected $table = 'hotels';
    public $timestamps = false;

    public static function whereId($value) {
        return Hotel::find($value);
    }
}
