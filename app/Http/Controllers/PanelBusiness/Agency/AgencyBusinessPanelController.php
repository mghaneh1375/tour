<?php

namespace App\Http\Controllers\PanelBusiness\Agency;

use App\Http\Controllers\Controller;
use App\models\Business\Business;
use App\models\Cities;
use App\models\places\Majara;
use App\models\tour\Tour;
use App\models\tour\TourDifficult_Tour;
use App\models\tour\TourDiscount;
use App\models\tour\TourEquipment;
use App\models\tour\TourFeature;
use App\models\tour\TourFitFor_Tour;
use App\models\tour\TourFocus_Tour;
use App\models\tour\TourKind_Tour;
use App\models\tour\TourNotice;
use App\models\tour\TourPic;
use App\models\tour\TourPlaceRelation;
use App\models\tour\TourPrices;
use App\models\tour\TourSchedule;
use App\models\tour\TourStyle_Tour;
use App\models\tour\TourTimes;
use App\models\tour\Transport_Tour;
use Illuminate\Http\Request;

class AgencyBusinessPanelController extends Controller
{
    public $defaultViewLocation = 'panelBusiness.pages.Agency';

    public function tourList(){
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

    public function deleteAllTours(){
        $code = 'koochita1400121232';
        if($code === $_GET['code']) {

            Tour::whereRaw('1')->delete();
            TourDifficult_Tour::truncate();
            TourFitFor_Tour::truncate();
            TourFocus_Tour::truncate();
            TourStyle_Tour::truncate();
            TourKind_Tour::truncate();
            TourNotice::truncate();
            TourTimes::truncate();
            Transport_Tour::truncate();
            TourPlaceRelation::truncate();
            TourSchedule::truncate();
            TourPrices::truncate();
            TourDiscount::truncate();
            TourEquipment::truncate();
            TourFeature::truncate();

            $location = __DIR__ . '/../../../../../../assets/_images/tour';

            $pics = TourPic::all();
            foreach ($pics as $pic) {
                $nLoc = "{$location}/{$pic->tourId}/{$pic->pic}";
                if (is_file($nLoc))
                    unlink($nLoc);

                $pic->delete();
            }

            dd("done");
        }
        else
            dd("wrong code");
    }
}
