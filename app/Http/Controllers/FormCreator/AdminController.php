<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Notification;
use App\models\FormCreator\UserAsset;
use App\models\Ticket;
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

        if($user_asset->ticket_id != null) {

            Ticket::firstOrCreate(['parentId', $user_asset->ticket_id], [
                'userId' => $user_asset->id,
                'parentId' =>  $user_asset->user_id
            ]);

            // if( == 0) {

            //     $newTicket = new Ticket();
            //     $newTicket->userId = $parent->userId;
            //     $newTicket->adminId = \auth()->user()->id;

            // }



        }
        

        if($request['status'] == 'REJECT') {
            
            if($request->has('err_text'))
                $user_asset->err_text = $request['err_text'];

        //     $newTicket->adminSeen = 1;
        //     $newTicket->seen = 0;
        //     $newTicket->parentId = $parent->id;
        //     $newTicket->businessId = $parent->businessId;
        //     $newTicket->msg = $request->description ?? null;
        //     if($request->has("file")) {
        //         $newTicket->fileName = $request->file('file')->getClientOriginalName();
        //         $path = $request->file->store('public/tickets');
        //         $path = str_replace('public/', '', $path);
        //         $newTicket->file = $path;
        //     }
        //     $newTicket->save();

        //     $parent->updated_at = Carbon::now();
        //     $parent->save();
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
