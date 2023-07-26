<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function username()
    {
        return 'mobile';
    }

    public function signIn($msg = "") {
        return view('login', ['msg' => $msg]);
    }

    public function signOut() {
        Auth::logout();
        return view('login', ["msg" => ""]);
    }

    public function doLogin(Request $request) {

        $request->validate([
            'phone' => 'required|regex:/(09)[0-9]{9}/',
            "password" => "required"
        ]);

        $user = User::wherePhone($request["phone"])->first();
        if($user == null)
            return $this->signIn("نام کاربری و یا رمزعبور اشتباه است.");

        if($request["password"] != "123456")
            return $this->signIn("نام کاربری و یا رمزعبور اشتباه است.");

        Auth::login($user);
        return Redirect::route('home');
    }

    public function activation_code(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/(09)[0-9]{9}/',
        ]);

        $user = User::wherePhone($request['phone'])->firstOr(function () use ($request) {
            $user = new User;
            $user->phone = $request['phone'];
            try {
                $user->save();
            }
            catch (\Exception $x) {
                dd($x);
            }
            return $user;
        });

        if ($user->vc_expired_at != null && $user->vc_expired_at > Carbon::now()) {
            return response()->json([
                'status' => 1,
                'message' => 'کد احراز هویت قبلی شما هنوز باطل نشده است.'
            ]);
        }

        // $user->verification_code = rand(1000, 9999);
        $user->verification_code = 1111;
        $user->vc_expired_at = Carbon::now()->addMinutes(2);
        $user->save();

        self::sendSMS($user->phone, $user->verification_code, 'app');

        return response()->json([
            'status' => 0,
//            'verification_code' => $user->verification_code
        ]);
    }

    public function login(Request $request) {

        $request->validate([
            'phone' => ['required', Rule::exists('users')],
            'verification_code' => 'required|string',
        ]);

        $user = User::wherePhone($request['phone'])->first();

        if ($user->vc_expired_at < Carbon::now()) {
            return response()->json([
                'status' => 2,
                'message' => __('auth.expired')
            ]);
        }

        if ($user->verification_code != $request['verification_code']) {
            return response()->json([
                'status' => 3,
                'message' => __('auth.not-match')
            ]);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        $token = self::createToken();

        $apiRes = Http::asForm()->withoutVerifying()->post(self::$apiBaseUrl . "checkPhone", [
            "token" => $token[0],
            "time" => $token[1],
            "phone" => $request["phone"]
        ]);

        if($apiRes->successful()) {
            $apiRes = $apiRes->json();
            if(isset($apiRes["status"]) && $apiRes["status"] == "0") {
                $user->name = $apiRes["username"];
                $user->save();
            }
        }

        return response()->json([
            'status' => 0,
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 0,
        ]);
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function version()
    {
        return response()->json([
            'status' => 0,
            'version' => '0.1.0'
        ]);
    }

    public function versionWithAuth(Request $request) {
        return response()->json([
            'status' => 0,
            'version' => '0.1.0',
            'user' => $request->user()
        ]);
    }

    public function chooseUsername(Request $request) {

        $request->validate([
            "username" => "required"
        ]);

        $user = $request->user();
        $token = self::createToken();
        $apiRes = Http::asForm()->withoutVerifying()->post(self::$apiBaseUrl . "addUser", [
            "token" => $token[0],
            "time" => $token[1],
            "data" => $request["username"],
            "phone" =>  $user->phone,
        ]);

        if(!$apiRes->successful()) {
            return response()->json([
                "status" => "-1"
            ]);
        }

        $apiRes = $apiRes->json();
        if(!isset($apiRes["status"]) || $apiRes["status"] != "0") {
            return response()->json([
                "status" => "-1"
            ]);
        }

        $user->name = $request["username"];
        $user->save();

        return response()->json([
            "status" => "0"
        ]);

    }

}
