<?php

namespace App\Http\Middleware\BusinessPanel;

use Closure;

class BusinessPanelGuest
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
        if(!auth()->check())
            return $next($request);
        else
            return redirect(route('businessPanel.mainPage'));
    }
}
