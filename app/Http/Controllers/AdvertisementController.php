<?php

namespace App\Http\Controllers;

use App\models\Advertisement\Advertisement;
use App\models\Advertisement\AdvertisementSizes;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function getAdvertisement()
    {
        $section = isset($_GET['section']) ? $_GET['section'] : 'all';
        $data = json_decode($_GET['data']);

        $getedId = [];
        $advers = [];

        foreach($data as $item){
            $size = AdvertisementSizes::where('kindName', $item)->first();
            if(!isset($getedId[$size->kindName]))
                $getedId[$size->kindName] = [];

            $advs = Advertisement::where('kindId', $size->id)->whereNotIn('id', $getedId[$size->kindName])->select(['id', 'title', 'url', 'pics'])->take($size->takeCount)->get();
            if(count($advs) != $size->takeCount){
                $getedId[$size->kindName] = [];
                $advs = Advertisement::where('kindId', $size->id)->whereNotIn('id', $getedId[$size->kindName])->select(['id', 'title', 'url', 'pics'])->take($size->takeCount)->get();
            }
            foreach ($advs as $ad) {
                $ad->pics = json_decode($ad->pics);
                $ad->pics->pc = \URL::asset("_images/esitrevda/{$ad->pics->pc}");
                $ad->pics->mobile = \URL::asset("_images/esitrevda/{$ad->pics->mobile}");

                array_push($getedId[$size->kindName], $ad->id);
            }

            array_push($advers, [
                'kind' => $item,
                'ads' => $advs
            ]);
        }

        return response()->json(['status' => 'ok', 'result' => $advers]);
    }
}
