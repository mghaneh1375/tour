<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\places\Place;
use App\models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainApiController extends Controller
{
    public function getPlacesForKoochitaTv()
    {
        $nowTime = Carbon::now()->getTimestamp();
        $ck = config("app.koochitaTvNouncCode").'_'.$_GET['time'];
        $checkHash = Hash::check($ck, $_GET['code']);
        if(($nowTime - $_GET['time']) > 1000)
            return response()->json('outTime');

        if($checkHash){
            $states = [];
            $statesId = json_decode($_GET['state']);
            foreach ($statesId as $sId) {
                $st = State::find($sId);
                if($st != null){
                    $st->url = route('cityPage', ['kind' => 'state', 'city' => $st->name]);
                    $st->pic = getStatePic($st->id, 0);
                    array_push($states, $st);
                }
            }

            $cities = [];
            $citiesId = json_decode($_GET['city']);
            foreach ($citiesId as $cId) {
                $ci = Cities::find($cId);
                if($ci != null) {
                    $ci->url = route('cityPage', ['kind' => 'city', 'city' => $ci->name]);
                    $ci->pic = getStatePic(0, $ci->id);
                    $st = State::find($ci->stateId);
                    if($st != null)
                        $st->state = $st->name;

                    array_push($cities, $ci);
                }
            }

            $places = [];
            $pls = json_decode($_GET['places']);
            foreach ($pls as $item){
                $kindPlace = Place::find($item->kindPlaceId);
                if($kindPlace != null && $kindPlace->tableName != null){
                    $place = \DB::table($kindPlace->tableName)->select(['id', 'name', 'cityId'])->find($item->id);
                    if($place != null){
                        $place->url = route('placeDetails', ['kindPlaceId' => $item->kindPlaceId, 'placeId' => $item->id]);
                        $place->pic = getPlacePic($place->id, $item->kindPlaceId);
                        $ci = Cities::find($place->cityId);
                        if($ci != null){
                            $place->city = $ci->name;
                            $st = State::find($ci->stateId);
                            if($st != null)
                                $place->state = $st->name;
                        }
                        array_push($places, $place);
                    }
                }
            }

            return response()->json(['state' => $states, 'cities' => $cities, 'places' => $places]);
        }
        else
            return response()->json('nok');
    }

    public function deleteFileWithDir(Request $request)
    {
        $assetLocation = __DIR__.'/../../../../../assets';

        $nowTime = Carbon::now()->getTimestamp();
        $ck = config("app.DeleteNonceCode").'_'.$request->time;
        $checkHash = Hash::check($ck, $request->code);
        if(($nowTime - $request->time) > 2000)
            return response()->json(['status' => 'outTime']);

        if($checkHash){
            $errorFile = [];
            $notFoundFile = [];
            $deletedFile = [];

            $files = json_decode($request->filesDirectory);
            foreach($files as $file) {
                try {
                    $fileDir = $assetLocation . '/' . $file;
                    if (is_file($fileDir)) {
                        unlink($fileDir);
                        array_push($deletedFile, $file);
                    }
                    else
                        array_push($notFoundFile, $file);
                }
                catch (\Exception $exception){
                    array_push($errorFile, $file);
                }
            }


            return response()->json(['status' => 'ok', 'result' => ['success' => $deletedFile, 'error' => $errorFile, 'notFound' => $notFoundFile]]);
        }
        else
            return response()->json(['status' => 'error']);
    }
}
