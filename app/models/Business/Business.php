<?php

namespace App\models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * An Eloquent Model: 'Business'
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $nickName
 * @property string $tel
 * @property string $nid
 * @property string $economyCode
 * @property string $site
 * @property string $insta
 * @property string $telegram
 * @property string $introduction
 * @property string $address
 * @property string $pic
 * @property string $lastChangesNewsPaper
 * @property string $additionalValue
 * @property string $expireAdditionalValue
 * @property string $logo
 * @property string $mail
 * @property string $shaba
 * @property integer $cityId
 * @property integer $userId
 * @property integer $assignUserId
 * @property double $lat
 * @property double $lng
 * @property boolean $hasCertificate
 * @property boolean $haghighi
 * @property boolean $hasAdditionalValue
 * @property boolean $readyForCheck
 * @property boolean $finalStatus
 * @property boolean $type_status
 * @property boolean $name_status
 * @property boolean $nickName_status
 * @property boolean $tel_status
 * @property boolean $nid_status
 * @property boolean $economyCode_status
 * @property boolean $site_status
 * @property boolean $insta_status
 * @property boolean $telegram_status
 * @property boolean $introduction_status
 * @property boolean $address_status
 * @property boolean $pic_status
 * @property boolean $lastChangesNewsPaper_status
 * @property boolean $additionalValue_status
 * @property boolean $expireAdditionalValue_status
 * @property boolean $logo_status
 * @property boolean $mail_status
 * @property boolean $shaba_status
 * @property boolean $cityId_status
 * @property boolean $lat_status
 * @property boolean $lng_status
 * @property boolean $hasCertificate_status
 * @property boolean $haghighi_status
 * @property boolean $hasAdditionalValue_status
 * @property boolean $fullOpen
 * @property boolean $fullOpen_status
 * @property boolean $afterClosedDayIsOpen
 * @property boolean $afterClosedDayIsOpen_status
 * @property boolean $closedDayIsOpen
 * @property boolean $closedDayIsOpen_status
 * @property boolean $problem
 * @property string $inWeekOpenTime
 * @property boolean $inWeekOpenTime_status
 * @property string $inWeekCloseTime
 * @property boolean $inWeekCloseTime_status
 * @property string $afterClosedDayOpenTime
 * @property boolean $afterClosedDayOpenTime_status
 * @property string $afterClosedDayCloseTime
 * @property boolean $afterClosedDayCloseTime_status
 * @property string $closedDayOpenTime
 * @property boolean $closedDayOpenTime_status
 * @property string $closedDayCloseTime
 * @property boolean $closedDayCloseTime_status
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\Business whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\Business whereReadyForCheck($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\Business whereFinalStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\Business whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Business\Business whereAssignUserId($value)
 */

class Business extends Model {

    protected $table = 'business';

    public static function whereId($value) {
        return Business::find($value);
    }

    public function hasAccess() {

        if($this->userId == Auth::user()->id)
            return ["full"];

        $acl = BusinessACL::whereUserId(Auth::user()->id)->whereBusinessId($this->id)->whereAccept(true)->first();
        if($acl == null)
            return null;

        $access = [];

        if($acl->infoAccess)
            array_push($access, "info");

        if($acl->financialAccess)
            array_push($access, "financial");

        if($acl->userAccess)
            array_push($access, "user");

        if($acl->contentAccess)
            array_push($access, "content");

        return $access;
    }

    public static function deleteBusiness(Business $business) {

        $madareks = BusinessMadarek::whereBusinessId($business->id)->get();
        foreach ($madareks as $madarek) {
            BusinessMadarek::deleteMadarek($madarek);
        }

        $pics = BusinessPic::whereBusinessId($business->id)->get();
        foreach ($pics as $pic) {
            BusinessPic::deletePic($pic);
        }

        $business->delete();
    }
}

