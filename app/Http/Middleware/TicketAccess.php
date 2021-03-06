<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TicketAccess
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

        $business = $request->route("business");
        if($business == null)
            return response()->json([
                "status" => "nok",
                "msg" => "لطفا کسب و کار خود را ارسال کنید."
            ]);

        if($business->userId != Auth::user()->id && Auth::user()->level != 1)
            return response()->json([
                "status" => "nok",
                "msg" => "شما اجازه دسترسی به این کسب و کار را ندارید."
            ]);

        return $next($request);

    }
}
