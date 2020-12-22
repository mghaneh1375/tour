<?php

namespace App\Http\Middleware;

use App\models\Safarnameh;
use App\models\SafarnamehCategories;
use App\models\SafarnamehCategoryRelations;
use Closure;
use Illuminate\Support\Facades\View;


class SafarnamehShareData
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
        $Tfunc = getToday();
        $today = $Tfunc['date'];
        $nowTime = $Tfunc['time'];

        $category = SafarnamehCategories::where('parent', 0)->get();
        foreach ($category as $item)
            $item->subCategory = SafarnamehCategories::where('parent', $item->id)->get();

        View::share(['category' => $category]);
        return $next($request);
    }
}
