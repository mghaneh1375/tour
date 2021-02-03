<?php

namespace App\Http\Middleware\BusinessPanel;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BusinessPanelShareData
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
        if(\auth()->check()) {
            $userInfo = auth()->user();
            $userInfo->pic = getUserPic($userInfo->id);
            View::share(['fileVersions' => 1, 'userInfo' => $userInfo]);

            if (!$request->is('completeUserInfo') && ($userInfo->first_name == null || $userInfo->last_name == null || $userInfo->phone == null || $userInfo->birthday == null))
                return redirect(route('businessPanel.completeUserInfo'));

            return $next($request);
        }
        else{
            $userInfo = [];
        }

        View::share(['fileVersions' => 1, 'userInfo' => $userInfo]);
        return $next($request);

    }
}
