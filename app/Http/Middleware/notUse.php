<?php

namespace App\Http\Middleware;

use Closure;

class notUse
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
        return redirect(route('main'));
//        return $next($request);
    }
}
