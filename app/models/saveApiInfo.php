<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class saveApiInfo extends Model
{
    protected $table = 'save_api_infos';
    protected $casts = ['array' => 'array'];
}
