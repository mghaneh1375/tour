<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\PanelBusiness\Agency\TourCreationAgencyController;
use App\Http\Controllers\PanelBusiness\Agency\AgencyBusinessPanelController;
use App\Http\Controllers\PanelBusiness\AuthPanelBusinessController;
use App\Http\Controllers\PanelBusiness\BPAjax;
use App\Http\Controllers\PanelBusiness\ContractController;
use App\Http\Controllers\PanelBusiness\MainPanelBusinessController;
use App\Http\Controllers\PanelBusiness\ReportPanelBusinessController;
use App\Http\Controllers\PanelBusiness\TicketController;
use App\Http\Controllers\PanelBusiness\UserPanelBusinessController;
use App\models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::post('cas-auth', [AuthPanelBusinessController::class, 'myLogin']);

Route::get('login-callback', [AuthPanelBusinessController::class, 'loginCallBack']);

Route::get('admin-login', function() { Auth::loginUsingId("607f046bdb19380d1ef94427"); });

Route::get('user1-login', function() { Auth::loginUsingId("607f046cdb19380d1ef94929"); });

Route::get('user2-login', function() { Auth::loginUsingId("607f046bdb19380d1ef9442c"); });

Route::get('logout', function() {

    Auth::logout();

});

Route::middleware(['BusinessPanelGuest', 'csrfVeri'])->group(function() {

    Route::get('/loginPage', function() {
        
        return Redirect::to('https://tour.bogenstudio.com/cas/login?redirectUrl=https://business.bogenstudio.com/login-callback&callback=https://business.bogenstudio.com/cas-auth');

    })->name('businessPanel.loginPage');

    Route::post('/user/checkRegisterInputs', [AuthPanelBusinessController::class, 'checkRegisterInputs'])->name('businessPanel.checkRegisterInputs');
    Route::post('/user/doSendVerificationPhoneCode', [AuthPanelBusinessController::class, 'doSendVerificationPhoneCode'])->name('businessPanel.doSendVerificationPhoneCode');
    Route::post('/user/doRegister', [AuthPanelBusinessController::class, 'doRegister'])->name('businessPanel.user.doRegister');
});


Route::middleware(['adminAccess', 'BusinessPanelShareData'])->prefix('boom')
    ->group(base_path('routes/formCreatorRoutes.php'));
    
Route::middleware(['auth'])->prefix('formCreator')
    ->group(base_path('routes/formCreatorAPIRoutes.php'));

Route::middleware(['BusinessPanelAuth', 'csrfVeri'])->group( function () {

    Route::middleware(['BusinessPanelShareData'])->group( function () {
        
        Route::view('createForm', 'panelBusiness.pages.assetManager.createForm')->name('createForm');
    
        Route::get('asset/{assetId}/step/{formId}/{userAssetId?}', function($assetId, $formId, $userAssetId=-1) {
            $states = State::all();
            return view('panelBusiness.pages.assetManager.assetForm', compact('assetId', 'formId', 'userAssetId', 'states'));
        });

        Route::get('/', [MainPanelBusinessController::class, 'mainPage'])->name('businessPanel.mainPage');
        Route::get('/profile', [MainPanelBusinessController::class, 'mainPage'])->name('profile');
        Route::get('/create', [MainPanelBusinessController::class, 'create'])->name('businessPanel.create');
       Route::view('businessesPanel', 'panelBusiness.pages.assetManager.businessesPanel')->name('businessPanel.panel');;
        Route::get('/myBusinesses', [UserPanelBusinessController::class, 'myBusinesses'])->name('businessPanel.myBusinesses');
        Route::get('/completeUserInfo', [MainPanelBusinessController::class, 'completeUserInfo'])->name('businessPanel.completeUserInfo');
    });

    Route::group(['middleware' => ['adminAccess']], function () {
        Route::middleware(['BusinessPanelShareData'])->group( function () {
            Route::get('getUnChecked', [ReportPanelBusinessController::class, "getUnChecked"])->name("businessPanel.getUnChecked");
            Route::get('getSpecificUnChecked/{business}', [ReportPanelBusinessController::class, "getSpecificUnChecked"])->name("businessPanel.getSpecificUnChecked");

            Route::get('contract', [ContractController::class, 'index'])->name('businessPanel.contracts');
            Route::get('contract/{contract}', [ContractController::class, 'show'])->name('businessPanel.contract');
        });

        Route::post('contract/{contract}', [ContractController::class, 'update'])->name('businessPanel.editContract');

        Route::post("businessFinalize/{business}", [ReportPanelBusinessController::class, "finalize"])->name("businessPanel.finalize");
        Route::post("getBusinessFinalStatus/{business}", [ReportPanelBusinessController::class, "getFinalStatus"])->name("businessPanel.getFinalStatus");
        Route::post("setBusinessFieldStatus/{business}", [ReportPanelBusinessController::class, "setFieldStatus"])->name("businessPanel.setFieldStatus");

        Route::get("formatAllTours", [AgencyBusinessPanelController::class, "deleteAllTours"]);
    });


    Route::post('/doCreate', [UserPanelBusinessController::class, 'doCreate'])->name('businessPanel.doCreate');
    Route::post('/getContract', [ContractController::class, 'getContract'])->name('businessPanel.getContract');
    Route::post('/completeUserInfo', [MainPanelBusinessController::class, 'editUserInfo'])->name('businessPanel.editUserInfo');

    // Ticket Routes
    Route::group(['middleware' => ['web']], function(){
        Route::get('ticket/user/show', [TicketController::class, 'ticketPage'])->name('ticket.page')->middleware(['BusinessPanelShareData']);
        Route::get('ticket/user/get/{parentId}', [TicketController::class, 'ticketGetUser'])->name('ticket.user.get');
        Route::post('ticket/user/store', [TicketController::class, 'storeTicketUser'])->name('ticket.user.store');
        Route::delete('ticket/user/delete', [TicketController::class, 'deleteTicketUser'])->name('ticket.user.delete');

        Route::group(['middleware' => ['adminAccess']], function (){
            Route::get('ticket/admin/show', [TicketController::class, 'adminTicketPage'])->name('ticket.admin.page')->middleware(['BusinessPanelShareData']);
            Route::get('ticket/admin/get/{parentId}', [TicketController::class, 'ticketGetAdmin'])->name('ticket.admin.get');
            Route::post('ticket/admin/store', [TicketController::class, 'storeTicketAdmin'])->name('ticket.admin.store');
            Route::post('ticket/admin/closeTicket', [TicketController::class, 'closeTicket'])->name('ticket.admin.close');
        });
    });

    // TOUR
    Route::group(['middleware' => ['web']], function(){

        Route::group(['middleware' => ['BusinessPanelShareData', 'BusinessPanelTypeManager']],  function(){
            Route::get('businessManagement/{business}/tour/list', [AgencyBusinessPanelController::class, 'tourList'])->name('businessManagement.tour.list');

            Route::get('businessManagement/{business}/tour/getFullyData/{tourId}', [TourCreationAgencyController::class, 'getFullyInfoOfTour'])->name('businessManagement.tour.getFullyInfoOfTour');

            Route::get('businessManagement/{business}/tour/create', [TourCreationAgencyController::class, 'tourCreateUrlManager'])->name('businessManagement.tour.create');
            Route::get('businessManagement/{business}/tour/create/stage_1/{tourId}/{type?}', [TourCreationAgencyController::class, 'tourCreateStageOne'])->name('businessManagement.tour.create.stage_1');
            Route::get('businessManagement/{business}/tour/create/stage_2/{tourId}', [TourCreationAgencyController::class, 'tourCreateStageTwo'])->name('businessManagement.tour.create.stage_2');
            Route::get('businessManagement/{business}/tour/create/stage_3/{tourId}', [TourCreationAgencyController::class, 'tourCreateStageThree'])->name('businessManagement.tour.create.stage_3');
            Route::get('businessManagement/{business}/tour/create/stage_4/{tourId}', [TourCreationAgencyController::class, 'tourCreateStageFour'])->name('businessManagement.tour.create.stage_4');
            Route::get('businessManagement/{business}/tour/create/stage_5/{tourId}', [TourCreationAgencyController::class, 'tourCreateStageFive'])->name('businessManagement.tour.create.stage_5');
            Route::get('businessManagement/{business}/tour/create/stage_6/{tourId}', [TourCreationAgencyController::class, 'tourCreateStageSix'])->name('businessManagement.tour.create.stage_6');

            Route::get('businessManagement/{business}/tour/getLists', [AgencyBusinessPanelController::class, 'getTourList'])->name('businessManagement.tour.getLists');
        });

        Route::group(['middleware' => ['throttle:30']],  function(){
            Route::post('businessManagement/tour/store/stage_1', [TourCreationAgencyController::class, 'tourStoreStageOne'])->name('businessManagement.tour.store.stage_1');
            Route::post('businessManagement/tour/store/stage_2', [TourCreationAgencyController::class, 'tourStoreStageTwo'])->name('businessManagement.tour.store.stage_2');
            Route::post('businessManagement/tour/store/stage_3', [TourCreationAgencyController::class, 'tourStoreStageThree'])->name('businessManagement.tour.store.stage_3');
            Route::post('businessManagement/tour/store/stage_4', [TourCreationAgencyController::class, 'tourStoreStageFour'])->name('businessManagement.tour.store.stage_4');
            Route::post('businessManagement/tour/store/stage_5', [TourCreationAgencyController::class, 'tourStoreStageFive'])->name('businessManagement.tour.store.stage_5');

            Route::post('businessManagement/tour/store/pic', [TourCreationAgencyController::class, 'tourStorePic'])->name('businessManagement.tour.store.pic');
            Route::delete('businessManagement/tour/delete/pic', [TourCreationAgencyController::class, 'tourDeletePic'])->name('businessManagement.tour.delete.pic');

            Route::delete('businessManagement/tour/delete', [TourCreationAgencyController::class, 'deleteTour'])->name('businessManagement.tour.delete');
        });

        Route::get('businessManagement/tour/getPlaceInfoForPlan', [TourCreationAgencyController::class, 'getPlaceInfoForPlan'])->name('tour.getPlaceInfoForPlan');

        Route::post('businessManagement/tour/update/timeStatus', [TourCreationAgencyController::class, 'tourUpdateTimeStatus'])->name('businessManagement.tour.update.timeStatus');
        Route::post('businessManagement/tour/update/tourPublished', [TourCreationAgencyController::class, 'tourUpdateTourPublished'])->name('businessManagement.tour.update.published');
    });

    Route::group(['middleware' => ['BusinessPanelTypeManager', 'BusinessPanelShareData']], function(){
        Route::get('businessManagement/{business}/main', [MainPanelBusinessController::class, 'getToBusinessManagementPage'])->name('businessManagement.panel');
    });

    Route::group(['middleware' => ['businessAccess']], function () {
        Route::delete('/deleteBusiness/{business}', [UserPanelBusinessController::class, 'delete'])->name('businessPanel.deleteBusiness');

        Route::middleware(['BusinessPanelShareData'])->group(function () {
            Route::get('/myBusiness/{business}', [MainPanelBusinessController::class, 'myBusiness'])->name('businessPanel.myBusiness');
        });
    });

    Route::group(['middleware' => ['businessModify']], function () {

        Route::middleware(['BusinessPanelShareData'])->group(function (){
            Route::get('businessEdit/{business}/{step?}', [UserPanelBusinessController::class, 'edit'])->name('businessPanel.edit');
        });

        Route::post('/updateBusinessInfo1/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo1'])->name('businessPanel.updateBusinessInfo1');
        Route::post('/updateBusinessInfo2/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo2'])->name('businessPanel.updateBusinessInfo2');
        Route::post('/updateBusinessInfo4/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo4'])->name('businessPanel.updateBusinessInfo4');
        Route::post('/updateBusinessInfo5/{business}', [UserPanelBusinessController::class, 'updateBusinessInfo5'])->name('businessPanel.updateBusinessInfo5');
        Route::post('/uploadBusinessPic/{business}', [UserPanelBusinessController::class, 'uploadPic'])->name('businessPanel.uploadPic');
        Route::delete('/deleteBusinessPic/{business}', [UserPanelBusinessController::class, 'deletePic'])->name('businessPanel.deletePic');
        Route::delete('/deleteBusinessMadarek/{business}', [UserPanelBusinessController::class, 'deleteMadarek'])->name('businessPanel.deleteMadarek');
        Route::post('/finalizeBusinessInfo/{business}', [UserPanelBusinessController::class, 'finalizeBusinessInfo'])->name('businessPanel.finalizeBusinessInfo');
    });

    Route::group(['middleware' => ['web']], function(){
       Route::get('bp/ajax/searchCity', [BPAjax::class, 'searchCity'])->name('BP.ajax.searchCity');
       Route::post('bp/ajax/searchInPlace', [BPAjax::class, 'searchInPlace'])->name('BP.ajax.searchInPlace');
    });


    Route::get('/doLogOut', [AuthPanelBusinessController::class, 'doLogOut'])->name('businessPanel.doLogOut');
});


    Route::post('searchForCity', [AjaxController::class, 'searchForCity'])->name('searchForCity');

    Route::get('findUser', 'AjaxController@findUser')->name('findUser');

    Route::get('searchSpecificKindPlace', [AjaxController::class, 'searchSpecificKindPlace'])->name('search.place.with.name.kindPlaceId');
    
    Route::get('findCityWithState', [AjaxController::class, 'findCityWithState'])->name('findCityWithState');
