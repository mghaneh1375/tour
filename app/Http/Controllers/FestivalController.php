<?php

namespace App\Http\Controllers;

use App\models\ActivationCode;
use App\models\Cities;
use App\models\Festival;
use App\models\festival\FestivalSurvey;
use App\models\FestivalContent;
use App\models\FestivalLimboContent;
use App\models\places\Place;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FestivalController extends Controller
{
    public function mainPageFestival()
    {
        $this->deleteLimboFiles();

        $selectedPic = (object)[
            'title' => 'کوچیتا | فستیوال ایران ما',
            'description' => 'در جشنواره ایران ما شرکت کنید',
            'pic' => \URL::asset('images/icons/KOFAV0.svg'),
            'kind' => 'photo',
            'section' => 'main',
            'code' => 0,
        ];
        if(isset($_GET['code'])) {
            $content = FestivalContent::where('code', $_GET['code'])->first();

            $selectedPic = (object)[
                'title' => 'کوچیتا | فستیوال ایران ما | اثر: kiavash_zp',
                'description' => 'در جشنواره ایران ما شرکت کنید',
                'pic' => \URL::asset('_images/festival/content/thumb_'.$content->content),
                'kind' => $content->isPic == 1 ? 'photo' : 'video',
                'section' => $content->festival->name,
                'code' => $content->code,
            ];
        }

        return view('pages.festival.festivalMainPage', compact(['selectedPic']));
    }

    public function festivalIntroduction()
    {
        return view('pages.festival.festivalIntroduction');
    }

    public function festivalUploadWorksPage()
    {
        if(auth()->check()) {
            $user = auth()->user();
            return view('pages.festival.festivalSubmitWorks', compact(['user']));
        }
        else
            return redirect(route('festival'));
    }

    public function submitWorks(Request $request)
    {
        $userData = json_decode($request->userData);
        $data = json_decode($request->data);
        $user = auth()->user();

        $errorText = [];

        if(User::where('email', $userData->email)->where('id', '!=', $user->id)->count() > 0)
            array_push($errorText, 'ایمیل وارد شده در سامانه موجود می باشد.');
        if(User::where('phone', $userData->phone)->where('id', '!=', $user->id)->count() > 0)
            array_push($errorText, 'شماره تماس وارد شده در سامانه موجود می باشد.');

        if(count($errorText) > 0)
            return response()->json(['status' => 'nok', 'error' => $errorText]);

        if($user->first_name == null || $user->first_name != '')
            $user->first_name = $userData->firstName;
        if($user->last_name == null || $user->last_name != '')
            $user->last_name = $userData->lastName;
        if($user->email == null || $user->email != '')
            $user->email = $userData->email;
        if($user->phone == null || $user->phone != '')
            $user->phone = $userData->phone;
        if($user->age == null || $user->age != '')
            $user->age = $userData->age;
        if($user->sex == null || $user->sex != '')
            $user->sex = $userData->sex;
        if($user->website == null || $user->website != '')
            $user->link = $userData->website;
        if($user->instagram == null || $user->instagram != '')
            $user->instagram = $userData->instagram;
        $user->save();

        $destination = __DIR__.'/../../../../assets/_images/festival';

        if(!is_dir($destination.'/content'))
            mkdir($destination.'/content');

        $limboDestination = $destination.'/limbo/';
        $contentDestination = $destination.'/content/';

        foreach ($data as $item){
            if($item !== false) {
                if (is_file($destination . '/limbo/' . $item->uploadedFileName)) {
                    do $code = random_int(1000, 9999); while (FestivalContent::where('code', $code)->count() > 0);

                    rename( $limboDestination.$item->uploadedFileName, $contentDestination.$item->uploadedFileName);

                    if (is_file($destination . '/limbo/thumb_' . $item->uploadedFileName))
                        rename($destination . '/limbo/thumb_' . $item->uploadedFileName, $destination . '/content/thumb_' . $item->uploadedFileName);
                    FestivalLimboContent::where('userId', $user->id)->where('content', $item->uploadedFileName)->delete();
                    FestivalLimboContent::where('userId', $user->id)->where('content', 'thumb_'.$item->uploadedFileName)->delete();

                    if (isset($item->thumbnailFileName) && is_file($limboDestination . $item->thumbnailFileName)) {
                        rename($limboDestination . $item->thumbnailFileName, $contentDestination . $item->thumbnailFileName);
                        if (is_file($limboDestination . $item->thumbnailFileName))
                            rename($limboDestination . $item->thumbnailFileName, $contentDestination . $item->thumbnailFileName);

                        FestivalLimboContent::where('userId', $user->id)->where('content', $item->thumbnailFileName)->delete();
                    }
                    else if(!is_file($limboDestination. $item->thumbnailFileName) && $item->type == 'video'){
                        try {
                            $item->thumbnailFileName = explode('.', $item->uploadedFileName)[0].'.jpg';
                            shell_exec('ffmpeg -i /var/www/asset/_images/festival/content/'.$item->uploadedFileName.' -ss 00:00:01 -vframes 1 /var/www/asset/_images/festival/content/'.$item->thumbnailFileName);
                        }
                        catch (\Exception $exception){
                            continue;
                        }
                    }

                    $newContent = new FestivalContent();
                    $newContent->festivalId = Festival::where('name', $request->sideSection)->first()->id;
                    $newContent->userId = $user->id;
                    $newContent->title = $item->title;
                    $newContent->isPic = $item->type == 'photo' ? 1 : 0;
                    $newContent->isVideo = $item->type == 'video' ? 1 : 0;
                    $newContent->description = $item->description;
                    $newContent->cityName = $item->cityId;
                    $newContent->kindPlaceId = $item->kindPlaceId;
                    $newContent->placeId = $item->placeId;
                    $newContent->content = $item->uploadedFileName;
                    $newContent->thumbnail = $item->thumbnailFileName;
                    $newContent->code = $code;
                    $newContent->confirm = 1;
                    $newContent->save();
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function uploadFile(Request $request)
    {
        $start = microtime(true);
        $user = auth()->user();
        $data = json_decode($request->data);
        $direction = __DIR__.'/../../../../assets/_images/festival';
        if(!is_dir($direction))
            mkdir($direction);

        $direction .= '/limbo';
        if(!is_dir($direction))
            mkdir($direction);

        if(isset($request->cancelUpload) && $request->cancelUpload == 1){
            $direction .= '/'.$request->storeFileName;
            if(is_file($direction))
                unlink($direction);
            FestivalLimboContent::where('userId', $user->id)
                                ->where('content', $request->storeFileName)
                                ->delete();
            echo json_encode(['status' => 'canceled']);
            return;
        }

        if(isset($request->storeFileName) && isset($request->file_data) && $request->storeFileName != 0){
            $fileName = $request->storeFileName;
            $direction .= '/'.$fileName;
            $result = uploadLargeFile($direction, $request->file_data);
        }
        else if(isset($request->thumbnail) && $request->thumbnail != ''){
            $fileName = explode('.', $request->fileName);
            $fileName = $fileName[0].'.png';

            $direction .= '/'.$fileName;
            $result = uploadLargeFile($direction, $request->thumbnail);

            if($result) {
                $location = __DIR__ . '/../../../../assets/_images/festival/limbo';
                $size = [['width' => 250, 'height' => 250, 'name' => 'thumb_', 'destination' => $location]];
                $result = resizeUploadedImage(file_get_contents($direction), $size, $fileName);
                if(is_file($location.'/'.$fileName))
                    unlink($location.'/'.$fileName);

                $fileName = 'thumb_'.$fileName;

                $limbo = new FestivalLimboContent();
                $limbo->userId = $user->id;
                $limbo->content = $fileName;
                $limbo->save();
            }
        }
        else{
            $file_name = $request->file_name;
            $fileType = explode('.', $file_name);
            $fileName = time().'_'.$user->id.'.'.end($fileType);

            $direction .= '/'.$fileName;
            $result = uploadLargeFile($direction, $request->file_data);

            if($result) {
                $limbo = new FestivalLimboContent();
                $limbo->userId = $user->id;
                $limbo->content = $fileName;
                $limbo->save();
            }
        }

        if(isset($request->last) && $request->last == 'true' && $data->kind == 'photo'){
            $location = __DIR__.'/../../../../assets/_images/festival/limbo';
            $size = [[ 'width' => 250, 'height' => 250, 'name' => 'thumb_', 'destination' => $location ]];
            $result = resizeUploadedImage(file_get_contents($direction), $size, $fileName);
        }

        if($result)
            return response()->json(['status' => 'ok', 'fileName' => $fileName, 'time' => microtime(true)-$start]);
        else
            return response()->json(['status' => 'nok']);
    }

    public function deleteUploadFile(Request $request)
    {
        if(isset($request->fileName) && $request->fileName != ''){
            $limbo = FestivalLimboContent::where('content', $request->fileName)
                                        ->where('userId', auth()->user()->id)
                                        ->first();
            if($limbo != null){
                $direction = __DIR__.'/../../../../assets/_images/festival/limbo/';
                if(is_file($direction.$limbo->content))
                    unlink($direction.$limbo->content);
                if(is_file($direction.'thumb_'.$limbo->content))
                    unlink($direction.'thumb_'.$limbo->content);

                if(isset($request->thumbnail) && $request->thumbnail != null && $request->thumbnail != ''){
                    $thumb = FestivalLimboContent::where('content', $request->thumbnail)
                                                ->where('userId', auth()->user()->id)
                                                ->first();
                    if($thumb != null) {
                        if (is_file($direction . $thumb->content))
                            unlink($direction . $thumb->content);
                        if (is_file($direction . 'thumb_' . $thumb->content))
                            unlink($direction . 'thumb_' . $thumb->content);

                        $thumb->delete();
                    }
                }

                $limbo->delete();
                echo 'ok';
            }
            else
                echo 'notFound';
        }
        else
            echo 'nok';

        return;
    }

    public function getFestivalContent(Request $request)
    {
        if($request->kind == 'photo')
            $content = Festival::where('name', $request->mainSection)
                                ->first()
                                ->picContents()
                                ->get();
        else
            $content = Festival::where('name', $request->mainSection)
                                ->first()
                                ->videoContents()
                                ->get();

        foreach ($content as $item){
            if($item->isPic == 1){
                $item->pic = \URL::asset('_images/festival/content/'.$item->content);
                $item->thumbnail = \URL::asset('_images/festival/content/'.$item->thumbnail);
            }
            if($item->isVideo == 1) {
                $item->video = \URL::asset('_images/festival/content/'.$item->content);
                if(is_file(__DIR__.'/../../../../assets/_images/festival/content/'.$item->thumbnail))
                    $item->thumbnail = \URL::asset('_images/festival/content/'.$item->thumbnail);
                else
                    $item->thumbnail = \URL::asset('images/mainPics/nopicv01.jpg');
            }
            $item->url = route('festival.main').'?code='.$item->code;
            $item->like = $item->festivalSurveysCount();
            $item->youLike = 0;

            $us = User::find($item->userId);
            $item->username = $us->username;
            $item->userUrl = route('profile', ['username' => $us->username]);
            $item->userPic = getUserPic($us->id);

            $city = Cities::find($item->cityName);
            if($city != null) {
                $state = $city->getState;
                $item->city = $city->name;
                $item->state = $state->name;
            }
            else{
                $item->city = $item->cityName;
                $item->state = '';
            }
            if($item->placeId != null && $item->placeId != 0){
                $kindPlace = Place::find($item->kindPlaceId);
                $place = \DB::table($kindPlace->tableName)->find($item->placeId);
                $item->placeName = $place->name;
                $item->placePic = getPlacePic($place->id, $kindPlace->id);
                $item->placeUrl = createUrl($kindPlace->id, $place->id, 0, 0);
                $item->place = 'استان '.$item->state.' ، شهر '.$item->city.' ، ' . $item->placeName;
            }
            else{
                $item->placeName = '';
                if($city != null)
                    $item->placeUrl = createUrl(0, 0, 0, $city->id);
                else
                    $item->placeUrl = '#';

                $item->place = 'استان '.$item->state.' ، شهر '.$item->city;
            }

            if(auth()->check())
                $item->youLike = FestivalSurvey::where('contentId', $item->id)
                                                ->where('userId', auth()->user()->id)
                                                ->count();
        }

        $mySurveys = [];
        if(auth()->check()){
            $festival = Festival::where('name', $request->mainSection)->first();

            if($request->kind == 'photo')
                $condition = ['festivalContents.isPic' => 1];
            else
                $condition =['festivalContents.isVideo' => 1];

            $mySurveys = FestivalSurvey::join('festivalContents', 'festivalContents.id', 'festivalSurveys.contentId')
                                        ->where('festivalContents.userId', auth()->user()->id)
                                        ->where('festivalContents.festivalId', $festival->id)
                                        ->where($condition)
                                        ->pluck('festivalContents.code')
                                        ->toArray();
        }

        echo json_encode(['status' => 'ok', 'result' => $content, 'mySurveys' => $mySurveys]);
        return;
    }

    public function likeWork(Request $request)
    {
        if(isset($request->code)){
            $content = FestivalContent::where('code', $request->code)->first();
            $festival = $content->festival;
            if($content->isPic == 1)
                $condition = ['festivalContents.isPic' => 1];
            else
                $condition =['festivalContents.isVideo' => 1];
            $mySurveys = FestivalSurvey::join('festivalContents', 'festivalSurveys.contentId', 'festivalContents.id')
                                        ->where('festivalContents.userId', auth()->user()->id)
                                        ->where('festivalContents.festivalId', $festival->id)
                                        ->where($condition)
                                        ->count();

            $thisCodeMySurvey = FestivalSurvey::where('contentId', $content->id)
                                                ->where('userId', auth()->user()->id)
                                                ->first();
            if($thisCodeMySurvey != null)
                $thisCodeMySurvey->delete();
            else{
                if($mySurveys == 5 && $request->replace == 0){
                    echo json_encode(['status' => 'moreThanFive']);
                    return;
                }
                else if($mySurveys == 5 && $request->replace != 0){
                    $replace = FestivalContent::where('code', $request->replace)->first();
                    FestivalSurvey::where('contentId', $replace->id)
                                ->where('userId', auth()->user()->id)
                                ->update(['contentId' => $content->id]);
                }
                else{
                    $survey = new FestivalSurvey();
                    $survey->contentId = $content->id;
                    $survey->userId = auth()->user()->id;
                    $survey->save();
                }
            }

            $mySurveys = FestivalSurvey::join('festivalContents', 'festivalContents.id', 'festivalSurveys.contentId')
                ->where('festivalContents.userId', auth()->user()->id)
                ->where('festivalContents.festivalId', $festival->id)
                ->where($condition)
                ->pluck('festivalContents.code')
                ->toArray();

            echo json_encode(['status' => 'ok', 'result' => $mySurveys]);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function getMySurvey(Request $request)
    {
        $user = auth()->user();
        $festival = Festival::where('name', $request->section)->first();
        if($request->kind == 'photo')
            $condition = ['isPic' => 1];
        else
            $condition = ['isVideo' => 1];

        $mySurveys = FestivalSurvey::join('festivalContents', 'festivalContents.id', 'festivalSurveys.contentId')
                        ->where('festivalContents.userId', $user->id)
                        ->where('festivalContents.festivalId', $festival->id)
                        ->where($condition)
                        ->pluck('festivalContents.code')
                        ->toArray();

        echo json_encode(['status' => 'ok', 'result' => $mySurveys]);
    }

    private function deleteLimboFiles(){
        $limbos = FestivalLimboContent::where('created_at', '<=', Carbon::now()->subDay(1))->get();
        $destination = __DIR__.'/../../../../assets/_images/festival/limbo';

        foreach ($limbos as $item){
            if(is_file($destination.'/'.$item->content))
                unlink($destination.'/'.$item->content);
            if(is_file($destination.'/thumb_'.$item->content))
                unlink($destination.'/thumb_'.$item->content);
            $item->delete();
        }

        return true;
    }
}
