<?php

namespace App\Http\Controllers;

use App\models\Alert;
use App\models\places\Amaken;
use App\models\places\Boomgardy;
use App\models\places\Hotel;
use App\models\LogFeedBack;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\places\Majara;
use App\models\PhotographersLog;
use App\models\PhotographersPic;
use App\models\places\Place;
use App\models\QuestionUserAns;
use App\models\Report;
use App\models\places\Restaurant;
use App\models\ReviewPic;
use App\models\ReviewUserAssigned;
use App\models\places\SogatSanaie;
use Illuminate\Http\Request;

class DeleteContentController extends Controller
{
    public function deleteAlbumPic(Request $request)
    {
        if(isset($request->id)){
            $id = explode( '_', $request->id);
            if(count($id) == 2){
                if($id[0] == 'review'){
                    $reviewPic = ReviewPic::find($id[1]);
                    if($reviewPic != null){
                        $logModal = LogModel::find($reviewPic->logId);
                        if(auth()->check() && $logModal->visitorId == auth()->user()->id) {
                            $kindPlace = Place::find($logModal->kindPlaceId);
                            $place = \DB::table($kindPlace->tableName)->find($logModal->placeId);
                            $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlace->fileName . '/' . $place->file . '/' . $reviewPic->pic;
                            if (is_file($location)) {
                                unlink($location);
                                $reviewPic->delete();
                                echo json_encode(['status' => 'ok']);
                            }
                            else
                                echo json_encode(['status' => 'fileNotFound']);
                        }
                        else
                            echo json_encode(['status' => 'authError']);
                    }
                    else
                        echo json_encode(['status' => 'notFound']);
                }
                else if($id[0] == 'photographer'){
                    $pic = PhotographersPic::find($id[1]);
                    if($pic != null){
                        if(auth()->check() && auth()->user()->id == $pic->userId){
                            $kindPlace = Place::find($pic->kindPlaceId);
                            $place = \DB::table($kindPlace->tableName)->find($pic->placeId);
                            $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlace->fileName . '/' . $place->file;

                            $picFormat = ['', 't-', 's-', 'l-', 'f-'];
                            foreach ($picFormat as $item)
                                if (is_file($location . '/' . $item . $pic->pic))
                                    unlink($location . '/' . $item . $pic->pic);

                            PhotographersLog::where('picId', $pic->id)->delete();
                            $pic->delete();
                            echo json_encode(['status' => 'ok']);
                        }
                        else
                            echo json_encode(['status' => 'authError']);
                    }
                    else
                        echo json_encode(['status' => 'notFound']);
                }
                else
                    echo json_encode(['status' => 'nok2']);
            }
            else
                echo json_encode(['status' => 'nok1']);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

}
