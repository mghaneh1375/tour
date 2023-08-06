<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Notification;
use App\models\FormCreator\UserAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller {

    public function setAssetStatus(Request $request, UserAsset $user_asset) {

        $request->validate([
            'status' => ['required', Rule::in(['PENDING', 'REJECT', 'CONFIRM'])],
        ]);

        if($user_asset->status == "INIT") {
            return response()->json([
                "status" => -1,
                "msg" => "در حال حاضر مجاز به انجام چنین عملیاتی نیستید."
            ]);
        }

        $user_asset->status = $request["status"];
        $user_asset->save();
        return response()->json([
            "status" => 0
        ]);

    }

    public function notifications() {
        DB::update("update notifications set seen = true where 1");
        return view('formCreator.notifications', ['notifications' => Notification::orderBy('id', 'desc')->get()]);
    }
}
