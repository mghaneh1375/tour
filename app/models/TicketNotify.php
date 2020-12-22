<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'TicketNotify'
 *
 * @property integer $id
 * @property string $date
 * @property string $from
 * @property string $to
 * @property string $email
 * @method static \Illuminate\Database\Query\Builder|\App\models\TicketNotify whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\TicketNotify whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\TicketNotify whereTo($value)
 */

class TicketNotify extends Model {

    protected $table = 'ticketNotify';
    public $timestamps = false;

    public static function whereId($value) {
        return TicketNotify::find($value);
    }
}
