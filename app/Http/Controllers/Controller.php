<?php

namespace App\Http\Controllers;

use App\models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

include_once 'Common.php';
include_once 'Common2.php';

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function checkUsernameStatic($username, $add=false, $phoneOrParentId=null, $status=1) {

        $u = User::whereUserName($username)->first();

        if($u)
            return -1;

        if($add) {
            $u = new User();
            $u->username = $username;

            if($phoneOrParentId != null) {
                $phoneOrParentId = $phoneOrParentId . '';
                if(strlen($phoneOrParentId) == 11 && $phoneOrParentId[0] == "0")
                    $u->phone = $phoneOrParentId;
                else
                    $u->parent = $phoneOrParentId;
            }

            $u->password = "123456";
            $u->status = $status;
            $u->save();
            return $u->id;
        }

        return 0;
    }

    public static function checkCoronaVirus($_codeMeli){
        if($_codeMeli == '0440565960' || $_codeMeli === '0440565961')
            return 'sick';
        else
            return 'ok';
    }

}
