<?php

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

Route::middleware(['BusinessPanelAuth', 'csrfVeri'])->group( function (){

    Route::middleware(['BusinessPanelShareData'])->group( function (){
        Route::get('/', 'MainPanelBusinessController@mainPage')->name('businessPanel.mainPage');

        Route::get('/completeUserInfo', 'MainPanelBusinessController@completeUserInfo')->name('businessPanel.completeUserInfo');
    });

    Route::get('/doLogOut', 'UserPanelBusinessController@doLogOut')->name('businessPanel.doLogOut');
});





