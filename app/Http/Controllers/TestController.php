<?php

namespace App\Http\Controllers;

use App\models\AbstractLog;
use App\models\ActivationCode;
use App\models\Activity;
use App\models\Adab;
use App\models\Amaken;
use App\models\Block;
use App\models\Hotel;
use App\models\LogModel;
use App\models\Majara;
use App\models\Message;
use App\models\Opinion;
use App\models\PicItem;
use App\models\PlaceStyle;
use App\models\Restaurant;
use App\models\RetrievePas;
use App\models\User;
use Auth;
use CURLFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller {

    function getOS() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;

    }

    function getBrowser() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        =   "Unknown Browser";

        $browser_array  =   array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/edge/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser    =   $value;
            }

        }
        return $browser;

    }

    static $cookie;

    public function start($c) {

        $user_os        =   $this->getOS();
        $user_browser   =   $this->getBrowser();

        $testClass = new TestController();

        $methods = [];

        foreach (get_class_methods($testClass) as $method) {
            if (strpos($method, "test") === 0)
                $methods[count($methods)] = $method;
        }

        $totalUsers = User::all()->count();
        $date = date('Ymd', strtotime('-7 days'));
        $inLastWeek = DB::select('select COUNT(*) as countNum from users where replace(substr(created_at, 1, 10), "-", "") > ' . $date);

        if($inLastWeek == null && count($inLastWeek) == 0)
            $inLastWeek = 0;
        else
            $inLastWeek = $inLastWeek[0]->countNum;

        $date = getPast('-7 days')['date'];
//        $boys = AboutMe::where('sex', '=', 1)->count();
//        $girls = AboutMe::where('sex', '=', 0)->count();

        $totalSeen = AbstractLog::all()->sum('counter');
        $lastWeekSeen = AbstractLog::where('date', '>', $date)->sum('counter');

        $date = getPast('-30 days')['date'];
        $logs = DB::select('select sum(counter) as counter, url from abstractLog WHERE date > ' . $date . ' group by(url)');

        $activityId = Activity::whereName('مشاهده')->first()->id;
        $topLogs = DB::select('SELECT l1.placeId, l1.kindPlaceId, count(*) as countNum FROM log l1, log l2 WHERE l1.activityId = ' . $activityId . ' and l1.activityId = l2.activityId and l1.placeId = l2.placeId and l1.kindPlaceId = l2.kindPlaceId and l1.id < l2.id GROUP BY(l1.placeId) ORDER by countNum DESC LIMIT 0, 10');

        foreach ($topLogs as $itr) {
            switch ($itr->kindPlaceId){
                case 1:
                    $itr->name = Amaken::whereId($itr->placeId)->name;
                    break;
                case 3:
                    $itr->name = Restaurant::whereId($itr->placeId)->name;
                    break;
                case 4:
                    $itr->name = "sad";
                    break;
                case 6:
                    $itr->name = Majara::whereId($itr->placeId)->name;
                    break;
                case 8:
                    $itr->name = Adab::whereId($itr->placeId)->name;
                    break;
            }
        }

        return view('test', array('methods' => $methods, 'cookie' => $c, 'totalUsers' => $totalUsers, 'inLastWeek' => $inLastWeek,
            'boys' => $boys, 'girls' => $girls, 'totalSeen' => $totalSeen, 'lastWeekSeen' => $lastWeekSeen, 'logs' => $logs,
            'topLogs' => $topLogs));
    }

    public function methodTest() {

        if(!isset($_POST["method"]) || !isset($_POST["cookie"]))
            return;

        TestController::$cookie = makeValidInput($_POST["cookie"]);

        $testClass = new TestController();
        $requestedMethod = makeValidInput($_POST["method"]);

        foreach (get_class_methods($testClass) as $method) {
            if (strpos($method, "test") === 0 && $method == $requestedMethod) {
                echo call_user_func(array($testClass, $method));
            }
        }
    }

    public function testChangePas() {

        $oldPas = Auth::user();

        $pas = '22721969';
        $user = Auth::user();
        $user->password = Hash::make($pas);
        $user->save();

        $data = [
            'oldPassword' => $pas,
            'newPassword' => '22743823',
            'repeatPassword' => '22743824'
        ];

        $ch = curl_init(route('changePas'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Cookie: ' . TestController::$cookie]);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);  // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200 && $httpCode != 302) {
            $user->password = $oldPas;
            $user->save();
            return $httpCode;
        }

        if(Hash::check('22743823', Auth::user()->password)) {
            $user->password = $oldPas;
            $user->save();
            return "pas and confirm are same but accepted";
        }

        $data = [
            'oldPassword' => $pas . "adsa",
            'newPassword' => '22743823',
            'repeatPassword' => '22743823'
        ];

        $ch = curl_init(route('changePas'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Cookie: ' . TestController::$cookie]);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);  // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200 && $httpCode != 302) {
            $user->password = $oldPas;
            $user->save();
            return $httpCode;
        }

        if(Hash::check('22743823', Auth::user()->password)) {
            $user->password = $oldPas;
            $user->save();
            return "pas and confirm are same but accepted";
        }

        $data = [
            'oldPassword' => $pas,
            'newPassword' => '22743823',
            'repeatPassword' => '22743823'
        ];

        $ch = curl_init(route('changePas'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Cookie: ' . TestController::$cookie]);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);  // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


        if ($httpCode != 200 && $httpCode != 302) {
            $user->password = $oldPas;
            $user->save();
            return $httpCode;
        }

        if(Hash::check('22743823', Auth::user()->password)) {
            $user->password = $oldPas;
            $user->save();
            return "ok";
        }

        $user->password = $oldPas;
        $user->save();
        return "password should change but ...";

    }
}