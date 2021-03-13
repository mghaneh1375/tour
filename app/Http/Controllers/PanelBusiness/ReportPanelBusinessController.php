<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\Business\Business;
use App\models\Business\BusinessMadarek;
use App\models\Business\BusinessPic;
use App\models\Cities;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class ReportPanelBusinessController extends Controller {

    private static function translate($key) {

        switch ($key) {
            case "lat":
                return ["مختصات lat"];
            case "lng":
                return ["مختصات lng"];
            case "cityId":
                return ["شهر"];
            case "nid":
                return ["شماره ملی/شناسه ملی"];
            case "tel":
                return ["شماره ثابت"];
            case "haghighi":
                return ["حقیقی/حقوقی"];
            case "name":
                return ["نام قانونی کسب و کار"];
            case "economyCode":
                return ["کد اقتصادی"];
            case "site":
                return ["سایت"];
            case "mail":
                return ["ایمیل"];
            case "insta":
                return ["اینستاگرام"];
            case "telegram":
                return ["تلگرام"];
            case "address":
                return ["آدرس"];
            case "introduction":
                return ["معرفی کوتاه"];
            case "shaba":
                return ["شماره شبا"];
            case "expireAdditionalValue":
                return ["تاریخ انقضا ارزش افزوده"];
            case "additionalValue":
                return ["تصویر گواهی ارزش افزوده"];
            case "logo":
                return ["تصویر گواهی ارزش افزوده"];
            case "lastChangesNewsPaper":
                return ["تصویر گواهی ارزش افزوده"];
            case "pic":
                return ["تصویر گواهی ارزش افزوده"];
            case "afterClosedDayIsOpen":
                return ["آیا بعد از روزهای تعطیل باز است؟"];
            case "fullOpen":
                return ["آیا 24 ساعته است؟"];
            case "closedDayIsOpen":
                return ["آیا روز های تعطیل باز است؟"];
            case "hasAdditionalValue":
                return ["آیا دارای ارزش افزوده است؟"];
            case "hasCertificate":
                return ["آیا کسب و کار دارای مجوز است؟"];

        }

        return [$key];
    }

    private static function translateAns($key, $val) {

        switch ($key) {
            case "lat":
                return ["مختصات lat", $val];
            case "lng":
                return ["مختصات lng", $val];
            case "cityId":
                return ["شهر", Cities::whereId($val)->name];
            case "nid":
                return ["شماره ملی/شناسه ملی", $val];
            case "tel":
                return ["شماره ثابت", $val];
            case "haghighi":
                return ["حقیقی/حقوقی", ($val) ? "حقیقی" : "حقوقی"];
            case "name":
                return ["نام قانونی کسب و کار", $val];
            case "economyCode":
                return ["کد اقتصادی", $val];
            case "site":
                return ["سایت", $val];
            case "mail":
                return ["ایمیل", $val];
            case "insta":
                return ["اینستاگرام", $val];
            case "telegram":
                return ["تلگرام", $val];
            case "address":
                return ["آدرس", $val];
            case "introduction":
                return ["معرفی کوتاه", $val];
            case "inWeekOpenTime":
                return ["ساعت آغاز به کار در روز های عادی", $val];
            case "inWeekCloseTime":
                return ["ساعت اتمام کار در روز های عادی", $val];
            case "afterClosedDayOpenTime":
                return ["ساعت آغاز به کار در روز های بعد از تعطیلی", $val];
            case "afterClosedDayCloseTime":
                return ["ساعت اتمام کار در روز های بعد از تعطیلی", $val];
            case "closedDayOpenTime":
                return ["ساعت آغاز به کار در روز های تعطیلی", $val];
            case "closedDayCloseTime":
                return ["ساعت اتمام کار در روز های تعطیلی", $val];
            case "shaba":
                return ["شماره شبا", $val];
            case "expireAdditionalValue":
                return ["تاریخ انقضا ارزش افزوده", $val];
            case "additionalValue":
                if($val != null && !empty($val) && file_exists(__DIR__ . '/../../../../public/storage/' . $val))
                    return ["تصویر گواهی ارزش افزوده", URL::asset("storage/" . $val)];
                return ["تصویر گواهی ارزش افزوده", "تصویری آپلود نشده"];
            case "logo":
                if($val != null && !empty($val) && file_exists(__DIR__ . '/../../../../public/storage/' . $val))
                    return ["تصویر لوگو", URL::asset("storage/" . $val)];
                return ["تصویر گواهی ارزش افزوده", "تصویری آپلود نشده"];
            case "lastChangesNewsPaper":
                if($val != null && !empty($val) && file_exists(__DIR__ . '/../../../../public/storage/' . $val))
                    return ["تصویر روزنامه آخرین تغییرات/روزنامه تاسیس", URL::asset("storage/" . $val)];
                return ["تصویر گواهی ارزش افزوده", "تصویری آپلود نشده"];
            case "pic":
                if($val != null && !empty($val) && file_exists(__DIR__ . '/../../../../public/storage/' . $val))
                    return ["تصویر کسب و کار", URL::asset("storage/" . $val)];
                return ["تصویر گواهی ارزش افزوده", "تصویری آپلود نشده"];
            case "afterClosedDayIsOpen":
                return ["آیا بعد از روزهای تعطیل باز است؟", ($val) ? "بله" : "خیر"];
            case "fullOpen":
                return ["آیا 24 ساعته است؟", ($val) ? "بله" : "خیر"];
            case "closedDayIsOpen":
                return ["آیا روز های تعطیل باز است؟", ($val) ? "بله" : "خیر"];
            case "hasAdditionalValue":
                return ["آیا دارای ارزش افزوده است؟", ($val) ? "بله" : "خیر"];
            case "hasCertificate":
                return ["آیا کسب و کار دارای مجوز است؟", ($val) ? "بله" : "خیر"];

        }

        return [$key, $val];
    }

    public function getUnChecked() {

        $requests = Business::where('readyForCheck', true)
                            ->select(['id', 'name', 'created_at', 'updated_at', 'type', 'userId'])
                            ->orderBy('id', 'desc')
                            ->get();

        foreach ($requests as $request) {
            $request->user = User::whereId($request->userId);

            $cTime = $request->created_at->format('H:i:s');
            $cDate = verta($request->created_at)->format('Y-m-d');

            $uTime = $request->updated_at->format('H:i:s');
            $uDate = verta($request->updated_at)->format('Y-m-d');

            $request->createBusinessDate = "{$cTime}  {$cDate}";
            $request->updateBusinessDate = "{$uTime}  {$uDate}";
        }
        return view('panelBusiness.pages.report.unChecked', ['requests' => $requests]);
    }

    public function getSpecificUnChecked(Business $business) {
        if(!$business->readyForCheck || $business->finalStatus) {
            return response()->json([
                "status" => "nok"
            ]);
        }

        $attrs = [];
        $counter = 0;
        $attributes = $business->getAttributes();

        foreach ($attributes as $key => $val) {
            if(strpos($key, "_status") === false &&
                array_key_exists($key . '_status', $attributes)) {
                $attrs[$counter++] = [self::translateAns($key, $val), $business[$key . '_status'], $key];
            }
        }

        $madareks = BusinessMadarek::where('businessId', $business->id)->get();
        foreach ($madareks as $madarek) {
            switch ($madarek->role) {
                case 1:
                    $madarek->role = "رئیس هیئت مدیره";
                    break;
                case 2:
                    $madarek->role = "مدیرعامل";
                    break;
                case 3:
                    $madarek->role = "نائب رئیسه هیئت مدیره";
                    break;
                case 4:
                    $madarek->role = "عضو هیئت مدیره";
                    break;
                case 5:
                    $madarek->role = "سایر";
                    break;
            }
            $madarek->pic1 = URL::asset('storage/' . $madarek->pic1);
            $madarek->pic2 = URL::asset('storage/' . $madarek->pic2);
        }

        $pics = BusinessPic::where('businessId', $business->id)->get();
        foreach ($pics as $pic)
            $pic->pic = URL::asset('storage/' . $pic->pic);

        return view('panelBusiness.pages.report.specificUnChecked', ['id' => $business->id,
            'attrs' => $attrs, 'madareks' => $madareks,
            'pics' => $pics]);
    }

    public function setFieldStatus(Request $request, Business $business) {

        if(!$business->readyForCheck || $business->finalStatus) {
            return response()->json([
                "status" => "nok",
                "msg" => "درخواست مورد نظر در وضعیت کنونی قابل اجرا نیست"
            ]);
        }

        $request->validate([
            "field" => ["required"]
        ]);

        if(($request["field"] == "pics" || $request["field"] == "madareks") && !$request->has("id")) {
            return response()->json([
                "status" => "nok",
                "msg" => "فیلد آی دی اجباری است"
            ]);
        }

        if(($request["field"] == "pics" || $request["field"] == "madareks")) {
            $id = $request["id"];
            if($request["field"] == "pics") {
                $businessPic = BusinessPic::whereId($id);
                if($businessPic == null || $businessPic->businessId != $business->id) {
                    return response()->json([
                        "status" => "nok",
                        "msg" => "فیلد آی دی نامعتبر است"
                    ]);
                }
                $businessPic->status = !$businessPic->status;
                $businessPic->save();
                return response()->json([
                    "status" => "ok",
                    "newStatus" => ($businessPic->status) ? "تایید شده" : "تایید نشده"
                ]);
            }
            $businessMadarek = BusinessMadarek::whereId($id);
            if($businessMadarek == null || $businessMadarek->businessId != $business->id) {
                return response()->json([
                    "status" => "nok",
                    "msg" => "فیلد آی دی نامعتبر است"
                ]);
            }
            $businessMadarek->status = !$businessMadarek->status;
            $businessMadarek->save();
            return response()->json([
                "status" => "ok",
                "newStatus" => ($businessMadarek->status) ? "تایید شده" : "تایید نشده"
            ]);
        }

        $isColExist = Schema::connection('mysql')->hasColumn("business", $request["field"]);

        if($isColExist) {

            try {
                $business[$request["field"] . "_status"] = !$business[$request["field"] . "_status"];
                $business->save();

                return response()->json([
                    "status" => "ok",
                    "newStatus" => ($business[$request["field"] . "_status"]) ? "تایید شده" : "رد شده"
                ]);
            }
            catch (\Exception $x) {
                return response()->json([
                    "status" => "nok",
                    "msg" => $x->getMessage()
                ]);
            }

        }

        return response()->json([
            "status" => "nok",
            "msg" => "فیلد مورد نظر وجود ندارد."
        ]);
    }

    public function getFinalStatus(Business $business) {

        if(!$business->readyForCheck || $business->finalStatus) {
            return response()->json([
                "status" => "nok2",
                "msg" => "درخواست مورد نظر در وضعیت کنونی قابل اجرا نیست"
            ]);
        }

        $rejected_attrs = [];
        $counter = 0;

        foreach ($business->getAttributes() as $key => $val) {

            if(strpos($key, "_status") !== false && !$val) {
                $rejected_attrs[$counter++] = self::translate(explode("_", $key)[0]);
            }
        }

        if(count($rejected_attrs) == 0) {
            return response()->json([
                "status" => "ok"
            ]);
        }

        return response()->json([
            "status" => "nok",
            "fields" => $rejected_attrs
        ]);
    }

    public function finalize(Business $business) {

        if(!$business->readyForCheck || $business->finalStatus) {
            return response()->json([
                "status" => "nok",
                "msg" => "درخواست مورد نظر در وضعیت کنونی قابل اجرا نیست"
            ]);
        }

        $rejected_attrs = [];
        $counter = 0;

        foreach ($business->getAttributes() as $key => $val) {

            if(strpos($key, "_status") !== false && !$val) {
                $rejected_attrs[$counter++] = self::translate(explode("_", $key)[0]);
            }
        }

        if(count($rejected_attrs) == 0)
            $business->finalStatus = true;
        else {
            $business->finalStatus = false;
            $business->problem = true;
        }

        $business->readyForCheck = false;
        $business->save();

        return response()->json([
            "status" => "ok"
        ]);

    }

}
