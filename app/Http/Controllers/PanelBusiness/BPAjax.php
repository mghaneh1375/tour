<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Helpers\DefaultDataDB;
use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\places\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BPAjax extends Controller
{
    public function searchCity(){
        $cityName = $_GET['value'];
        $stateId = isset($_GET['stateId']) ? $_GET['stateId'] : 0;

        $selectValue = ['cities.id AS id', 'cities.name AS cityName', 'cities.isVillage AS isVillage', 'state.id AS stateId', 'state.name AS stateName'];
        if($stateId === 0)
            $cities = Cities::join('state', 'state.id', 'cities.stateId')->where('cities.name', 'LIKE', "%{$cityName}%")->select($selectValue)->get();
        else
            $cities = Cities::join('state', 'state.id', 'cities.stateId')->where('cities.stateId', $stateId)->where('cities.name', 'LIKE', "%{$cityName}%")->select($selectValue)->get();

        return response()->json(['status' => 'ok', 'result' => $cities]);
    }

    public function searchInPlace(Request $request){
        if(!$request->has('value'))
            return response()->json(['status' => 'error1']);

        $value = $request->input('value');
        if(strlen($value) <= 1)
            return response()->json(['status' => 'error2']);

        if(isset($request->kindPlaceIds))
            $kindPlaceIdes = $request->kindPlaceIds;
        else
            $kindPlaceIdes = [1, 3, 4, 6, 12, 13];

        $places = [];
        $allKindPlaces = DefaultDataDB::getPlaceDB();

        foreach ($kindPlaceIdes as $kindPlaceId){
            $kindPlace = $allKindPlaces[$kindPlaceId];

            $finded = \DB::table("$kindPlace->tableName AS mainT")
                            ->join('cities', 'cities.id', 'mainT.cityId')
                            ->where('mainT.name', 'LIKE', "%{$value}%")
                            ->select(['mainT.*', 'cities.name AS cityName'])
                            ->get();

            foreach ($finded as $item){
                array_push($places, [
                    'id' => $item->id,
                    'name' => $item->name,
                    'pic' => URL::asset("_images/{$kindPlace->fileName}/{$item->file}/l-{$item->picNumber}", null, $item->server),
                    'cityName' => $item->cityName,
                    'kindPlaceId' => $kindPlace->id,
                ]);
            }
        }

        return response()->json(['status' => 'ok', 'result' => $places]);
    }

}
