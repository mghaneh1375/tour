<?php

namespace App\models\localShops;

use App\models\Activity;
use App\models\LogModel;
use App\models\PhotographersPic;
use App\models\User;
use Illuminate\Database\Eloquent\Model;

class LocalShops extends Model
{
    protected $table = 'localShops';

    public function getCategory()
    {
        return $this->belongsTo(LocalShopsCategory::class, 'categoryId', 'id');
    }

    public function getPictures(){

        $allPictures = [];
        $owner = User::select(['id', 'username'])->find($this->userId);
        $owner->pic = getUserPic($owner->id);

        $pictures = $this->hasMany(LocalShopsPictures::class, 'localShopId', 'id')->get();
        foreach ($pictures as $pic){
            $pic->pic = [
                'main' => \URL::asset('_images/localShops/'.$this->file.'/'.$pic->pic),
                's' => \URL::asset('_images/localShops/'.$this->file.'/s-'.$pic->pic),
                'f' => \URL::asset('_images/localShops/'.$this->file.'/f-'.$pic->pic),
                'l' => \URL::asset('_images/localShops/'.$this->file.'/l-'.$pic->pic),
                't' => \URL::asset('_images/localShops/'.$this->file.'/t-'.$pic->pic),
            ];
            $pic->picCategory = 'sitePicture';
            $pic->ownerUsername = $owner->username;
            $pic->ownerPic = $owner->pic;

            array_push($allPictures, $pic);
        }

        $photographerPics = PhotographersPic::Join('users', 'users.id', 'photographersPics.userId')
                            ->where('photographersPics.kindPlaceId', 13)
                            ->where('photographersPics.placeId', $this->id)
                            ->where(function($query){
                                if(auth()->check())
                                    $query->where('photographersPics.userId', auth()->user()->id)->OrWhere('photographersPics.status', 1);
                                else
                                    $query->where('photographersPics.status', 1);
                            })->select(['photographersPics.*', 'users.username'])->get();

        foreach($photographerPics as $item){
            $item->pic = [
                'main' => \URL::asset('userPhoto/localShops/'.$this->file.'/s-'.$item->pic),
                's' => \URL::asset('userPhoto/localShops/'.$this->file.'/s-'.$item->pic),
                'f' => \URL::asset('userPhoto/localShops/'.$this->file.'/f-'.$item->pic),
                'l' => \URL::asset('userPhoto/localShops/'.$this->file.'/l-'.$item->pic),
                't' => \URL::asset('userPhoto/localShops/'.$this->file.'/t-'.$item->pic),
            ];
            $item->picCategory = 'photographer';

            $item->ownerUsername = $item->username;
            $item->ownerPic = getUserPic($item->userId);

            array_push($allPictures, $item);
        }

        return $allPictures;
    }

    public function getMainPicture()
    {
        $pictures = $this->hasMany(LocalShopsPictures::class, 'localShopId', 'id')
                        ->where('isMain', 1)
                        ->first();

        if($pictures == null)
            return false;
        else {
            $pictures->pic = [
                'main' => \URL::asset('_images/localShops/' . $this->id . '/' . $pictures->pic),
                's' => \URL::asset('_images/localShops/' . $this->id . '/s-' . $pictures->pic),
                'f' => \URL::asset('_images/localShops/' . $this->id . '/f-' . $pictures->pic),
                'l' => \URL::asset('_images/localShops/' . $this->id . '/l-' . $pictures->pic),
                't' => \URL::asset('_images/localShops/' . $this->id . '/t-' . $pictures->pic),
            ];

            return $pictures;
        }
    }

    public function getReviews(){
        $reviewAct = Activity::where('name', 'نظر')->first();
        $reviews = $this->hasMany(LogModel::class, 'placeId', 'id')
                        ->where('kindPlaceId', 13)
                        ->where('activityId', $reviewAct->id)
                        ->where(function ($query){
                            if(auth()->check())
                                $query->where('confirm', 1)->orWhere('visitorId', auth()->user()->id);
                            else
                                $query->where('confirm', 1);
                        })
                        ->orderByDesc('created_at')->get();

        foreach ($reviews as $item)
            $item = \reviewTrueType($item);

        return $reviews;
    }

}
