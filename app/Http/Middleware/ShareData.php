<?php

namespace App\Http\Middleware;

use App\models\Followers;
use App\models\logs\UserSeenLog;
use App\models\Message;
use App\models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareData
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
        $fileVersions = 177;

        $config = \App\models\ConfigModel::first();

        if(auth()->check()){
            $authUserInfos = User::select(['id', 'username', 'first_name', 'last_name'])->find(auth()->user()->id);
            $authUserInfos->userLevel = User::nearestLevelInModel($authUserInfos->id);
            $authUserInfos->userTotalPoint = User::getUserPointInModel($authUserInfos->id);
            $authUserInfos->nextLevel = $authUserInfos->userLevel[1]->floor - $authUserInfos->userTotalPoint;
            $authUserInfos->pic = getUserPic($authUserInfos->id);
            $authUserInfos->newMsg = Message::where('seen', 0)
                                    ->where('receiverId', $authUserInfos->id)
                                    ->count();

            $authUserInfos->followerCount = Followers::where('followedId', $authUserInfos->id)->count();
            $authUserInfos->followingCount = Followers::where('userId', $authUserInfos->id)->count();

            $newRegisterOpen = false;
            if(\Session::get('newRegister'))
                $newRegisterOpen = true;

            //            $userInfo = User::getUserActivityCount($authUserInfos->id);

            View::share([
                'authUserInfos' => $authUserInfos,
                'config' => $config,
                'fileVersions' => $fileVersions,
                'newRegisterOpen' => $newRegisterOpen
            ]);
        }
        else {
//            $buPic = \URL::asset('images/mainPics/noPicSite.jpg');
            View::share(['config' => $config, 'fileVersions' => $fileVersions]);
        }

        return $next($request);
    }
}
