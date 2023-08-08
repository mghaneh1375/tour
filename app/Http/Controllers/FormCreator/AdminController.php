<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Notification;
use App\models\FormCreator\UserAsset;
use App\models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller {

    public function setAssetStatus(Request $request, UserAsset $user_asset) {

        $request->validate([
            'status' => ['required', Rule::in(['PENDING', 'REJECT', 'CONFIRM'])],
            'err_text' => 'nullable|string|min:2'
        ]);

        if($user_asset->status == "INIT") {
            return response()->json([
                "status" => -1,
                "msg" => "در حال حاضر مجاز به انجام چنین عملیاتی نیستید."
            ]);
        }

        $user_asset->status = $request["status"];

        DB::connection('formDB')->update('update user_forms_data set status = "' . $request["status"] . 
            '" where status = "PENDING" and user_asset_id = ' . $user_asset->id);

        $newTicket = null;
        $parent = null;

        $adminId = $request->id;

        if($user_asset->ticket_id != null) {

            $msg = '';

            if($request['status'] == "CONFIRM")
                $msg = 'درخواست شما با موفقیت تایید گردید';
            else if($request['status'] == "REJECT") {
                $msg = 'درخواست شما به دلایل زیر رد گردید ' . '<br/>';
                if($request->has('err_text'))
                    $msg .= $request['err_text'];
            }

            $newTicket = Ticket::firstOrCreate(['parentId', $user_asset->ticket_id], [
                'userId' => $user_asset->user_id,
                'parentId' =>  $user_asset->ticket_id,
                'adminId' => $adminId,
                'businessId' => $user_asset->id
            ]);

            $parent = $newTicket->parentId;

            $newTicket->adminSeen = 1;
            $newTicket->seen = 0;
            $newTicket->msg = $msg;

            $newTicket->save();

            $parent->updated_at = Carbon::now();
            $parent->save();

        }
        

        if($request['status'] == 'REJECT' && $request->has('err_text')) {   
            $user_asset->err_text = $request['err_text'];
        }
        
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
