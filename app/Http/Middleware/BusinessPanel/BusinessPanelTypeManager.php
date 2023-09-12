<?php

namespace App\Http\Middleware\BusinessPanel;

use App\models\Business\Business;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BusinessPanelTypeManager
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
        $businessId = $request->route("business");
        $business = Business::find($businessId);
        if($business == null || $business->userId != \auth()->user()->_id || $business->finalStatus == 0)
            return redirect(route("businessPanel.myBusinesses"));

        View::share(['businessType' => $business->type, 'businessIdForUrl' => $business->id, 'businessName' => $business->name]);

        return $next($request);
    }
}
