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

    private static $KOOCHITA_SERVER = "https://koochita-server.bogenstudio.com/api/";
    private static $ROOM_SERVER = "http://193.151.137.75/api/";

    public function setPlaceId(Request $request, UserAsset $user_asset) {

        $request->validate([
            'place_id' => ['required', 'string']
        ]);

        $ch = curl_init( self::$KOOCHITA_SERVER . "place/checkIdExist/" . $request['place_id'] );

        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Accept:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if($httpcode != 200)
            return response()->json([
                'status' => '1',
                'msg' => 'داده وارد شده معتبر نمی باشد'
            ]);

        $result = json_decode($result);
        
        if($result->status == 'nok')
            return response()->json([
                'status' => '1',
                'msg' => $result->msg
            ]);

        $user_asset->place_id = $request['place_id'];
        $user_asset->save();

        return response()->json([
            'status' => '0'
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

                $ch = curl_init( self::$KOOCHITA_SERVER ."place/addPlace" );
            
                $data = [
                    'name' => $user_asset->title,
                    'pic' => asset('storage/' . $user_asset->pic),
                ];
    
                $representerData = $user_asset->get_presenter_data();
                foreach($representerData as $itr) {
                    
                    if($itr->key_ == 'geo') {
                        $d = explode(' ', $itr->data);
                        $data['c'] = (double)$d[0];
                        $data['d'] = (double)$d[1];
                    }
                    else if($itr->key_ == 'city') {
                        $d = explode('$$', $itr->data);
                        $data['state'] = $d[0];
                        $data['city'] = $d[1];
                    }
                    else
                        $data[$itr->key_] = $itr->data;
                }
    
                $payload = json_encode( $data );
                // dd($payload);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_TIMEOUT, 120);

                $result = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if($httpcode != 200)
                    return response()->json([
                        'status' => '1',
                        'msg' => 'داده وارد شده معتبر نمی باشد'
                    ]);


                $result = json_decode($result);
                
                if($result->status == 'nok')
                    return response()->json([
                        'status' => '1',
                        'msg' => $result->msg
                    ]);
            
                $placeId = $result->id;
                
                $user_asset->place_id = $placeId;
                $user_asset->save();
            }
            else
                $placeId = $user_asset->place_id;

            $ch = curl_init( self::$ROOM_SERVER . "/boom/system/store" );
            
            $data = [
                'userId' => $user_asset->user_id,
                'businessId' => $user_asset->id,
                'placeId' => $placeId
            ];

            $payload = json_encode( $data );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            curl_close($ch);

            if($httpcode != 200)
                return response()->json([
                    'status' => '1',
                    'msg' => 'خطا در سامانه اتاق ها',
                    'errCode' => $httpcode
                ]);

            $result = json_decode($result);
                
            if($result->status == 'nok')
                return response()->json([
                    'status' => '1',
                    'msg' => $result->msg
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
