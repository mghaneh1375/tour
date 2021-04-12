<?php

namespace App\Http\Controllers;

use App\models\logs\UserScrollLog;
use App\models\logs\UserSeenLog;
use Illuminate\Http\Request;

class LogController extends Controller
{



    public function storeUserSeenLog(Request $request)
    {
        if(isset($request->seenPageLogId) && $request->seenPageLogId != 0){
            $log = UserSeenLog::find($request->seenPageLogId);
            if(auth()->check())
                $log->userId = auth()->user()->id;
            $log->seenTime = $log->seenTime + 5;
            $log->save();

            $scroll = UserScrollLog::where('userSeenId', $request->seenPageLogId)->first();
            $scroll->scrollLog = json_encode($request->scrollData);
            $scroll->save();

            return response()->json(['status' => 'ok', 'seenPageLogId' => $log->id]);
        }

        $nowDate = verta()->format('Y-m-d');
        if(!isset($_COOKIE['userCode'])){
            $userCode = generateRandomString(10);
            while(UserSeenLog::where('userCode', $userCode)->count() > 0)
                $userCode = generateRandomString(10);

            setcookie('userCode', $userCode, time()+(86400*30));
        }
        else
            $userCode = $_COOKIE['userCode'];

        if(auth()->check())
            $seenLog = UserSeenLog::create([
                'userId' => auth()->user()->id,
                'userCode' => $userCode,
                'url' => $request->url,
                'seenTime' => 0,
                'date' => $nowDate,
                'isMobile' => $request->isMobile,
                'width' => $request->windowsSize['width'],
                'height' => $request->windowsSize['height'],
                'relatedId' => $request->relatedId,
            ]);
        else
            $seenLog = UserSeenLog::create([
                'userCode' => $userCode,
                'url' => $request->url,
                'seenTime' => 0,
                'date' => $nowDate,
                'isMobile' => $request->isMobile,
                'width' => $request->windowsSize['width'],
                'height' => $request->windowsSize['height'],
                'relatedId' => $request->relatedId,
            ]);

        $scrollLog = UserScrollLog::firstOrCreate([ 'userSeenId' => $seenLog->id]);

        return response()->json(['status' => 'ok', 'seenPageLogId' => $seenLog->id]);
    }
}
