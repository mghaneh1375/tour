<?php

use App\Http\Controllers\FormCreator\AdminController;
use App\Http\Controllers\FormCreator\AssetController;
use App\Http\Controllers\FormCreator\ReportController;
use App\Http\Controllers\FormCreator\UserAssetController;
use Illuminate\Support\Facades\Route;

// Route::get('login', [AuthController::class, 'signIn'])->name("login");
// Route::post('doLogin', [AuthController::class, 'doLogin'])->name("doLogin");
// Route::get('/', [AuthController::class, 'signIn']);

Route::get('notifications', [AdminController::class, 'notifications'])->name("notifications");

Route::group(['prefix' => 'asset'], function() {

    Route::get('/', [AssetController::class, 'index'])->name('asset.index');

    Route::get('/{asset}', [AssetController::class, 'show'])->name('asset.show');

    Route::post('/', [AssetController::class, 'store'])->name('asset.store');

    Route::post("/{asset}/edit", [AssetController::class, 'edit'])->name('asset.update');

    Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('asset.destroy');

});


Route::resource('asset.form', FormController::class)->shallow()->except('update', 'create');
Route::resource('form.form_field', FormFieldController::class)->shallow()->except('show', 'create');
Route::resource('asset.subAsset', SubAssetController::class)->shallow()->except('update', 'create');

Route::group(["prefix" => "report"], function () {

    Route::get('/', [ReportController::class, 'index'])->name('report.index');

});

Route::group(["prefix" => "user_asset/{userAsset}"], function () {

    Route::get('/', [UserAssetController::class, 'show']);
    Route::delete('/', [UserAssetController::class, 'destroy']);

});

Route::post('setAssetStatus/{userAsset}', [AdminController::class, 'setAssetStatus'])->name('setAssetStatus');
