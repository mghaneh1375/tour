<?php

namespace App\Http\Controllers;


use App\models\Activity;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\LogModel;
use App\models\places\Place;
use App\models\places\PlaceStyle;
use App\models\places\Restaurant;
use App\models\SectionPage;
use App\models\State;
use App\models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class RestaurantController extends Controller {

    private function getSimilarRestaurants($place)
    {

        $stateId = State::whereId(Cities::whereId($place->cityId)->stateId)->id;

        $restaurants = DB::Select('select * from restaurant where cityId in (select cities.id from cities where stateId = ' . $stateId . ')');
        $arr = [];
        $count = 0;

        foreach ($restaurants as $restaurant) {

            if ($restaurant->id == $place->id) {
                $restaurant->point = -1;
                continue;
            }

            $point = 0;
            if ($restaurant->modern == $place->modern)
                $point += 3;
            if ($restaurant->mamooli == $place->mamooli)
                $point += 3;
            if ($restaurant->kind_id == $place->kind_id)
                $point += 3;
            if ($restaurant->food_irani == $place->food_irani)
                $point += 3;
            if ($restaurant->food_farangi == $place->food_farangi)
                $point += 3;
            if ($restaurant->food_mahali == $place->food_mahali)
                $point += 3;

            $arr[$count++] = [$count, $point];

        }

        usort($arr, function ($a, $b) {
            return $a[1] - $b[1];
        });

        $out = [$restaurants[$arr[0][0]], $restaurants[$arr[1][0]], $restaurants[$arr[2][0]], $restaurants[$arr[3][0]]];

        $kindPlaceId = Place::whereName('رستوران')->first()->id;
        for ($i = 0; $i < count($out); $i++) {
            if (file_exists((__DIR__ . '/../../../../assets/_images/restaurant/' . $out[$i]->file . '/f-1.jpg')))
                $out[$i]->pic = URL::asset("_images/restaurant/" . $out[$i]->file . '/f-1.jpg');
            else
                $out[$i]->pic = URL::asset("images/mainPics/noPicSite.jpg");

            $condition = ['placeId' => $out[$i]->id, 'kindPlaceId' => $kindPlaceId, 'confirm' => 1,
                'activityId' => Activity::whereName('نظر')->first()->id];

            $out[$i]->reviews = LogModel::where($condition)->count();
            $out[$i]->rate = getRate($out[$i]->id, $kindPlaceId)[1];
        }

        return $out;
    }

    public function getSimilarsRestaurant()
    {

        if (isset($_POST["placeId"])) {
            $place = Restaurant::whereId(makeValidInput($_POST["placeId"]));
            if ($place != null) {
                echo \GuzzleHttp\json_encode($this->getSimilarRestaurants($place));
                return;
            }
        }

        echo \GuzzleHttp\json_encode([]);
    }

}
