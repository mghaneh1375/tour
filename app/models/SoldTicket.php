<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'SoldTicket'
 *
 * @property integer $id
 * @property string $invoiceToken
 * @property integer $total
 * @property integer $status
 * @property string $bookingRef
 * @method static \Illuminate\Database\Query\Builder|\App\models\SoldTicket whereInvoiceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\SoldTicket whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\SoldTicket whereBookingRef($value)
 */

class SoldTicket extends Model {

    protected $table = 'soldTicket';

    public static function whereId($value) {
        return SoldTicket::find($value);
    }
}
