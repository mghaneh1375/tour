<?php

namespace App\Http\Controllers;

use App\models\Followers;
use App\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function setFollower(Request $request)
    {
        if(isset($request->id)){
            $u = \Auth::user();
            $followed = User::find($request->id);
            if($followed != null){
                $check = Followers::where('userId', $u->id)->where('followedId', $followed->id)->first();
                if($check != null){
                    $check->delete();
                    $status = 'delete';
                }
                else{
                    $check = new Followers();
                    $check->userId = $u->id;
                    $check->followedId = $followed->id;
                    $check->save();
                    $status = 'store';
                }

                $followerNumber = Followers::where('followedId', $followed->id)->count();
                $followingNumber = Followers::where('userId', $u->id)->count();
                echo json_encode(['status' => $status, 'followerNumber' => $followerNumber, 'followingNumber' => $followingNumber]);
            }
            else
                echo json_encode(['status' => 'notFound']);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function getFollower(Request $request)
    {
        if(isset($request->id)){
            $you = 0;
            $follow = [];
            if(auth()->check())
                $you = auth()->user()->id;

            if($request->kind == 'follower')
                $follow = Followers::where('followedId', $request->id)->get();
            else if($you != 0 && $you == $request->id && $request->kind == 'following')
                $follow = Followers::where('userId', $you)->get();

            foreach ($follow as $item){
                if($request->kind == 'follower')
                    $user = User::select(['id', 'username'])->find($item->userId);
                else if($you != 0 && $you == $request->id)
                    $user = User::select(['id', 'username'])->find($item->followedId);

                $item->pic = getUserPic($user->id);
                $item->url = route('profile', ['username' => $user->username]);
                $item->username = $user->username;
                $item->userId = $user->id;
                $item->followed = 0;
                if($you != 0) {
                    $item->followed = Followers::where('userId', $you)
                                        ->where('followedId', $user->id)
                                        ->count();
                    $item->notMe = 1;
                    if($user->id == $you)
                        $item->notMe = 0;
                }
            }

            echo json_encode(['status' => 'ok', 'result' => $follow]);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }
}
