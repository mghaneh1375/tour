<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAssetResource;
use App\models\FormCreator\UserAsset;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function index(Request $request) {
        return view('formCreator.report.userAssets', ['userAssets' => UserAssetResource::collection(UserAsset::orderBy('updated_at', 'desc')->get())->toArray($request)]);
    }
}
