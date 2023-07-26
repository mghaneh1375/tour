<?php

namespace App\Http\Controllers;

use App\models\Cities;
use App\models\places\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AjaxController extends Controller {


    public function findCityWithState()
    {
        if(isset($_GET['stateId']) && isset($_GET["value"])){
            $city = Cities::where('stateId', $_GET['stateId'])->where('name', 'LIKE', '%'.$_GET["value"].'%')->get();
            foreach ($city as $item){
                $item->state = $item->getState;
                if(is_file(__DIR__.'/../../../../assets/_images/city/'.$item->image))
                    $item->pic = URL::asset('_images/city/'.$item->image);
                else
                    $item->pic = URL::asset('images/mainPics/noPicSite.jpg');
            }
            return response()->json(['status' => 'ok', 'result' => $city]);
        }
        return response()->json(['status' => 'nok']);
    }


    public function searchForCity(Request $request) {
        $result = [];
        $key = $request->key;
        if(isset($request->state) && $request->state == 1)
            $result = DB::select("SELECT state.id, state.name as stateName FROM state WHERE state.name LIKE '%$key%' ");

        foreach ($result as $item)
            $item->kind = 'state';

        $cities = DB::select("SELECT cities.id, cities.name as cityName, state.name as stateName, cities.isVillage as isVillage FROM cities, state WHERE cities.stateId = state.id AND isVillage = 0 AND cities.name LIKE '%$key%' ");
        foreach ($cities as $item) {
            $item->kind = 'city';
            array_push($result, $item);
        }

        if(isset($request->village) && $request->village == 1) {
            $village = DB::select("SELECT cities.id, cities.name as cityName, state.name as stateName, cities.isVillage as isVillage FROM cities, state WHERE cities.stateId = state.id AND isVillage != 0 AND cities.name LIKE '%$key%' ");
            foreach ($village as $item) {
                $item->kind = 'village';
                array_push($result, $item);
            }
        }
        echo json_encode($result);
        return;
    }

    
    public function searchSpecificKindPlace(){
        $place = [];
        if($_GET['kindPlaceId'] == 0){
            $kindPlaceses = Place::whereNotNull('tableName')->where('mainSearch', 1)->get();
            foreach ($kindPlaceses as $kindPlace){
                if($kindPlace->id == 10 || $kindPlace->id == 11 || $kindPlace->id == 14)
                    $select = ['id', 'name', 'picNumber', 'cityId', 'file'];
                else
                    $select = ['id', 'name', 'picNumber', 'cityId', 'file', 'C', 'D'];
                $pl = DB::table($kindPlace->tableName)->where('name', 'LIKE', '%' . $_GET["value"] . '%')->select($select)->get();
                foreach ($pl as $item) {
                    $item->kindPlaceId = $kindPlace->id;
                    $item->fileName = $kindPlace->fileName;
                    array_push($place, $item);
                }
            }
        }
        else {
            $kindPlace = Place::find($_GET['kindPlaceId']);
            if($kindPlace->id == 10 || $kindPlace->id == 11 || $kindPlace->id == 14)
                $select = ['id', 'name', 'picNumber', 'cityId', 'file'];
            else
                $select = ['id', 'name', 'picNumber', 'cityId', 'file', 'C', 'D'];

            $place = DB::table($kindPlace->tableName)->where('name', 'LIKE', '%' . $_GET["value"] . '%')->select($select)->get();
            foreach ($place as $item) {
                $item->kindPlaceId = $kindPlace->id;
                $item->fileName = $kindPlace->fileName;
            }
        }

        foreach ($place as $item){
            $item->city = Cities::find($item->cityId);
            if($item->city != null)
                $item->state = $item->city->getState;

            if(file_exists(__DIR__ . '/../../../../assets/_images/'.$item->fileName.'/'.$item->file.'/l-'.$item->picNumber))
                $item->pic = URL::asset('_images/'.$item->fileName.'/'.$item->file.'/l-'.$item->picNumber);
            else
                $item->pic = URL::asset('images/mainPics/noPicSite.jpg');
        }
        return response()->json(['status' => 'ok', 'result' => $place]);
    }


}
