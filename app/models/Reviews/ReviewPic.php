<?php

namespace App\models\Reviews;

use App\Http\Controllers\Controller;
use App\models\LogModel;
use App\models\places\Place;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReviewPic extends Model
{
    protected $guarded = [];
    protected $table = 'reviewPics';

    public static $assetLocation = __DIR__.'/../../../../assets';

    public function deleteThisPicture(){
        if(auth()->check()) {
            $reviewId = $this->logId;

            $review = LogModel::find($reviewId);
            if($review == null)
                return 'notFoundReview';

            if(auth()->user()->id == $review->visitorId){
                $location = "userPhoto/";
                if($this->kindPlaceId == 0 && $this->placeId == 0)
                    $location .= 'nonePlaces';
                else{
                    $kindPlace = Place::find($this->kindPlaceId);
                    $place = \DB::table($kindPlace->tableName)->find($this->placeId);
                    $location .= "{$kindPlace->fileName}/{$place->file}";
                }

                if($this->server == config('app.ServerNumber')){
                    $folderLoc = self::$assetLocation.'/'.$location;

                    if(is_file($folderLoc.'/'.$this->pic))
                        unlink($folderLoc.'/'.$this->pic);

                    if($this->isVideo == 1){
                        if($this->thumbnail != null)
                            $thumbnail = $this->thumbnail;
                        else{
                            $thumbnail = explode('.', $this->pic);
                            $thumbnail[count($thumbnail)-1] = '.png';
                            $thumbnail = implode('', $thumbnail);
                        }

                        if(is_file($folderLoc.'/'.$thumbnail))
                            unlink($folderLoc.'/'.$thumbnail);
                    }

                    $this->delete();
                    return 'ok';
                }
                else{
                    $files = ["{$location}/{$this->pic}"];
                    if($this->isVideo == 1){
                        if($this->thumbnail != null)
                            $thumbnail = $this->thumbnail;
                        else{
                            $thumbnail = explode('.', $this->pic);
                            $thumbnail[count($thumbnail)-1] = '.png';
                            $thumbnail = implode('', $thumbnail);
                        }
                        array_push($files, "{$location}/{$thumbnail}");
                    }
                    $apiResponse = Controller::sendDeleteFileApiToServer($files, $this->server);
                    if($apiResponse['status'] == 'ok'){
                        $this->delete();
                        return 'ok';
                    }
                    else
                        return 'error';
                }

            }
            else
                return 'notForYou';
        }
        else
            return 'notAuth';
    }

    public static function deleteNotSetPictures(){
        $pics = ReviewPic::where('logId', null)->get();
        $filesServers = [];
        foreach ($pics as $item){
            $diffTimeDay = Carbon::now()->diffInHours($item->created_at);
            if($diffTimeDay > 24){
                if($item->server == config('app.ServerNumber')) {
                    $location = self::$assetLocation . "/limbo/{$item->pic}";
                    if (file_exists($location))
                        unlink($location);

                    if($item->isVideo == 1){
                        if($item->thumbnail != null)
                            $thumbnail = $item->thumbnail;
                        else{
                            $thumbnail = explode('.', $item->pic);
                            $thumbnail[count($thumbnail)-1] = '.png';
                            $thumbnail = implode('', $thumbnail);
                        }
                        $thumbnail = self::$assetLocation . "/limbo/{$thumbnail}";
                        if(is_file($thumbnail))
                            unlink($thumbnail);
                    }
                }
                else{
                    $serNum = $item->server;
                    if(!is_array($filesServers[$serNum]))
                        $filesServers[$serNum] = [];

                    array_push($filesServers[$serNum], "/limbo/{$item->pic}");

                    if($item->isVideo == 1){
                        if($item->thumbnail != null)
                            $thumbnail = $item->thumbnail;
                        else{
                            $thumbnail = explode('.', $item->pic);
                            $thumbnail[count($thumbnail)-1] = '.png';
                            $thumbnail = implode('', $thumbnail);
                        }
                        array_push($filesServers[$serNum], "/limbo/{$thumbnail}");
                    }
                }

                $item->delete();
            }
        }

        try{
            foreach ($filesServers as $serverNumber => $files)
                Controller::sendDeleteFileApiToServer($files, $serverNumber);
        }
        catch (\Exception $exception){}

    }
}
