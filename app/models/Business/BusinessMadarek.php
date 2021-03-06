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

    public static function deleteMadarek($madarek) {

        if($madarek->pic1 != null && !empty($madarek->pic1) &&
            file_exists(__DIR__ . '/../../../../storage/app/public/' . $madarek->pic1))
            unlink(__DIR__ . '/../../../../storage/app/public/' . $madarek->pic1);

        if($madarek->pic2 != null && !empty($madarek->pic2) &&
            file_exists(__DIR__ . '/../../../../storage/app/public/' . $madarek->pic2))
            unlink(__DIR__ . '/../../../../storage/app/public/' . $madarek->pic2);

        $madarek->delete();

    }
}

