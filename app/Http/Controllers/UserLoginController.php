<?php

namespace App\Http\Controllers;

use App\models\ActivationCode;
use App\models\RetrievePas;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
    public function login()
    {
        return redirect(route('main'));
    }

    public function doLogin()
    {
        if (isset($_POST["username"]) && isset($_POST["password"])) {

            $username = makeValidInput($_POST['username']);
            $password = makeValidInput($_POST['password']);

            $credentials  = ['username' => $username, 'password' => $password];
            $credentialsPhone  = ['phone' => $username, 'password' => $password];
            $credentialsEmail  = ['email' => $username, 'password' => $password];

            if (Auth::attempt($credentials, true) || Auth::attempt($credentialsPhone, true) || Auth::attempt($credentialsEmail, true)) {
                $user = Auth::user();
                if ($user->status != 0) {
                    
                    if(!Auth::check())
                        Auth::login($user);

                    return response()->json(['status' => 'ok']);
                }
                else {
                    auth()->logout();
                    return response()->json(['status' => 'nok2']);
                }
            }
        }
        else
            return response()->json(['status' => 'nok']);
    }

    public function checkLogin() {
        if(!Auth::check()) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = makeValidInput($_POST['username']);
                $password = makeValidInput($_POST['password']);
                $credentials  = ['username' => $username, 'password' => $password];
                if (Auth::attempt($credentials, true)) {
                    $user = Auth::user();
                    if ($user->status != 0) {
                        if(!Auth::check())
                            Auth::login($user);
                    }
                }
            }
        }

        return \redirect(url($_POST['redirectUrl']));
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $back = \redirect()->back();
        if(Session::has('lang'))
            $language = Session::get('lang');

        Auth::logout();
        Session::flush();

        if(isset($language))
            Session::put('lang', $language);

        return \redirect()->back();
    }

    public function checkEmail()
    {
        if (isset($_POST["email"]) && $_POST['email'] != '') {
            if(\auth()->check())
                echo (User::where('email',makeValidInput($_POST["email"]))->where('id', '!=', \auth()->user()->id)->count() > 0) ? 'nok' : 'ok';
            else
                echo (User::where('email',makeValidInput($_POST["email"]))->count() > 0) ? 'nok' : 'ok';
            return;
        }
        echo "nok1";
        return;
    }

    public function checkRegisterData(Request $request)
    {
        if(isset($request->name) && isset($request->emailPhone)){
            $nameErr = false;
            $emailErr = false;
            $phoneErr = false;

            if(strpos($request->emailPhone, '@') > -1) {
                $checkEmail = User::where('email', $request->emailPhone)->first();
                if($checkEmail != null)
                    $emailErr = true;
            }
            else{
                $phone = convertNumber('en', $request->emailPhone);
                $checkPhone = User::where('phone', $phone)->first();
                if($checkPhone != null)
                    $phoneErr = true;
            }

            $checkName = User::where('username', $request->name)->first();
            if($checkName != null)
                $nameErr = true;

            echo json_encode(['status' => 'ok', 'nameErr' => $nameErr, 'phoneErr' => $phoneErr, 'emailErr' => $emailErr]);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function checkUserName()
    {
        if (isset($_POST["username"])) {
            $username = makeValidInput($_POST['username']);
            $invitationCode = "";

            if(\auth()->check()){
                if(User::where('username',$username)->where('id', '!=', \auth()->user()->id)->count() > 0)
                    echo 'nok1';
                else
                    echo 'ok';
            }
            else {
                if (isset($_POST["invitationCode"]))
                    $invitationCode = makeValidInput($_POST["invitationCode"]);

                if (User::where('username',$username)->count() > 0)
                    echo "nok1";
                else if (!empty($invitationCode) && User::where('invitationCode',$invitationCode)->count() == 0)
                    echo 'nok';
                else
                    echo 'ok';
            }

            return;
        }
        echo "nok";
    }

    public function checkPhoneNum(Request $request)
    {
        if (isset($request->phoneNum)) {
            $sendCode = false;
            $phoneNum = makeValidInput($request->phoneNum);
            $phoneNum = convertNumber('en', $phoneNum);

            if(\auth()->check()){
                if (User::where('phone', $phoneNum)->where('id', '!=', \auth()->user()->id)->count() > 0)
                    echo 'nok';
                else {
                    if(isset($request->sendCode) && $request->sendCode == 1 && $phoneNum != \auth()->user()->phone)
                        $sendCode = true;
                    else
                        echo 'ok';
                }
            }
            else {
                if (User::where('phone', $phoneNum)->count() > 0)
                    echo json_encode(['status' => 'nok']);
                else
                    $sendCode = true;
            }

            if($sendCode){
                $activation = ActivationCode::where('phoneNum', $phoneNum)->first();
                if ($activation != null) {
                    if((90 - time() + $activation->sendTime) < 0)
                        $this->resendActivationCode();
                    else
                        echo json_encode(['status' => 'ok', 'reminder' => (90 - time() + $activation->sendTime)]);
                    return;
                }

                $code = createCode();
                while (ActivationCode::where('code', $code)->count() > 0)
                    $code = createCode();

                if ($activation == null) {
                    $activation = new ActivationCode();
                    $activation->phoneNum = $phoneNum;
                }

                $msgId = sendSMS($phoneNum, $code, 'sms');
                if ($msgId == -1) {
                    echo json_encode(['status' => 'nok3']);
                    return;
                }

                $activation->sendTime = time();
                $activation->code = $code;
                try {
                    $activation->save();
                    echo json_encode(['status' => 'ok', 'reminder' => 90]);
                } catch (\Exception $x) {
                }
            }
            return;
        }

        echo json_encode(['status' => 'nok']);
    }

    public function checkReCaptcha()
    {
//        echo 'ok';
//        return;

        if (isset($_POST["captcha"])) {
            $response = $_POST["captcha"];
            $privatekey = "6LfiELsUAAAAALYmxpnjNQHcEPlhQdbGKpNpl7k4";

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$privatekey}&response={$response}");
            $captcha_success = json_decode($verify);
            if ($captcha_success->success == true)
                echo "ok";
            else
                echo "nok2";

            return;
        }
        echo "nok";
    }

    public function checkActivationCode()
    {
        if (isset($_POST["activationCode"]) && isset($_POST["phoneNum"])) {
            $phoneNum = convertNumber('en', $_POST["phoneNum"]);
            $code = convertNumber('en', $_POST["activationCode"]);
            $condition = ['code' => $code, 'phoneNum' => $phoneNum];
            $activation = ActivationCode::where($condition)->first();
            if ($activation != null)
                return response()->json(['status' => "ok"]);
            else
                return response()->json(['status' => "err1"]);
        }
        else
            return response()->json(['status' => "nok"]);
    }

    public function resendActivationCode()
    {
        if (isset($_POST["phoneNum"])) {

            $phoneNum = makeValidInput($_POST["phoneNum"]);
            $activation = ActivationCode::where('phoneNum', $phoneNum)->first();

            if ($activation != null) {

                $t = $activation->sendTime;
                if (time() - $t < 90) {
                    echo json_encode(['status' => 'nok', 'reminder' => (90 - time() + $t)]);
                    return;
                } else {

                    $code = createCode();
                    while (ActivationCode::where('code', $code)->count() > 0)
                        $code = createCode();

                    $msgId = sendSMS($phoneNum, $code, 'sms');

                    if ($msgId == -1) {
                        echo json_encode(['status' => 'nok3', 'reminder' => 90]);
                        return;
                    }

                    $activation->sendTime = time();
                    $activation->code = $code;
                    try {
                        $activation->save();
                        echo json_encode(['status' => 'ok', 'reminder' => 90]);;
                        return;
                    } catch (\Exception $x) {
                    }
                }
            }
            echo json_encode(['status' => 'nok', 'reminder' => 90]);
        }
    }
    public function retrievePasByPhone()
    {
        if (isset($_POST["phone"])) {
            $phoneNum = convertNumber('en', $_POST["phone"]);
            $user = User::where('phone', makeValidInput($phoneNum))->first();
            if ($user != null) {
                $activeCode = ActivationCode::where('userId', $user->id)
                                            ->where('phoneNum', $phoneNum)
                                            ->first();
                if ($activeCode != null && (90 - time() + $activeCode->sendTime) > 0)
                    return response()->json(['status' => 'ok', 'reminder' => 90 - time() + $activeCode->sendTime]);

                $code = createCode();
                while (ActivationCode::where('code', $code)->count() > 0)
                    $code = createCode();

                $msgId = sendSMS($user->phone, $code, 'sms');
                if ($msgId != -1) {
                    $activeCode = ActivationCode::where('userId', $user->id)->where('phoneNum', $phoneNum)->first();
                    if($activeCode == null) {
                        $activeCode = new ActivationCode();
                        $activeCode->userId = $user->id;
                        $activeCode->phoneNum = $user->phone;
                    }
                    $activeCode->sendTime = time();
                    $activeCode->code = $code;
                    $activeCode->save();

                    return response()->json(['status' => 'ok', 'reminder' => 90]);
                }
                else
                    return response()->json(['status' => 'nok2']);
            }
            else
                return response()->json(['status' => 'nok1']);
        }
        else
            return response()->json(['status' => 'nok']);
    }

    public function loginWithGoogle()
    {
        $url = route('main');
        if(isset($_GET['state']))
            $url = $_GET['state'];

        if (Auth::check())
            return Redirect::to($url);

        if (isset($_GET['code'])) {

            require_once __DIR__ . '/glogin/libraries/Google/autoload.php';

            //Insert your cient ID and sexcret
            //You can get it from : https://console.developers.google.com/
            $client_id = config('app.GOOGLE_CLIENT_ID');
//            $client_secret = '8NM4weptz-Pz-6gbolI5J0yi';
            $client_secret = config('app.GOOGLE_CLIENT_SECRET2');
            $redirect_uri = route('loginWithGoogle');
            $redirect_uri = str_replace('http://', 'https://', $redirect_uri);

            /************************************************
             * Make an API request on behalf of a user. In
             * this case we need to have a valid OAuth 2.0
             * token for the user, so we need to send them
             * through a login flow. To do this we need some
             * information from our API console project.
             ************************************************/
            $client = new \Google_Client();
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri($redirect_uri);
            $client->addScope("email");
            $client->addScope("profile");

            /************************************************
             * When we create the service here, we pass the
             * client to it. The client then queries the service
             * for the required scopes, and uses that when
             * generating the authentication URL later.
             ************************************************/
            $service = new \Google_Service_Oauth2($client);

            /************************************************
             * If we have a code back from the OAuth 2.0 flow,
             * we need to exchange that with the authenticate()
             * function. We store the resultant access token
             * bundle in the session, and redirect to ourself.
             */
            $client->authenticate($_GET['code']);

            $user = $service->userinfo->get(); //get user info
            $userCheckEmail = User::where('email', $user->email)->first();
            if($userCheckEmail != null){
                if($userCheckEmail->googleId == null){
                    $userCheckEmail->googleId = $user->id;
                    $userCheckEmail->password = Hash::make($user->id);
                    try {
                        $userCheckEmail->save();
                    }
                    catch (\Exception $x) {
                    }
                }
            }
            else{

                $usernameCheck =  explode('@', $user->email)[0];
                while (true){
                    $checkUser = \App\User::where('username', $usernameCheck)->first();
                    if($checkUser == null)
                        break;
                    else
                        $usernameCheck = explode('@', $user->email)[0] .  random_int(1000, 9999);
                }

                $userCheckEmail = new User();
                $userCheckEmail->username = $usernameCheck;
                $userCheckEmail->password = Hash::make($user->id);
                $name = explode(' ', $user->name);
                if(isset($name[0]))
                    $userCheckEmail->first_name = $name[0];
                if(isset($name[1]))
                    $userCheckEmail->last_name = $name[1];
                $userCheckEmail->email = $user->email;
                $userCheckEmail->picture = $user->picture;
                $userCheckEmail->googleId = $user->id;
                try {
                    $userCheckEmail->save();
                    createWelcomeMsg($userCheckEmail->id);
                }
                catch (\Exception $x) {
                }
            }
            Auth::attempt(['username' => $userCheckEmail->username, 'password' => $user->id], true);
        }

        return redirect(url($url));
    }

}
