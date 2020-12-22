<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model {
    protected $table = 'Tour';

    public function kinds()
    {
        return $this->belongsToMany(TourKind::class, 'tourkind_tour', 'tourId', 'kindId');
    }
    public function Styles()
    {
        return $this->belongsToMany(TourStyle::class, 'tourstyle_tour', 'tourId', 'styleId');
    }
    public function Difficults()
    {
        return $this->belongsToMany(TourDifficult::class, 'tourdifficult_tours', 'tourId', 'difficultId');
    }
    public function Focus()
    {
        return $this->belongsToMany(TourFocus::class, 'tourfocus_tour', 'tourId', 'focusId');
    }
}
