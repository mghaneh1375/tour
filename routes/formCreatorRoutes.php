<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormCreator\AdminController;
// use App\Http\Controllers\FormCreator\AuthController;
use App\Http\Controllers\FormCreator\ReportController;
use App\Http\Controllers\FormCreator\UserAssetController;

// Route::get('login', [AuthController::class, 'signIn'])->name("login");
// Route::post('doLogin', [AuthController::class, 'doLogin'])->name("doLogin");
Route::get('home', [ReportController::class, 'index'])->name("home")->middleware(['BusinessPanelShareData']);
// Route::get('/', [AuthController::class, 'signIn']);

Route::get('notifications', [AdminController::class, 'notifications'])->name("notifications");

Route::resource('asset', AssetController::class)->except('update', "edit", "create");
Route::post("asset/{asset}/edit", [AssetController::class, 'edit']);

Route::resource('asset.form', FormController::class)->shallow()->except('update', 'create');
Route::resource('form.form_field', FormFieldController::class)->shallow()->except('update', 'show', 'create');
Route::resource('asset.subAsset', SubAssetController::class)->shallow()->except('update', 'create');

Route::group(["prefix" => "report", "middleware" => ['auth', 'adminAccess']], function () {

    Route::get('/', [ReportController::class, 'index']);

});

Route::group(["prefix" => "user_asset/{userAsset}", "middleware" => ['auth', 'adminAccess']], function () {

    Route::get('/', [UserAssetController::class, 'show']);
    Route::delete('/', [UserAssetController::class, 'destroy']);

});

Route::group(["middleware" => ['auth', 'adminAccess']], function () {

    Route::post('setAssetStatus/{userAsset}', [AdminController::class, 'setAssetStatus'])->name('setAssetStatus');
    Route::get('logout', [AuthController::class, 'signOut'])->name('logout');

});