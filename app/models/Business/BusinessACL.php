<?php

namespace App\models\Business;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'BusinessACL'
 *
 * @property integer $id
 * @property integer $businessId
 * @property integer $userId
 * @property boolean $userAccess
 * @property boolean $contentAccess
 * @property boolean $infoAccess
 * @property boolean $financialAccess
 * @property boolean $accept
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\BusinessACL whereBusinessId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\BusinessACL whereAccept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\BusinessACL whereUserId($value)
 */

class BusinessACL extends Model {

    protected $table = 'businessACL';
    public $timestamps = false;

    public static function whereId($value) {
        return BusinessACL::find($value);
    }
}

