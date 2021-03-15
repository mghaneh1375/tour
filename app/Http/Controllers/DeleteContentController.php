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
use App\models\Reviews\ReviewPic;
use App\models\Reviews\ReviewUserAssigned;
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
                    $result = ReviewPic::find($id[1])->deleteThisPicture();
                    return response()->json(['status' => $result]);
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
                            return response()->json(['status' => 'ok']);
                        }
                        else
                            return response()->json(['status' => 'authError']);
                    }
                    else
                        return response()->json(['status' => 'notFound']);
                }
                else
                    return response()->json(['status' => 'nok2']);
            }
            else
                return response()->json(['status' => 'nok1']);
        }
        else
            return response()->json(['status' => 'nok']);
    }

}
