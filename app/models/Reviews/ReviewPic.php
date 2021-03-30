<?php

namespace App\models\Reviews;

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
                $location = self::$assetLocation."/userPhoto/";
                if($this->kindPlaceId == 0 && $this->placeId == 0)
                    $location .= 'nonePlaces';
                else{
                    $kindPlace = Place::find($this->kindPlaceId);
                    $place = \DB::table($kindPlace->tableName)->find($this->placeId);

                    $location .= $kindPlace->fileName .'/'.$place->file;
                }

                if(is_file($location.'/'.$this->pic))
                    unlink($location.'/'.$this->pic);

                if($this->isVideo == 1){
                    if($this->thumbnail != null)
                        $thumbnail = $this->thumbnail;
                    else{
                        $thumbnail = explode('.', $this->pic);
                        $thumbnail[count($thumbnail)-1] = '.png';
                        $thumbnail = implode('', $thumbnail);
                    }

                    if(is_file($location.'/'.$thumbnail))
                        unlink($location.'/'.$thumbnail);
                }

                $this->delete();
                return 'ok';
            }
            else
                return 'notForYou';
        }
        else
            return 'notAuth';
    }

    public static function deleteNotSetPictures(){
        $pics = ReviewPic::where('logId', null)->get();
        foreach ($pics as $item){
            $diffTimeDay = Carbon::now()->diffInHours($item->created_at);
            if($diffTimeDay > 24){

                $location = self::$assetLocation."/limbo/{$item->pic}";
                if(file_exists($location))
                    unlink($location);
                $item->delete();
            }
        }
    }
}
