<?php

namespace App\models\Business;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'BusinessMadarek'
 *
 * @property integer $id
 * @property integer $businessId
 * @property integer $role
 * @property integer $idx
 * @property string $pic1
 * @property string $pic2
 * @property string $name
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\BusinessMadarek whereBusinessId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\BusinessMadarek whereIdx($value)
 */

class BusinessMadarek extends Model {

    protected $table = 'businessMadareks';
    public $timestamps = false;

    public static function whereId($value) {
        return BusinessMadarek::find($value);
    }
}

