<?php

namespace App\Http\Controllers\PanelBusiness\Agency;

use App\Http\Controllers\Controller;
use App\models\Business\Business;
use App\models\Cities;
use App\models\places\Majara;
use App\models\tour\Tour;
use Illuminate\Http\Request;

class AgencyBusinessPanelController extends Controller
{
    public $defaultViewLocation = 'panelBusiness.pages.Agency';

    public function tourList()
    {
        $view = $this->defaultViewLocation.'.tour.agencyTourListPanel';
        return view($view);
    }

    public function getTourList($business){
        $urlParse = parse_url(\Illuminate\Support\Facades\Request::url());
        $hostName = explode('.', $urlParse['host']);
        $port = isset($urlParse['port']) ? ":{$urlParse['port']}" : '';
        $baseUrl = "{$urlParse['scheme']}://{$hostName[1]}{$port}";

        $tours = Tour::join('cities', 'cities.id', 'tour.srcId')
                    ->where('tour.businessId', $business)
                    ->select([
                        'cities.name AS srcName',
                        'tour.name', 'tour.id', 'tour.code', 'tour.srcId', 'tour.destId',
                        'tour.kindDest', 'tour.isLocal', 'tour.day', 'tour.night',
                        'tour.private', 'tour.isPublished', 'tour.confirm'
                    ])
                    ->orderBy('tour.id', 'desc')
                    ->get();

        foreach($tours as $item){
            if($item->isPublished == 0)
                $item->status = 'پیش نویس';
            else if($item->confirm == 0)
                $item->status = 'در حال بررسی';
            else if($item->confirm == 1)
                $item->status = 'انتشار';

            $destination = $item->kindDest == 'city' ? 'cities' : 'majara';
            $destination = \DB::table($destination)->find($item->destId);
            $item->destName = $destination != null ? $destination->name : '';

            $item->url = "{$baseUrl}/tour/show/{$item->code}";
        }

        return response()->json(['status' => 'ok', 'result' => $tours]);
    }
}
