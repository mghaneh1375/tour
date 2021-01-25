<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\models\news\News;
use App\models\news\NewsCategory;
use App\models\news\NewsCategoryRelations;
use App\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class NewsController extends Controller
{
    public function newsMainPage()
    {
        $selectCol = ['id', 'title', 'meta', 'slug', 'keyword', 'pic'];

        $allNewsCount = News::all()->count();

        $sliderNews = News::youCanSee()->select($selectCol)->orderBy('time')->orderBy('date')->take(5)->get();

        $sideSliderNews = News::youCanSee()->select($selectCol)->orderBy('time')->orderBy('date')->skip(5)->take(4)->get();
        if(count($sideSliderNews) < 4){
            $remaining = 4 - count($sideSliderNews);
            $skip = 5 - $remaining;
            $sideSliderNews = News::youCanSee()->select($selectCol)->orderBy('created_at')->skip($skip)->take(4)->get();
        }

        foreach ([$sliderNews, $sideSliderNews] as $section){
            foreach ($section as $item)
                $item = getNewsMinimal($item);
        }


        $allCategories = NewsCategory::where('parentId', 0)->get();
        foreach ($allCategories as $category){
            $category->allSubIds = NewsCategory::where('id', $category->id)->orWhere('parentId', $category->id)->pluck('id')->toArray();
            $category->news = News::youCanSee()->join('newsCategoryRelations', 'newsCategoryRelations.newsId', 'news.id')
                                    ->where('newsCategoryRelations.categoryId', $category->id)
                                    ->where('newsCategoryRelations.isMain', 1)
                                    ->select(['news.id', 'news.title', 'news.meta', 'news.slug', 'news.keyword', 'news.pic'])
                                    ->orderBy('news.time')->orderBy('news.date')
                                    ->take(7)->get();

            foreach ($category->news as $item)
                $item = getNewsMinimal($item);
        }

        return view('pages.News.newsMainPage', compact(['sliderNews', 'sideSliderNews', 'allCategories']));
    }

    public function newsShow($slug)
    {
        $news = News::youCanSee()->where('slug', $slug)->first();
        if($news == null)
            return redirect(route('news.main'));

        $news->tags = $news->getTags->pluck('tag')->toArray();
        $news->time = implode(':', str_split($news->time, 2));

        $news->pic = URL::asset("_images/news/{$news->id}/{$news->pic}");
        $news->category = NewsCategory::join('newsCategoryRelations', 'newsCategoryRelations.categoryId', 'newsCategories.id')
                                    ->where('newsCategoryRelations.isMain', 1)
                                    ->where('newsCategoryRelations.newsId', $news->id)
                                    ->select(['newsCategories.id', 'newsCategories.name'])
                                    ->first();

        $sideAdv = [];
        $sideAdvLocation = __DIR__.'/../../../../public/images/esitrevda';
        foreach(scandir($sideAdvLocation) as $files){
            if(is_file($sideAdvLocation.'/'.$files))
                array_push($sideAdv, URL::asset("images/esitrevda/{$files}"));
        }

        $otherNews = NewsCategoryRelations::join('news', 'news.id', 'newsCategoryRelations.newsId')
                            ->where('newsCategoryRelations.categoryId', $news->category->id)
                            ->where('newsCategoryRelations.newsId', '!=', $news->id)
                            ->where('newsCategoryRelations.isMain', 1)
                            ->select(['news.id', 'news.title', 'news.meta', 'news.slug', 'news.keyword', 'news.pic'])
                            ->get();
        foreach ($otherNews as $item)
            $item = getNewsMinimal($item);

        $date = explode('/', $news->date);
        $times = explode(':', $news->time);
        $news->showTime = Verta::createJalali($date[0], $date[1], $date[2], $times[0], $times[1], 0)->format('%d %B %Y  H:i');

        $news->author = User::find($news->userId)->username;

        return view('pages.News.newsShow', compact(['news', 'sideAdv', 'otherNews']));
    }
}
