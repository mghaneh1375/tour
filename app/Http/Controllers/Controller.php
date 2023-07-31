<?php

namespace App\Http\Controllers;

use App\models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

include_once 'Common.php';

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected static $sharedKey = "myTokenSharedKeyMammadKia";
//    protected static $apiBaseUrl = "https://mykoochita.com/";
    protected static $apiBaseUrl = "https://koochita.com/";

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

    public static function sendDeleteFileApiToServer($files, $server){

        if(config('app.env') === 'local')
            return ['status' => 'ok', 'result' => 'not in local'];

        $nonce = config('app.DeleteNonceCode');
        $apiUrl = "https://sr{$server}.koochita.com/api/deleteFileWithDir";

        $time = Carbon::now()->getTimestamp();
        $hash = Hash::make($nonce.'_'.$time);

        $response = Http::asForm()->delete($apiUrl, [
            'code' => $hash,
            'time' => $time,
            'filesDirectory' => json_encode($files)
        ]);

        if($response->successful())
            return ['status' => 'ok', 'result' => $response->json()];
        else
            return ['status' => 'error', 'result' => $response->json()];
    }

    protected static function createToken() {
        $time = time();
        return [hash("sha256", self::$sharedKey . $time), $time];
    }

    public static function sendSMS($destNum, $text, $template, $token2 = "") {

        return 1;
        // require_once __DIR__ . '/../../../vendor/autoload.php';

        // try{
        //     $api = new KavenegarApi("4836666C696247676762504666386A336846366163773D3D");
        //     $result = $api->VerifyLookup($destNum, $text, $token2, '', $template);
        //     if($result){
        //         foreach($result as $r){
        //             return $r->messageid;
        //         }
        //     }
        // }
        // catch(ApiException $e){
        //     // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
        //     echo $e->errorMessage();
        //     return -1;
        // }
        // catch(HttpException $e){
        //     // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
        //     echo $e->errorMessage();
        //     return -1;
        // }
    }
    

    public static function convertDate($created) {

        include_once 'jdate.php';

        if(count(explode(' ', $created)) == 2)
            $created = explode('-', explode(' ', $created)[0]);
        else
            $created = explode('-', $created);

        $created = gregorian_to_jalali($created[0], $created[1], $created[2]);
        return $created[0] . '/' . $created[1] . '/' . $created[2];
    }

    public static $COMMON_ERRS = [
        'view_index.unique' => "اولویت نمایش باید منحصر به فرد باشد",
        'pic.required' => 'لطفا تصویر را بارگذاری فرمایید'
    ];
}
