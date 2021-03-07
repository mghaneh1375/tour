<?php

namespace App\models\tour;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static youCanSee()
 */
class TourTimes extends Model
{
    protected $guarded = [];
    protected $table = 'tourTimes';
    public $timestamps = false;

    public function scopeYouCanSee($query){
        date_default_timezone_set('Asia/Tehran');

        $time = verta()->format('Y/m/d');
        return $query->where('tourTimes.sDate', '>', $time)->where('tourTimes.isPublished', 1)->where('tourTimes.canRegister', 1);
    }

    public function getDailyDiscount(){
        $sDateTour = explode('/', $this->sDate);
        $diffDay = abs(Verta::createJalali($sDateTour[0], $sDateTour[1], $sDateTour[2])->diffDays(\verta()));
        $dayDiscounts = TourDiscount::where('tourId', $this->tourId)->where('remainingDay', '!=', null)->where('remainingDay', '>=', $diffDay)->orderBy('remainingDay')->first();
        return $dayDiscounts != null ? ['id' => $dayDiscounts->id, 'discount' => $dayDiscounts->discount]: ['id' => 0, 'discount' => 0];
    }
}
