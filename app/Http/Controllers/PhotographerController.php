<?php

namespace App\Http\Controllers;

use App\models\PhotographersLog;
use App\models\PhotographersPic;
use App\models\places\Place;
use App\models\Reviews\ReviewPic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PhotographerController extends Controller
{
    public $assetLocation = __DIR__.'/../../../../assets' ;

    public function storePhotographerFile(Request $request){
        $data = json_decode($request->data);
        $placeId = $data->placeId;
        $kindPlaceId = $data->kindPlaceId;

        $kindPlace = Place::find($kindPlaceId);
        $place = DB::table($kindPlace->tableName)->find($placeId);
        if($kindPlace == null)
            return response()->json(['status' => 'error']);

        $location = "{$this->assetLocation}/userPhoto/{$kindPlace->fileName}";
        if(!file_exists($location))
            mkdir($location);

        $location .= "/{$place->file}";
        if(!file_exists($location))
            mkdir($location);

        $tSize = ['width' => 150, 'height' => null, 'name' => 't-', 'destination' => $location];
        $lSize = ['width' => 200, 'height' => null, 'name' => 'l-', 'destination' => $location];
        $fSize = ['width' => 350, 'height' => 250, 'name' => 'f-', 'destination' => $location];
        $sSize = ['width' => 600, 'height' => 400, 'name' => 's-', 'destination' => $location];

        if(isset($request->storeFileName) && isset($request->file_data) && $request->storeFileName != 0)
            $fileName = $request->storeFileName;
        else {
            if(isset($data->fileName) && $data->fileName != null)
                $fileName = $data->fileName;
            else {
                $fileName = time() . rand(100, 999) . '_' . \auth()->user()->id . '.png';

                $photographer = new PhotographersPic();
                $photographer->userId = Auth::user()->id;
                $photographer->server = config('app.ServerNumber');
                $photographer->name = $data->name;
                $photographer->alt = $data->alt;
                $photographer->description = $data->description;
                $photographer->pic = $fileName;
                $photographer->kindPlaceId = $kindPlaceId;
                $photographer->placeId = $placeId;
                $photographer->like = 0;
                $photographer->dislike = 0;
                $photographer->isSitePic = 0;
                $photographer->isPostPic = 0;
                $photographer->status = 0;
                $photographer->save();
            }
        }

        $location .= "/{$fileName}";
        $result = uploadLargeFile($location, $request->file_data);

        if($request->last == "true"){
            $size = [];
            if($data->fileKind === "mainFile"){
                if(array_search( "squ", $data->otherSize) !== false){
                    array_push($size, $tSize);
                    array_push($size, $lSize);
                }
                if(array_search( "req", $data->otherSize) !== false){
                    array_push($size, $fSize);
                    array_push($size, $sSize);
                }
            }
            else if($data->fileKind === "squ")
                $size = [$tSize, $lSize];
            else if($data->fileKind === "req")
                $size = [$fSize, $sSize];

            $image = file_get_contents("{$location}");
            resizeUploadedImage($image, $size, $fileName);

            unlink($location);
        }

        $url = URL::asset("userPhoto/{$kindPlace->fileName}/{$place->file}/f-{$fileName}");

        if($result)
            return response()->json(['status' => 'ok', 'fileName' => $fileName, 'result' => ['fileName' => $fileName, 'url' => $url]]);
        else
            return response()->json(['status' => 'nok']);
    }

    public function likePhotographer(Request $request)
    {
        $user = \auth()->user();
        if(isset($request->id) && isset($request->like)){
            $id = explode('_', $request->id);
            if($id[0] == 'photographer') {
                $photo = PhotographersPic::find($id[1]);
                if ($photo != null) {
                    $userStatus = PhotographersLog::where('picId', $photo->id)->where('userId', $user->id)->first();

                    if ($userStatus == null) {
                        $userStatus = new PhotographersLog();

                        if ($request->like == 1) {
                            $userStatus->like = 1;
                            $photo->like++;
                        } else if ($request->like == -1) {
                            $userStatus->like = -1;
                            $photo->dislike++;
                        }

                        $userStatus->userId = $user->id;
                        $userStatus->picId = $photo->id;
                    }
                    else {
                        if ($userStatus->like == 1)
                            $photo->like--;
                        else if ($userStatus->like == -1)
                            $photo->dislike--;
                        if ($request->like == 1) {
                            $userStatus->like = 1;
                            $photo->like++;
                        } else if ($request->like == -1) {
                            $userStatus->like = -1;
                            $photo->dislike++;
                        }
                    }

                    $userStatus->save();
                    $photo->save();
                    return response()->json(['status' => 'ok', 'like' => $photo->like, 'disLike' => $photo->dislike]);
                }
                else
                    return response()->json(['nok3']);
            }
            else
                return response()->json(['nok2']);
        }
        else
            return response()->json(['nok4']);
    }

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
                            $location = "{$this->assetLocation}/userPhoto/{$kindPlace->fileName}/{$place->file}";

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
