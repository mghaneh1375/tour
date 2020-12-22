<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Train'
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\Train whereName($value)
 */


class Train extends Model {

    protected $table = 'train';
    public $timestamps = false;

    public static function whereId($target) {
        return Train::find($target);
    }
}
