<?php

namespace App\Http\Controllers;

use App\models\Activity;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\LogModel;
use App\models\places\Place;
use App\models\places\PlaceFeatureRelation;
use App\models\places\PlaceFeatures;
use App\models\places\PlacePic;
use App\models\places\PlaceStyle;
use App\models\SectionPage;
use App\models\State;
use App\models\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class AmakenController extends Controller {

    private function getSimilarAmakens($place)
    {

        $stateId = State::whereId(Cities::whereId($place->cityId)->stateId)->id;

        $amakens = DB::Select('select * from amaken where cityId in (select cities.id from cities where stateId = ' . $stateId . ')');
        $arr = [];
        $count = 0;

        foreach ($amakens as $amaken) {

            if ($amaken->id == $place->id) {
                $amaken->point = -1;
                continue;
            }

            $point = 0;
            if ($amaken->tarikhibana == $place->tarikhibana)
                $point += 3;
            if ($amaken->modern == $place->modern)
                $point += 3;
            if ($amaken->mamooli == $place->mamooli)
                $point += 3;
            if ($amaken->tabiat == $place->tabiat)
                $point += 3;
            if ($amaken->kooh == $place->kooh)
                $point += 3;
            if ($amaken->darya == $place->darya)
                $point += 3;

            $arr[$count++] = [$count, $point];

        }

        usort($arr, function ($a, $b) {
            return $a[1] - $b[1];
        });

        $out = [$amakens[$arr[0][0]], $amakens[$arr[1][0]], $amakens[$arr[2][0]], $amakens[$arr[3][0]]];

        $kindPlaceId = Place::whereName('اماکن')->first()->id;
        for ($i = 0; $i < count($out); $i++) {
            if (file_exists((__DIR__ . '/../../../../assets/_images/amaken/' . $out[$i]->file . '/f-1.jpg')))
                $out[$i]->pic = URL::asset("_images/amaken/" . $out[$i]->file . '/f-1.jpg');
            else
                $out[$i]->pic = URL::asset("images/mainPics/noPicSite.jpg");

            $condition = ['placeId' => $out[$i]->id, 'kindPlaceId' => $kindPlaceId, 'confirm' => 1,
                'activityId' => Activity::whereName('نظر')->first()->id];

            $out[$i]->reviews = LogModel::where($condition)->count();
            $out[$i]->rate = $out[$i]->fullRate;
        }

        return $out;
    }

    public function getSimilarsAmaken() {

        if (isset($_POST["placeId"])) {
            $place = Amaken::whereId(makeValidInput($_POST["placeId"]));
            if ($place != null) {
                echo \GuzzleHttp\json_encode($this->getSimilarAmakens($place));
                return;
            }
        }

        echo \GuzzleHttp\json_encode([]);
    }
}
