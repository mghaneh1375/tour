<?php

use App\Http\Controllers\FormCreator\AdminController;
use App\Http\Controllers\FormCreator\AssetController;
use App\Http\Controllers\FormCreator\FormController;
use App\Http\Controllers\FormCreator\FormFieldController;
use App\Http\Controllers\FormCreator\ReportController;
use App\Http\Controllers\FormCreator\SubAssetController;
use App\Http\Controllers\FormCreator\UserAssetController;
use Illuminate\Support\Facades\Route;


Route::get('notifications', [AdminController::class, 'notifications'])->name("notifications");

Route::group(['prefix' => 'asset'], function() {

    Route::get('/', [AssetController::class, 'index'])->name('asset.index');

    Route::get('/{asset}', [AssetController::class, 'show'])->name('asset.show');

    Route::post('/', [AssetController::class, 'store'])->name('asset.store');

    Route::post("/{asset}/edit", [AssetController::class, 'edit'])->name('asset.update');

    Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('asset.destroy');


    Route::group(['prefix' => '/{asset}/form'], function() {

        Route::get('/', [FormController::class, 'index'])->name('asset.form.index');
    
        Route::post('/', [FormController::class, 'store'])->name('asset.form.store');
    
    });
    
    Route::group(['prefix' => '/{asset}/subAsset'], function() {

        Route::get('/', [SubAssetController::class, 'index'])->name('asset.sub_asset.index');
    
        Route::post('/', [SubAssetController::class, 'store'])->name('asset.sub_asset.store');
    
    });


    Route::resource('asset.subAsset', SubAssetController::class)->shallow()->except('update', 'create');

});

Route::group(['prefix' => 'form/{form}'], function() {

    Route::post("/edit", [FormController::class, 'edit'])->name('form.update');

    Route::delete("/", [FormController::class, 'destroy'])->name('form.destroy');

    Route::group(['prefix' => '/form_field'], function() {

        Route::get('/', [FormFieldController::class, 'index'])->name('form.form_field.index');
        
        Route::post('/', [FormFieldController::class, 'store'])->name('form.form_field.store');

    });

});

Route::group(['prefix' => 'form_field/{form_field}'], function() {

    Route::put("/update", [FormFieldController::class, 'update'])->name('form_field.update');

    Route::delete("/", [FormFieldController::class, 'destroy'])->name('form_field.destroy');

});


Route::group(["prefix" => "report"], function () {

    Route::get('/', [ReportController::class, 'index'])->name('report.index');

});

Route::group(["prefix" => "user_asset/{user_asset}"], function () {

    Route::get('/', [UserAssetController::class, 'show'])->name('user_asset.show');
    Route::delete('/', [UserAssetController::class, 'destroy']);

});

Route::post('setAssetStatus/{user_asset}', [AdminController::class, 'setAssetStatus'])->name('setAssetStatus');
