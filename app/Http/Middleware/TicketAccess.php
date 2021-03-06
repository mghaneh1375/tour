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

        $ticket = $request->route("ticket");
        if($ticket == null)
            return response()->json([
                "status" => "nok",
                "msg" => "لطفا تیکت خود را ارسال کنید."
            ]);

        $u = Auth::user();

        if($ticket->from_ != $u->id &&
            $ticket->to_ != $u->id &&
            $u->level != 1)
            return response()->json([
                "status" => "nok",
                "msg" => "شما اجازه دسترسی به این تیکت را ندارید."
            ]);

        return $next($request);

    }
}
