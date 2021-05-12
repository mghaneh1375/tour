<?php

use App\Helpers\DefaultDataDB;
use App\models\ActivationCode;
use App\models\Activity;
use App\models\ActivityLogs;
use App\models\localShops\LocalShopsPictures;
use App\models\PhotographersPic;
use App\models\places\places\Amaken;
use App\models\Cities;
use App\models\CityPic;
use App\models\DefaultPic;
use App\models\places\Hotel;
use App\models\Level;
use App\models\LogFeedBack;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\places\Majara;
use App\models\Medal;
use App\models\Message;
use App\models\places\Place;
use App\models\places\PlacePic;
use App\models\places\PlaceRates;
use App\models\QuestionAns;
use App\models\BookMarkReference;
use App\models\places\Restaurant;
use App\models\Reviews\ReviewPic;
use App\models\Reviews\ReviewUserAssigned;
use App\models\places\SogatSanaie;
use App\models\State;
use App\models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function assetDirLocGet(){
    return __DIR__.'/../../../../assets';
}

//medals
function getTakenMedal($userId){
    $takenMedal = [];
    $takenMedalId = [];
    $countsTaken = [];

    $groupMedal = Medal::orderBy('floor')
        ->groupBy('activityId')
        ->groupBy('kindPlaceId')
        ->select(['activityId', 'kindPlaceId'])
        ->get();

    foreach ($groupMedal as $gm){
        $activity = Activity::find($gm->activityId);
        if($activity->tableName != null) {
            if($activity->tableName == 'log')
                $sqlQuery = 'visitorId = '.$userId.' ';
            else
                $sqlQuery = 'userId = '.$userId.' ';

            if($activity->controllerNeed == 1){
                if($activity->tableName == 'photographersPics')
                    $sqlQuery .= '&& status = 1 ';
                else if($activity->tableName == 'userAddPlaces')
                    $sqlQuery .= '&& archive = 1 ';
                else
                    $sqlQuery .= '&& confirm = 1 ';
            }

            if($gm->kindPlaceId != -1)
                $sqlQuery .= '&& kindPlaceId = '.$gm->kindPlaceId.' ';

            $countss = \DB::table($activity->tableName)->whereRaw($sqlQuery)->count();

            $countsTaken[$gm->kindPlaceId.'_'.$gm->activityId] = $countss;

            $med = Medal::where('kindPlaceId', $gm->kindPlaceId)
                ->where('activityId', $gm->activityId)
                ->where('floor', '<=', $countss)->get();

            foreach ($med as $item) {
                array_push($takenMedal, $item);
                array_push($takenMedalId, $item->id);
            }
        }
        else
            $countsTaken[$gm->kindPlaceId.'_'.$gm->activityId] = 0;
    }

    $inProgressMedal = Medal::whereNotIn('id', $takenMedalId)
                                ->orderBy('floor')
                                ->groupBy('activityId')
                                ->groupBy('kindPlaceId')
                                ->select(['activityId', 'kindPlaceId'])
                                ->get();
    $allMedals = Medal::orderBy('floor')->get();

    foreach ([$allMedals, $inProgressMedal, $takenMedal] as $medals){
        foreach ($medals as $item) {
            $act = Activity::find($item->activityId);
            $kindPlaceName = '';
            $kindPlace = DefaultDataDB::getSinglePlace($item->kindPlaceId);
            if ($kindPlace != null) {
                $item->sumText = $item->floor . ' ' . $act->name . ' در ' . $kindPlace->name;
                $kindPlaceName = ' در ' . $kindPlace->name;
            }
            else
                $item->sumText = $item->floor . ' ' . $act->name;

            $item->take = $countsTaken[$item->kindPlaceId . '_' . $item->activityId];
            if ($item->take >= $item->floor) {
                $item->take = $item->floor;
                $item->offPic = URL::asset('_images/badges/' . $item->pic_2);
                $item->percent = 0;
            }
            else {
                $item->offPic = URL::asset('_images/badges/' . $item->pic_1);
                $item->percent = floor(($item->take / $item->floor) * 100);
            }

            $item->text = 'این مدال بعد از ' . $item->floor . ' تا ' . $act->name . ' ' . $kindPlaceName . ' بدست می آید';
            $item->onPic = URL::asset('_images/badges/' . $item->pic_2);
        }
    }

    return ['allMedal' => $allMedals, 'inProgressMedal' => $inProgressMedal, 'takenMedal' => $medals];
}
function getUserPoints($uId) {
    $points = DB::select("SELECT SUM(activity.rate) as total FROM log, activity WHERE confirm = 1 and log.visitorId = " . $uId . " and log.activityId = activity.id");

    if($points == null || count($points) == 0 || $points[0]->total == "")
        return 0;

    return $points[0]->total;
}
function nearestLevel($uId) {

    $points = getUserPoints($uId);
    $currLevel = Level::where('floor', '<=', $points)->orderBy('floor', 'DESC')->first();

    if($currLevel == null)
        $currLevel = Level::orderBy('floor', 'ASC')->first();

    $nextLevel = Level::where('floor', '>', $points)->orderBy('floor', 'ASC')->first();

    if($nextLevel == null)
        $nextLevel = Level::orderBy('floor', 'ASC')->first();

    return [$currLevel, $nextLevel];
}
function getMedals($uId) {

    $medals = Medal::all();

    $counter = 0;

    foreach ($medals as $medal) {
//        if($medal->controllerNeed == 1)
//            $count = \DB::table($medal->tableName)->

        if(getActivitiesCount($uId, $medal->activityId, $medal->kindPlaceId) >= $medal->floor)
            $counter++;
    }

    return $counter;
}
function getNearestMedals($uId) {

    $activities = Activity::all();

    $arr = array();
    $counter = 0;

    foreach ($activities as $activity) {
        $count = LogModel::where('visitorId', $uId)->where('activityId',$activity->id)->count();
        $medals = Medal::where('activityId',$activity->id)->get();

        foreach ($medals as $medal) {
            if($medal->floor > $count) {
                $alaki = Place::whereId($medal->kindPlaceId);
                if($alaki == null)
                    $arr[$counter++] = ["medal" => $medal, "needed" => $medal->floor - $count, "kindPlaceId" => -1];
                else
                    $arr[$counter++] = ["medal" => $medal, "needed" => $medal->floor - $count, "kindPlaceId" => $alaki->name];
            }
        }
    }

    usort($arr, 'sortByNeeded');

    $limit = (count($arr) >= 3) ? 3 : count($arr);

    array_splice($arr, $limit);
    $counter = 0;

    while ($counter < $limit) {
        $arr[$counter]["medal"]->activityId = Activity::whereId($arr[$counter]["medal"]->activityId)->name;
        $counter++;
    }

    return $arr;
}

function uploadLargeFile($_direction, $_file_data){
    $file_data = decode_chunk($_file_data);
    if ($file_data === false)
        return false;
    else
        file_put_contents($_direction, $file_data, FILE_APPEND);

    return true;
}

function decode_chunk( $data ) {
    $data = explode( ';base64,', $data );
    if ( !is_array($data) || !isset($data[1]))
        return false;
    $data = base64_decode( $data[1] );
    if (!$data)
        return false;
    return $data;
}

function getPostCategories() {

    return [
        [
            'super' => "اماکن گردشگری",
            'childs' => [
                ['id' => 1, 'key' => 'اماکن تاریخی'],
                ['id' => 2, 'key' => 'اماکن مذهبی'],
                ['id' => 3, 'key' => 'اماکن تفریحی'],
                ['id' => 4, 'key' => 'طبیعت گردی'],
                ['id' => 5, 'key' => 'مراکز خرید'],
                ['id' => 6, 'key' => 'موزه ها']
            ]
        ],
        [
            'super' => "هتل و رستوران",
            "childs" => [
                ['id' => 7, 'key' => 'هتل'],
                ['id' => 8, 'key' => 'رستوران'],
            ]
        ],
        [
            'super' => "حمل و نقل",
            'childs' => [
                ['id' => 9, 'key' => 'هواپیما'],
                ['id' => 10, 'key' => 'اتوبوس'],
                ['id' => 11, 'key' => 'سواری'],
                ['id' => 12, 'key' => 'فطار']
            ]
        ],
        [
            'super' => "آداب و رسوم",
            "childs" => [
                ['id' => 13, 'key' => 'سوغات محلی'],
                ['id' => 14, 'key' => 'صنایع دستی'],
                ['id' => 15, 'key' => 'اماکن تفریحی'],
                ['id' => 16, 'key' => 'غذای محلی'],
                ['id' => 17, 'key' => 'لباس محلی'],
                ['id' => 18, 'key' => 'گویش محلی'],
                ['id' => 19, 'key' => 'اصطلاحات محلی'],
            ]
        ],
        [
            'super' => "جشنواره و آیین",
            "childs" => [
                ['id' => 20, 'key' => 'رسوم محلی'],
                ['id' => 21, 'key' => 'جشنواره'],
                ['id' => 22, 'key' => 'تور'],
                ['id' => 23, 'key' => 'کنسرت']
            ]
        ]
    ];
}

function getValueInfo($key) {

    $values = [
        'hotel-detail' => 1, 'adab-detail' => 2, 'amaken-detail' => 3, 'majara-detail' => 4, 'restaurant-detail' => 5,
        'hotel-list' => 6, 'adab-list' => 7, 'amaken-list' => 8, 'majara-list' => 9, 'restaurant-list' => 10,
        'main_page' => 11
    ];

    return $values[$key];

}

function dotNumber($number){

    $number = round($number);
//    dd($number);
    $i = 1;
    $num = 0;

    while($i < $number) {
        $i *= 10;
        $num++;
    }

    $string_number = "";

    for($i = 0; $i < $num; $i++) {
        $string_number .= $number % 10;
        $number = (int)$number / 10;
        if($i % 3 == 2)
            $string_number .= ',';
    }

    $tmp = "";
    for($i = strlen($string_number) - 1; $i >= 0; $i--) {
        $tmp .= $string_number[$i];
    }

//    $mande = $num % 3;
//    $string_number = floor($number / (10**($num-$mande)));
//    $number = $number % (10**($num-$mande));
//    $num = $num - $mande;
//    $div = $num;
//
//    for($i = 0; $i < $div/3; $i++){
//        $string_number .= '.';
//        if($number != 0) {
//            $num -= 3;
//            $string_number .= floor($number / (10 ** ($num)));
//            $number = $number % (10 ** ($num));
//        }
//        else if($i < ($div/3)-1){
//            $string_number .= '000';
//        }
//        else{
//            $string_number .= '000';
//        }
//    }

    return $tmp;
}

function getPast($past) {

    include_once 'jdate.php';

    $jalali_date = jdate("c", $past);

    $date_time = explode('-', $jalali_date);

    $subStr = explode('/', $date_time[0]);

    $day = $subStr[0] . $subStr[1] . $subStr[2];

    $time = explode(':', $date_time[1]);

    $time = $time[0] . $time[1];

    return ["date" => $day, "time" => $time];
}

function getCDN($key) {
//    '_image_CDN' => 'http://79.175.133.206:8080/_images/'
    $arr = ['imageCDN' => 'https://shazdemosafer.com/images/',
        '_image_CDN' => 'http://assets.baligh.ir/_images/',
        'cssCDN' => 'https://shazdemosafer.com/css/',
        'jsCDN' => 'https://shazdemosafer.com/js/',
        'fontCDN' => 'https://shazdemosafer.com/fonts/'];
    return $arr[$key];
}

function _custom_check_national_code($code) {

    if(!preg_match('/^[0-9]{10}$/',$code))
        return false;

    for($i=0;$i<10;$i++)
        if(preg_match('/^'.$i.'{10}$/',$code))
            return false;
    for($i=0,$sum=0;$i<9;$i++)
        $sum+=((10-$i)*intval(substr($code, $i,1)));
    $ret=$sum%11;
    $parity=intval(substr($code, 9,1));
    if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
        return true;
    return false;
}

function makeValidInput($input) {
    $input = addslashes($input);
    $input = trim($input);
//    if(get_magic_quotes_gpc())
//        $input = stripslashes($input);
    $input = htmlspecialchars($input);

//    $input = str_replace('ي', 'ی',  $input);

    return $input;
}

function createCode() {
    while (true) {
        $str = rand(100000, 999999);
        if(ActivationCode::whereCode($str)->count() == 0)
            return $str;
    }
}

function sendMail($text, $recipient, $subject) {
    require_once __DIR__ . '/../../../vendor/autoload.php';

    $mail = new PHPMailer(true);                           // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->CharSet = "UTF-8";
        //Recipients
        $mail->setFrom('info@shazdemosafer.com', 'Mailer');
//    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress($recipient);               // Name is optional
//        $mail->addReplyTo('ghane@shazdemosafer.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $text;
        $mail->AltBody = $text;

        $mail->send();
        return true;
    } catch (Exception $e) {
//        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    }
}

function getActivitiesCount($uId, $activityId, $kindPlaceId) {

    if($kindPlaceId != -1) {
        $conditions = ["visitorId" => $uId, 'activityId' => $activityId, 'confirm' => 1,
            'kindPlaceId' => $kindPlaceId];
    }
    else {
        $conditions = ["visitorId" => $uId, 'activityId' => $activityId, 'confirm' => 1];
    }

    return LogModel::where($conditions)->count();

}

function sortByNeeded($a, $b) {
    return $a['needed'] - $b['needed'];
}

function getRate($placeId, $kindPlaceId) {

    try {
        $kindPlace = DefaultDataDB::getSinglePlace($kindPlaceId);
        $place = \DB::table($kindPlace->tableName)->find($placeId);

        $avgRate = floor($place->fullRate);
        $numOfRate = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];

        $numOfRateDB = PlaceRates::where('kindPlaceId', $kindPlace->id)->where('placeId', $place->id)->select(['id', 'rate'])->get()->groupBy('rate');
        foreach ($numOfRateDB as $key => $item)
            $numOfRate[$key] = count($item);

        return [$numOfRate, $avgRate];
    }
    catch (\Exception $exception){
        return [[0, 0, 0, 0, 0], 0];
    }
}

function uploadCheck($target_file, $name, $section, $limitSize, $ext) {
    $err = "";
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $check = getimagesize($_FILES[$name]["tmp_name"]);
    $uploadOk = 1;

    if($check === false) {
        $err .= "فایل ارسالی در قسمت " . $section . " معتبر نمی باشد" .  "<br />";
        $uploadOk = 0;
    }


    if ($uploadOk == 1 && $_FILES[$name]["size"] > $limitSize) {
        $limitSize /= 1000000;
        $limitSize .= "MB";
        $err .=  "حداکثر حجم مجاز برای بارگذاری تصویر " .  " <span>" . $limitSize . " </span>" . "می باشد" . "<br />";
    }

    $imageFileType = strtolower($imageFileType);

    if($ext != -1 && $imageFileType != $ext)
        $err .= "شما تنها فایل های $ext. را می توانید در این قسمت آپلود نمایید" . "<br />";
    return $err;
}

function upload($target_file, $name, $section) {

    try {
        move_uploaded_file($_FILES[$name]["tmp_name"], $target_file);
    }
    catch (Exception $x) {
        return "اشکالی در آپلود تصویر در قسمت " . $section . " به وجود آمده است" . "<br />";
    }
    return "";
}

function uploadCheckArray($target_file, $name, $section, $limitSize, $ext, $index) {
    $err = "";
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $check = getimagesize($_FILES[$name]["tmp_name"][$index]);
    $uploadOk = 1;

    if($check === false) {
        $err .= "فایل ارسالی در قسمت " . $section . " معتبر نمی باشد" .  "<br />";
        $uploadOk = 0;
    }


    if ($uploadOk == 1 && $_FILES[$name]["size"][$index] > $limitSize) {
        $limitSize /= 1000000;
        $limitSize .= "MB";
        $err .=  "حداکثر حجم مجاز برای بارگذاری تصویر " .  " <span>" . $limitSize . " </span>" . "می باشد" . "<br />";
    }

    $imageFileType = strtolower($imageFileType);

    if($ext != -1 && $imageFileType != $ext)
        $err .= "شما تنها فایل های $ext. را می توانید در این قسمت آپلود نمایید" . "<br />";
    return $err;
}
function uploadArray($target_file, $name, $section, $index) {

    try {
        move_uploaded_file($_FILES[$name]["tmp_name"][$index], $target_file);
    }
    catch (Exception $x) {
        return "اشکالی در آپلود تصویر در قسمت " . $section . " به وجود آمده است" . "<br />";
    }
    return "";
}

function sendSMS($destNum, $text, $template, $token2 = "") {

    require_once __DIR__ . '/../../../vendor/autoload.php';

    try{
        $api = new \Kavenegar\KavenegarApi("4836666C696247676762504666386A336846366163773D3D");
        $result = $api->VerifyLookup($destNum, $text, $token2, '', $template);
        if($result){
            foreach($result as $r){
                return $r->messageid;
            }
        }
    }
    catch(\Kavenegar\Exceptions\ApiException $e){
        // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
        echo $e->errorMessage();
        return -1;
    }
    catch(\Kavenegar\Exceptions\HttpException $e){
        // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
        echo $e->errorMessage();
        return -1;
    }
}

//email
function welcomeEmail($username, $email){
    $header = 'به کوچیتا خوش آمدید';
    $userName = $username;
    $view = \View::make('emails.welcomeEmail', compact(['header', 'userName']));
    $html = $view->render();
    if(sendEmail($html, $header, $email))
        return true;
    else
        return false;
}

function forgetPassEmail($userName, $link, $email){
    $header = 'فراموشی رمز عبور';
    $view = \View::make('emails.forgetPass', compact(['header', 'userName', 'link']));
    $html = $view->render();
    if(sendEmail($html, $header, $email))
        return true;
    else
        return false;
}

function sendEmail($text, $subject, $to){
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $text;
        $mail->AltBody = $text;
        $mail->setFrom('support@koochita.com', 'Koochita');
        $mail->addAddress($to);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => true
            )
        );
//        $mail->addReplyTo('ghane@shazdemosafer.com', 'Information');
//        $mail->addCC('cc@example.com');
//        $mail->addBCC('bcc@example.com');
        $mail->send();
        return true;

//        $mail->isSMTP();                                      // Set mailer to use SMTP
//        $mail->SMTPAuth = true;             // Enable SMTP authentication
//        $mail->CharSet = 'UTF-8';
//        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
//        $mail->Host = '127.0.0.1';  // Specify main and backup SMTP servers
//        $mail->Username = 'info';                 // SMTP username
//        $mail->Password = 'adeli1982';                           // SMTP password
//        $mail->SMTPOptions = array(
//            'ssl' => array(
//                'verify_peer' => false,
//                'verify_peer_name' => false,
//                'allow_self_signed' => true
//            )
//        );
//        $mail->setFrom( 'info@koochita.com', 'koochita');
//        $mail->addAddress($to);
//        $mail->isHTML(true);                                  // Set email format to HTML
//        $mail->Subject = $subject;
//        $mail->Body = $text;
//        $mail->send();
    }
    catch (Exception $e) {
        return false;
    }
}

function distanceBetweenCoordination($lat1, $lng1, $lat2, $lng2){
    try{
        $earthRadius = 6371000;
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lng2);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
    catch(\Exception $exception){
        return false;
    }
}

function convertNumber($kind , $number){

    $en = array("0","1","2","3","4","5","6","7","8","9");
    $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");

    if($kind == 'en')
        $number = str_replace($fa, $en, $number);
    else
        $number = str_replace($en, $fa, $number);

    return $number;
}

function compressImage($source, $destination, $quality){
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    try{
        return imagejpeg($image, $destination, $quality);
    }
    catch (Exception $x) {
        return false;
    }
}


function getDifferenceTimeString($time){
    $time = Carbon::make($time);

    $diffTimeInMin = Carbon::now()->diffInMinutes($time);

    if($diffTimeInMin <= 15)
        $diffTime = 'هم اکنون';
    else if($diffTimeInMin <= 60)
        $diffTime = 'دقایقی پیش';
    else{
        $diffTimeHour = Carbon::now()->diffInHours($time);
        if($diffTimeHour <= 24)
            $diffTime = $diffTimeHour . ' ساعت پیش ';
        else{
            $diffTimeDay = Carbon::now()->diffInDays($time);
            if($diffTimeDay < 30)
                $diffTime = $diffTimeDay . ' روز پیش ';
            else{
                $diffTimeMonth = Carbon::now()->diffInMonths($time);
                if($diffTimeMonth < 12)
                    $diffTime = $diffTimeMonth . ' ماه پیش ';
                else{
                    $diffYear = (int)($diffTimeMonth / 12);
                    $diffMonth = $diffTimeMonth % 12;
                    $diffTime = $diffYear . ' سال  و ' . $diffMonth . ' ماه پیش ';
                }
            }
        }
    }

    return $diffTime;

}

function deleteAnses($logId){
    $activity = DefaultDataDB::getActivityWithName('پاسخ');
    $log = LogModel::where('activityId', $activity)->where('id', $logId)->first();
    if($log != null){
        LogFeedBack::where('logId', $logId)->delete();
        $related = LogModel::where('activityId', $activity)->where('relatedTo', $logId)->get();
        foreach ($related as $item)
            deleteAnses($item->id);
        $log->delete();
    }
    return true;
}

function commonInPlaceDetails($kindPlaceId, $placeId, $city, $state, $place){

    $section = \DB::select('SELECT questionId FROM questionSections WHERE (kindPlaceId = 0 OR kindPlaceId = ' . $kindPlaceId . ') AND (stateId = 0 OR stateId = ' . $state->id . ') AND (cityId = 0 OR cityId = ' . $city->id . ') GROUP BY questionId');

    $questionId = array();
    foreach ($section as $item)
        array_push($questionId, $item->questionId);

    if($questionId != null && count($questionId) != 0) {
        $questions = \DB::select('SELECT * FROM questions WHERE id IN (' . implode(",", $questionId) . ')');
        $questionsAns = \DB::select('SELECT * FROM questionAns WHERE questionId IN (' . implode(",", $questionId) . ')');
    }
    else{
        $questions = array();
        $questionsAns = array();
    }

    $multiQuestion = array();
    $textQuestion = array();
    $rateQuestion = array();

    foreach ($questions as $item) {
        if ($item->ansType == 'multi') {
            $item->ans = QuestionAns::where('questionId', $item->id)->get();
            array_push($multiQuestion, $item);
        }
        else if($item->ansType == 'text')
            array_push($textQuestion, $item);
        else if($item->ansType == 'rate')
            array_push($rateQuestion, $item);
    }

    $a2 = DefaultDataDB::getActivityWithName('نظر');
    $a3 = DefaultDataDB::getActivityWithName('پاسخ');

    $condition = ['activityId' => $a2->id, 'placeId' => $placeId, 'kindPlaceId' => $kindPlaceId, 'confirm' => 1, 'relatedTo' => 0];
    $reviews = LogModel::where($condition)->whereRaw('CHARACTER_LENGTH(text) > 2')->get();
    $reviewCount = count($reviews);

    $ansReviewCount = 0;
    foreach ($reviews as $item)
        $ansReviewCount += getAnsToComments($item->id)[1];

    $userReviweCount = DB::select('SELECT visitorId FROM log WHERE placeId = ' . $placeId . ' AND kindPlaceId = '. $kindPlaceId . ' AND confirm = 1 AND activityId = ' . $a2->id . ' AND CHARACTER_LENGTH(text) > 2 GROUP BY visitorId');
    $userReviweCount = count($userReviweCount);

    return [$reviewCount, $ansReviewCount, $userReviweCount, $multiQuestion, $textQuestion, $rateQuestion];
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function saveViewPerPage($kindPlaceId, $placeId){
    $allKindPlaces = DefaultDataDB::getPlaceDB();
    $value = 'kindPlaceId:'.$kindPlaceId.'Id:'.$placeId;
    if(!(Cookie::has($value) == $value)) {
        try {
            if(isset($allKindPlaces[$kindPlaceId])) {
                $kindPlace = $allKindPlaces[$kindPlaceId];
                if ($kindPlace != null)
                    \DB::select("UPDATE `{$kindPlace->tableName}` SET `seen`= `seen`+1  WHERE `id`={$placeId}");
            }
        }
        catch (\Exception $exception){}
        Cookie::queue(Cookie::make($value, $value, 5));
    }
}

function getUserPic($id = 0){
    $userPicsInArray = config('userPictureArr');

    if(!array_key_exists($id, $userPicsInArray)){
        $user = User::find($id);
        if ($id == 0 || $user == null)
            $uPic = URL::asset('images/mainPics/noPicSite.jpg');
        else {
            if (strpos($user->picture, 'http') !== false)
                $uPic = $user->picture;
            else {
                if ($user->uploadPhoto == 0) {
                    $deffPic = DefaultPic::find($user->picture);

                    if ($deffPic != null)
                        $uPic = URL::asset("defaultPic/{$deffPic->name}");
                    else
                        $uPic = URL::asset('images/mainPics/noPicSite.jpg');
                }
                else
                    $uPic = URL::asset("userProfile/{$user->picture}", null, $user->server);
            }
        }

        $userPicsInArray[$id] = $uPic;
        config(['userPictureArr' => $userPicsInArray]);
    }

    return $userPicsInArray[$id];
}

function getPlacePic($placeId = 0, $kindPlaceId = 0, $kind = 'f'){
    $allKindPlaces = DefaultDataDB::getPlaceDB();

    $defaultPic = URL::asset("images/mainPics/noPicSite.jpg");
    if($placeId != 0) {
        $server = 1;
        if(isset($allKindPlaces[$kindPlaceId])){
            $kindPlace = $allKindPlaces[$kindPlaceId];
            if($kindPlace->id == 13){
                $place = DB::table($kindPlace->tableName)->where('id', $placeId)->select(['id', 'file'])->first();
                $pic = LocalShopsPictures::where('localShopId', $place->id)->where('isMain', 1)->first();
                if($pic != null){
                    $server = $pic->server;
                    $pic = $pic->pic;
                }
            }
            else {
                $place = DB::table($kindPlace->tableName)->where('id', $placeId)->select(['id', 'file', 'picNumber', 'server'])->first();
                $server = $place->server;
                $pic = $place->picNumber;
            }

            if ($place != null && $place->file != 'none' && $place->file != null) {
                if (is_array($kind)) {
                    $pics = [];
                    foreach ($kind as $k) {
                        $pi = $defaultPic;
                        if($pic != null && $pic != '')
                            $pi = URL::asset("_images/{$kindPlace->fileName}/{$place->file}/{$k}-{$pic}", null, $server);

                        array_push($pics, $pi);
                    }
                    return $pics;
                }
                else{
                    if($pic == null || $pic == '')
                        return $defaultPic;
                    else
                        return URL::asset("_images/{$kindPlace->fileName}/{$place->file}/{$kind}-{$pic}", null, $server);
                }
            }
        }
    }

    return $defaultPic;
}


function getStatePic($stateId = 0, $cityId = 0){
    $locationPic = assetDirLocGet().'/_images/city';
    if($cityId != 0){
        $place = Cities::find($cityId);
        $pics = CityPic::where('cityId', $cityId)->get();
        if(count($pics) == 0)
            return URL::asset('images/mainPics/noPicSite.jpg');
        else{
            $locationPic1 = $locationPic .'/' . $place->id . '/' . $place->image;
            if(is_file($locationPic1))
                return URL::asset('_images/city/' . $place->id  . '/' . $place->image);
            else
                return URL::asset('_images/city/' . $place->id  . '/' . $pics[0]->pic);
        }
    }
    else if($stateId != 0)
        return URL::asset('images/mainPics/nopicv01.jpg');
    else
        return URL::asset('images/mainPics/nopicv01.jpg');
}

function createUrl($kindPlaceId, $placeId, $stateId, $cityId, $articleId = 0){
    if($stateId != 0){
        $state = DefaultDataDB::getStateWithId($stateId);
        return url('cityPage/state/' . $state->name);
    }
    else if($cityId != 0){
        $city = Cities::find($cityId);
        return url('cityPage/city/' . $city->name);
    }
    else if($kindPlaceId != 0){
        return route('placeDetails', ['kindPlaceId' => $kindPlaceId, 'placeId' => $placeId]);
    }
    else if($articleId != 0){
        $post = \App\models\safarnameh\Safarnameh::find($articleId);
        if($post != null)
            return url('/safarnameh/show/'. $post->id);
        else
            return false;
    }
}

function createPicUrl($articleId){

    if($articleId != 0){
        $post = \App\models\safarnameh\Safarnameh::find($articleId);
        if($post != null)
            return URL::asset('_images/userPhoto/' . $post->userId . '/' . $post->pic);
    }
}

function createSeeLog($placeId, $kindPlaceId, $subject, $text){

    $time = getToday()['time'];
    $today = Carbon::now()->format('Y-m-d');

    $userId = 0;
    if(auth()->check())
        $userId = auth()->user()->id;

    $log = new LogModel();
    $log->visitorId = $userId;
    $log->placeId = $placeId;
    $log->kindPlaceId = $kindPlaceId;
    $log->date = $today;
    $log->time = $time;
    $log->activityId = 1;
    $log->subject = $subject;
    $log->text = $text;
//    $log->save();

    return [$time, $today, $log->id];
}

function storeNewTag($tag){
    $check = \App\models\Tag::where('name', $tag)->first();
    if($check == null){
        $newTag = new \App\models\Tag();
        $newTag->name = $tag;
        $newTag->save();

        return $newTag->id;
    }
    else
        return false;
}

function getCityPic($cityId){
    $resultPic = null;
    $city = Cities::find($cityId);
    if($cityId != null) {
        $loc = assetDirLocGet().'/_images/city/' . $city->id;

        if($city->image == null){
            $pics = CityPic::where("cityId", $city->ic)->get();
            if(count($pics) != 0) {
                foreach ($pics as $pic) {
                    if(is_file($loc . '/' . $pic->pic)) {
                        $resultPic = URL::asset('_images/city/' . $city->id . '/' . $pic->pic);
                        break;
                    }
                }
            }
            else{
                $seenActivity = Activity::whereName('مشاهده')->first();
                $ala = Amaken::where('cityId', $cityId)->pluck('id')->toArray();
                $mostSeen = [];
                if (count($ala) != 0)
                    $mostSeen = DB::select('SELECT placeId, COUNT(id) as seen FROM log WHERE activityId = ' . $seenActivity->id . ' AND kindPlaceId = 1 AND placeId IN (' . implode(",", $ala) . ') GROUP BY placeId ORDER BY seen DESC');

                if (count($mostSeen) != 0) {
                    foreach ($mostSeen as $item) {
                        $p = Amaken::find($item->placeId);
                        $location = assetDirLocGet().'/_images/amaken/' . $p->file . '/s-' . $p->picNumber;
                        if (file_exists($location)) {
                            $resultPic = URL::asset('_images/amaken/' . $p->file . '/s-' . $p->picNumber);
                            break;
                        }
                    }
//                    if ($resultPic == null || $resultPic == '')
//                        $resultPic = URL::asset('images/mainPics/noPicSite.jpg');
                }
//                else
//                    $resultPic = URL::asset('images/mainPics/noPicSite.jpg');
            }
        }
        else
            $resultPic = URL::asset('_images/city/' . $city->id . '/' . $city->image);

    }

    return $resultPic;
}

//    http://image.intervention.io/
function resizeImage($image, $size, $fileName = ''){
    try {
        if($fileName == '') {
            $fileType = $image->getClientOriginalExtension() == '' ? '.jpg' : ".{$image->getClientOriginalExtension()}";
            $fileName = time().rand(100, 999).$fileType;
        }

        foreach ($size as $item){
            $input['imagename'] = $item['name'] .  $fileName ;
            $destinationPath = $item['destination'];

            $img = \Image::make($image->getRealPath());

            $width = $img->width();
            $height = $img->height();


            if($item['height'] != null && $item['width'] != null){
                $ration = $width/$height;
                $nWidth = $ration * $item['height'];
                $nHeight = $item['width'] / $ration;
                if($nWidth < $item['width']) {
                    $height = $nHeight;
                    $width = $item['width'];
                }
                else if($nHeight < $item['height']) {
                    $width = $nWidth;
                    $height = $item['height'];
                }
            }
            else {
                if ($item['width'] != null && $width > $item['width'])
                    $width = $item['width'];

                if ($item['height'] != null && $height > $item['height'])
                    $height = $item['height'];

            }


            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
        }

        return $fileName;
    }
    catch (Exception $exception){
        return 'error';
    }
}

function resizeUploadedImage($pic, $size, $fileName = ''){
    try {
        $image = $pic;
        if($fileName == '') {
            $randNum = random_int(100, 999);
            if($image->getClientOriginalExtension() == '')
                $fileName = time() . $randNum . '.jpg';
            else
                $fileName = time() . $randNum . '.' . $image->getClientOriginalExtension();
        }

        foreach ($size as $item){
            $input['imagename'] = $item['name'] .  $fileName ;
            $destinationPath = $item['destination'];
            $img = \Image::make($image);
            $width = $img->width();
            $height = $img->height();

            if($item['height'] != null && $item['width'] != null){
                $ration = $width/$height;
                $nWidth = $ration * $item['height'];
                $nHeight = $item['width'] / $ration;
                if($nWidth < $item['width']) {
                    $height = $nHeight;
                    $width = $item['width'];
                }
                else if($nHeight < $item['height']) {
                    $width = $nWidth;
                    $height = $item['height'];
                }
            }
            else if($item['height'] != null || $item['width'] != null) {
                if ($item['width'] == null || $width > $item['width'])
                    $width = $item['width'];

                if ($item['height'] == null || $height > $item['height'])
                    $height = $item['height'];
            }

            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
        }

        return $fileName;
    }
    catch (Exception $exception){
        return 'error';
    }
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}


//time
function jalaliToGregorian($time){
    include_once 'jdate.php';

    $date = explode('/', $time);
    $date = jalali_to_gregorian($date[0], $date[1], $date[2]);

    return $date;
}

function gregorianToJalali($time, $splite = '-'){
    include_once 'jdate.php';

    $date = explode($splite, $time);
    $date = gregorian_to_jalali($date[0], $date[1], $date[2]);

    return $date;
}

function formatDate($date) {
    return $date[0] . $date[1] . $date[2] . $date[3] . '/'
        . $date[4] . $date[5] . '/' . $date[6] . $date[7];
}

function convertDate($created) {

    include_once 'jdate.php';

    if(count(explode(' ', $created)) == 2)
        $created = explode('-', explode(' ', $created)[0]);
    else
        $created = explode('-', $created);

    $created = gregorian_to_jalali($created[0], $created[1], $created[2]);
    return $created[0] . '/' . $created[1] . '/' . $created[2];
}

function getToday() {

    include_once 'jdate.php';

    $jalali_date = jdate("c");

    $date_time = explode('-', $jalali_date);

    $subStr = explode('/', $date_time[0]);

    $day = $subStr[0] . $subStr[1] . $subStr[2];

    $time = explode(':', $date_time[1]);

    $time = $time[0] . $time[1];

    return ["date" => $day, "time" => $time];
}

function getCurrentYear() {

    include_once 'jdate.php';

    $jalali_date = jdate("c");

    $date_time = explode('-', $jalali_date);

    $subStr = explode('/', $date_time[0]);

    return $subStr[0];
}

function convertDateToString($date, $implodeCharacter = '') {
    $subStrD = explode('/', $date);
    if(count($subStrD) == 1)
        $subStrD = explode(',', $date);

    if(strlen($subStrD[1]) == 1)
        $subStrD[1] = "0" . $subStrD[1];

    if(strlen($subStrD[2]) == 1)
        $subStrD[2] = "0" . $subStrD[2];

    return implode($implodeCharacter, $subStrD);
}

function convertTimeToString($time) {
    $subStrT = explode(':', $time);
    return $subStrT[0] . $subStrT[1];
}

function convertStringToTime($time) {
    return $time[0] . $time[1] . ":" . $time[2] . $time[3];
}

function convertStringToDate($date, $spliter = '/') {
    if($date == "")
        return $date;
    return $date[0] . $date[1] . $date[2] . $date[3] . $spliter . $date[4] . $date[5] . $spliter . $date[6] . $date[7];
}

function convertJalaliToText($date){
    $monthName = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
    $dayName = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];

    $date = convertStringToDate($date);
//    $date = convertDateToString($date);
    $year = $date[0].$date[1].$date[2].$date[3];
    $month = $date[5].$date[6];
    $day = $date[8].$date[9];

    $v = Verta();
    $date = $v->createJalali($year,$month,$day)->format('%A %d %B %Y');
    return $date;

}

function createWelcomeMsg($userId){
    $msg = '<div>مرسی از ثبت نامت دوست من.</div><div>شما بخش مهمی از کوچیتا هستید. ما سعی کردیم تا همه چیز برای شما خوب طراحی بشه. در کوچیتا شما می تونید شهر، روستا، غذای محلی،سوغات، بوم گردی ها، جاذبه ها، طبیعت گردی و هتل ها رو پیدا کنید و عکس و نظر خودتون و دوستانتون را ببینید و بهترین انتخاب رو داشته باشید.</div><a href="https://koochita.com/placeList/11/country" target="_blank" style="display: block; margin: 5px 0px;">لیست غذاهای محلی ایران</a><a href="https://koochita.com/placeList/1/country" target="_blank" style="display: block; margin: 5px 0px;">لیست جاذبه های ایران  </a><a href="https://koochita.com/placeList/12/country" target="_blank" style="display: block; margin: 5px 0px;">لیست بوم‌گردی های ایران</a><a href="https://koochita.com/placeList/6/country" target="_blank" style="display: block; margin: 5px 0px;">لیست طبیعت گردی (کمپینگ) های ایران</a><div>شما همیشه می تونید از صفحه اول سایت و یا دکمه منو، شهر یا مکان مورد نظرتون رو سریع پیدا کنید. هر جایی که رفتید در قسمت ارسال دیدگاه می تونید نظرتون رو به همراه عکس و یا فیلم برای دوستانتون به اشتراک بگذارید.اگر عکاس هستید می تونید در قسمت من عکاس هستم عکس هاتون رو آپلود کنید تا ما با اسم خودتون منتشر کنیم.  شما می تونید از لینک زیر صفحه پروفایلتون رو ببینید. به شما کمک  می‌کنه تا با دوستانتون در تماس باشید ، برنامه ریزی سفر کنید ، سفرنامه بنویسید و با دوستانتون به اشتراک بگذارید.  این امکان از منوی کناری در موبایل و منوی بالا در کامپیوتر هم در دسترسه.</div><a href="https://koochita.com/profile/index" target="_blank" style="display: block; margin: 5px 0px;">صفحه پروفایل من</a><div>هر وقت سوالی داشتید و یا نظرتون رو می خواستید به ما بگید به همین اکانت پیام بدید. ما مشتاق صحبت کردن با شما هستیم.</div><div>در آخر هم خوشحال میشیم که ما رو در اینستاگرام دنبال کنید تا از خبرهای جدید، فعالیت های تیم کوچیتا و مسابقات اطلاع پیدا کنید. آیدی اینستاگرام <a href="https://www.instagram.com/koochita_com/">@koochita_com</a></div>';

    $newMsg = new Message();
    $newMsg->senderId = 0;
    $newMsg->receiverId = $userId;
    $newMsg->message = $msg;
    $newMsg->date = verta()->format('Y-m-d');
    $newMsg->time = verta()->format('H:i');
    $newMsg->seen = 0;
    $newMsg->save();

    \Session::put(['newRegister' => true]);

    return true;
}
