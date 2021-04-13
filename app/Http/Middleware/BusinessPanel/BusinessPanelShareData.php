<?php

namespace App\Http\Middleware\BusinessPanel;

use App\models\Business\Business;
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
        $fileVersions = 3;
        if(\auth()->check()) {
            $userInfo = auth()->user();
            $userInfo->pic = getUserPic($userInfo->id);
            $businessList = Business::where('userId', $userInfo->id)->select(['name', 'id'])->get();

            View::share(['fileVersions' => $fileVersions, 'userInfo' => $userInfo, 'allOtherYourBusinessForHeader' => $businessList]);


            if (!$request->is('completeUserInfo') && ($userInfo->first_name == null || $userInfo->last_name == null || $userInfo->phone == null || $userInfo->birthday == null))
                return redirect(route('businessPanel.completeUserInfo'));

            return $next($request);
        }
        else{
            $userInfo = [];
            return redirect(route("businessPanel.loginPage"));
        }

        View::share(['fileVersions' => $fileVersions, 'userInfo' => $userInfo]);
        return $next($request);
    }
}
