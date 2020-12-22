<?php

namespace App\models;

use App\Helpers\ReviewTrueType;
use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Restaurant'
 *
 * @property integer $id
 * @property string $name
 */

class Restaurant extends Model {

    protected $table = 'restaurant';
    public $timestamps = false;

    public function getReviews(){
        $reviewAct = Activity::where('name', 'نظر')->first();
        $reviews = $this->hasMany(LogModel::class, 'placeId', 'id')
                        ->where('kindPlaceId', 3)
                        ->where('activityId', $reviewAct->id)
                        ->where('confirm', 1)
                        ->orderByDesc('date')->get();

        foreach ($reviews as $item)
            $item = \reviewTrueType($item);

        return $reviews;
    }

    public static function whereId($value) {
        return Restaurant::find($value);
    }
}
