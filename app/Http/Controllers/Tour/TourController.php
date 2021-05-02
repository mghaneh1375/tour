<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\models\Cities;
use App\models\tour\Tour;
use App\models\tour\TourDiscount;
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
use Illuminate\Support\Facades\URL;

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

    public function tourMainPage(){
        return view('pages.tour.mainPageTourF.mainPageTour');
    }

    public function getMainPageTours(){
        $type = $_GET['type'];
        $categoryName = '';
        $destinations = [];

        if($type === 'cityTourism'){
            $categoryName = 'شهر گردی';
            $tours = TourTimes::YouCanSee()
                ->join('tour', 'tour.id', 'tourTimes.tourId')
                ->join('tourPics', 'tourPics.tourId', 'tour.id')
                ->join('cities', 'cities.id', 'tour.srcId')
                ->join('state', 'state.id', 'cities.stateId')
                ->join('business', 'business.id', 'tour.businessId')
                ->where(['tour.isPublished' => 1, 'tour.confirm' => 1, 'tour.type' => $type])
                ->select(['tour.id', 'tour.name', 'tour.code', 'tour.srcId', 'tour.type',
                    'tourTimes.sDate', 'tourTimes.id AS timeId', 'tourTimes.cost AS cost',
                    'tourPics.pic', 'business.name AS agencyName',
                    'business.logo AS agencyLogo',
                    'cities.id AS cityId', 'cities.name AS cityName',
                    'state.name AS stateName'])
                ->orderBy('tourTimes.sDate')
                ->groupBy('tour.code')
                ->get();

            $destinations = TourTimes::YouCanSee()
                ->join('tour', 'tour.id', 'tourTimes.tourId')
                ->join('cities', 'cities.id', 'tour.srcId')
                ->where(['tour.isPublished' => 1, 'tour.confirm' => 1, 'tour.isLocal' => 1])
                ->select(['cities.*'])
                ->groupBy('tour.srcId')
                ->get();

            foreach ($destinations as $item){
                $item->url = '#';
                $item->pic = URL::asset("_images/city/{$item->id}/{$item->image}");
            }
        }
        else if($type === 'iranTour'){
            $categoryName = 'ایران گردی';
            $tours = TourTimes::YouCanSee()
                ->join('tour', 'tour.id', 'tourTimes.tourId')
                ->join('tourPics', 'tourPics.tourId', 'tour.id')
                ->join('cities', 'cities.id', 'tour.srcId')
                ->join('state', 'state.id', 'cities.stateId')
                ->join('business', 'business.id', 'tour.businessId')
                ->where(['tour.isPublished' => 1, 'tour.confirm' => 1, 'tour.isLocal' => 0])
                ->select(['tour.id', 'tour.name', 'tour.code', 'tour.day', 'tour.night', 'tour.srcId', 'tour.destId', 'tour.minCost',
                    'tourTimes.sDate',
                    'tourPics.pic', 'business.name AS agencyName', 'business.logo AS agencyLogo',
                    'cities.id AS cityId', 'cities.name AS cityName',
                    'state.name AS stateName'])
                ->orderBy('tourTimes.sDate')
                ->groupBy('tour.code')
                ->get();

            $destinations = TourTimes::YouCanSee()
                ->join('tour', 'tour.id', 'tourTimes.tourId')
                ->join('cities', 'cities.id', 'tour.destId')
                ->where(['tour.isPublished' => 1, 'tour.confirm' => 1, 'tour.isLocal' => 0, 'tour.kindDest' => 'city'])
                ->select(['cities.*'])
                ->groupBy('tour.srcId')
                ->get();

            foreach($tours as $tour) {
                $tour->categoryName = 'ایران گردی';
            }

            foreach ($destinations as $item){
                $item->url = '#';
                $item->pic = URL::asset("_images/city/{$item->id}/{$item->image}");
            }
        }
        else if($type === 'road'){
            $categoryName = 'مسیرگردی';
            $tours = [];
        }

        foreach($tours as $tour){
            $tour->categoryName = $categoryName;
            $tour->pic = URL::asset("_images/tour/{$tour->id}/{$tour->pic}");
            $tour->url = route('tour.show', ['code' => $tour->code]);
            $tour->minCost = number_format($tour->minCost);

            $tour->agencyPic = URL::asset("storage/{$tour->agencyLogo}");
        }

        return response()->json(['status' => 'ok', 'result' => ['tour' => $tours, 'destinations' => $destinations]]);

    }

    public function showTour($code){
        $this->defaultActions();

        $tour = Tour::join('business', 'business.id', 'tour.businessId')
                    ->where('tour.code', $code)
                    ->select(['tour.*', 'business.name AS agencyName', 'business.logo AS agencyLogo', 'business.tel AS agencyPhone'])
                    ->first();

        if($tour == null)
            abort(404);

        $tour->agencyLogo = URL::asset("storage/{$tour->agencyLogo}");

        if($tour->isPublish === 0 || $tour->confirm === 0){
            $you = auth()->check() ? auth()->user() : null;
            if($you === null || $you->id != $tour->userId)
                return redirect(route("tour.main"));
        }

        $owner = User::find($tour->userId);
        $ownerPic = getUserPic($owner->id);

        $tour->timeCode = isset($_GET['timeCode']) ? $_GET['timeCode'] : TourTimes::where('tourId', $tour->id)->orderBy('sDate')->first()->code;

        $tour->src = Cities::find($tour->srcId);
        if($tour->isLocal == 0){
            $table = $tour->kindDest == 'city' ? 'cities' : 'majara';
            $tour->dest = \DB::table($table)->select(['id', 'name'])->find($tour->destId);
        }
        else
            $tour->dest = (object)['name' => ''];


        $tour->pics = TourPic::where(['tourId' => $tour->id])->get();
        foreach ($tour->pics as $pic) {
            $pic->pic = $pic->getPicUrl();
            $pic->userPic = $ownerPic;
        }

        $guid = ['pic' => '', 'name' => '', 'koochita' => false, 'has' => false];
        if($tour->isTourGuidDefined == 1) {
            $guid['has'] = true;
            if ($tour->tourGuidKoochitaId == 0) {
                $guid['pic'] = getUserPic(0);
                $guid['name'] = $tour->tourGuidName;
            }
            else{
                $tourGuid = User::find($tour->tourGuidKoochitaId);
                if ($tourGuid != null) {
                    $guid['koochita'] = true;
                    $guid['pic'] = getUserPic($tourGuid->id);
                    $guid['name'] = $tourGuid->username;
                }
            }
        }

        $tour->guid = (object)$guid;

        if($tour->backupPhone != null)
            $tour->backupPhone = explode('-', $tour->backupPhone);
        else
            $tour->backupPhone = [$tour->agencyPhone];

        return view('pages.tour.tour-details', compact(['tour']));
    }

    public function getFullTourInformation(){
        $code = $_GET['code'];

        $tour = Tour::where('code', $code)->first();

        $thisTour = ['tourId' => $tour->id];

        $tour->src = Cities::select(['id', 'name'])->find($tour->srcId);
        if($tour->type !== 'cityTourism'){
            $table = $tour->kindDest == 'city' ? 'cities' : 'majara';
            $tour->dest = \DB::table($table)->select(['id', 'name'])->find($tour->destId);
        }
        else
            $tour->dest = (object)['name' => ''];

        $tour->cost = number_format($tour->minCost);

        $sideTransport = [];
        $sideTransportId = json_decode($tour->sideTransport);
        if(is_array($sideTransportId))
            $sideTransport = TransportKind::whereIn('id', $sideTransportId)->pluck('name')->toArray();

        $tour->sideTransport = $sideTransport;

        $tour->kinds = $tour->kinds()->pluck('name')->toArray();
        $tour->style = $tour->Styles()->pluck('name')->toArray();
        $tour->fitFor = $tour->FitFor()->pluck('name')->toArray();
        $tour->difficult = $tour->Difficults()->pluck('name')->toArray();

        $tour->language = json_decode($tour->language);

        if($tour->isTransport == 1){
            $tour->mainTransport = Transport_Tour::where($thisTour)->first();
            $tour->mainTransport->sTransportName = TransportKind::find($tour->mainTransport->sTransportId)->name;
            if($tour->mainTransport->eTransportId != 0)
                $tour->mainTransport->eTransportName = TransportKind::find($tour->mainTransport->eTransportId)->name;
            else
                $tour->mainTransport->eTransportName = $tour->mainTransport->sTransportName;
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

        $times = TourTimes::youCanSee()->where('tourId', $tour->id)->orderBy('sDate')->get();
        foreach($times as $item){

            $stt = explode('/', $item->sDate);
            $item->sDateName = Verta::createJalali($stt[0], $stt[1], $stt[2])->format('%A Y/m/d');

            if($item->eDate != null) {
                $ett = explode('/', $item->eDate);
                $item->eDateName = Verta::createJalali($ett[0], $ett[1], $ett[2])->format('%A Y/m/d');
            }

            $item->anyCapacity = 0;
            $item->capacityRemaining = $item->maxCapacity - $item->registered;
            $item->hasCapacity = ($item->capacityRemaining > 0);
        }
        $tour->timeAndPrices = $times;

        if($tour->tourGuidKoochitaId != 0){
            $guid = User::select(['first_name', 'last_name'])->find($tour->tourGuidKoochitaId);
            $tour->tourGuidName = $guid->first_name . ' ' . $guid->last_name;
        }

        return response()->json(['status' => 'ok', 'result' => $tour]);
    }

    private function defaultActions(){
        $tourReserve = TourUserReservation::where('created_at', '<', Carbon::now()->subMinute(25))->get();
        foreach ($tourReserve as $item)
            $item->deleteAndReturnCapacity();

        $nowDate = \verta()->format('Y/m/d');
        TourTimes::where('sDate', '<=', $nowDate)->where('canRegister', 1)->update(['canRegister' => 0]);
    }
}
