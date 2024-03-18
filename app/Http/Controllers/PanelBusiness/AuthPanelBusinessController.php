<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\ActivationCode;
use App\models\DefaultPic;
use App\models\RetrievePas;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once(__DIR__.'/../glogin/libraries/Google/autoload.php');

class AuthPanelBusinessController extends Controller
{

	private function getPublicKeys()
    	{

	$response = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtx5XIQ7QRnKZRRDexf7X
zZxMhf+hE807qwi0Ul1WWcLt5be7zsHGdOsn3BGGB8BAmeA54qespU7MJFNIW21l
Qb/XqexShrsiOvVxs8Z75RZfA2UjYwV1tHW58MTIgRdER67aJj0hIofgOFztB0CN
RHaehltR3up3tEPnz0HxsuSESmPccU86YJUKyu2QUW7hcrj0yUBeFiFrDhRKel5O
9+X862FOE+aSWAaX69hTUTf8CDSXpAlH93xX27Uz5h/bTbSIB2fXbsINe0d4HdX2
TQceyBQe+LoNmIfrnTPjyvf67ICGYFkCH8G7zF9851o63sbquWKA6NQ90ydkV/hO
twIDAQAB
-----END PUBLIC KEY-----
EOD;

	return $response;

    }

	public function myLogin(Request $request) {


		if(!$request->has('token'))
			return abort(401);

		$token = $request['token'];
		$payload = JWT::decode($token, new Key($this->getPublicKeys(), 'RS256'));

		if($payload == null || !isset($payload->user_name))
			return abort(401);

		return response()->json(['status' => 'ok', 'data' => $payload->user_name]);
	}


	public function loginCallBack(Request $request) {

		$user = User::where('username', $request->query('uuid'))->first();
		if($user == null)
			return abort(401);

		Auth::loginUsingId($user->_id, TRUE);
		return Redirect::to('/');

	}


    public function loginPage() {

        $googleClient_id = config('app.GOOGLE_CLIENT_ID');
        $googleClient_secret = config('app.GOOGLE_CLIENT_SECRET');
        $redirect_uri = route('businessPanel.loginWithGoogle');
        $redirect_uri = str_replace('http://', 'https://', $redirect_uri);

        $client = new \Google_Client();
        $client->setClientId($googleClient_id);
        $client->setClientSecret($googleClient_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");

        $service = new \Google_Service_Oauth2($client);
        $authUrl = $client->createAuthUrl();

        $url = $_SERVER['REQUEST_URI'];

        $fileVersions = 15;

        return view('panelBusiness.pages.auth.login', compact(['authUrl', 'fileVersions']));
    }
    private function sendVerifyCodeForPhone($_phone){
        $activation = ActivationCode::where('phoneNum', $_phone)->first();
        if ($activation != null) {
            if((90 - time() + $activation->sendTime) > 0)
                return 90 - time() + $activation->sendTime;
        }

        $code = createCode();

        if ($activation == null) {
            $activation = new ActivationCode();
            $activation->phoneNum = $_phone;
        }

        $msgId = sendSMS($_phone, $code, 'sms');
        if ($msgId == -1)
            return 'error';

        $activation->sendTime = time();
        $activation->code = $code;
        try {
            $activation->save();
            return 90;
        } catch (\Exception $x) {
            return 'error';
        }
    }
    public function checkRegisterInputs(Request $request){
        if(isset($request->username) && isset($request->phone)){
            $username = makeValidInput($request->username);
            $phone = convertNumber('en', makeValidInput($request->phone));
            if(strlen($phone) == 11 && $phone[0] == 0 && $phone[1] == 9){
                $checkUsername = User::where('username', $username)->first();
                $checkPhone = User::where('phone', $phone)->first();

                if($checkPhone != null)
                    return response()->json(['status' => 'error3']);
                if($checkUsername != null)
                    return response()->json(['status' => 'error4']);


                $remainingTime = $this->sendVerifyCodeForPhone($phone);
                if($remainingTime == 'error')
                    return response()->json(['status' => 'error5']);
                else
                    return response()->json(['status' => 'ok', 'result' => $remainingTime]);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function doSendVerificationPhoneCode(Request $request){
        if(isset($request->phone)){
            $phone = convertNumber('en', makeValidInput($request->phone));
            if(strlen($phone) == 11 && $phone[0] == 0 && $phone[1] == 9){

                $remainingTime = $this->sendVerifyCodeForPhone($phone);
                if($remainingTime == 'error')
                    return response()->json(['status' => 'error5']);
                else
                    return response()->json(['status' => 'ok', 'result' => $remainingTime]);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function doLogin(Request $request){

        if(isset($request->username) && isset($request->password)){
            $username = makeValidInput($request->username);
            $password = makeValidInput($request->password);

            $credentials  = ['username' => $username, 'password' => $password];
            $credentialsPhone  = ['phone' => $username, 'password' => $password];
            $credentialsEmail  = ['email' => $username, 'password' => $password];

            if (Auth::attempt($credentials, true) ||
                Auth::attempt($credentialsPhone, true) ||
                Auth::attempt($credentialsEmail, true))
            {
                $user = Auth::user();
                if ($user->status != 0) {
                    return redirect(route('businessPanel.mainPage'));
                }
                else {
                    auth()->logout();
                    return redirect(route('businessPanel.loginPage'))->with(['error' => 'blocked']);
                }
            }
        }

        return redirect(route('businessPanel.loginPage'))->with(['error' => 'wrongInput']);
    }
    public function doRegister(Request $request) {

        if(isset($request->username) && isset($request->phone) && isset($request->password)){
            $username = makeValidInput($request->username);
            $phone = convertNumber('en', makeValidInput($request->phone));
            $password = makeValidInput($request->password);
            $verifyCode = makeValidInput($request->verifyCode);

            if(strlen($phone) == 11 && $phone[0] == 0 && $phone[1] == 9){
                $checkUsername = User::where('username', $username)->first();
                $checkPhone = User::where('phone', $phone)->first();

                if($checkPhone != null)
                    return response()->json(['status' => 'error3']);
                if($checkUsername != null)
                    return response()->json(['status' => 'error4']);


                $activation = ActivationCode::where('phoneNum', $phone)->first();
                if($activation == null)
                    return response()->json(['status' => 'doResendCode']);

                if($activation->code != $verifyCode)
                    return response()->json(['status' => 'notSame']);

                if((90 - time() + $activation->sendTime) <= 0)
                    return response()->json(['status' => 'notTime']);


                $inviteCode = generateRandomString(6);
                while(User::where('invitationCode', $inviteCode)->count() > 0)
                    $inviteCode = generateRandomString(6);

                $user = new User();
                $user->username = $username;
                $user->password = Hash::make($password);
                $user->phone = $phone;
                $user->invitationCode = $inviteCode;
                $user->picture = DefaultPic::all()->random(1)[0]->id;
                $user->save();

                $activation->delete();

                Auth::login($user);

                return response()->json(['status' => 'ok']);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function doLogOut()
    {
        Auth::logout();
        return redirect(route("businessPanel.loginPage"));
    }

    public function loginWithGoogle()
    {
        $url = route('main');
        if(isset($_GET['state']))
            $url = $_GET['state'];

        if (Auth::check())
            return \Redirect::to($url);

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
                    $userCheckEmail->password = \Hash::make($user->id);
                    try {
                        $userCheckEmail->save();
                    }
                    catch (Exception $x) {
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
                $userCheckEmail->password = \Hash::make($user->id);
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
                catch (Exception $x) {
                }
            }
            Auth::attempt(['username' => $userCheckEmail->username, 'password' => $user->id], true);
        }

        return redirect(url($url));
    }

}
