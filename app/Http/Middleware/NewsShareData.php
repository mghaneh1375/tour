<?php

namespace App\Http\Middleware;

use App\models\news\NewsCategory;
use Closure;
use Illuminate\Support\Facades\View;

class NewsShareData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $newsCategories = NewsCategory::where('parentId', 0)->get();
        foreach ($newsCategories as $category)
            $category->sub = NewsCategory::where('parentId', $category->id)->get();


        View::share(['newsCategories' => $newsCategories]);


        return $next($request);
    }
}
