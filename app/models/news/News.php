<?php

namespace App\models\news;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static youCanSee()
 */

class News extends Model
{
    protected $table = 'news';

    public function scopeYouCanSee($query){
        $func = getToday();
        $today = $func["date"];
        $nowTime = $func["time"];

        return $query->whereRaw('(date <= ' . $today . ' OR (date = ' . $today . ' AND (time <= ' . $nowTime . ' || time IS NULL)))')
                        ->where('release', '!=', 'draft')
                        ->where('confirm', 1);
    }

    public function getTags(){
        return $this->belongsToMany(NewsTags::class, 'newsTagsRelations', 'newsId', 'tagId');
    }
}
