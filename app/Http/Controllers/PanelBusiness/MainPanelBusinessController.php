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
use App\models\FormCreator\UserAsset;
use App\models\Business\BusinessMadarek;
use App\models\Business\BusinessPic;
use App\models\DefaultPic;
use App\models\RetrievePas;
use App\models\FormCreator\Asset;
use App\Http\Resources\UserAssetDigest;

use Illuminate\Support\Facades\Hash;

class MainPanelBusinessController extends Controller {

    public function mainPage() {
        $assets = Asset::all();
        $output = [];
        $uId = Auth::user()->_id;
 
        
        foreach($assets as $asset) {
            
            $userAssets = $asset->user_assets()->where('user_id', $uId)->get();
            
            if(count($userAssets) == 0)
                continue;

            $tmp = UserAssetDigest::collection($userAssets);

            
            foreach($tmp as $itr) {
                $itr['asset'] = $asset->name;
                $itr['asset_id'] = $asset->id;
                $itr['type'] = $asset->type;
                if($asset->type == 'Authentication'){
                }else{
                    array_push($output, $itr);
                }   
            }
        }


        $myBusiness = $output;
        foreach($myBusiness as $mb){
            $mb->url = route('businessManagement.panel', ['business' => $mb->id]);
        }
        $fileVersions = 14;
        $newTicketCount = 0;
        $newNotificationCount = 0;

        return view('panelBusiness.pages.mainPage', compact(['myBusiness', 'fileVersions', 'newTicketCount', 'newNotificationCount']));
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

        $acl = BusinessACL::where('userId', Auth::user()->_id)->where('businessId', $business)->first();

        if($acl == null)
            return view('general.noAccess');

        if($acl->accept)
            return redirect(route('myBusiness', ['business' => $business]));

        return view('panelBusiness.pages.viewInvitation', ['aclId' => $acl->id]);
    }

    public function acceptInvitation(BusinessACL $businessACL) {

        if($businessACL->userId != Auth::user()->_id)
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
