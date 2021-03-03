<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class LocalShopsShareData
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
        $fileVersions = 1;
        if(auth()->check())
            $userPic = getUserPic(auth()->user()->id);
        else
            $userPic = getUserPic(0);

        View::share(['fileVersions' => $fileVersions, 'userPic' => $userPic]);
        return $next($request);
    }
}
