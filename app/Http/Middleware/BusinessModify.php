<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BusinessModify {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $business = $request->route("business");
        if($business == null)
            return response()->json(["status" => "nok", "msg" => "لطفا کسب و کار خود را ارسال کنید."]);
        if($business->userId == Auth::user()->id || $business->readyForCheck || $business->finalStatus)
            return $next($request);
        else
            return response()->json(["status" => "nok", "msg" => "شما اجازه تغییر این کسب و کار را ندارید."]);
    }
}
