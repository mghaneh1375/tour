<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\tour\Tour;
use App\models\tour\TourEquipment;
use App\models\tour\TourPic;
use App\models\tour\TourPrices;
use App\models\tour\TourTimes;
use App\models\tour\TourUserReservation;
use App\models\tour\Transport_Tour;
use App\models\tour\TransportKind;
use App\User;
use Carbon\Carbon;
use ClassesWithParents\CInterface;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\Transport;

class TourController extends Controller{

    public $DateOfWeeks = [
        'شنبه',
        'یک شنبه',
        'دوشنبه',
        'سه شنبه',
        'چهارشنبه',
        'پنج شنبه',
        'جمعه',
    ];

    public function showTour($code){
        $tourReserve = TourUserReservation::where('created_at', '<', Carbon::now()->subMinute(25))->get();
        foreach ($tourReserve as $item)
            $item->deleteAndReturnCapacity();

        $timeCode = isset($_GET['timeCode']) ? $_GET['timeCode'] : 0;

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


        $tour->pics = TourPic::where($thisTour)->get();
        foreach ($tour->pics as $pic) {
            $pic->pic = \URL::asset('_images/tour/' . $tour->id . '/' . $pic->pic);
            $pic->userPic = $ownerPic;
        }

        $tour->cost = number_format($tour->minCost);

        $timeToSee = null;
        if($timeCode != 0)
            $timeToSee = TourTimes::where('tourId', $tour->id)->where('code', $timeCode)->first();

        if($timeToSee == null)
            $timeToSee = TourTimes::where('tourId', $tour->id)->orderBy('sDate')->first();

        $stt = explode('/', $timeToSee->sDate);
        $sDateInWeek = $this->DateOfWeeks[Verta::createJalali($stt[0], $stt[1], $stt[2])->dayOfWeek];
        $tour->sDateName = $sDateInWeek .' ' . $timeToSee->sDate;

        $ett = explode('/', $timeToSee->eDate);
        $eDateInWeek = $this->DateOfWeeks[Verta::createJalali($ett[0], $ett[1], $ett[2])->dayOfWeek];
        $tour->eDateName = $eDateInWeek .' ' . $timeToSee->eDate;

        $tour->timeCode = $timeToSee->code;

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

        $sideTransportId = json_decode($tour->sideTransport);
        $tour->sideTransport = TransportKind::whereIn('id', $sideTransportId)->pluck('name')->toArray();

        $tour->kinds = $tour->kinds()->pluck('name')->toArray();
        $tour->style = $tour->Styles()->pluck('name')->toArray();
        $tour->fitFor = $tour->FitFor()->pluck('name')->toArray();
        $tour->difficult = $tour->Difficults()->pluck('name')->toArray();

        $tour->language = json_decode($tour->language);

        if($tour->isTransport == 1){
            $tour->mainTransport = Transport_Tour::where($thisTour)->first();
            $tour->mainTransport->sTransportName = TransportKind::find($tour->mainTransport->sTransportId)->name;
            $tour->mainTransport->eTransportName = TransportKind::find($tour->mainTransport->eTransportId)->name;
        }

        $tour->features = $tour->GetFeatures;
        foreach ($tour->features as $feat)
            $feat->cost = number_format($feat->cost);


        $mustEquip = [];
        $suggestEquip = [];
        $equipments = TourEquipment::join('subEquipments', 'subEquipments.id', 'tourEquipments.subEquipmentId')
                                    ->where('tourEquipments.tourId', $tour->id)
                                    ->select(['subEquipments.name', 'tourEquipments.isNecessary'])
                                    ->get();
        foreach ($equipments as $item){
            if($item->isNecessary == 1)
                array_push($mustEquip, $item->name);
            else
                array_push($suggestEquip, $item->name);
        }

        $tour->mustEquip = $mustEquip;
        $tour->suggestEquip = $suggestEquip;

        $tour->schedule = $tour->getFullySchedule();

        $times = TourTimes::where('tourId', $tour->id)->where('isPublished', 1)->orderBy('sDate')->get();
        foreach($times as $item){
            $stt = explode('/', $item->sDate);
            $sDateInWeek = $this->DateOfWeeks[Verta::createJalali($stt[0], $stt[1], $stt[2])->dayOfWeek];
            $item->sDateName = $sDateInWeek .' ' . $item->sDate;

            $ett = explode('/', $item->eDate);
            $eDateInWeek = $this->DateOfWeeks[Verta::createJalali($ett[0], $ett[1], $ett[2])->dayOfWeek];
            $item->eDateName = $eDateInWeek .' ' . $item->eDate;

            if($tour->anyCapacity == 1) {
                $item->anyCapacity = 1;
                $item->hasCapacity = true;
            }
            else{
                $item->anyCapacity = 0;
                $item->capacityRemaining = $tour->maxCapacity - $item->registered;
                $item->hasCapacity = ($item->capacityRemaining > 0);
            }

        }
        $tour->times = $times;

        $tour->prices = TourPrices::where('tourId', $tour->id)->get();

        if($tour->tourGuidKoochitaId != 0){
            $guid = User::select(['first_name', 'last_name'])->find($tour->tourGuidKoochitaId);
            $tour->tourGuidName = $guid->first_name . ' ' . $guid->last_name;
        }

        return response()->json(['status' => 'ok', 'result' => $tour]);
    }


}
