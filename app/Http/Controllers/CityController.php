<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\places\Amaken;
use App\models\places\Boomgardy;
use App\models\Cities;
use App\models\CityPic;
use App\models\places\Hotel;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\places\Majara;
use App\models\places\Place;
use App\models\places\PlacePic;
use App\models\Question;
use App\models\places\Restaurant;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\places\SogatSanaie;
use App\models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CityController extends Controller
{
    public function cityPage($kind, $city, Request $request) {
        $todayFunc = getToday();
        $city = str_replace('+', ' ', $city);
        $today = $todayFunc["date"];
        $nowTime = $todayFunc["time"];
        if($kind == 'state')
            $place = State::where('name', $city)->first();
        else
            $place = Cities::where('name', $city)->first();

        if($place == null)
            return redirect(\url('/'));

        if($kind == 'city') {
            $place->state = State::whereId($place->stateId)->name;
            $place->listName = $place->name;
            $articleUrl = route('safarnameh.list', ['type' => 'city', 'search' => $place->listName]);
            $locationName = [ "name" => $place->name, "state" => $place->state, "stateNameUrl" => $place->state,
                              "cityName" => $place->name, "cityNameUrl" => $place->listName, "articleUrl" => $articleUrl,
                              "kindState" => 'city'];

            $allAmakenId = Amaken::where('cityId', $place->id)->pluck('id')->toArray();
            $allAmaken = Amaken::where('cityId', $place->id)->count();
            $allMajara = Majara::where('cityId', $place->id)->count();
            $allHotels = Hotel::where('cityId', $place->id)->count();
            $allRestaurant = Restaurant::where('cityId', $place->id)->count();
            $allMahaliFood = MahaliFood::where('cityId', $place->id)->count();
            $allSogatSanaie = SogatSanaie::where('cityId', $place->id)->count();
            $allBoomgardy = Boomgardy::where('cityId', $place->id)->count();
            $allSafarnamehCount = SafarnamehCityRelations::where('cityId', $place->id)->count();
        }
        else {
            $place->listName = $place->name;
            $place->name = 'استان ' . $place->name;
            $articleUrl = route('safarnameh.list', ['type' => 'state', 'search' => $place->listName]);
            $locationName = ["name" => $place->name, 'cityName' => $place->name, 'cityNameUrl' => $place->listName,
                            "state" => $place->name, "stateNameUrl" => $place->listName,
                            'articleUrl' => $articleUrl, 'kindState' => 'state'];

            $allCities = Cities::where('stateId', $place->id)->where('isVillage',0)->pluck('id')->toArray();

            $allAmakenId = Amaken::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allAmaken = Amaken::whereIn('cityId', $allCities)->count();
            $allMajara = Majara::whereIn('cityId', $allCities)->count();
            $allHotels = Hotel::whereIn('cityId', $allCities)->count();
            $allRestaurant = Restaurant::whereIn('cityId', $allCities)->count();
            $allMahaliFood = MahaliFood::whereIn('cityId', $allCities)->count();
            $allSogatSanaie = SogatSanaie::whereIn('cityId', $allCities)->count();
            $allBoomgardy = Boomgardy::whereIn('cityId', $allCities)->count();
            $allSafarnamehCount = SafarnamehCityRelations::where('stateId', $place->id)->count();
        }
        $mainLocation = __DIR__ . '/../../../../assets/_images';

        if($place->image != null && is_file($mainLocation."/city/$place->id/$place->image"))
            $place->image = URL::asset("_images/city$place->id/$place->image");
        else
            $place->image = URL::asset('_images/nopic/blank.jpg');

        $pics = [];
        $DBpic = PlacePic::join('amaken', 'amaken.id', 'placePics.placeId')
                        ->where('placePics.kindPlaceId', 1)
                        ->whereIn('placePics.placeId', $allAmakenId)
                        ->select(['amaken.id', 'amaken.picNumber AS mainPic', 'amaken.keyword', 'amaken.name', 'amaken.file', 'placePics.alt', 'placePics.picNumber'])
                        ->get();

        $location = $mainLocation.'/amaken/';
        foreach ($DBpic as $item){
            $mainPic = null;
            $smallPic = null;
            if(is_file($location.$item->file.'/s-'.$item->picNumber))
                $mainPic= URL::asset("_images/amaken/$item->file/s-$item->picNumber");

            if(is_file($location.$item->file.'/l-'.$item->picNumber))
                $smallPic = URL::asset("_images/amaken/$item->file/l-$item->picNumber");
            else
                $smallPic = $mainPic;

            if($mainPic != null)
                array_push($pics, [
                    'mainPic' => $mainPic,
                    'smallPic' => $smallPic,
                    'alt' => $item->keyword,
                    'name' => $item->name,
                    'url' => route('placeDetails', ['kindPlaceId' => 1, 'placeId' => $item->id])
                ]);
        }

        $place->pic = $pics;

        $placeCounts = [
            'amaken' => $allAmaken,
            'majara' => $allMajara,
            'hotel' => $allHotels,
            'restaurant' => $allRestaurant,
            'mahaliFood' => $allMahaliFood,
            'sogatSanaie' => $allSogatSanaie,
            'boomgardy' => $allBoomgardy,
            'safarnameh' => $allSafarnamehCount,
        ];

        $safarnameh = [];
        $safarnamehId = [];
        $postTake = 7;
        if($kind == 'state')
            $safarnamehId = SafarnamehCityRelations::where('stateId', $place->id)->pluck('safarnamehId')->toArray();
        else{
            $safarnamehId = SafarnamehCityRelations::where('cityId', $place->id)->pluck('safarnamehId')->toArray();
            if(count($safarnamehId) < $postTake){
                $less = $postTake - count($safarnamehId);
                $pId = SafarnamehCityRelations::where('stateId', $place->stateId)->take($less)->pluck('safarnamehId')->toArray();
                $safarnamehId = array_merge($safarnamehId, $pId);
            }
        }
        if(count($safarnamehId) != 0){
            $pt = Safarnameh::whereIn('id', $safarnamehId)->where('release', '!=', 'draft')->whereRaw('date < ' .$today. ' OR (date = ' . $today . ' AND time < ' . $nowTime . ' )')->take($postTake)->orderBy('date', 'DESC')->get();
            foreach ($pt as $item)
                array_push($safarnameh, $item);

            if(count($pt) < $postTake){

                $less = $postTake - count($pt);
                $postInRel = SafarnamehCityRelations::all()->pluck('safarnamehId')->toArray();
                $p = Safarnameh::whereNotIn('id', $safarnamehId)->whereNotIn('id', $postInRel)->where('release', '!=', 'draft')->whereRaw('date < ' .$today. ' OR (date = ' . $today . ' AND time < ' . $nowTime . ' )')->take($less)->orderBy('date', 'DESC')->get();
                foreach ($p as $item)
                    array_push($safarnameh, $item);
            }
        }
        else
            $safarnameh = Safarnameh::where('release', '!=', 'draft')->whereRaw('date < ' .$today. ' OR (date = ' . $today . ' AND time < ' . $nowTime . ' )')->take($postTake)->orderBy('date', 'DESC')->get();
        foreach ($safarnameh as $item)
            $item = SafarnamehMinimalData($item);

        $mainWebSiteUrl = \url('/');
        $mainWebSiteUrl .= '/' . $request->path();
        if($kind == 'state')
            $localStorageData = ['kind' => 'state', 'name' => $place->name , 'city' => '', 'state' => $place->listName, 'mainPic' => $place->image, 'redirect' => $mainWebSiteUrl];
        else
            $localStorageData = ['kind' => 'city', 'name' => $place->name , 'city' => $place->listName, 'state' => $place->state, 'mainPic' => $place->image, 'redirect' => $mainWebSiteUrl];

        return view('cityPage', compact(['place', 'kind', 'localStorageData', 'locationName', 'safarnameh', 'placeCounts']));
    }

    public function getCityPageReview(Request $request)
    {
        $kind = $_GET['kind'];
        $placeId = $_GET['placeId'];
        $take = 15;
        $reviews = $this->getCityReviews($kind, $placeId, $take);
        if(count($reviews) != $take){
            $lessReview = [];
            $notIn = [];
            foreach ($reviews as $item)
                array_push($notIn, $item->id);

            if($kind == 'city'){
                $place = Cities::find($placeId);
                $less = $take - count($reviews);
                $lessReview = $this->getCityReviews('state', $place->stateId, $less, $notIn);
                foreach ($lessReview as $item)
                    array_push($reviews, $item);
            }

            $less = $take - count($reviews);
            if($less != 0){
                $notIn = [];
                foreach ($reviews as $item)
                    array_push($notIn, $item->id);

                $lessReview = $this->getCityReviews('country', 0, $less, $notIn);
                foreach ($lessReview as $item)
                    array_push($reviews, $item);
            }
        }

        foreach ($reviews as $item)
            $item = reviewTrueType($item); // in common.php

        echo json_encode($reviews);
        return;
    }

    public function getCityPageTopPlace()
    {
        $kind = $_GET['kind'];
        $id = $_GET['id'];

        $topAmaken = $this->getTopPlaces(1, $kind, $id);
        $topRestaurant = $this->getTopPlaces(3, $kind, $id);
        $topHotel = $this->getTopPlaces(4, $kind, $id);
        $topMajra = $this->getTopPlaces(6, $kind, $id);
        $topSogatSanaies = $this->getTopPlaces(10, $kind, $id);
        $topMahaliFood = $this->getTopPlaces(11, $kind, $id);
        $topBoomgardy = $this->getTopPlaces(12, $kind, $id);

        $topPlaces = [
            'topBoomgardyCityPage' => $topBoomgardy,
            'topAmakenCityPage' => $topAmaken,
            'topRestaurantInCity' => $topRestaurant,
            'topHotelCityPage' => $topHotel,
            'topMajaraCityPage' => $topMajra,
            'topSogatCityPage' => $topSogatSanaies,
            'topFoodCityPage' => $topMahaliFood
        ];

        return response()->json(['topPlaces' => $topPlaces]);
    }

    public function getCityAllPlaces(Request $request)
    {
        $activityId = Activity::whereName('نظر')->first()->id;

        if($request->kind == 'city'){
            $allAmaken = Amaken::where('cityId', $request->id)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
            $allMajara = Majara::where('cityId', $request->id)->select(['id', 'name', 'slug', 'C', 'D', 'dastresi', 'picNumber', 'file', 'keyword', 'cityId', 'reviewCount', 'fullRate'])->get();
            $allHotels = Hotel::where('cityId', $request->id)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
            $allRestaurant = Restaurant::where('cityId', $request->id)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
            $allBoomgardy = Boomgardy::where('cityId', $request->id)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
        }
        else{
            $allCities = Cities::where('stateId', $request->id)->where('isVillage',0)->pluck('id')->toArray();

            $allAmaken = Amaken::whereIn('cityId', $allCities)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
            $allMajara = Majara::whereIn('cityId', $allCities)->select(['id', 'name', 'slug', 'C', 'D', 'dastresi', 'picNumber', 'file', 'keyword', 'cityId', 'reviewCount', 'fullRate'])->get();
            $allHotels = Hotel::whereIn('cityId', $allCities)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
            $allRestaurant = Restaurant::whereIn('cityId', $allCities)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
            $allBoomgardy = Boomgardy::whereIn('cityId', $allCities)->select(['id', 'name', 'slug', 'C', 'D', 'address', 'picNumber', 'file', 'keyword', 'cityId', 'phone', 'reviewCount', 'fullRate'])->get();
        }
        $allPlaces = ['amaken' => $allAmaken, 'hotels' => $allHotels, 'restaurant' => $allRestaurant, 'majara' => $allMajara, 'boomgardy' => $allBoomgardy];

        $count = 0;
        $C = 0;
        $D = 0;
        foreach ($allPlaces as $key => $plac){
            switch ($key){
                case 'amaken':
                    $kindPlace = Place::find(1);
                    break;
                case 'hotels':
                    $kindPlace = Place::find(4);
                    break;
                case 'restaurant':
                    $kindPlace = Place::find(3);
                    break;
                case 'majara':
                    $kindPlace = Place::find(6);
                    break;
                case 'boomgardy':
                    $kindPlace = Place::find(12);
                    break;
            }
            foreach ($plac as $item){
                if($item->C > 39.817043976810254 || $item->D > 62.148940583173776 || $item->C < 24.337168697512585 || $item->D < 43.75341666481935){
                    $item->C = 37.404470200738906;
                    $item->D = 51.81568255996895;
                    $item->save();
                }

                $location = __DIR__ .'/../../../../assets/_images/' . $kindPlace->fileName . '/' . $item->file;
                $item->pic = null;
                if(is_file($location . '/f-' . $item->picNumber))
                    $item->pic = URL::asset('_images/' . $kindPlace->fileName . '/' . $item->file . '/f-' . $item->picNumber);
                if($item->pic == null)
                    $item->pic = URL::asset('images/mainPics/nopicv01.jpg');

                $item->url = route('placeDetails', ['kindPlaceId' => $kindPlace->id, 'placeId' => $item->id]);
                $cit = Cities::find($item->cityId);
                $item->cityName = $cit->name;
                $item->stateName = $cit->getState->name;
                $item->rate = $item->fullRate;
                if($item->rate == 0)
                    $item->rate = 2;
                $item->review = $item->reviewCount;

                $C += (float)$item->C;
                $D += (float)$item->D;
                $count++;
            }
        }

        if($count > 0) {
            $C /= $count;
            $D /= $count;
        }
        else{
            $C = 32.681757;
            $D = 53.498319;
        }

        $map = ['C' => $C, 'D' => $D];

        $centerPlace = null;

        return response()->json(['map' => $map, 'allPlaces' => $allPlaces, 'centerPlace' => $centerPlace]);
    }

    private function getCityReviews($kind, $id, $take, $notIn = [0]){
        $reviewActivity = Activity::whereName('نظر')->first();

        if($kind == 'city') {
            $allAmaken = Amaken::where('cityId', $id)->pluck('id')->toArray();
            $allMajara = Majara::where('cityId', $id)->pluck('id')->toArray();
            $allHotels = Hotel::where('cityId', $id)->pluck('id')->toArray();
            $allRestaurant = Restaurant::where('cityId', $id)->pluck('id')->toArray();
            $allMahaliFood = MahaliFood::where('cityId', $id)->pluck('id')->toArray();
            $allSogatSanaie = SogatSanaie::where('cityId', $id)->pluck('id')->toArray();
            $allBoomgardy = Boomgardy::where('cityId', $id)->pluck('id')->toArray();
        }
        else if($kind == 'state'){
            $allCities = Cities::where('stateId', $id)->where('isVillage', 0)->pluck('id')->toArray();

            $allAmaken = Amaken::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allMajara = Majara::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allHotels = Hotel::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allRestaurant = Restaurant::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allMahaliFood = MahaliFood::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allSogatSanaie = SogatSanaie::whereIn('cityId', $allCities)->pluck('id')->toArray();
            $allBoomgardy = Boomgardy::whereIn('cityId', $allCities)->pluck('id')->toArray();
        }
        else{
            if(count($notIn) == 0)
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 ORDER BY `date` DESC LIMIT ' . $take);
            else
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 AND id NOT IN (' . implode(",", $notIn) . ') ORDER BY `date` DESC LIMIT ' . $take);

            return $lastReview;
        }


        $sqlQuery = '';
        if(count($allAmaken) != 0)
            $sqlQuery .= '( kindPlaceId = 1 AND placeId IN (' . implode(",", $allAmaken) . ') )';
        if(count($allRestaurant) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 3 AND placeId IN (' . implode(",", $allRestaurant) . ') )';
        }
        if(count($allHotels) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 4 AND placeId IN (' . implode(",", $allHotels) . ') )';
        }
        if(count($allMajara) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 6 AND placeId IN (' . implode(",", $allMajara) . ') )';
        }
        if(count($allSogatSanaie) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 10 AND placeId IN (' . implode(",", $allSogatSanaie) . ') )';
        }
        if(count($allMahaliFood) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 11 AND placeId IN (' . implode(",", $allMahaliFood) . ') )';
        }
        if(count($allBoomgardy) != 0){
            if($sqlQuery != '')
                $sqlQuery .= ' OR ';
            $sqlQuery .= '( kindPlaceId = 12 AND placeId IN (' . implode(",", $allBoomgardy) . ') )';
        }

        $lastReview = [];

        if($sqlQuery != '') {
            if (count($notIn) == 0)
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 AND (' . $sqlQuery . ') ORDER BY `date` DESC LIMIT ' . $take);
            else
                $lastReview = DB::select('SELECT * FROM log WHERE subject != "dontShowThisText" AND activityId = ' . $reviewActivity->id . ' AND confirm = 1 AND (' . $sqlQuery . ') AND id NOT IN (' . implode(",", $notIn) . ') ORDER BY `date` DESC LIMIT ' . $take);
        }

        return $lastReview;
    }

    private function getTopPlaces($kindPlaceId, $kind, $cityId){
        $kindPlace = Place::find($kindPlaceId);
        $seenActivity = Activity::whereName('مشاهده')->first()->id;
        $activityId = Activity::whereName('نظر')->first()->id;
        $ansActivityId = Activity::whereName('پاسخ')->first()->id;
        $quesActivityId = Activity::whereName('سوال')->first()->id;

        $lastMonthDate = Carbon::now()->subMonth()->format('Y-m-d');

        $placeId = [];
        $places = [];

        $cId = [];
        if($kind == 'city')
            $cId[0] = $cityId;
        else
            $cId = Cities::where('stateId', $cityId)->where('isVillage',0)->pluck('id')->toArray();

        $allPlace = DB::table($kindPlace->tableName)->whereIn('cityId', $cId)->pluck('id')->toArray();

        if(count($allPlace) != 0){
            $commonQuery = 'log.kindPlaceId = ' .$kindPlaceId. ' AND log.placeId IN (' . implode(",", $allPlace) . ') AND log.date > ' .$lastMonthDate. ' GROUP BY log.placeId';

            $mostSeen = DB::select('SELECT log.placeId as placeId, COUNT(log.id) as `count` FROM log WHERE log.activityId = ' . $seenActivity . ' AND ' .$commonQuery. ' ORDER BY `count` DESC LIMIT 2');
            foreach ($mostSeen as $item)
                array_push($placeId, $item->placeId);
            if(count($placeId) == 0)
                $placeIdQuery = '0';
            else
                $placeIdQuery = implode(",", $placeId);

            $questionRate = Question::where('ansType', 'rate')->pluck('id')->toArray();
            $mostRate = DB::select('SELECT log.placeId as placeId, AVG(qua.ans) as rate FROM log INNER JOIN questionUserAns AS qua ON  qua.questionId IN (' . implode(",", $questionRate) . ') AND qua.logId = log.id AND log.placeId NOT IN (' . $placeIdQuery . ') AND ' . $commonQuery . ' ORDER BY rate DESC LIMIT 2');
            foreach ($mostRate as $item)
                array_push($placeId, $item->placeId);
            if(count($placeId) == 0)
                $placeIdQuery = '0';
            else
                $placeIdQuery = implode(",", $placeId);


            $mostComment = DB::select('SELECT log.placeId as placeId, COUNT(log.id) as `count` FROM log WHERE (log.activityId = '. $activityId . ' OR log.activityId = ' . $ansActivityId . ' OR log.activityId = ' . $quesActivityId . ') AND log.placeId NOT IN (' . $placeIdQuery . ') AND ' . $commonQuery . ' ORDER BY `count` DESC LIMIT 2');
            foreach ($mostComment as $item)
                array_push($placeId, $item->placeId);
            if(count($placeId) == 0)
                $placeIdQuery = '0';
            else
                $placeIdQuery = implode(",", $placeId);

            $less = 8 - count($placeId);
            $randomPlace = DB::table($kindPlace->tableName)->whereNotIn('id', $placeId)->whereIn('cityId', $cId)->inRandomOrder()->take($less)->pluck('id')->toArray();
            foreach ($randomPlace as $item)
                array_push($placeId, $item);

            $places = DB::table($kindPlace->tableName)->whereIn('id', $placeId)->select(['id', 'cityId','name', 'file', 'picNumber', 'keyword'])->get();
            foreach ($places as $item){

                $item->pic = getPlacePic($item->id, $kindPlace->id);
                $item->url = createUrl($kindPlace->id, $item->id, 0, 0);
                $item->rate = getRate($item->id, $kindPlace->id)[1];
                $item->cityV = Cities::find($item->cityId);
                $item->city =  $item->cityV->name;
                $item->state = State::find($item->cityV->stateId)->name;

                $condition = ['activityId' => $activityId, 'placeId' => $item->id, 'kindPlaceId' => $kindPlace->id, 'confirm' => 1, 'relatedTo' => 0];
                $item->review = LogModel::where($condition)->count();
            }
        }
        return $places;
    }
}
