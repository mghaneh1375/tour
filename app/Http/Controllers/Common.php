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
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function assetDirLocGet(){
    return __DIR__.'/../../../../assets';
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

function sortByNeeded($a, $b) {
    return $a['needed'] - $b['needed'];
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
    $view = View::make('emails.welcomeEmail', compact(['header', 'userName']));
    $html = $view->render();
    if(sendEmail($html, $header, $email))
        return true;
    else
        return false;
}

function forgetPassEmail($userName, $link, $email){
    $header = 'فراموشی رمز عبور';
    $view = View::make('emails.forgetPass', compact(['header', 'userName', 'link']));
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


function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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

