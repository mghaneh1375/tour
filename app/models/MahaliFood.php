<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class MahaliFood extends Model
{
    protected $table = 'mahaliFood';

    public function materials(){
        return $this->belongsToMany(FoodMaterial::class, 'foodMaterialRelations', 'mahaliFoodId', 'foodMaterialId')
                    ->withPivot('volume');
    }
}
