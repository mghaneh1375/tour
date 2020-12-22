<?php

namespace App\Http\Controllers;

use App\models\Alert;
use App\models\Amaken;
use App\models\Boomgardy;
use App\models\Hotel;
use App\models\LogFeedBack;
use App\models\LogModel;
use App\models\MahaliFood;
use App\models\Majara;
use App\models\PhotographersLog;
use App\models\PhotographersPic;
use App\models\Place;
use App\models\QuestionUserAns;
use App\models\Report;
use App\models\Restaurant;
use App\models\ReviewPic;
use App\models\ReviewUserAssigned;
use App\models\SogatSanaie;
use Illuminate\Http\Request;

class DeleteContentController extends Controller
{
    public function deleteReview(Request $request)
    {
        if(\auth()->check()){
            $user = \auth()->user();
            if(isset($request->id)){
                $review = LogModel::find($request->id);
                if($review != null && $review->visitorId == $user->id){
                    $kindPlace = Place::find($review->kindPlaceId);
                    $place = \DB::table($kindPlace->tableName)->find($review->placeId);
                    $location = __DIR__ . '/../../../../assets/userPhoto/' . $kindPlace->fileName . '/' . $place->file;
                    $reviewPics = ReviewPic::where('logId', $review->id)->get();
                    foreach ($reviewPics as $pic){
                        if(is_file($location.'/'.$pic->pic))
                            unlink($location.'/'.$pic->pic);
                        $pic->delete();
                    }

                    $userAssigned = ReviewUserAssigned::where('logId', $review->id)->get();
                    foreach ($userAssigned as $item){
                        Alert::where('referenceId', $item->id)->where('referenceTable', 'reviewUserAssigned')->delete();
                        $item->delete();
                    }

                    LogFeedBack::where('logId', $review->id)->delete();

                    $anses = LogModel::where('relatedTo', $review->id)->get();
                    foreach ($anses as $item)
                        deleteAnses($item->id);

                    QuestionUserAns::where('logId', $review->id)->delete();
                    Report::where('logId', $review->id)->delete();

                    $alert = new Alert();
                    $alert->userId = $user->id;
                    $alert->subject = 'deleteReviewByUser';
                    $alert->referenceTable = $kindPlace->tableName;
                    $alert->referenceId = $place->id;
                    $alert->save();

                    \DB::table($kindPlace->tableName)->where('id', $place->id)->update(['reviewCount' => $place->reviewCount-1]);
                    $review->delete();
                    echo 'ok';
                }
                else
                    echo 'nok2';
            }
            else
                echo 'nok1';
        }
        else
            echo 'nok';

        return;
    }

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
