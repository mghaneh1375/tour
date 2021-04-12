<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\Business\BusinessACL;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\models\ActivationCode;
use App\models\Business\Business;
use App\models\Business\BusinessMadarek;
use App\models\Business\BusinessPic;
use App\models\DefaultPic;
use App\models\RetrievePas;
use Illuminate\Support\Facades\Hash;

require_once(__DIR__.'/../glogin/libraries/Google/autoload.php');

class MainPanelBusinessController extends Controller {

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
            User::where('codeMeli', $request["nid"])->count() > 0) {
            return response()->json([
                "status" => "nok",
                "msg" => ($request["isForeign"] == "false") ? "شماره ملی وارد شده در سامانه موجود است." :
                    "شماره پاسپورت وارد شده در سامانه موجود است."
            ]);
        }

        if($request["phone"] != Auth::user()->phone &&
            User::where('Phone', $request["phone"])->count() > 0) {
            return response()->json([
                "status" => "nok",
                "msg" => "شماره همراه وارد شده در سامانه موجود است."
            ]);
        }

        if($request["email"] != Auth::user()->email &&
            User::where('email', $request["email"])->count() > 0) {
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

        $acl = BusinessACL::where('userId', Auth::user()->id)->where('businessId', $business)->first();

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
