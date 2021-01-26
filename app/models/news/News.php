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
        date_default_timezone_set('Asia/Tehran');

        $time = verta()->format('Y/m/d H:i');
        return $query->where('dateAndTime', '<=', $time)
                     ->where('release', '!=', 'draft')
                     ->where('confirm', 1);
    }

    public function getTags(){
        return $this->belongsToMany(NewsTags::class, 'newsTagsRelations', 'newsId', 'tagId');
    }
}
