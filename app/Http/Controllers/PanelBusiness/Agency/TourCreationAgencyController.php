<?php

namespace App\Http\Controllers\PanelBusiness\Agency;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PanelBusiness\Agency\Tour\cityTourismCreationController;
use App\Http\Controllers\PanelBusiness\Agency\Tour\MultiDayTourCreationController;
use App\models\Business\Business;
use App\models\Cities;
use App\models\State;
use App\models\tour\Tour;
use App\models\tour\TourDifficult;
use App\models\tour\TourDiscount;
use App\models\tour\TourEquipment;
use App\models\tour\TourFeature;
use App\models\tour\TourFitFor;
use App\models\tour\TourKind_Tour;
use App\models\tour\TourPeriod;
use App\models\tour\TourPic;
use App\models\tour\TourPrices;
use App\models\tour\TourStyle_Tour;
use App\models\tour\TourTimes;
use App\models\tour\Transport_Tour;
use App\models\tour\TransportKind;
use App\models\users\UserInfoNeeded;
use App\User;
use ClassesWithParents\CInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class TourCreationAgencyController extends Controller{

    public $tourKindInfo = [
        'cityTourism' => ['code' => 1]
    ];
    public $assetLocation = __DIR__.'/../../../../../../assets';
    public $defaultViewLocation = 'panelBusiness.pages.Agency';

    public function tourCreateUrlManager($business, $tourId = 0){
        $view = "{$this->defaultViewLocation}.tour.create.createTour_beforeStart";
        return view($view);
    }

    public function tourCreateStageOne($business, $tourId, $type = ''){
        $tour = Tour::select(['id', 'userId', 'businessId', 'name', 'type', 'srcId', 'userInfoNeed', 'private', 'cancelAble', 'cancelDescription'])->find($tourId);

        if($tour != null){
            $business = Business::find($business);
            if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
                return redirect(route('businessManagement.tour.list', ['business' => $business->id]));

            if($tour->type === 'cityTourism')
                $class = new cityTourismCreationController();
            else
                $class = new MultiDayTourCreationController();

            $tour = $class->showStep_1($tour);
            $type = $tour->type;
        }

        if ($type === 'cityTourism')
            $view = "{$this->defaultViewLocation}.tour.create.cityTourism.createTour_cityTourism_stage_1";
        else
            $view = "{$this->defaultViewLocation}.tour.create.createTour_stage_1";

        $states = State::all();
        return view($view, compact(['tour', 'states', 'type']));
    }
    public function tourStoreStageOne(Request $request){
        $business = Business::find($request->businessId);
        if($business != null && ($business->type == 'agency')){

            if($request->tourType === 'cityTourism')
                $createClass = new cityTourismCreationController();
            else
                $createClass = new MultiDayTourCreationController();

            $result = $createClass->storeStep_1($request, $business);

            if ($result['status'] === 'ok')
                return response()->json(['status' => 'ok', 'result' => $result['result']->id]);
            else
                return response()->json(['status' => $result['status'], 'result' => $result['errors']]);
        }
        else
            return response()->json(['status' => 'notBusinessAccess']);
    }

    public function tourCreateStageTwo($businessId, $tourId){
        $business = Business::find($businessId);
        $tour = Tour::find($tourId);

        if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
            return redirect(route('businessManagement.tour.list', ['business' => $business->id]));

        if($tour->type === 'cityTourism')
            $class = new cityTourismCreationController();
        else
            $class = new MultiDayTourCreationController();

        return $class->showStep_2($tour);
    }
    public function tourStoreStageTwo(Request $request){
        $tour = Tour::find($request->tourId);

        if($tour != null && $tour->userId == auth()->user()->id){

            if($tour->type === 'cityTourism')
                $createClass = new cityTourismCreationController();
            else
                $createClass = new MultiDayTourCreationController();

            $result = $createClass->storeStep_2($request, $tour);
            if($result === 'ok')
                return response()->json(['status' => 'ok']);
            else
                return response()->json(['status' => 'error']);
        }
        else
            return response()->json(['status' => 'notYours']);
    }

    public function tourCreateStageThree($businessId, $tourId){
        $business = Business::find($businessId);
        $tour = Tour::find($tourId);

        if($tour != null){
            if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
                return redirect(route('businessManagement.tour.list', ['business' => $business->id]));

            if($tour->type === 'cityTourism')
                $class = new cityTourismCreationController();
            else
                $class = new MultiDayTourCreationController();

            return $class->showStep_3($tour);
        }
        else
            abort(404);
    }
    public function tourStoreStageThree(Request $request)
    {
        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){
            if($tour->type === 'cityTourism')
                $createClass = new cityTourismCreationController();
            else
                $createClass = new MultiDayTourCreationController();

            $result = $createClass->storeStep_3($request, $tour);
            if($result === 'ok')
                return response()->json(['status' => 'ok']);
            else
                return response()->json(['status' => 'error']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function tourCreateStageFour($businessId, $tourId){
        $business = Business::find($businessId);
        $tour = Tour::find($tourId);
        if(auth()->user()->id == $tour->userId){
            if($tour != null){
                if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
                    return redirect(route('businessManagement.tour.list', ['business' => $business->id]));

                if($tour->type === 'cityTourism')
                    $class = new cityTourismCreationController();
                else
                    $class = new MultiDayTourCreationController();

                return $class->showStep_4($tour);
            }
        }

        abort(404);
    }
    public function tourStoreStageFour(Request $request)
    {
        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){
            if($tour->type === 'cityTourism')
                $createClass = new cityTourismCreationController();
            else
                $createClass = new MultiDayTourCreationController();

            $result = $createClass->storeStep_4($request, $tour);

            if($result === 'ok')
                return response()->json(['status' => 'ok']);
            else
                return response()->json(['status' => 'error']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function tourCreateStageFive($businessId, $tourId){
        $business = Business::find($businessId);
        $tour = Tour::find($tourId);

        if($tour->userId == auth()->user()->id){
            if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
                return redirect(route('businessManagement.tour.list', ['business' => $business->id]));

            if($tour->type === 'cityTourism')
                $class = new cityTourismCreationController();
            else
                $class = new MultiDayTourCreationController();

            return $class->showStep_5($tour);
        }
        else
            return redirect()->back();
    }
    public function tourStoreStageFive(Request $request){

        $tour = Tour::find($request->tourId);

        if($tour->userId == auth()->user()->id){
            if($tour->type === 'cityTourism')
                $class = new cityTourismCreationController();
            else
                $class = new MultiDayTourCreationController();

            $result = $class->storeStep_5($request, $tour);
            if($result === 'ok')
                return response()->json(['status' => 'ok']);
            else
                return response()->json(['status' => 'error']);

        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function tourCreateStageSix($businessId, $tourId){
        $business = Business::find($businessId);
        $tour = Tour::find($tourId);

        if($tour->userId == auth()->user()->id){
            if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
                return redirect(route('businessManagement.tour.list', ['business' => $business->id]));

            $view = "{$this->defaultViewLocation}.tour.create.createTour_stage_6";
            return view($view, compact(['tour']));
        }
        else
            return redirect()->back();
    }

    public function getFullyInfoOfTour($businessId, $tourId){
        $business = Business::find($businessId);
        $tour = Tour::find($tourId);
        if($tour != null){
            if($business->id != $tour->businessId || \auth()->user()->id != $tour->userId)
                return redirect(route('businessManagement.tour.list'));


            $src = Cities::find($tour->srcId);
            $destType = $tour->kindDest === 'city' ? 'cities' : 'majara';
            $dest = \DB::table($destType)->find($tour->destId);

            $tour->srcName = $src->name ?? '';
            $tour->destName = $dest->name ?? '';

            $userInfoNeedTranslator = ['faName' => 'نام و نام خانوادگی فارسی', 'sex' => 'جنسیت',
                                        'birthDay' => 'تاریخ تولد', 'meliCode' => 'کدملی',
                                        'enName' => 'نام و نام خانوادگی انگلیسی', 'country' => 'ملیت',
                                        'passport' => 'اطلاعات پاسپورت'];
            $userInfoNeed = json_decode($tour->userInfoNeed);
            for($i = 0; $i < count($userInfoNeed); $i++)
                $userInfoNeed[$i] = $userInfoNeedTranslator[$userInfoNeed[$i]];
            $tour->userInfoNeed = $userInfoNeed;

            $tour->times = TourTimes::where('tourId', $tour->id)->get();

            $transport = Transport_Tour::where('tourId', $tour->id)->first();
            if($transport != null){
                $sType = TransportKind::find($transport->sTransportId);
                $eType = TransportKind::find($transport->eTransportId);
                $transport->sType = $sType->name ?? '';
                $transport->eType = $eType->name ?? '';

                $transport->sMap = json_decode($transport->sLatLng);
                $transport->eMap = json_decode($transport->eLatLng);
                $tour->transport = $transport;
            }
            else
                $tour->transport = false;

            $sideTransport = json_decode($tour->sideTransport);
            if($sideTransport != null) {
                $sideTransport = TransportKind::whereIn('id', $sideTransport)->pluck('name')->toArray();
                $tour->sideTransport = $sideTransport;
            }
            else
                $tour->sideTransport = [];

            $tour->language = json_decode($tour->language);
            if($tour->language == null)
                $tour->language = [];

            $tour->meals = json_decode($tour->meals);
            if($tour->meals == null)
                $tour->meals = [];

            $tourGuideKoochita = User::find($tour->tourGuidKoochitaId);
            if($tourGuideKoochita != null && $tour->tourGuidKoochitaId > 0)
                $tour->guideName = $tourGuideKoochita->username;
            else
                $tour->guideName = $tour->tourGuidName;

            $tour->minCost = number_format($tour->minCost);
            $otherPrice = TourPrices::where('tourId', $tour->id)->orderBy('ageFrom')->get();
            foreach ($otherPrice as $item){
                if($item->isFree == 0)
                    $item->cost = number_format($item->cost);
            }
            $tour->otherCost = $otherPrice;

            $features = TourFeature::where('tourId', $tour->id)->get();
            foreach($features as $feat)
                $feat->cost = number_format($feat->cost);
            $tour->features = $features;

            $tour->groupDiscount = TourDiscount::where('tourId', $tour->id)->whereNotNull('minCount')->whereNotNull('maxCount')->get();
            $tour->remainingDay = TourDiscount::where('tourId', $tour->id)->whereNotNull('remainingDay')->orderBy('remainingDay')->get();

            $tour->kind = TourKind_Tour::join('tourKind', 'tourKind.id', 'tourKind_tour.kindId')
                                    ->where('tourKind_tour.tourId', $tour->id)
                                    ->pluck('tourKind.name')->toArray();

            $tour->defficult = TourDifficult::join('tourDifficult_tours', 'tourDifficult_tours.difficultId', 'tourDifficults.id')
                                            ->where('tourDifficult_tours.tourId', $tour->id)->select(['tourDifficults.name'])->first();
            if($tour->defficult != null)
                $tour->defficult = $tour->defficult->name;


            $fitFor = TourFitFor::join('tourFitFor_Tours', 'tourFitFor_Tours.fitForId', 'tourFitFor.id')
                                ->where('tourFitFor_Tours.tourId', $tour->id)->pluck('tourFitFor.name')->toArray();
            $tour->fitFor = implode('-', $fitFor);

            $tourStyle = TourStyle_Tour::join('tourStyles', 'tourStyles.id', 'tourStyle_tour.styleId')
                                        ->where('tourStyle_tour.tourId', $tour->id)
                                        ->pluck('tourStyles.name')
                                        ->toArray();
            $tour->style = implode('-', $tourStyle);

            $equip = TourEquipment::join('subEquipments', 'subEquipments.id','tourEquipments.subEquipmentId')
                                ->where('tourEquipments.tourId', $tour->id)
                                ->select(['tourEquipments.isNecessary', 'subEquipments.name'])
                                ->get()->groupBy('isNecessary');

            if(count($equip) > 0) {
                $tour->notNeccesseryEquip = implode('-', $equip[0]->pluck('name')->toArray());
                $tour->neccesseryEquip = implode('-', $equip[1]->pluck('name')->toArray());
            }

            $pics = TourPic::where('tourId', $tour->id)->pluck('pic')->toArray();
            $baseUrl = URL::asset("_images/tour/{$tour->id}");
            for($i = 0; $i < count($pics); $i++)
                $pics[$i] = $baseUrl.'/'.$pics[$i];
            $tour->pics = $pics;


            if($tour->confirm == 0) {
                $tour->statusText = 'در حال بررسی';
                $tour->statusCode = 0;
            }
            else if($tour->isPublished == 0){
                $tour->statusText = 'پیش نویس';
                $tour->statusCode = 1;
            }
            else{
                $tour->statusText = 'منتشر شده';
                $tour->statusCode = 2;
            }

            return view("{$this->defaultViewLocation}.tour.fullTourInfo", compact(['tour']));
        }
        else
            return redirect(route('businessManagement.tour.list'));
    }

    public function tourStorePic(Request $request){

        $start = microtime(true);
        $data = json_decode($request->data);

        $tour = Tour::find($data->tourId);
        if($tour->userId == auth()->user()->id){
            $direction = "{$this->assetLocation}/_images/tour";
            if(!is_dir($direction))
                mkdir($direction);

            $direction .= '/'.$tour->id;
            if(!is_dir($direction))
                mkdir($direction);

            if(isset($request->cancelUpload) && $request->cancelUpload == 1){
                $direction .= '/'.$request->storeFileName;
                if(is_file($direction))
                    unlink($direction);

                TourPic::where('tourId', $tour->id)->where('pic', $request->storeFileName)->delete();
                return response()->json(['status' => 'canceled']);
            }

            if(isset($request->storeFileName) && isset($request->file_data) && $request->storeFileName != 0){
                $fileName = $request->storeFileName;
                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->file_data);
            }
            else{
                $fileType = explode('.', $request->file_name);
                $fileName = time().'_'.rand(100, 999).'_'.$tour->id.'.'.end($fileType);

                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->file_data);

                if($result) {
                    $limbo = new TourPic();
                    $limbo->tourId = $tour->id;
                    $limbo->pic = $fileName;
                    $limbo->save();
                }
            }

            if($result)
                return response()->json(['status' => 'ok', 'fileName' => $fileName, 'time' => microtime(true)-$start]);
            else
                return response()->json(['status' => 'nok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function tourDeletePic(Request $request){
        $tour = Tour::find($request->tourId);
        $picName = $request->fileName;
        if($tour->userId == auth()->user()->id){
            $location = "{$this->assetLocation}/_images/tour/{$tour->id}";
            $pic = TourPic::where('tourId', $tour->id)->where('pic', $picName)->first();
            if($pic != null){
                if(is_file($location.'/'.$picName))
                    unlink($location.'/'.$picName);
                $pic->delete();
                return response()->json(['status' => 'ok']);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function tourUpdateTimeStatus(Request $request){
        $tourTimeId = $request->timeId;
        $tourTime = TourTimes::find($tourTimeId);
        if($tourTime != null){
            $tour = Tour::find($tourTime->tourId);
            if($tour != null){
                if($tour->userId == \auth()->user()->id){
                    $tourTime->isPublished = $tourTime->isPublished == 1 ? 0 : 1;
                    $tourTime->save();

                    return response()->json(['status' => 'ok', 'result' => $tourTime->isPublished]);
                }
                else
                    return response()->json(['status' => 'notAccess']);
            }
            else
                return response()->json(['status' => 'notFoundTour']);
        }
        else
            return response()->json(['status' => 'notFound']);
    }

    public function tourUpdateTourPublished(Request $request){
        $tour = Tour::find($request->tourId);
        if($tour != null){
            if($tour->userId == \auth()->user()->id){
                $tour->isPublished = $tour->isPublished == 1 ? 0 : 1;
                $tour->save();

                return response()->json(['status' => 'ok', 'publish' => $tour->isPublished]);
            }
            else
                return response()->json(['status' => 'notAccess']);
        }
        else
            return response()->json(['status' => 'notFound']);
    }

    public function deleteTour(Request $request){
        $tour = Tour::find($request->tourId);
        if($tour != null){
            if($tour->userId == \auth()->user()->id){
                $response = $tour->fullyDeleted();
                if($response['status'] == 'ok')
                    return response()->json(['status' => 'ok']);
                else if($response['status'] == 'hasRegistered')
                    return response()->json(['status' => 'registered']);
            }
            else
                return response()->json(['status' => 'notAccess']);
        }
        else
            return response()->json(['status' => 'notFound']);
    }
}

