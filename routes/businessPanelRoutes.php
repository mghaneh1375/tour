<?php

use App\Http\Controllers\PanelBusiness\ContractController;
use App\Http\Controllers\PanelBusiness\MainPanelBusinessController;
use App\Http\Controllers\PanelBusiness\ReportPanelBusinessController;
use App\Http\Controllers\PanelBusiness\TicketController;
use App\Http\Controllers\PanelBusiness\UserPanelBusinessController;
use Illuminate\Support\Facades\Route;


Route::middleware(['BusinessPanelGuest', 'csrfVeri'])->group(function(){

    Route::middleware(['BusinessPanelShareData'])->group(function(){

        Route::get('/loginPage', [MainPanelBusinessController::class, 'loginPage'])->name('businessPanel.loginPage');

        Route::get('/loginWithGoogle', [MainPanelBusinessController::class, 'loginWithGoogle'])->name('businessPanel.loginWithGoogle');
    });

    Route::post('/user/checkRegisterInputs', [MainPanelBusinessController::class, 'checkRegisterInputs'])->name('businessPanel.checkRegisterInputs');

    Route::post('/user/doSendVerificationPhoneCode', [MainPanelBusinessController::class, 'doSendVerificationPhoneCode'])->name('businessPanel.doSendVerificationPhoneCode');

    Route::post('/user/doRegister', [MainPanelBusinessController::class, 'doRegister'])->name('businessPanel.user.doRegister');

    Route::post('/doLogin', [MainPanelBusinessController::class, 'doLogin'])->name('businessPanel.doLogin');
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

Route::middleware(['BusinessPanelAuth', 'csrfVeri'])->group( function () {

    Route::middleware(['BusinessPanelShareData'])->group( function () {

        Route::get('/', [MainPanelBusinessController::class, 'mainPage'])->name('businessPanel.mainPage');

        Route::get('/create', [MainPanelBusinessController::class, 'create'])->name('businessPanel.create');

        Route::get('/myBusinesses', [UserPanelBusinessController::class, 'myBusinesses'])->name('businessPanel.myBusinesses');

        Route::get('/completeUserInfo', [MainPanelBusinessController::class, 'completeUserInfo'])->name('businessPanel.completeUserInfo');

        Route::middleware(['businessAccess'])->group(function () {

            Route::get('/myBusiness/{business}', [MainPanelBusinessController::class, 'myBusiness'])->name('businessPanel.myBusiness');

            Route::get('businessMsgs/{business}', [TicketController::class, "msgs"])->name("ticket.msgs");

        });

        Route::group(['middleware' => ['ticketAccess']], function () {

            Route::get('/businessSpecificMsgs/{ticket}', [TicketController::class, 'specificMsgs'])->name('ticket.specificMsgs');

        });

        Route::middleware(['businessModify'])->group(function () {

            Route::get('businessEdit/{business}/{step?}', [UserPanelBusinessController::class, 'edit'])->name('businessPanel.edit');

        });
    });

    Route::group(['middleware' => ['BusinessPanelShareData', 'adminAccess']], function () {

        Route::get('contract', [ContractController::class, 'index'])->name('businessPanel.contracts');

        Route::get('contract/{contract}', [ContractController::class, 'show'])->name('businessPanel.contract');

    });

    Route::group(['middleware' => ['adminAccess']], function () {

        Route::post('contract/{contract}', [ContractController::class, 'update'])->name('businessPanel.editContract');

        Route::post('/ticketClose/{ticket}', [TicketController::class, 'close'])->name('businessPanel.ticketClose');

        Route::post('/ticketOpen/{ticket}', [TicketController::class, 'open'])->name('businessPanel.ticketOpen');
    });

    Route::post('/doCreate', [UserPanelBusinessController::class, 'doCreate'])->name('businessPanel.doCreate');

    Route::group(['middleware' => ['businessAccess']], function () {

        Route::delete('/deleteBusiness/{business}', [UserPanelBusinessController::class, 'delete'])->name('businessPanel.deleteBusiness');

        Route::post('/businessGeneralMsgs/{business}', [TicketController::class, 'generalMsgs'])->name('businessPanel.generalMsgs');

        Route::post('/businessAddTicket/{business}', [TicketController::class, 'addTicket'])->name('businessPanel.addTicket');

    });

    Route::group(['middleware' => ['ticketAccess']], function () {

        Route::post('/ticketAddMsg/{ticket}', [TicketController::class, 'addMsg'])->name('businessPanel.ticketAddMsg');

        Route::delete('/deleteTicket/{ticket}', [TicketController::class, 'delete'])->name('businessPanel.deleteTicket');

        Route::post('/ticketMsgs/{ticket}', [TicketController::class, 'ticketMsgs'])->name('businessPanel.ticketMsgs');

    });

    Route::group(['middleware' => ['businessModify']], function () {

        Route::post('/updateBusinessInfo1/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo1'])->name('businessPanel.updateBusinessInfo1');

        Route::post('/updateBusinessInfo2/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo2'])->name('businessPanel.updateBusinessInfo2');

        Route::post('/updateBusinessInfo4/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo4'])->name('businessPanel.updateBusinessInfo4');

        Route::post('/updateBusinessInfo5/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo5'])->name('businessPanel.updateBusinessInfo5');

        Route::post('/uploadBusinessPic/{business}', [UserPanelBusinessController::class, 'uploadPic'])->name('businessPanel.uploadPic');

        Route::delete('/deleteBusinessPic/{business}', [UserPanelBusinessController::class, 'deletePic'])->name('businessPanel.deletePic');

        Route::delete('/deleteBusinessMadarek/{business}', [UserPanelBusinessController::class, 'deleteMadarek'])->name('businessPanel.deleteMadarek');

        Route::post('/finalizeBusinessInfo/{business}', [UserPanelBusinessController::class, 'finalizeBusinessInfo'])->name('businessPanel.finalizeBusinessInfo');

    });

    Route::post('/getContract', [ContractController::class, 'getContract'])->name('businessPanel.getContract');

    Route::post('/completeUserInfo', [MainPanelBusinessController::class, 'editUserInfo'])->name('businessPanel.editUserInfo');

    Route::get('/doLogOut', [MainPanelBusinessController::class, 'doLogOut'])->name('businessPanel.doLogOut');
});





