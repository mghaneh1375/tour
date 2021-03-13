<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\ActivationCode;
use App\models\Business\Business;
use App\models\Business\BusinessACL;
use App\models\Business\BusinessMadarek;
use App\models\Business\BusinessPic;
use App\models\DefaultPic;
use App\models\RetrievePas;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

require_once(__DIR__.'/../glogin/libraries/Google/autoload.php');

class MainPanelBusinessController extends Controller {

    public function loginPage() {

        $googleClient_id = '774684902659-1tdvb7r1v765b3dh7k5n7bu4gpilaepe.apps.googleusercontent.com';
        $googleClient_secret = 'ARyU8-RXFJZD5jl5QawhpHne';
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

        return view('panelBusiness.pages.auth.login', compact(['authUrl']));
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

//        $msgId = sendSMS($_phone, $code, 'sms');
//        if ($msgId == -1)
//            return 'error';

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
                    RetrievePas::where('uId', $user->id)->delete();
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

                Auth::loginUsingId($user->id);
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

    public function mainPage() {
        return view('panelBusiness.pages.empty');
    }

    public function completeUserInfo() {
        return view('panelBusiness.pages.userInfoSetting');
    }

    public function editUserInfo(Request $request) {

        $request->validate([
            "firstName" => "required",
            "lastName" => "required",
            "nid" => "required",
            "isForeign" => ["required", Rule::in(["true", "false"])],
            "phone" => "required|regex:/(09)[0-9]{9}/",
            "email" => ["required"],
            "birthDay" => ["required", "regex:/^(13)\d\d(\/)(0[1-9]|1[012])(\/)(0[1-9]|[12][0-9]|3[01])/"]
        ], $messages=[
            "isForeign.in" => "لطفا مشخص کنید که اتباع هستید یا خیر.",
            "phone.regex" => "شماره همراه وارد شده معتبر نمی باشد.",
            "birthDay.regex" => "تاریخ تولد وارد شده معتبر نمی باشد.",
        ]);

        if($request["isForeign"] == "false") {
            if(!_custom_check_national_code($request["nid"]))
                return response()->json([
                    "status" => "nok",
                    "msg" => "شماره ملی وارد شده معتبر نمی باشد."
                ]);
        }

        if($request["nid"] != Auth::user()->codeMeli &&
            User::whereCodeMeli($request["nid"])->count() > 0) {
            return response()->json([
                "status" => "nok",
                "msg" => ($request["isForeign"] == "false") ? "شماره ملی وارد شده در سامانه موجود است." :
                    "شماره پاسپورت وارد شده در سامانه موجود است."
            ]);
        }

        if($request["phone"] != Auth::user()->phone &&
            User::wherePhone($request["phone"])->count() > 0) {
            return response()->json([
                "status" => "nok",
                "msg" => "شماره همراه وارد شده در سامانه موجود است."
            ]);
        }

        if($request["email"] != Auth::user()->email &&
            User::whereEmail($request["email"])->count() > 0) {
            return response()->json([
                "status" => "nok",
                "msg" => "ایمیل وارد شده در سامانه موجود است."
            ]);
        }

//        if($request["phone"] != Auth::user()->phone) {
//
//        }

        $user = Auth::user();
        $user->first_name = $request["firstName"];
        $user->last_name = $request["lastName"];
        $user->codeMeli = $request["nid"];
        $user->phone = $request["phone"];
        $user->birthday = $request["birthDay"];
        $user->email = $request["email"];
        $user->isForeign = ($request["isForeign"] == "true");
        $user->save();

        return response()->json([
            "status" => "ok"
        ]);

    }

    public function viewInvitation($business) {

        $acl = BusinessACL::whereUserId(Auth::user()->id)->whereBusinessId($business)->first();

        if($acl == null)
            return view('general.noAccess');

        if($acl->accept)
            return redirect(route('myBusiness', ['business' => $business]));

        return view('panelBusiness.pages.viewInvitation', ['aclId' => $acl->id]);
    }

    public function acceptInvitation(BusinessACL $businessACL) {

        if($businessACL->userId != Auth::user()->id)
            return view('general.noAccess');

        if(!$businessACL->accept) {
            $businessACL->accept = true;
            $businessACL->save();
        }

        return redirect(route('myBusiness', ['business' => $businessACL->businessId]));
    }

    public function create() {
        return view('panelBusiness.pages.create');
    }

    public function getToBusinessManagementPage(){
        return view('panelBusiness.pages.Agency.agencyMainPage');
    }

}
