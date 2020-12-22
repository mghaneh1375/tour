<?php

namespace App\models\logs;

use Illuminate\Database\Eloquent\Model;

class UserSeenLog extends Model
{
    protected $guarded = [];
    protected $table = 'userSeenLogs';
}
