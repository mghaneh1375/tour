<?php

use App\Http\Controllers\PanelBusiness\ContractController;
use App\Http\Controllers\PanelBusiness\MainPanelBusinessController;
use App\Http\Controllers\PanelBusiness\ReportPanelBusinessController;
use App\Http\Controllers\PanelBusiness\UserPanelBusinessController;
use Illuminate\Support\Facades\Route;



Route::middleware(['BusinessPanelGuest', 'csrfVeri'])->group(function(){

    Route::middleware(['BusinessPanelShareData'])->group(function(){
        Route::get('/loginPage', 'UserPanelBusinessController@loginPage')->name('businessPanel.loginPage');

        Route::get('/loginWithGoogle', 'UserPanelBusinessController@loginWithGoogle')->name('businessPanel.loginWithGoogle');
    });

    Route::post('/user/checkRegisterInputs', 'UserPanelBusinessController@checkRegisterInputs')->name('businessPanel.checkRegisterInputs');

    Route::post('/user/doSendVerificationPhoneCode', 'UserPanelBusinessController@doSendVerificationPhoneCode')->name('businessPanel.doSendVerificationPhoneCode');

    Route::post('/user/doRegister', 'UserPanelBusinessController@doRegister')->name('businessPanel.user.doRegister');

    Route::post('/doLogin', 'UserPanelBusinessController@doLogin')->name('businessPanel.doLogin');
});


Route::middleware(['BusinessPanelAuth', 'adminAccess', 'csrfVeri'])->group( function (){

    Route::middleware(['BusinessPanelShareData'])->group( function () {

        Route::get('getUnChecked', [ReportPanelBusinessController::class, "getUnChecked"])->name("businessPanel.getUnChecked");

        Route::get('getSpecificUnChecked/{business}', [ReportPanelBusinessController::class, "getSpecificUnChecked"])->name("businessPanel.getSpecificUnChecked");

    });

    Route::post("businessFinalize/{business}", [ReportPanelBusinessController::class, "finalize"])->name("businessPanel.finalize");

    Route::post("getBusinessFinalStatus/{business}", [ReportPanelBusinessController::class, "getFinalStatus"])->name("businessPanel.getFinalStatus");

    Route::post("setBusinessFieldStatus/{business}", [ReportPanelBusinessController::class, "setFieldStatus"])->name("businessPanel.setFieldStatus");

});

Route::middleware(['BusinessPanelAuth', 'csrfVeri'])->group( function (){

    Route::middleware(['BusinessPanelShareData'])->group( function () {

        Route::get('/', 'MainPanelBusinessController@mainPage')->name('businessPanel.mainPage');

        Route::get('/create', 'MainPanelBusinessController@create')->name('businessPanel.create');

        Route::get('/myBusinesses', [UserPanelBusinessController::class, 'myBusinesses'])->name('businessPanel.myBusinesses');

        Route::get('/myBusiness/{business}', [MainPanelBusinessController::class, 'myBusiness'])->name('businessPanel.myBusiness');

        Route::get('/completeUserInfo', [MainPanelBusinessController::class, 'completeUserInfo'])->name('businessPanel.completeUserInfo');

        Route::middleware(['businessModify'])->group(function () {

            Route::get('/edit/{business}', [UserPanelBusinessController::class, 'edit'])->name('businessPanel.edit');

        });
    });

    Route::group(['middleware' => ['BusinessPanelShareData', 'adminAccess']], function () {

        Route::get('contract', [ContractController::class, 'index'])->name('businessPanel.contracts');

        Route::get('contract/{contract}', [ContractController::class, 'show'])->name('businessPanel.contract');

    });

    Route::group(['middleware' => ['adminAccess']], function () {

        Route::post('contract/{contract}', [ContractController::class, 'update'])->name('businessPanel.editContract');

    });

    Route::post('/doCreate', 'MainPanelBusinessController@doCreate')->name('businessPanel.doCreate');

    Route::group(['middleware' => ['businessAccess']], function () {

        Route::delete('/deleteBusiness/{business}', [UserPanelBusinessController::class, 'delete'])->name('businessPanel.deleteBusiness');

    });

    Route::group(['middleware' => ['businessModify']], function () {

        Route::post('/updateBusinessInfo1/{business}', 'MainPanelBusinessController@updateBusinessInfo1')->name('businessPanel.updateBusinessInfo1');

        Route::post('/updateBusinessInfo2/{business}', 'MainPanelBusinessController@updateBusinessInfo2')->name('businessPanel.updateBusinessInfo2');

        Route::post('/updateBusinessInfo3/{business}', 'MainPanelBusinessController@updateBusinessInfo3')->name('businessPanel.updateBusinessInfo3');

        Route::post('/updateBusinessInfo4/{business}', 'MainPanelBusinessController@updateBusinessInfo4')->name('businessPanel.updateBusinessInfo4');

        Route::post('/updateBusinessInfo5/{business}', 'MainPanelBusinessController@updateBusinessInfo5')->name('businessPanel.updateBusinessInfo5');

        Route::post('/uploadBusinessPic/{business}', 'MainPanelBusinessController@uploadPic')->name('businessPanel.uploadPic');

        Route::delete('/deleteBusinessPic/{business}', 'MainPanelBusinessController@deletePic')->name('businessPanel.deletePic');

        Route::delete('/deleteBusinessMadrak/{business}', 'MainPanelBusinessController@deleteMadrak')->name('businessPanel.deleteMadrak');

        Route::post('/finalizeBusinessInfo/{business}', 'MainPanelBusinessController@finalizeBusinessInfo')->name('businessPanel.finalizeBusinessInfo');

    });


    Route::post('/getContract', [ContractController::class, 'getContract'])->name('businessPanel.getContract');

    Route::post('/completeUserInfo', 'MainPanelBusinessController@editUserInfo')->name('businessPanel.editUserInfo');

    Route::get('/doLogOut', 'UserPanelBusinessController@doLogOut')->name('businessPanel.doLogOut');
});





