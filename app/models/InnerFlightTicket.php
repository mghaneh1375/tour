<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'InnerFlightTicket'
 *
 * @property integer $id
 * @property string $date
 * @property string $time
 * @property string $arrivalTime
 * @property integer $price
 * @property integer $maxPrice
 * @property integer $childPrice
 * @property integer $infantPrice
 * @property boolean $isCharter
 * @property boolean $isIncreasable
 * @property string $flightId
 * @property string $line
 * @property string $from
 * @property string $lineEn
 * @property string $lineCode
 * @property string $lineLogo
 * @property string $lineLogoSmall
 * @property string $uniqueKey
 * @property string $to
 * @property string $provider
 * @property integer $free
 * @property boolean $isBusiness
 * @property integer $noTicket
 * @method static \Illuminate\Database\Query\Builder|\App\models\InnerFlightTicket whereFlightId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\InnerFlightTicket whereUniqueCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\InnerFlightTicket whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\InnerFlightTicket whereTo($value)
 */

class InnerFlightTicket extends Model {

    protected $table = 'innerFlightTicket';
    public $timestamps = false;

    public static function whereId($value) {
        return InnerFlightTicket::find($value);
    }
}
