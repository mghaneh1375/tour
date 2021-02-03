<?php

namespace App\Http\Middleware\BusinessPanel;

use Closure;
use Illuminate\Support\Facades\Auth;

class BusinessPanelAuth
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
        if(auth()->check()){
            if($request->is('loginPage'))
                return redirect(route('businessPanel.mainPage'));
            else
                return $next($request);
        }
        else{
            if($request->is('loginPage'))
                return $next($request);
            elseif($request->method() == "GET")
                return redirect(route('businessPanel.loginPage'));
            else
                return response('Unauthorized.', 401);
        }
    }
}
