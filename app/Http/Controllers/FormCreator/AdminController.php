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


    public function setPlaceId(Request $request, UserAsset $user_asset) {

        $request->validate([
            'place_id' => ['required', 'string']
        ]);

        $user_asset->place_id = $request['place_id'];
        $user_asset->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }

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


        if($request['status'] == "CONFIRM") {

            if($user_asset->place_id == null) {

                $ch = curl_init( "http://127.0.0.1:8080/api/boom/system/store" );
            
                $data = [
                    'userId' => $user_asset->user_id,
                    'businessId' => $user_asset->id,
                    'title' => $user_asset->title,
                    'image' => asset('storage/' . $user_asset->pic),
                    'createdAt' => Carbon::now()
                ];
    
                $subData = [];
    
                $representerData = $user_asset->get_presenter_data();
                foreach($representerData as $itr) {
                    $subData[$itr->key_] = $itr->data;
                }
    
                $data['data'] = $subData;
    
                $payload = json_encode( $data );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_exec($ch);
                curl_close($ch);

            }

            $ch = curl_init( "http://127.0.0.1:8080/api/boom/system/store" );
            
            $data = [
                'userId' => $user_asset->user_id,
                'businessId' => $user_asset->id,
                'title' => $user_asset->title,
                'image' => asset('storage/' . $user_asset->pic),
                'createdAt' => Carbon::now()
            ];

            $subData = [];

            $representerData = $user_asset->get_presenter_data();
            foreach($representerData as $itr) {
                $subData[$itr->key_] = $itr->data;
            }

            $data['data'] = $subData;

            $payload = json_encode( $data );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_exec($ch);
            curl_close($ch);

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

            $newTicket = Ticket::firstOrCreate(['parentId' => $user_asset->ticket_id], [
                'userId' => $user_asset->user_id,
                'parentId' =>  $user_asset->ticket_id,
                'adminId' => $adminId,
                'businessId' => $user_asset->id,
                'isForBusiness' => false
            ]);

            $parent = Ticket::find($newTicket->parentId);

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
