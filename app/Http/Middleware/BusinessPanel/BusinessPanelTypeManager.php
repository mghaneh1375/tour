<?php

namespace App\Http\Middleware\BusinessPanel;

use App\models\Business\Business;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\models\FormCreator\Asset;
use App\Http\Resources\UserAssetDigest;

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
        $assets = Asset::all();
        $output = [];
        $uId = Auth::user()->_id;
 
        
        foreach($assets as $asset) {
            
            $userAssets = $asset->user_assets()->where('id', $businessId)->get();
            
            if(count($userAssets) == 0)
                continue;

            $tmp = UserAssetDigest::collection($userAssets);

            
            foreach($tmp as $itr) {
                $itr['asset'] = $asset->name;
                $itr['asset_id'] = $asset->id;
                $itr['type'] = $asset->type;
                if($asset->type == 'Authentication'){
                }else{
                    array_push($output, $itr);
                }   
            }
        }
        $business = $output;
        foreach ($business as $busines){

            View::share(['businessType' => $busines['type'], 'businessIdForUrl' => $busines['id'], 'businessName' => $busines['title']]);
        }

        // if($business == null || $business->userId != \auth()->user()->_id || $business->finalStatus == 0)
        //     return redirect(route("businessPanel.myBusinesses"));

        // View::share(['businessType' => 'agency', 'businessIdForUrl' => 74, 'businessName' => 'IRAN']);

        return $next($request);
    }
}
