<?php

namespace App\models\Business;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Contract'
 *
 * @property integer $id
 * @property string $type
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\Contract whereType($value)
 */

class Contract extends Model {

    protected $table = 'contracts';
    public $timestamps = false;

    public static function whereId($value) {
        return Contract::find($value);
    }

}
