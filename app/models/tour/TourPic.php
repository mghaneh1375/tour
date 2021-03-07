<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

class TourPic extends Model
{
    protected $table = 'tourPics';
    public $timestamps = false;

    public function getPicUrl(){
        return \URL::asset("_images/tour/{$this->tourId}/{$this->pic}");
    }
}
