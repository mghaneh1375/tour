<?php

namespace App\models\safarnameh;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static youCanSee()
 */
class Safarnameh extends Model
{
    protected $table = 'safarnameh';

    public function scopeYouCanSee($query){
        $today = getToday()['date'];
        $nowTime = getToday()['time'];

        return $query->whereRaw('(safarnameh.date < ' . $today . ' OR (safarnameh.date = ' . $today . ' AND  (safarnameh.time <= ' . $nowTime . ' OR safarnameh.time IS NULL)))')
                    ->whereRaw('safarnameh.release <> "draft"')->where('confirm', 1);
    }

}
