<?php

namespace App\Http\Controllers\LocalShop;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocalShopInfos;
use App\models\localShops\LocalShops;
use App\models\localShops\LocalShopsCategory;
use App\models\localShops\LocalShopsPictures;
use Illuminate\Http\Request;

class CreateLocalShopController extends Controller
{
    public $localShopFolder = __DIR__.'/../../../../../assets/_images/localShops';

    public function createLocalShopPage()
    {
        $localShopCategories = LocalShopsCategory::where('parentId', 0)->get();

        return view('pages.localShops.createLocalShopPage', compact(['localShopCategories']));
    }

    public function storeLocalShop(StoreLocalShopInfos $request)
    {
        if($request->id != 0){
            $localShop = LocalShops::find($request->id);
            if($localShop == null)
                return response()->json(['status' => 'notFound']);

            if($localShop->userId != auth()->user()->id)
                return response()->json(['status' => 'notYours']);
        }
        else{
            $localShop = new LocalShops();
            $localShop->userId = auth()->user()->id;
            $localShop->author = auth()->user()->id;
        }

        $localShop->name = $request->name;
        $localShop->categoryId = $request->category;
        $localShop->description = $request->description;
        $localShop->phone = $request->phone;
        $localShop->cityId = $request->cityId;
        $localShop->address = $request->address;
        $localShop->lat = $request->lat;
        $localShop->lng = $request->lng;
        $localShop->website = $request->website;
        $localShop->instagram = $request->instagram;
        if($request->inPlaceId != 0)
            $localShop->relatedPlaceId = $request->inPlaceId;
        if($request->inPlace)
            $localShop->relatedPlaceName = $request->inPlace;

        $localShop->isBoarding = $request->fullOpen === 'true' ? 1 : 0;
        $localShop->afterClosedDayIsOpen = $request->afterClosedDayButton === 'false' ? 1 : 0;
        $localShop->closedDayIsOpen = $request->closedDayButton === 'false' ? 1 : 0;

        $localShop->inWeekOpenTime = $request->inWeekDayStart;
        $localShop->inWeekCloseTime = $request->inWeekDayEnd;
        $localShop->afterClosedDayOpenTime = $request->afterClosedDayStart;
        $localShop->afterClosedDayCloseTime = $request->afterClosedDayEnd;
        $localShop->closedDayOpenTime = $request->closedDayStart;
        $localShop->closedDayCloseTime = $request->closedDayEnd;
        $localShop->save();

        $localShop->file = $localShop->id;
        $localShop->save();

        $location = $this->localShopFolder;
        if(!is_dir($location))
            mkdir($location);
        $location .= '/'.$localShop->id;
        if(!is_dir($location))
            mkdir($location);

        return response()->json(['status' => 'ok', 'result' => $localShop->id]);
    }

    public function storeLocalShopPics(Request $request)
    {
        if(isset($request->localShopId)){
            if(isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
                $localShop = LocalShops::find($request->localShopId);
                if($localShop != null && $localShop->userId == auth()->user()->id){

                    $nLocation = $this->localShopFolder;
                    if(!is_dir($nLocation))
                        mkdir($nLocation);

                    $nLocation .= '/'.$request->localShopId;
                    if(!is_dir($nLocation))
                        mkdir($nLocation);

                    $size = [
                        [
                            'width' => null,
                            'height' => 1080,
                            'name' => '',
                            'destination' => $nLocation
                        ],
                        [
                            'width' => 600,
                            'height' => 400,
                            'name' => 's-',
                            'destination' => $nLocation
                        ],
                        [
                            'width' => 350,
                            'height' => 250,
                            'name' => 'f-',
                            'destination' => $nLocation
                        ],
                        [
                            'width' => 150,
                            'height' => 150,
                            'name' => 't-',
                            'destination' => $nLocation
                        ],
                        [
                            'width' => 200,
                            'height' => 200,
                            'name' => 'l-',
                            'destination' => $nLocation
                        ],
                    ];

                    $image = $request->file('pic');

                    $nFileName = resizeImage($image, $size);
                    if($nFileName == 'error')
                        return response()->json(['status' => 'error4']);

                    $webpFileName = explode('.', $nFileName);
                    $fileType = end($webpFileName);
                    $webpFileName[count($webpFileName)-1] = '.png';
                    $webpFileName = implode('', $webpFileName);

                    foreach ($size as $siz){
                        $imgLoc = $nLocation.'/'.$siz['name'].$nFileName;
                        if($fileType === 'webp')
                            $img = imagecreatefromwebp($imgLoc);
                        else if($fileType === 'jpg' || $fileType === 'jpeg')
                            $img = imagecreatefromjpeg($imgLoc);
                        else if($fileType == 'gif')
                            $img = imagecreatefromgif($imgLoc);
                        else
                            continue;

                        $checkConvert = imagepng($img, $nLocation.'/'.$siz['name'].$webpFileName, 80);
                        if($checkConvert && is_file($imgLoc))
                            unlink($imgLoc);
                    }

                    $findMain = LocalShopsPictures::where('localShopId', $localShop->id)->where('isMain', 1)->count();

                    $newPic = new LocalShopsPictures();
                    $newPic->server = config('app.ServerNumber');
                    $newPic->localShopId = $localShop->id;
                    $newPic->isMain = $findMain == 0 ? 1 : 0;
                    $newPic->pic = $webpFileName;
                    $newPic->save();

                    return response()->json(['status' => 'ok', 'result' => $newPic->pic]);
                }
                else
                    return response()->json(['status' => 'error3']);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function deleteLocalShopPics(Request $request)
    {
        if(isset($request->localShopId) && isset($request->fileName)){
            $localShop = LocalShops::where('id', $request->localShopId)->where('userId', auth()->user()->id)->first();

            if($localShop != null){
                $pic = LocalShopsPictures::where('localShopId', $localShop->id)
                    ->where('pic', $request->fileName)
                    ->first();
                if($pic != null){
                    $isMain = 0;
                    if($pic->isMain == 1)
                        $isMain = 1;
                    $location = "{$this->localShopFolder}/{$localShop->id}/";
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

}
