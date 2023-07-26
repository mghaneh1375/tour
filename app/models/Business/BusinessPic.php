<?php

namespace App\models\Business;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'BusinessPic'
 *
 * @property integer $id
 * @property integer $businessId
 * @property string $pic
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\BusinessPic whereBusinessId($value)
 */

class BusinessPic extends Model {

    protected $table = 'businessPic';
    public $timestamps = false;

    public static function whereId($value) {
        return BusinessPic::find($value);
    }

    public static function deletePic($pic) {

        if($pic->pic != null && !empty($pic->pic) &&
            file_exists(__DIR__ . '/../../../../storage/app/public/' . $pic->pic))
            unlink(__DIR__ . '/../../../../storage/app/public/' . $pic->pic);

        $pic->delete();
    }
}

