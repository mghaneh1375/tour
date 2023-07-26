<?php

use Illuminate\Support\Facades\Route;

// Route::get('login', [AuthController::class, 'signIn'])->name("login");
// Route::post('doLogin', [AuthController::class, 'doLogin'])->name("doLogin");

Route::group(['middleware' => ['BusinessPanelShareData']], function() {

    Route::get('home', [ReportController::class, 'index'])->name("home");
    // Route::get('/', [AuthController::class, 'signIn']);

    Route::get('notifications', [AdminController::class, 'notifications'])->name("notifications");

    Route::resource('asset', AssetController::class)->except('update', "edit", "create");
    Route::post("asset/{asset}/edit", [AssetController::class, 'edit']);

    Route::resource('asset.form', FormController::class)->shallow()->except('update', 'create');
    Route::resource('form.form_field', FormFieldController::class)->shallow()->except('show', 'create');
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

});
