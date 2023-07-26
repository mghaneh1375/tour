<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\UserAsset;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function index() {
        return view('formCreator.report.userAssets', ['userAssets' => UserAsset::all()]);
    }


}
