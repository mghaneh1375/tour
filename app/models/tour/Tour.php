<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model {
    protected $table = 'tour';

    public function kinds()
    {
        return $this->belongsToMany(TourKind::class, 'tourKind_tour', 'tourId', 'kindId');
    }
    public function Styles()
    {
        return $this->belongsToMany(TourStyle::class, 'tourStyle_tour', 'tourId', 'styleId');
    }
    public function Difficults()
    {
        return $this->belongsToMany(TourDifficult::class, 'tourDifficult_tours', 'tourId', 'difficultId');
    }
    public function Focus()
    {
        return $this->belongsToMany(TourFocus::class, 'tourFocus_tour', 'tourId', 'focusId');
    }

    public function GetFeatures(){
        return $this->hasMany(TourFeature::class, 'tourId', 'id');
    }
    public function GetDiscounts(){
        return $this->hasMany(TourDiscount::class, 'tourId', 'id');
    }

}
