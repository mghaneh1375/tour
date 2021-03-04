<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\Business\Business;
use App\models\Business\BusinessACL;
use App\models\Business\BusinessMadarek;
use App\models\Business\BusinessPic;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MainPanelBusinessController extends Controller {

    public function mainPage() {
        return view('panelBusiness.pages.empty');
    }

    public function uploadPic(Request $request, Business $business) {

        $request->validate([
            "field" => ["required", Rule::in(["additionalValue", "pic", "logo", "madarek"])],
            "pic" => "image"
        ]);

        $path = $request->pic->store('public');
        $path = str_replace('public/', '', $path);

        if($request["field"] == "pic") {

            if(BusinessPic::whereBusinessId($business->id)->count() >= 4) {
                return response()->json([
                    "status" => "nok",
                    "msg" => "تعداد تصاویر آپلود شده بیش از حد مجاز است."
                ]);
            }

            $businessPic = new BusinessPic();
            $businessPic->businessId = $business->id;
            $businessPic->pic = $path;
            $businessPic->save();

            return response()->json([
                "status" => "ok",
                "id" => $businessPic->id
            ]);
        }

        else if($request["field"] == "madarek") {

            if(!$request->has("idx")) {
                return response()->json([
                    "status" => "nok",
                    "msg" => "لطفا مشخص کنید درباره کدام عضو تصمیم گیری می کنید."
                ]);
            }

            $idx = $request["idx"];
            $businessMadarek = BusinessMadarek::whereBusinessId($business->id)->whereIdx($idx)->first();
            if($businessMadarek == null) {
                $businessMadarek = new BusinessMadarek();
                $businessMadarek->businessId = $business->id;
                $businessMadarek->idx = $idx;
            }

            $selected = 1;

            if($businessMadarek->pic1 == null || empty($businessMadarek->pic1))
                $businessMadarek->pic1 = $path;
            else if($businessMadarek->pic2 == null || empty($businessMadarek->pic2)) {
                $businessMadarek->pic2 = $path;
                $selected = 2;
            }
            else
                return response()->json([
                    "status" => "nok",
                    "msg" => "برای این عضو دیگر نمی توان عکسی آپلود کرد."
                ]);

            $businessMadarek->save();
            return response()->json([
                "status" => "ok",
                "id" => $selected
            ]);
        }
        $business[$request["field"]] = $path;
        $business->save();

        return response()->json(["status" => "ok", "id" => -1]);
    }

    public function deleteMadrak(Request $request, Business $business) {

        $request->validate([
            "idx" => "required|integer"
        ], $messages=[
            "idx.required" => "لطفا آی دی مورد نظر را وارد کنید.",
            "idx.integer" => "آی دی مورد نظر نامعتبر است."
        ]);

        $idx = $request["idx"];
        $businessPic = BusinessMadarek::whereBusinessId($business->id)->whereIdx($idx)->first();

        if($businessPic->pic1 != null && !empty($businessPic->pic1)) {
            $pic = $businessPic->pic1;
            if (file_exists(__DIR__ . '/../../../../storage/app/public/' . $pic))
                unlink(__DIR__ . '/../../../../storage/app/public/' . $pic);
        }

        if($businessPic->pic2 != null && !empty($businessPic->pic2)) {
            $pic = $businessPic->pic2;
            if (file_exists(__DIR__ . '/../../../../storage/app/public/' . $pic))
                unlink(__DIR__ . '/../../../../storage/app/public/' . $pic);
        }

        $businessPic->delete();
        return response()->json([
            "status" => "ok"
        ]);
    }

    public function deletePic(Request $request, Business $business) {

        $request->validate([
            "field" => ["required", Rule::in(["additionalValue", "pic", "logo", "madarek"])]
        ]);

        if($request["field"] == "additionalValue" || $request["field"] == "logo") {

            if (file_exists(__DIR__ . '/../../../../storage/app/public/' . $business[$request["field"]])) {
                unlink(__DIR__ . '/../../../../storage/app/public/' . $business[$request["field"]]);
            }

            $business[$request["field"]] = null;
            $business->save();
        }

        else if($request["field"] == "pic") {

            if(!$request->has("id"))
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'لطفا آی دی تصویر را بدهید.'
                ]);

            $businessPic = BusinessPic::whereId($request["id"]);

            if($businessPic == null || $businessPic->businessId != $business->id) {
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'شما اجازه دسترسی به این عکس را ندارید.'
                ]);
            }

            if (file_exists(__DIR__ . '/../../../../storage/app/public/' . $businessPic->pic))
                unlink(__DIR__ . '/../../../../storage/app/public/' . $businessPic->pic);

            $businessPic->delete();
        }

        else if($request["field"] == "madarek") {

            if(!$request->has("id"))
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'لطفا مشخص کنید تصویر رو یا پشت کارت ملی را می خواهید حذف کنید.'
                ]);

            $id = $request["id"];
            if($id != 1 && $id != 2)
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'idx وارد شده نامعتبر است.'
                ]);

            if(!$request->has("idx"))
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'لطفا آی دی تصویر را بدهید.'
                ]);

            $idx = $request["idx"];
            $businessPic = BusinessMadarek::whereBusinessId($business->id)->whereIdx($idx)->first();

            if($businessPic == null) {
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'آی دی مورد نظر نامعتبر است.'
                ]);
            }

            if($id == 1) {
                $pic = $businessPic->pic1;
                $businessPic->pic1 = null;
            }
            else {
                $pic = $businessPic->pic2;
                $businessPic->pic2 = null;
            }

            if (file_exists(__DIR__ . '/../../../../storage/app/public/' . $pic))
                unlink(__DIR__ . '/../../../../storage/app/public/' . $pic);

            $businessPic->save();
        }

        return response()->json(["status" => "ok"]);
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

    public function myBusiness(Business $business) {

        $acl = $business->hasAccess();
        if($acl == null)
            return view('general.noAccess');

        return view('panelBusiness.pages.myBusiness', ['acl' => $acl]);
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

    public function doCreate(Request $request) {

        $request->validate([
            "type" => ["required", Rule::in(["tour", "agency", "restaurant", "hotel"])],
            "haghighi" => ["required", Rule::in(["true", "false"])],
            "hoghoghi" => ["required", Rule::in(["true", "false"])]
        ], $messages=[
            "type.in" => "لطفا نوع خدمت قابل ارائه خود را مشخص کنید."
        ]);

        $haghighi = ($request["haghighi"] == "true");
        $hoghoghi = ($request["hoghoghi"] == "true");

        if(($haghighi && $hoghoghi) || (!$haghighi && !$hoghoghi)) {
            return response()->json([
                "status" => "nok",
                "msg" => "لطفا نوع ارائه دهنده را مشخص کنید."
            ]);
        }

        $business = new Business();
        $business->type = $request["type"];
        $business->haghighi = $haghighi;
        $business->userId = Auth::user()->id;
        $business->save();

        return response()->json([
            "status" => "ok",
            "id" => $business->id
        ]);
    }

    public function updateBusinessInfo1(Request $request, Business $business) {

        $request->validate([
            "name" => "required",
            "nid" => "required",
            "tel" => "required|integer|min:7",
            "mail" => "required",
            "introduction" => "required",
            "economyCode" => "nullable|integer",
        ]);

        if(!$business->haghighi &&
            (!$request->has('economyCode') || empty($request["economyCode"]))) {
            return response()->json([
                "status" => "nok",
                "msg" => "لطفا کد اقتصادی را وارد نمایید."
            ]);
        }

        if(!$business->haghighi)
            $business->economyCode = $request["economyCode"];
        else if(!_custom_check_national_code($request["nid"])) {
            return response()->json([
                "status" => "nok",
                "msg" => "شماره ملی وارد شده نامعبتر است."
            ]);
        }

        $business->mail = $request["mail"];
        $business->introduction = $request["introduction"];
        $business->nid = $request["nid"];
        $business->name = $request["name"];
        $business->tel = $request["tel"];

        if($request->has("telegram"))
            $business->telegram = $request["telegram"];

        if($request->has("insta"))
            $business->insta = $request["insta"];

        if($request->has("site"))
            $business->site = $request["site"];

        $business->save();

        return response()->json([
            "status" => "ok"
        ]);
    }

    public function updateBusinessInfo2(Request $request, Business $business) {

        $request->validate([
            "fullOpen" => ["required", Rule::in(["true", "false"])],
            "afterClosedDayButton" => ["required", Rule::in(["true", "false"])],
            "closedDayButton" => ["required", Rule::in(["true", "false"])],
            "inWeekDayStart" => ["required", "regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]/"],
            "inWeekDayEnd" => ["required", "regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]/"],
            "afterClosedDayStart" => ["required", "regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]/"],
            "afterClosedDayEnd" => ["required", "regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]/"],
            "closedDayStart" => ["required", "regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]/"],
            "closedDayEnd" => ["required", "regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]/"],
            "cityId" => "required|exists:cities,id",
            "coordinate" => ["required", "regex:/^[-]?((([0-8]?[0-9])(\.(\d{1,15}))?)|(90(\.0+)?)),\s?[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d{1,15}))?)|180(\.0+)?)$/"],
            "address" => ["required"]
        ], $messages=[
            "cityId.exists" => "شهر مورد نظر وجود ندارد.",
            "coordinate.regex" => "لطفا مختصات جغرافیایی خود را مشخص کنید.",
            "fullOpen.in" => "لطفا مشخص کنید 24 ساعته هستید یا نه.",
            "afterClosedDayButton.in" => "لطفا مشخص کنید روز های بعد از تعطیلی باز هستید یا نه.",
            "closedDayButton.in" => "لطفا مشخص کنید روز های تعطیلی باز هستید یا نه.",
            "address.required" => "لطفا آدرس خود را مشخص کنید.",
            "inWeekDayStart.regex" => "فرمت ساعت ها باید به شکل hh:mm باشد.",
            "inWeekDayEnd.regex" => "فرمت ساعت ها باید به شکل hh:mm باشد.",
            "afterClosedDayStart.regex" => "فرمت ساعت ها باید به شکل hh:mm باشد.",
            "afterClosedDayEnd.regex" => "فرمت ساعت ها باید به شکل hh:mm باشد.",
            "closedDayStart.regex" => "فرمت ساعت ها باید به شکل hh:mm باشد.",
            "closedDayEnd.regex" => "فرمت ساعت ها باید به شکل hh:mm باشد."
        ]);

        $business->fullOpen = $request["fullOpen"] === 'true' ? 1 : 0;
        $business->afterClosedDayIsOpen = $request['afterClosedDayButton'] === 'false' ? 1 : 0;
        $business->closedDayIsOpen = $request['closedDayButton'] === 'false' ? 1 : 0;

        $business->inWeekOpenTime = $request['inWeekDayStart'];
        $business->inWeekCloseTime = $request['inWeekDayEnd'];
        $business->afterClosedDayOpenTime = $request['afterClosedDayStart'];
        $business->afterClosedDayCloseTime = $request['afterClosedDayEnd'];
        $business->closedDayOpenTime = $request['closedDayStart'];
        $business->closedDayCloseTime = $request['closedDayEnd'];

        $business->cityId = $request["cityId"];
        $coordinate = str_replace(', ', ',', $request['coordinate']);
        $coordinate = explode(',', $coordinate);

        $business->lat = $coordinate[0];
        $business->lng = $coordinate[1];
        $business->address = $request["address"];

        $business->save();
        return response()->json([
            "status" => "ok"
        ]);
    }

    public function updateBusinessInfo3(Request $request, Business $business) {

    }

    public function updateBusinessInfo4(Request $request, Business $business) {

        $request->validate([
            "additionalValue" => ["required", Rule::in(["true", "false"])],
            "shaba" => "required|numeric|digits:24",
            "expire" => "required_if:additionalValue,true"
        ], $messages=[
            "additionalValue.in" => "لطفا مشخص کنید که آیا شما مشمول مالیات بر ارزش افزوده هستید یا خیر.",
            "shaba.numeric" => "شماره شبا وارد شده نامعتبر است.",
            "shaba.digits" => "شماره شبا وارد شده نامعتبر است.",
            "expire.required_if" => "لطفا تاریخ انقضا گواهی ارزش افزوده خود را وارد نمایید.",
        ]);

        if($request["additionalValue"] == "true" && $business->additionalValue == null) {
            return response()->json([
                "status" => "nok",
                "msg" => "لطفا تصویر گواهی ارزش افزوده خود را آپلود نمایید."
            ]);
        }

        $business->hasAdditionalValue = ($request["additionalValue"] == "true");
        $business->expireAdditionalValue = $request["expire"];
        $business->shaba = $request["shaba"];
        $business->save();

        return response()->json(["status" => "ok"]);
    }

    public function updateBusinessInfo5(Request $request, Business $business) {

        $businessMadarek = BusinessMadarek::whereBusinessId($business->id)->orderBy('id', 'asc')->get();

        $request->validate([
            "names" => "required|array|min:" . count($businessMadarek) . '|max:' . count($businessMadarek),
            "roles" => "required|array|min:" . count($businessMadarek) . '|max:' . count($businessMadarek),
            "roles.*"  => ["required", "numeric", Rule::in([1, 2, 3, 4, 5])],
            "names.*" => "required|string"
        ], $messages=[
            "names.required" => "آرایه مورد نظر معتبر نمی باشد",
            "names.array" => "آرایه مورد نظر معتبر نمی باشد",
            "names.min" => "آرایه مورد نظر معتبر نمی باشد",
            "names.max" => "آرایه مورد نظر معتبر نمی باشد",
            "roles.required" => "آرایه مورد نظر معتبر نمی باشد",
            "roles.array" => "آرایه مورد نظر معتبر نمی باشد",
            "roles.min" => "آرایه مورد نظر معتبر نمی باشد",
            "roles.max" => "آرایه مورد نظر معتبر نمی باشد",
        ]);

        $names = $request["names"];
        $roles = $request["roles"];

        for($i = 0; $i < count($businessMadarek); $i++) {
            $businessMadarek[$i]->name = $names[$i];
            $businessMadarek[$i]->role = $roles[$i];
            $businessMadarek[$i]->save();
        }

        return response()->json(["status" => "ok"]);
    }

    public function finalizeBusinessInfo(Business $business) {

        $business->readyForCheck = true;
        $business->save();

        return response()->json([
            "status" => "ok"
        ]);

    }
}
