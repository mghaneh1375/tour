<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Notify'
 *
 * @property integer $id
 * @property string $email
 * @property boolean $news
 * @property boolean $events
 * @method static \Illuminate\Database\Query\Builder|\App\models\Notify whereEmail($value)
 */

class Notify extends Model {

    protected $table = 'notify';
    public $timestamps = false;

    public static function whereId($value) {
        return Notify::find($value);
    }
}
