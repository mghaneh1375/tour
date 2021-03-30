<?php

use App\Http\Controllers\api\MainApiController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'api'], function () {

    Route::get('getPlacesForKoochitaTv', [MainApiController::class, 'getPlacesForKoochitaTv'])->name('api.getPlacesForKoochitaTv');

    Route::delete('deleteFileWithDir', [MainApiController::class, 'deleteFileWithDir'])->name('api.deleteFileWithDir');


    Route::post('totalSearchAPI', array('as' => 'totalSearchAPI', 'uses' => 'APIController@totalSearchAPI'));

    Route::post('getCitiesOrStates', array('as' => 'getCitiesOrStates', 'uses' => 'APIController@getCitiesOrStates'));

    Route::post('getStatesAPI', array('as' => 'getStatesAPI', 'uses' => 'APIController@getStates'));

    Route::post('getCitiesAPI', array('as' => 'getCitiesAPI', 'uses' => 'APIController@getCitiesAPI'));

    Route::post('getGoyeshAPI', array('as' => 'getGoyeshAPI', 'uses' => 'APIController@getGoyeshAPI'));

    Route::post('getHotelsMainAPI', array('as' => 'getHotelsMainAPI', 'uses' => 'APIController@getHotelsMainAPI'));

    Route::post('getAmakensMainAPI', array('as' => 'getAmakensMainAPI', 'uses' => 'APIController@getAmakensMainAPI'));

    Route::post('getRestaurantsMainAPI', array('as' => 'getRestaurantsMainAPI', 'uses' => 'APIController@getRestaurantsMainAPI'));

    Route::post('getFoodsMainAPI', array('as' => 'getFoodsMainAPI', 'uses' => 'APIController@getFoodsMainAPI'));

    Route::post('getHotelListElemsAPI', array('as' => 'getHotelListElemsAPI', 'uses' => 'APIController@getHotelListElemsAPI'));
});

Route::group(['namespace' => 'api', 'middleware' => ['throttle:30', 'cors']], function () {

    Route::post('login', 'APIController@login');

    Route::post('getAuthURL', array('as' => 'getAuthURL', 'uses' => 'APIController@getAuthURL'));

    Route::post('loginWithGoogle', array('as' => 'loginWithGoogle', 'uses' => 'APIController@loginWithGoogle'));
});

Route::group(['namespace' => 'api', 'middleware' => ['auth:api', 'cors']], function () {

    Route::post('logout', array('as' => 'logout', 'uses' => 'APIController@logout'));

    Route::post("showProfileAPI", ['as' => 'showProfileAPI', 'uses' => 'APIController@showProfile']);

    Route::post("getLastRecentlyMainAPI", ['as' => 'getLastRecentlyMainAPI', 'uses' => 'APIController@getLastRecentlyMainAPI']);

    Route::post("getBookMarkMainAPI", ['as' => 'getBookMarkMainAPI', 'uses' => 'APIController@getBookMarkMainAPI']);

    Route::post('getActivitiesNumSelfAPI', ['as' => 'getActivitiesNumSelfAPI', 'uses' => 'APIController@getActivitiesNumSelfAPI']);

    Route::post('getActivitiesNumGeneralAPI', ['as' => 'getActivitiesNumGeneralAPI', 'uses' => 'APIController@getActivitiesNumGeneralAPI']);

    Route::post('getActivitiesSelfAPI', ['as' => 'getActivitiesSelfAPI', 'uses' => 'APIController@getActivitiesSelfAPI']);

    Route::post('getActivitiesGeneralAPI', ['as' => 'getActivitiesGeneralAPI', 'uses' => 'APIController@getActivitiesGeneralAPI']);

    Route::post('sendMyInvitationCodeAPI', ['as' => 'sendMyInvitationCodeAPI', 'uses' => 'APIController@sendMyInvitationCodeAPI']);

});

Route::group(['namespace' => 'api', 'middleware' => ['auth:api', 'cors']], function () {

    Route::post("showBadgesAPI", ['as' => 'showBadgesAPI', 'uses' => 'APIController@showBadgesAPI']);

    Route::post("showOtherBadgeAPI", ['as' => 'showOtherBadgeAPI', 'uses' => 'APIController@showOtherBadgeAPI']);

});

Route::group(['namespace' => 'api', 'middleware' => ['auth:api', 'cors']], function () {

    Route::post("accountInfoAPI", ['as' => 'accountInfoAPI', 'uses' => 'APIController@accountInfoAPI']);
});

Route::middleware('')->get('/user', function (Request $request) {
    return $request->user();
});
