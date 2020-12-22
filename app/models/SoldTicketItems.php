<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'SoldTicketItems'
 *
 * @property integer $id
 * @property integer $soldTicketId
 * @property string $ageType
 * @property string $title
 * @property integer $value
 * @property string $direction
 * @property string $IDNumber
 * @property string $codeRef
 * @method static \Illuminate\Database\Query\Builder|\App\models\SoldTicketItems whereIDNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\SoldTicketItems whereSoldTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\SoldTicketItems whereCodeRef($value)
 */

class SoldTicketItems extends Model {

    protected $table = 'soldTicketItems';
    public $timestamps = false;

    public static function whereId($value) {
        return SoldTicketItems::find($value);
    }
}
