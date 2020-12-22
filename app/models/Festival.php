<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    public $timestamps = false;
    protected $table = 'festivals';

    public function picContents(){
        return $this->hasMany(FestivalContent::class, 'festivalId','id')
                    ->where('confirm', 1)
                    ->where('isPic', 1);
    }
    public function videoContents(){
        return $this->hasMany(FestivalContent::class, 'festivalId','id')
                    ->where('confirm', 1)
                    ->where('isVideo', 1);
    }
    public function contents(){
        return $this->hasMany(FestivalContent::class, 'festivalId','id');
    }
}
