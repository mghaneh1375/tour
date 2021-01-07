<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\FestivalLimboContent;
use App\models\MainEquipment;
use App\models\places\Amaken;
use App\models\places\Place;
use App\models\State;
use App\models\SubEquipment;
use App\models\tour\Tour;
use App\models\tour\TourDifficult;
use App\models\tour\TourDifficult_Tour;
use App\models\tour\TourDiscount;
use App\models\tour\TourEquipment;
use App\models\tour\TourFeature;
use App\models\tour\TourFocus;
use App\models\tour\TourFocus_Tour;
use App\models\tour\TourGuid;
use App\models\tour\TourHotel;
use App\models\tour\TourKind;
use App\models\tour\TourKind_Tour;
use App\models\tour\TourNotice;
use App\models\tour\TourPeriod;
use App\models\tour\TourPic;
use App\models\tour\TourPlace;
use App\models\tour\TourSchedule;
use App\models\tour\TourScheduleDetail;
use App\models\tour\TourScheduleDetailKind;
use App\models\tour\TourStyle;
use App\models\tour\TourStyle_Tour;
use App\models\tour\Transport_Tour;
use App\models\tour\TransportKind;
use App\User;
use Carbon\Carbon;
use ClassesWithParents\CInterface;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\Transport;

class TourController extends Controller{


    public function showTour($code){
        $tour = Tour::where('code', $code)->first();
        if($tour == null)
            abort(404);

        $owner = User::find($tour->userId);
        $ownerPic = getUserPic($owner->id);

        $thisTour = ['tourId' => $tour->id];

        $tour->src = Cities::find($tour->srcId);
        if($tour->isLocal == 0){
            $table = $tour->kindDest == 'city' ? 'cities' : 'majara';
            $tour->dest = \DB::table($table)->select(['id', 'name'])->find($tour->destId);
        }
        else
            $tour->dest = (object)['name' => ''];

        $tour->style = $tour->Styles()->pluck('name')->toArray();

        $tour->pics = TourPic::where($thisTour)->get();
        foreach ($tour->pics as $pic) {
            $pic->pic = \URL::asset('_images/tour/' . $tour->id . '/' . $pic->pic);
            $pic->userPic = $ownerPic;
        }

        return view('pages.tour.tour-details', compact(['tour']));
    }

    public function getFullTourInformation(){
        $code = $_GET['code'];

        $tour = Tour::where('code', $code)->first();

        $thisTour = ['tourId' => $tour->id];

        $tour->src = Cities::select(['id', 'name'])->find($tour->srcId);
        if($tour->isLocal == 0){
            $table = $tour->kindDest == 'city' ? 'cities' : 'majara';
            $tour->dest = \DB::table($table)->select(['id', 'name'])->find($tour->destId);
        }
        else
            $tour->dest = (object)['name' => ''];

        $tour->cost = number_format($tour->minCost);
        $tour->importantNotes = TourNotice::where($thisTour)->pluck('text')->toArray();

        $tour->childDisCount = TourDiscount::where($thisTour)->where('isChildren', 1)->first();
        $tour->reason = TourDiscount::where($thisTour)->where('isReason', 1)->first();

        $sideTransportId = json_decode($tour->sideTransport);
        $tour->sideTransport = TransportKind::whereIn('id', $sideTransportId)->pluck('name')->toArray();

        $tour->kinds = $tour->kinds()->pluck('name')->toArray();
        $tour->style = $tour->Styles()->pluck('name')->toArray();

        $tour->language = json_decode($tour->language);

        if($tour->isTransport == 1){
            $tour->mainTransport = Transport_Tour::where($thisTour)->first();
            $tour->mainTransport->sTransportName = TransportKind::find($tour->mainTransport->sTransportId)->name;
            $tour->mainTransport->eTransportName = TransportKind::find($tour->mainTransport->eTransportId)->name;
        }

        $tour->features = $tour->GetFeatures;
        foreach ($tour->features as $feat)
            $feat->cost = number_format($feat->cost);

        $equipments = TourEquipment::join('subEquipments', 'subEquipments.id', 'tourEquipments.subEquipmentId')
                                    ->where('tourEquipments.tourId', $tour->id)
                                    ->select(['subEquipments.name', 'tourEquipments.isNecessary'])
                                    ->get();

        $mustEquip = [];
        $suggestEquip = [];
        foreach ($equipments as $item){
            if($item->isNecessary == 1)
                array_push($mustEquip, $item->name);
            else
                array_push($suggestEquip, $item->name);
        }

        $tour->mustEquip = $mustEquip;
        $tour->suggestEquip = $suggestEquip;

        return response()->json(['status' => 'ok', 'result' => $tour]);
    }

}
