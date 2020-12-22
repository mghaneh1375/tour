<?php

namespace App\Http\Middleware;

use App\models\Language;
use Closure;

include_once __DIR__ .'/../Controllers/Common.php';

class Localization
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
        if(\Session::has('lang'))
            \App::setlocale(\Session::get('lang'));
        else
            \App::setLocale('fa');
//        else{
//            $country = ip_info("Visitor", "Country");
//            if($country == 'Iran')
//                \App::setlocale('fa');
//            else
//                \App::setlocale('en');
//        }

        return $next($request);
    }
}
