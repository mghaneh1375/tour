<?php

namespace App\Http\Controllers\LocalShop;

use App\Http\Requests\StoreLocalShopInfos;
use App\models\Activity;
use App\models\BookMark;
use App\models\localShops\LocalShopFeatures;
use App\models\localShops\LocalShops;
use App\models\localShops\LocalShopsCategory;
use App\models\localShops\LocalShopsPictures;
use App\models\LogModel;
use App\models\places\Place;
use App\models\Reviews\ReviewPic;
use App\models\Reviews\ReviewUserAssigned;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocalShopController extends Controller
{
    public function showLocalShops($id = 0){
        $localShop = LocalShops::find($id);
        if($localShop == null)
            dd('not found');

        $localShop->user = User::select(['id', 'username'])->find($localShop->userId);
        $localShop->ownerPic = getUserPic($localShop->user != null ? $localShop->user->id : 0);
        $localShop->ownerUsername = $localShop->user != null ? $localShop->user->username : '';

        $localShop->telephone = explode('-', $localShop->phone);
        $localShop->pics = $localShop->getPictures();
        $localShop->mainPic = $localShop->getMainPicture();
//        $localShop->tags = $localShop->getTags();
        if($localShop->description == '')
            $localShop->description = null;



        $codeForReview = null;
        $localShop->bookMark = 0;
        if(auth()->check()) {
            $user = auth()->user();
            $codeForReview = $user->id . '_' . random_int(100000, 999999);
            $localShop->bookMark = BookMark::join('bookMarkReferences', 'bookMarkReferences.id', 'bookMarks.bookMarkReferenceId')
                ->where('bookMarkReferences.tableName', 'localShops')
                ->where('bookMarks.referenceId', $localShop->id)
                ->where('bookMarks.userId', $user->id)->count();
        }

        $localShop->features = LocalShopFeatures::where('categoryId', $localShop->categoryId)->where('parentId', 0)->get();
        foreach($localShop->features as $feat){
            $feat->subs = LocalShopFeatures::join('local_shop_features_relations', 'local_shop_features_relations.featureId', 'local_shop_features.id')
                            ->where('local_shop_features.parentId', $feat->id)
                            ->where('local_shop_features_relations.localShopId', $localShop->id)
                            ->select(['local_shop_features.*'])
                            ->get();
        }

        return view('pages.localShops.showLocalShops', compact(['localShop', 'codeForReview']));
    }

    public function deleteLocalShopPics(Request $request)
    {
        if(isset($request->localShopId) && isset($request->fileName)){
            $localShop = LocalShops::where('id', $request->localShopId)
                                    ->where('userId', auth()->user()->id)
                                    ->first();
            if($localShop != null){
                $pic = LocalShopsPictures::where('localShopId', $localShop->id)
                                            ->where('pic', $request->fileName)
                                            ->first();
                if($pic != null){
                    $isMain = 0;
                    if($pic->isMain == 1)
                        $isMain = 1;
                    $location = __DIR__.'/../../../../../assets/_images/localShops/'.$localShop->id.'/';
                    $fileType = ['', 's-', 'l-', 'f-', 't-'];
                    foreach ($fileType as $item){
                        if(is_file($location.$item.$pic->pic))
                            unlink($location.$item.$pic->pic);
                    }
                    $pic->delete();

                    if($isMain == 1){
                        $newMain = LocalShopsPictures::where('id', $request->localShopId)->first();
                        if($newMain != null)
                            $newMain->update(['isMain' => 1]);
                    }
                    return response()->json(['status' => 'ok']);
                }
                else
                    return response()->json(['status' => 'ok']);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function storeReviewPic(Request $request)
    {
        if(isset($request->code)){
            $user = auth()->user();
            $code = $request->code;
            if(explode('_', $code)[0] == $user->id){
                $nLocation = __DIR__ . '/../../../../../assets/limbo';
                if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                    if ($request->kind == 'image') {
                        $size = [[
                            'width' => 1080,
                            'height' => null,
                            'name' => '',
                            'destination' => $nLocation
                        ]];
                        $image = $request->file('file');
                        $nFileName = resizeImage($image, $size);
                        if ($nFileName == 'error')
                            return response()->json(['status' => 'error4']);

                        $webpFileName = explode('.', $nFileName);
                        $fileType = end($webpFileName);
                        $webpFileName[count($webpFileName) - 1] = '.webp';
                        $webpFileName = $user->id . '_' . implode('', $webpFileName);

                        $img = null;
                        $imgLoc = $nLocation . '/' . $nFileName;
                        if ($fileType == 'png')
                            $img = imagecreatefrompng($imgLoc);
                        else if ($fileType == 'jpg' || $fileType == 'jpeg')
                            $img = imagecreatefromjpeg($imgLoc);
                        else if ($fileType == 'gif')
                            $img = imagecreatefromgif($imgLoc);

                        if ($img != null) {
                            $checkConvert = imagewebp($img, $nLocation . '/' . $webpFileName, 75);
                            if ($checkConvert && is_file($imgLoc))
                                unlink($imgLoc);
                        }
                        else if ($fileType == 'webp')
                            rename($imgLoc, $nLocation . '/' . $webpFileName);

                        ReviewPic::create([
                            'pic' => $webpFileName,
                            'code' => $code,
                            'isVideo' => 0,
                            'is360' => 0,
                        ]);

                        return response()->json(['status' => 'ok', 'result' => $webpFileName]);
                    }
                    else if ($request->kind == 'video' || $request->kind == '360Video') {
                        $exploded = explode('.', $_FILES['file']['name']);
                        $fileType = end($exploded);
                        $fileName = $user->id . '_' . time() . rand(100, 999) . '.' . $fileType;
                        $nLocation .= '/'.$fileName;
                        $success = move_uploaded_file($_FILES['file']['tmp_name'], $nLocation);
                        if ($success) {
                            ReviewPic::create([
                                'pic' => $fileName,
                                'code' => $code,
                                'isVideo' => $request->kind == 'video' ? 1 : 0,
                                'is360' => $request->kind == '360Video' ? 1 : 0,
                            ]);
                            return response()->json(['status' => 'ok', 'result' => $fileName]);
                        } else
                            return response()->json(['status' => 'error5']);
                    }
                }

                if($request->kind == 'videoPic'){
                    $exploded = explode('.', $request->fileName);
                    $exploded[count($exploded)-1] = '.png';
                    $fileName = implode('', $exploded);
                    $locPath = $nLocation.$fileName;

                    $success = uploadLargeFile($locPath, $request->file);
                    if($success){
                        $webpFileName = explode('.', $request->fileName);
                        $webpFileName[count($webpFileName) - 1] = '.webp';
                        $webpFileName = implode('', $webpFileName);
                        $img = imagecreatefrompng($locPath);
                        $checkConvert = imagewebp($img, $nLocation.'/'.$webpFileName, 75);
                        if ($checkConvert && is_file($locPath))
                            unlink($locPath);

                        ReviewPic::where('code', $request->code)
                                                ->where('pic', $request->fileName)
                                                ->update(['thumbnail' => $webpFileName]);

                        return response()->json(['status' => 'ok', 'result' => $webpFileName]);
                    }
                    else
                        return response()->json(['status' => 'error6']);
                }
                else
                    return response()->json(['status' => 'error8']);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function deleteReviewPic(Request $request)
    {
        if(isset($request->fileName) && isset($request->code)){
            $reviewFile = ReviewPic::where('code', $request->code)
                                    ->where('pic', $request->fileName)
                                    ->first();
            $nLocation = __DIR__ . '/../../../../../assets/limbo/';
            if(is_file($nLocation.$reviewFile->pic))
                unlink($nLocation.$reviewFile->pic);

            if($reviewFile->thumbnail != null){
                if(is_file($nLocation.$reviewFile->thumbnail))
                    unlink($nLocation.$reviewFile->thumbnail);
            }
            $reviewFile->delete();
            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function storeReview(Request $request)
    {
        if(isset($request->code) && isset($request->placeId) && isset($request->kindPlaceId)){
            $activity = Activity::where('name', 'نظر')->first();
            $kindPlace = Place::find($request->kindPlaceId);
            $place = \DB::table($kindPlace->tableName)->find($request->placeId);
            if($kindPlace == null || $place == null)
                return response()->json(['status' => 'error2']);

            $log = new LogModel();
            $log->placeId = $request->placeId;
            $log->kindPlaceId = $request->kindPlaceId;
            $log->visitorId = auth()->user()->id;
            $log->date = Carbon::now()->format('Y-m-d');
            $log->time = getToday()['time'];
            $log->activityId = $activity->id;
            $log->text = $request->text != null ? $request->text : '';
            $log->save();

            $nLocation = __DIR__.'/../../../../../assets/limbo';
            $dLocation = __DIR__.'/../../../../../assets/userPhoto/'.$kindPlace->fileName;
            if(!is_dir($dLocation))
                mkdir($dLocation);

            $dLocation .= '/'.$place->file;
            if (!file_exists($dLocation))
                mkdir($dLocation);

            $pics = ReviewPic::where('code', $request->code)->get();
            foreach ($pics as $pic) {
                if(is_file($nLocation.'/'.$pic->pic))
                    rename($nLocation.'/'.$pic->pic, $dLocation.'/'.$pic->pic);

                if($pic->thumbnail != null && is_file($nLocation.'/'.$pic->thumbnail))
                    rename($nLocation.'/'.$pic->thumbnail, $dLocation.'/'.$pic->thumbnail);

                $pic->update(['logId' => $log->id]);
            }

            $assigned = json_decode($request->userAssigned);
            foreach ($assigned as $item){
                $u = User::where('username', $item)->first();
                if($u != null)
                    ReviewUserAssigned::create([
                       'userId' => $u->id,
                       'logId' => $log->id
                    ]);
            }
            $codeForReview = auth()->user()->id.'_'.random_int(100000, 999999);

            return response()->json(['status' => 'ok', 'result' => $codeForReview]);
        }
        else
            return response()->json(['status' => 'error1']);
    }
}
