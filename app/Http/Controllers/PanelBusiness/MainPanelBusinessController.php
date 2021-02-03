<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainPanelBusinessController extends Controller
{
    public function mainPage(){

        dd('mainPage');
        return view('panelBusiness.pages.userInfoSetting');
    }

    public function completeUserInfo()
    {
        return view('panelBusiness.pages.userInfoSetting');
    }
}
