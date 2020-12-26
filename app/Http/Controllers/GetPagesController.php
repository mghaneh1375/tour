<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GetPagesController extends Controller
{
    public function getLoginPage(){
        $view = view('general.nLoginPopUp')->render();
        return response()->json($view);
    }
}
