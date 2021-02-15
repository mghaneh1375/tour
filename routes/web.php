<?php

use App\models\ConfigModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;

//Route::get('exportPhonesToExcels', 'HomeController@exporPhone');

Route::any('android', function (Illuminate\Http\Request $request) {

    $key = $request["key"];
    if(strlen($key) < 3) {
        return response()->json([
            "status" => "0",
            "result" => [$key]
        ]);

    }
    $cities = \Illuminate\Support\Facades\DB::select("select concat(name, ' در ', (select name from state where id = stateId)) as name from cities where isVillage = 0 and name like '%" . $key . "%'");
    $out = [];
    $counter = 0;

    foreach ($cities as $city) {
        $out[$counter++] = $city->name;
    }
    return response()->json([
        "status" => "0",
        "result" => $out
    ]);
});

Route::get('language/{lang}', function($lang){
    Session::put('lang', $lang);
    return redirect()->back();
});

//sitemap
Route::group(array(), function(){
    Route::get('/sitemap.xml', 'SitemapController@index');

    Route::get('/sitemap.xml/places', 'SitemapController@places');

    Route::get('/sitemap.xml/lists', 'SitemapController@lists');

    Route::get('/sitemap.xml/posts', 'SitemapController@posts');

    Route::get('/sitemap.xml/city', 'SitemapController@city');

    Route::get('/sitemap.xml/village', 'SitemapController@village');

    Route::get('/sitemap.xml/news', 'SitemapController@news');

});

Route::post('log/storeSeen', 'LogController@storeUserSeenLog')->name('log.storeSeen');
Route::get('edver/get', 'AdvertisementController@getAdvertisement')->name('advertisement.get');


Route::group(array('middleware' => ['throttle:60', 'web']), function () {

    Route::get('/', 'MainController@showMainPage')->name('home')->middleware('shareData');

    Route::get('main', function (){
        return redirect(\route('home'));
    })->name('main');

    Route::get('main/{mode?}', function(){
        return redirect(url('/'));
    })->name('mainMode');

    Route::get('/landingPage', 'MainController@landingPage')->name('landingPage')->middleware('shareData');

    //PDF creator
    Route::get('alaki/{tripId}', array('as' => 'alaki', 'uses' => 'HomeController@alaki'));

    Route::get('printPage/{tripId}', 'HomeController@printPage')->name('printPage');

    Route::get('soon', array('as' => 'soon', 'uses' => 'HomeController@soon'));

    Route::post('fillMyDivWithAdv', ['as' => 'fillMyDivWithAdv', 'uses' => 'PlaceController@fillMyDivWithAdv']);

    Route::post('getSimilarsHotel', array('as' => 'getSimilarsHotel', 'uses' => 'HotelController@getSimilarsHotel'));

    Route::post('getSimilarsAmaken', array('as' => 'getSimilarsAmaken', 'uses' => 'AmakenController@getSimilarsAmaken'));

    Route::post('getSimilarsRestaurant', array('as' => 'getSimilarsRestaurant', 'uses' => 'RestaurantController@getSimilarsRestaurant'));

    Route::post('getSimilarsMajara', array('as' => 'getSimilarsMajara', 'uses' => 'MajaraController@getSimilarsMajara'));

    Route::post('getNearby', array('as' => 'getNearby', 'uses' => 'PlaceController@getNearby'));

    Route::post('getQuestions', array('as' => 'getQuestions', 'uses' => 'PlaceController@getQuestions'));

    Route::post('askQuestion', array('as' => 'askQuestion', 'uses' => 'PlaceController@askQuestion'));

    Route::post('deleteQuestion', 'PlaceController@deleteQuestion')->name('deleteQuestion');

    Route::post('getCommentsCount', array('as' => 'getCommentsCount', 'uses' => 'PlaceController@getCommentsCount'));

    Route::post('showAllAns', array('as' => 'showAllAns', 'uses' => 'PlaceController@showAllAns'));

    Route::post('getComment', array('as' => 'getComment', 'uses' => 'PlaceController@getComment'));

    Route::post('filterComments', array('as' => 'filterComments', 'uses' => 'PlaceController@filterComments'));

    Route::post('showUserBriefDetail', array('as' => 'showUserBriefDetail', 'uses' => 'PlaceController@showUserBriefDetail'));

    Route::post('getPhotos', array('as' => 'getPhotos', 'uses' => 'PlaceController@getPhotos'));

    Route::post('getPhotoFilter', array('as' => 'getPhotoFilter', 'uses' => 'PlaceController@getPhotoFilter'));

    Route::get('showAllPlaces/{placeId1}/{kindPlaceId1}/{placeId2?}/{kindPlaceId2?}/{placeId3?}/{kindPlaceId3?}/{placeId4?}/{kindPlaceId4?}', array('as' => 'showAllPlaces4', 'uses' => 'PlaceController@showAllPlaces'));

    Route::post('getPlaceStyles', array('as' => 'getPlaceStyles', 'uses' => 'PlaceController@getPlaceStyles'));

    Route::post('getSrcCities', array('as' => 'getSrcCities', 'uses' => 'PlaceController@getSrcCities'));

//    Route::post('getTags', array('as' => 'getTags', 'uses' => 'PlaceController@getTags'));

    Route::get('policies', array('as' => 'policies', 'uses' => 'HomeController@showPoliciess'))->middleware('shareData');

    Route::get('estelahat/{goyesh}', array('as' => 'estelahat', 'uses' => 'HomeController@estelahat'));

    Route::get('otherBadge/{username}', array('as' => 'otherBadge', 'uses' => 'BadgeController@showOtherBadge'));

    Route::post('getActivities', array('as' => 'ajaxRequestToGetActivities', 'uses' => 'ActivityController@getActivities'));

    Route::post('getNumsActivities', array('as' => 'ajaxRequestToGetActivitiesNum', 'uses' => 'ActivityController@getNumsActivities'));

    Route::post('getRecentlyActivities', array('as' => 'recentlyViewed', 'uses' => 'ActivityController@getRecentlyActivities'));
});

//authenticated controller
Route::group(array('middleware' => ['throttle:30', 'shareData']), function(){
//    Route::get('login', 'UserLoginController@login');
    Route::get('newPasswordEmail/{code}', 'UserLoginController@newPasswordEmailPage')->name('newPasswordEmail');

    Route::post('setNewPasswordEmail', 'UserLoginController@setNewPasswordEmail')->name('setNewPasswordEmail');

    Route::post('checkLogin', array('as' => 'checkLogin', 'uses' => 'UserLoginController@checkLogin'));

    Route::get('login', array('as' => 'login', 'uses' => 'UserLoginController@mainDoLogin'));

    Route::post('login2', array('as' => 'login2', 'uses' => 'UserLoginController@doLogin'));

    Route::post('checkEmail', array('as' => 'checkEmail', 'uses' => 'UserLoginController@checkEmail'));

    Route::post('checkUserName', array('as' => 'checkUserName', 'uses' => 'UserLoginController@checkUserName'));

    Route::post('registerAndLogin', array('as' => 'registerAndLogin', 'uses' => 'UserLoginController@registerAndLogin'));

    Route::post('retrievePasByEmail', array('as' => 'retrievePasByEmail', 'uses' => 'UserLoginController@retrievePasByEmail'));

    Route::post('retrievePasByPhone', array('as' => 'retrievePasByPhone', 'uses' => 'UserLoginController@retrievePasByPhone'));

    Route::post('setNewPassword', 'UserLoginController@setNewPassword')->name('user.setNewPassword');

    Route::post('checkPhoneNum', array('as' => 'checkPhoneNum', 'uses' => 'UserLoginController@checkPhoneNum'));

    Route::post('checkRegisterData', 'UserLoginController@checkRegisterData')->name('checkRegisterData');

    Route::post('checkActivationCode', 'UserLoginController@checkActivationCode')->name('register.checkActivationCode');

    Route::post('resendActivationCode', array('as' => 'resendActivationCode', 'uses' => 'UserLoginController@resendActivationCode'));

    Route::post('resendActivationCodeForget', array('as' => 'resendActivationCodeForget', 'uses' => 'UserLoginController@resendActivationCodeForget'));

    Route::post('checkReCaptcha', array('as' => 'checkReCaptcha', 'uses' => 'UserLoginController@checkReCaptcha'));

    Route::get('loginWithGoogle', array('as' => 'loginWithGoogle', 'uses' => 'UserLoginController@loginWithGoogle'));

    Route::get('logout', array('as' => 'logout', 'uses' => 'UserLoginController@logout'));
});

//detailsPage
Route::get('place-details/{kindPlaceId}/{placeId}', 'PlaceController@setPlaceDetailsURL')->name('placeDetails');
Route::middleware(['throttle:60'])->group(function (){

    Route::middleware(['shareData'])->group(function (){
        Route::get('myLocation', 'MainController@myLocation')->name('myLocation');
        Route::get('placeList/{kindPlaceId}/{mode}/{city?}', 'PlaceController@showPlaceList')->name('place.list');
        Route::get('show-place-details/{kindPlaceName}/{slug}', 'PlaceController@showPlaceDetails')->name('show.place.details');
        Route::get('cityPage/{kind}/{city}', 'CityController@cityPage')->name('cityPage');
    });

    Route::middleware(['auth'])->group(function(){
        Route::post('places/setRateToPlace', 'PlaceController@setRateToPlace')->name('places.setRateToPlaces');
    });

    Route::get('placeDetails/getPics', 'PlaceController@getPlacePics')->name('place.getPics');
    Route::get('getPlacesWithLocation', 'MainController@getPlacesWithLocation')->name('getPlaces.location');
    Route::get('getCityPageTopPlace', 'CityController@getCityPageTopPlace')->name('cityPage.topPlaces');
    Route::post('getPlaceListElems', 'PlaceController@getPlaceListElems')->name('place.list.getElems');
    Route::post('getCityAllPlaces', 'CityController@getCityAllPlaces')->name('getCityAllPlaces');
});

//ajaxController
Route::middleware(['nothing'])->group(function () {

    Route::get('getMyInfoForPassenger', 'AjaxController@getMyInfoForPassenger')->name('getMyInfoForPassenger');

    Route::get('getLastPassengers', 'AjaxController@getLastPassengers')->name('getLastPassengers');

    Route::get('searchPlace', 'AjaxController@searchPlace')->name('search.place');

    Route::get('searchForFoodMaterial', 'AjaxController@searchForFoodMaterial')->name('search.foodMaterial');

    Route::post('searchSuggestion', 'AjaxController@searchSuggestion')->name('searchSuggestion');

    Route::post('getSingleQuestion', 'AjaxController@getSingleQuestion')->name('getSingleQuestion');

    Route::post('getTags', 'AjaxController@getTags')->name('getTags');

    Route::post('getCities', 'AjaxController@getCitiesDir')->name('getCitiesDir');

    Route::post('searchForMyContacts', array('as' => 'searchForMyContacts', 'uses' => 'AjaxController@searchForMyContacts'));

    Route::post('searchEstelah', array('as' => 'searchEstelah', 'uses' => 'AjaxController@searchEstelah'));

    Route::post('getStates', array('as' => 'getStates', 'uses' => 'AjaxController@getStates'));

    Route::post('getGoyesh', array('as' => 'getGoyesh', 'uses' => 'AjaxController@getGoyesh'));

    Route::post('getPlaceKinds', array('as' => 'getPlaceKinds', 'uses' => 'AjaxController@getPlaceKinds'));

    Route::post('getPlacePic', array('as' => 'getPlacePic', 'uses' => 'AjaxController@getPlacePic'));

    Route::post('proSearch', array('as' => 'proSearch', 'uses' => 'AjaxController@proSearch'));

    Route::post('searchForCity', array('as' => 'searchForCity', 'uses' => 'AjaxController@searchForCity'));

    Route::post('searchForLine', array('as' => 'searchForLine', 'uses' => 'AjaxController@searchForLine'));

    Route::post('findKoochitaAccount', 'AjaxController@findKoochitaAccount')->name('findKoochitaAccount');

    Route::post('log/like', 'AjaxController@likeLog')->name('likeLog');

    Route::get('findCityWithState', 'AjaxController@findCityWithState')->name('findCityWithState');

    Route::get('searchSpecificKindPlace', 'AjaxController@searchSpecificKindPlace')->name('search.place.with.name.kindPlaceId');

    Route::get('findUser', 'AjaxController@findUser')->name('findUser');

    Route::get('getMainPageSuggestion', 'AjaxController@getMainPageSuggestion')->name('getMainPageSuggestion');

    Route::get('searchInCounty', 'AjaxController@searchInCounty')->name('ajax.searchInCounty');
});

//review section
Route::middleware(['nothing'])->group(function () {
    Route::get('reviewPage/{id}', 'ReviewsController@showReviewPage')->name('review.page')->middleware('shareData');

    Route::get('review/getUserReviews', 'ReviewsController@getUserReviews')->name('review.getUserReviews');

    Route::get('review/getSingleReview', 'ReviewsController@getSingleReview')->name('review.getSingleReview');

    Route::get('review/getCityPageReview', 'ReviewsController@getCityPageReview')->name('review.getCityPageReview');

    Route::get('review/searchInReviewTags', 'ReviewsController@searchInReviewTags')->name('review.searchInReviewTags');

    Route::post('getReviews', 'ReviewsController@getReviews')->name('getReviews');

    Route::middleware(['auth'])->group(function (){
        Route::get('review/getReviewsForExplore', 'ReviewsController@getReviewExplore')->name('review.explore');

        Route::post('review/getNewCodeForUploadNewReview', 'ReviewsController@getNewCodeForUploadNewReview')->name('review.getNewCodeForUploadNewReview');

        Route::post('reviewUploadFile', 'ReviewsController@reviewUploadFile')->name('review.uploadFile');

        Route::post('reviewUploadPic', 'ReviewsController@reviewUploadPic')->name('reviewUploadPic');

        Route::post('doEditReviewPic', 'ReviewsController@doEditReviewPic')->name('doEditReviewPic');

        Route::post('deleteReviewPic', 'ReviewsController@deleteReviewPic')->name('deleteReviewPic');

        Route::post('review/store', 'ReviewsController@storeReview')->name('storeReview');

        Route::post('review/ans', 'ReviewsController@ansReview')->name('ansReview');

        Route::post('review/bookMark', 'ReviewsController@addReviewToBookMark')->name('review.bookMark');

        Route::post('review/delete', 'ReviewsController@deleteReview')->name('review.delete');
    });

});

//safarnameh
Route::group([], function () {
    Route::middleware(['shareData', 'SafarnamehShareData'])->group(function(){
        Route::get('/safarnameh', 'SafarnamehController@safarnamehMainPage')->name('safarnameh.index');
        Route::get('/safarnameh/show/{id}', 'SafarnamehController@showSafarnameh')->name('safarnameh.show');
        Route::get('/safarnameh/list/{type?}/{search?}', 'SafarnamehController@safarnamehList')->name('safarnameh.list');
    });

    Route::get('/article/{slug}', 'SafarnamehController@safarnamehRedirect');
    Route::get('/article/list/{type}/{search}', 'SafarnamehController@safarnamehListRedirect');

    Route::get('/safarnameh/mainPageData', 'SafarnamehController@safarnamehMainPageData')->name('safarnameh.getMainPageData');
    Route::get('/safarnameh/getListElement', 'SafarnamehController@getSafarnamehListElements')->name('safarnameh.getListElement');
    Route::get('/paginationInSafarnamehList', 'SafarnamehController@paginationInSafarnamehList')->name('safarnameh.list.pagination');
    Route::post('/getSafarnamehComments', 'SafarnamehController@getSafarnamehComments')->name('safarnameh.comment.get');

    Route::group(['middleware' => ['auth']], function (){
        Route::post('/safarnameh/like', 'SafarnamehController@LikeSafarnameh')->name('safarnameh.like');
        Route::post('/safarnameh/comment/store', 'SafarnamehController@StoreSafarnamehComment')->name('safarnameh.comment.store');
        Route::post('/safarnameh/comment/like', 'SafarnamehController@likeSafarnamehComment')->name('safarnameh.comment.like');
        Route::post('/safarnameh/bookMark', 'SafarnamehController@addSafarnamehBookMark')->name('safarnameh.bookMark');

        Route::post('safarnameh/store', 'SafarnamehController@storeSafarnameh')->name('safarnameh.store');
        Route::post('safarnameh/getForEdit', 'SafarnamehController@getSafarnameh')->name('safarnameh.get');
        Route::post('safarnameh/delete', 'SafarnamehController@deleteSafarnameh')->name('safarnameh.delete');
        Route::post('safarnameh/storePic', 'SafarnamehController@storeSafarnamehPics')->name('safarnameh.storePic');
    });
});

//reports
Route::group(array('middleware' => 'nothing'), function(){
    Route::post('getReportQuestions', 'ReportController@getReportQuestions')->name('getReportQuestions');

    Route::post('getReports', array('as' => 'getReportsDir', 'uses' => 'ReportController@getReports1'));

    Route::post('getReports2', array('as' => 'getReports', 'uses' => 'ReportController@getReports2'));

    Route::post('report', array('as' => 'report', 'uses' => 'ReportController@report'));

    Route::get('getReports', array('as' => 'getReports', 'uses' => 'ReportController@getReports'));

    Route::get('getReports/{page}', array('as' => 'getReports2', 'uses' => 'ReportController@getReports'));

    Route::post('storeReport', array('as' => 'storeReport', 'uses' => 'ReportController@storeReport'));

    Route::post('sendReceiveReport', array('as' => 'sendReceiveReport', 'uses' => 'ReportController@sendReceiveReport'));

    Route::post('sendReport', array('as' => 'sendReport', 'uses' => 'ReportController@sendReport'));
});

// profile common
Route::group(['middleware' => ['throttle:60']], function(){
    Route::get('addPlace/index', 'ProfileController@addPlaceByUserPage')->name('addPlaceByUser.index')->middleware('shareData');

    Route::get('profile/index/{username?}', 'ProfileController@showProfile')->name('profile')->middleware('shareData');

    Route::get('/profile/getUserPicsAndVideo', 'ProfileController@getUserPicsAndVideo')->name('profile.getUserPicsAndVideo');

    Route::post('/profile/getFollower', 'FollowerController@getFollower')->name('profile.getFollower');

    Route::post('/profile/getUserMedals', 'ProfileController@getUserMedals')->name('profile.getUserMedals');

    Route::post('/profile/getSafarnameh', 'ProfileController@getSafarnameh')->name('profile.getSafarnameh');

    Route::post('/profile/getQuestions', 'ProfileController@getQuestions')->name('profile.getQuestions');

    Route::group(array('middleware' => ['throttle:60', 'auth']), function () {

        Route::get('profile/getUserInfoFooter', 'ProfileController@getUserInfoFooter')->name('profile.getUserInfoFooter');

        Route::get('profile/getBookMarks', 'ProfileController@getBookMarks')->name('profile.getBookMarks');

        Route::get('profile/getMainFestival', 'ProfileController@getMainFestival')->name('profile.getMainFestival');

        Route::get('profile/festival/getMyWorks', 'ProfileController@getFestivalContent')->name('profile.festival.getMyWorks');

        Route::delete('profile/festival/deleteMyWork', 'ProfileController@deleteFestivalContent')->name('profile.festival.deleteMyWork');

        Route::post('profile/bookMark/delete', 'ProfileController@deleteBookMarkWithId')->name('profile.bookMark.delete');

        Route::post('profile/safarnameh/placeSuggestion', 'ProfileController@placeSuggestion')->name('profile.safarnameh.placeSuggestion');

        Route::post('profile/updateUserPhoto', 'ProfileController@updateUserPhoto')->name('profile.updateUserPhoto');

        Route::post('profile/updateMyBio', 'ProfileController@updateMyBio')->name('profile.updateMyBio');

        Route::post('profile/updateBannerPic', 'ProfileController@updateBannerPic')->name('profile.updateBannerPic');

        Route::get('profile/editPhoto', 'ProfileController@editPhoto')->name('profile.editPhoto')->middleware('shareData');

        Route::get('profile/message', 'MessageController@messagingPage')->name('profile.message.page')->middleware('shareData');

        Route::post('profile/message/get', 'MessageController@getMessages')->name('profile.message.get');

        Route::post('profile/message/update', 'MessageController@updateMessages')->name('profile.message.update');

        Route::post('profile/message/send', 'MessageController@sendMessages')->name('profile.message.send');

        Route::get('profile/myTrips', 'MyTripsController@myTrips')->name('myTrips')->middleware('shareData');

        Route::get('profile/myTrips/getTrips', 'MyTripsController@getTrips')->name('myTrips.getTrips');

        Route::get('profile/tripPlaces/{tripId}/{sortMode?}', 'MyTripsController@myTripsInner')->name('tripPlaces')->middleware('shareData');

        Route::get('profile/recentlyView', 'MyTripsController@recentlyViewTotal')->name('recentlyViewTotal')->middleware('shareData');

        Route::get('profile/accountInfo', 'ProfileController@accountInfo')->name('profile.accountInfo')->middleware('shareData');

        Route::post('profile/setFollower', 'FollowerController@setFollower')->name('profile.setFollower');

        Route::post('getRecentlyViewElems', array('as' => 'getRecentlyViewElems', 'uses' => 'MyTripsController@getRecentlyViewElems'));

        Route::post('doEditPhoto', array('as' => 'doEditPhoto', 'uses' => 'ProfileController@doEditPhoto'));

        Route::post('submitPhoto', array('as' => 'submitPhoto', 'uses' => 'ProfileController@submitPhoto'));


        Route::post('addPlace/createStepLog', 'ProfileController@createStepLog')->name('addPlaceByUser.createStepLog');

        Route::post('addPlace/store', 'ProfileController@storeAddPlaceByUser')->name('addPlaceByUser.store');

        Route::post('addPlace/storeImg', 'ProfileController@storeImgAddPlaceByUser')->name('addPlaceByUser.storeImg');

        Route::post('addPlace/deleteImg', 'ProfileController@deleteImgAddPlaceByUser')->name('addPlaceByUser.deleteImg');

        Route::post('getTripStyles', array('as' => 'getTripStyles', 'uses' => 'TripStyleController@getTripStyles'));

        Route::post('updateTripStyles', array('as' => 'updateTripStyles', 'uses' => 'TripStyleController@updateTripStyles'));

        Route::post('sendMyInvitationCode', array('as' => 'sendMyInvitationCode', 'uses' => 'ProfileController@sendMyInvitationCode'));

        Route::get('messages', array('as' => 'msgs', 'uses' => 'MessageController@showMessages'))->middleware('shareData');

        Route::get('messagesErr/{err}', array('as' => 'msgsErr', 'uses' => 'MessageController@showMessages'))->middleware('shareData');

        Route::post('opOnMsgs', array('as' => 'opOnMsgs', 'uses' => 'MessageController@opOnMsgs'));

        Route::post('sendMsg/{srcName?}', array('as' => 'sendMsg', 'uses' => 'MessageController@sendMsg'));

        Route::post('sendMsgAjax', array('as' => 'sendMsgAjax', 'uses' => 'MessageController@sendMsgAjax'));

        Route::post('getMessage', array('as' => 'getMessage', 'uses' => 'MessageController@getMessage'));

        Route::post('getListOfMsgs', array('as' => 'getListOfMsgsDir', 'uses' => 'MessageController@getListOfMsgs'));

        Route::post('blockUser', array('as' => 'block', 'uses' => 'MessageController@blockUser'));

        Route::post('blockList', array('as' => 'getBlockListDir', 'uses' => 'MessageController@blockList'));

        Route::get('badge', array('as' => 'badge', 'uses' => 'BadgeController@showBadges'));

        Route::post('deleteAccount', array('as' => 'deleteAccount', 'uses' => 'ProfileController@deleteAccount'));

        Route::post('searchInCities', array('as' => 'searchInCities', 'uses' => 'ProfileController@searchInCities'));

        Route::post('getDefaultPics', array('as' => 'getDefaultPics', 'uses' => 'ProfileController@getDefaultPics'));

        Route::post('getBannerPics', array('as' => 'getBannerPics', 'uses' => 'ProfileController@getBannerPics'));

        Route::post('updateProfile1', array('as' => 'updateProfile1', 'uses' => 'ProfileController@updateProfile1'));

        Route::post('checkAuthCode', array('as' => 'checkAuthCode', 'uses' => 'ProfileController@checkAuthCode'));

        Route::post('resendAuthCode', array('as' => 'resendAuthCode', 'uses' => 'ProfileController@resendAuthCode'));

        Route::post('updateProfile2', array('as' => 'updateProfile2', 'uses' => 'ProfileController@updateProfile2'));

        Route::post('updateProfile3', array('as' => 'changePas', 'uses' => 'ProfileController@updateProfile3'));

        Route::post('placeTrips', array('as' => 'placeTrips', 'uses' => 'MyTripsController@placeTrips'));

        Route::post('assignPlaceToTrip', array('as' => 'assignPlaceToTrip', 'uses' => 'MyTripsController@assignPlaceToTrip'));

        Route::get('seeTrip/{tripId}', array('as' => 'seeTrip', 'uses' => 'MyTripsController@tripHistory'));

        Route::get('acceptTrip/{tripId}', array('as' => 'acceptTrip', 'uses' => 'MyTripsController@acceptTrip'));

        Route::get('rejectInvitation/{tripId}', array('as' => 'rejectInvitation', 'uses' => 'MyTripsController@rejectInvitation'));

        Route::post('getTripMembers', array('as' => 'getTripMembers', 'uses' => 'MyTripsController@getTripMembers'));

        Route::post('getMemberAccessLevel', array('as' => 'getMemberAccessLevel', 'uses' => 'MyTripsController@getMemberAccessLevel'));

        Route::post('changeAddPlace', array('as' => 'changeAddPlace', 'uses' => 'MyTripsController@changeAddPlace'));

        Route::post('changePlaceDate', array('as' => 'changePlaceDate', 'uses' => 'MyTripsController@changePlaceDate'));

        Route::post('changeTripDate', array('as' => 'changeTripDate', 'uses' => 'MyTripsController@changeTripDate'));

        Route::get('travel', array('as' => 'travel', 'uses' => 'TravelController@showTravel'))->middleware('shareData');

        Route::post('sendAns', array('as' => 'sendAns', 'uses' => 'PlaceController@sendAns'));

        Route::post('sendAns2', array('as' => 'sendAns2', 'uses' => 'PlaceController@sendAns2'));

        Route::post('addPhotoToPlace', 'PlaceController@addPhotoToPlace')->name('addPhotoToPlace');

        Route::post('likePhotographer', 'PlaceController@likePhotographer')->name('likePhotographer');

        Route::post('addPhotoToComment/{placeId}/{kindPlaceId}', array('as' => 'addPhotoToComment', 'uses' => 'PlaceController@addPhotoToComment'));

        Route::post('setBookMark', array('as' => 'setBookMark', 'uses' => 'PlaceController@setBookMark'));

        Route::get('/alert/get', 'HomeController@getAlerts')->name('getAlerts');

        Route::post('/alert/seen', 'HomeController@seenAlerts')->name('alert.seen');

        Route::post('deleteUserPicFromComment', array('as' => 'deleteUserPicFromComment', 'uses' => 'PlaceController@deleteUserPicFromComment'));

    });
});

//festival
Route::group(['middleware' => ['web', 'shareData']], function(){

    Route::group(['middleware' => 'nothing'], function(){
        Route::get('/ashpazi', 'CookController@cookFestival')->name('festival.cook');
        Route::get('/Ashpazi', 'CookController@cookFestival');
        Route::get('/ASHPAZI', 'CookController@cookFestival');

        Route::post('/festival/cook/checkFirstStepRegister', 'CookController@checkFirstStepRegister')->name('festival.cook.firstStepRegister');

        Route::post('/festival/cook/fullRegister', 'CookController@fullRegister')->name('festival.cook.fullRegister');

        Route::group(['middleware' => ['auth']], function() {
            Route::post('/festival/cook/uploadFile', 'CookController@uploadFile')->name('festival.cook.uploadFile');

            Route::delete('/festival/cook/deleteFile', 'CookController@deleteFile')->name('festival.cook.deleteFile');

            Route::post('/festival/cook/submitFiles', 'CookController@submitFiles')->name('festival.cook.submitFiles');
        });
    });

    Route::get('/festival', 'FestivalController@festivalIntroduction')->name('festival');

    Route::get('/festival/main', 'FestivalController@mainPageFestival')->name('festival.main');

    Route::get('/festival/uploadWorks', 'FestivalController@festivalUploadWorksPage')->name('festival.uploadWorks');

    Route::post('/festival/getContent', 'FestivalController@getFestivalContent')->name('festival.getContent');

    Route::group(['middleware' => ['auth']], function(){
        Route::post('/festival/uploadFile', 'FestivalController@uploadFile')->name('festival.uploadFile');

        Route::post('/festival/uploadFile/delete', 'FestivalController@deleteUploadFile')->name('festival.uploadFile.delete');

        Route::post('/festival/submitWorks', 'FestivalController@submitWorks')->name('festival.submitWorks');

        Route::post('/festival/likeWork', 'FestivalController@likeWork')->name('festival.likeWork');

        Route::post('/festival/getMySurvey', 'FestivalController@getMySurvey')->name('festival.getMySurvey');
    });
});

//trip
Route::group(array('middleware' => ['auth']), function(){

    Route::get('trip/print/{tripId}', 'MyTripsController@printTrips')->name('trip.print');

    Route::post('trip/editTrip', 'MyTripsController@editTrip')->name('trip.editTrip');

    Route::post('trip/addNote', 'MyTripsController@addNote')->name('trip.addNote');

    Route::post('trip/editUserAccess', 'MyTripsController@editUserAccess')->name('trip.editUserAccess');

    Route::post('trip/add', 'MyTripsController@addTrip')->name('addTrip');

    Route::post('trip/invite', 'MyTripsController@inviteFriend')->name('trip.inviteFriend');

    Route::post('trip/invite/result', 'MyTripsController@inviteResult')->name('trip.invite.result');

    Route::post('trip/editUserAccestrip.addPlaces', 'MyTripsController@editUserAccess')->name('trip.editUserAccess');

    Route::post('trip/deleteMember', 'MyTripsController@deleteMember')->name('deleteMember');

    Route::post('trip/delete', 'MyTripsController@deleteTrip')->name('deleteTrip');

    Route::post('trip/addTripPlace', 'MyTripsController@addTripPlace')->name('trip.addPlace');

    Route::post('trip/deletePlace', 'MyTripsController@deletePlace')->name('trip.deletePlace');

    Route::post('trip/placeInfo', 'MyTripsController@placeInfo')->name('trip.placeInfo');

    Route::post('trip/assignDateToPlace','MyTripsController@assignDateToPlace')->name('trip.assignDateToPlace');

    Route::post('trip/changeDateTrip', 'MyTripsController@changeDateTrip')->name('trip.changeDateTrip');

    Route::post('trip/addComment', 'MyTripsController@addComment')->name('trip.addComment');

    Route::post('trip/comment/delete', 'MyTripsController@deleteComment')->name('trip.comment.delete');

});


// admin access
Route::group(array('middleware' => ['throttle:60', 'auth', 'adminAccess']), function () {

    Route::post('mainSliderStore', 'HomeController@mainSliderStore')->name('mainSlider.image.store');

    Route::post('mainSliderImagesDelete', 'HomeController@mainSliderImagesDelete')->name('mainSlider.image.delete');

    Route::post('middleBannerImage', 'HomeController@middleBannerImages')->name('middleBanner.image.store');

    Route::post('middleBannerImagesDelete', 'HomeController@middleBannerImagesDelete')->name('middleBanner.image.delete');

    Route::get('fillState', 'HomeController@fillState');

    Route::get('fillCity', 'HomeController@fillCity');

    Route::get('fillAirLine', 'HomeController@fillAirLine');

    Route::get('fillTrain', 'HomeController@fillTrain');

    Route::get('updateHotelsFile', 'HomeController@updateHotelsFile');

    Route::get('updateAmakensFile', 'HomeController@updateAmakensFile');

//    Route::any('updateBot', 'HomeController@updateBot');

    Route::get('export/{mode}', 'HomeController@export');

    Route::get('removeDuplicate/{key}', 'HomeController@removeDuplicate');

    Route::get('test/{c}', array('as' => 'test', 'uses' => 'TestController@start'));

    Route::post('testMethod', array('as' => 'testMethod', 'uses' => 'TestController@methodTest'));

    Route::post('changeMeta/kind={kind}/id={id}', 'MetaController@changeMeta');

    Route::post('findPlace', array('as' => 'findPlace', 'uses' => 'HomeController@findPlace'));
});

//hotel reservation
Route::group(array('middleware' => ['throttle:30', 'shareData']), function () {

    Route::get('buyHotel', function(){
//        session()->forget(['orderId', 'reserveRequestId', 'expiryDateTime', 'remain']);
//        if(auth()->check())
//            return redirect(url('hotelPas'));
//        else
//            return view('pishHotel');
        $mode = 2;
        return view('hotelPas1', compact('mode'));

    });
    Route::get('hotelPas/{mode?}', function($mode = ''){
        $now = \Carbon\Carbon::now();
        if(session('expiryDateTime') == null){
            session()->forget(['orderId', 'reserveRequestId', 'expiryDateTime', 'remain']);
        }
        else{
            $expireTime = \Carbon\Carbon::createFromTimeString(session('expiryDateTime'));
            if($expireTime <= $now) {
                session()->forget(['orderId', 'reserveRequestId', 'expiryDateTime', 'remain']);
            }
            else {
                $now = $now->timestamp;
                $expireTime = $expireTime->timestamp;
                $remain = $expireTime - $now;
                session(['remain' => $remain]);
            }
        }
        return view('hotelPas1', compact('mode'));
    });
    Route::post('updateSession', function (){
        session()->forget(['reserve_room']);

        $rooms = json_encode(request()->all());

        session(['reserve_room' => $rooms]);
        session(['backURL' => request('backURL')]);
        session(['hotel_name' => request('hotel_name')]);
        return;
    })->name('updateSession');
    Route::post('searchPlaceHotelList2', 'HotelReservationController@searchPlaceHotelList2')->name('searchPlaceHotelList2');
    Route::post('/makeSessionHotel', 'HotelReservationController@makeSessionHotel')->name('makeSessionHotel');
    Route::post('sendReserveRequest', 'HotelReservationController@sendReserveRequest')->name('sendReserveRequest');
    Route::post('GetReserveStatus', 'HotelReservationController@GetReserveStatus')->name('GetReserveStatus');
    Route::get('paymentPage', function (){
        dd('صفحه ی پرداخت');
    })->name('paymentPage');
    Route::get('voucherHotel', function(){
        dd('صدور واچر') ;
    })->name('voucherHotel');
    Route::post('getHotelPassengerInfo', 'HotelReservationController@getHotelPassengerInfo')->name('getHotelPassengerInfo');
    Route::post('getAccessTokenHotel', 'HotelReservationController@getAccessTokenHotel')->name('getAccessTokenHotel');
    Route::post('checkUserNameAndPassHotelReserve', 'HotelReservationController@checkUserNameAndPassHotelReserve')->name('checkUserNameAndPassHotelReserve');

    Route::post('getHotelWarning', 'HotelReservationController@getHotelWarning')->name('getHotelWarning');
    Route::get('AlibabaInfo', 'HotelReservationController@AlibabaInfo')->name('AlibabaInfo');
    Route::post('saveAlibabaInfo', 'HotelReservationController@saveAlibabaInfo')->name('saveAlibabaInfo');

});
Route::group(array('middleware' => ['throttle:30']), function () {
    Route::get('fillTable', function(){

        $ch = curl_init();

        $passengers = ['authToken' => 'bb9726149db593a2b098bb223ee1f520'];

        curl_setopt($ch, CURLOPT_URL, "https://api.blitbin.com/ext/countries");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $passengers);

//	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//			'Content-Type: application/json')
//	);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = json_decode(curl_exec($ch));

        curl_close ($ch);

        foreach ($content as $key => $value) {

            if($key == "countries") {
                foreach ($value as $k2 => $v2) {
                    $tmp = new \App\models\CountryCode();
                    foreach ($v2 as $k3 => $v3) {
                        if($k3 == "name")
                            $tmp->name = $v3;
                        else if($k3 == "name_en")
                            $tmp->nameEn = $v3;
                        else if($k3 == "code")
                            $tmp->code = $v3;
                    }
                    $tmp->save();
                }

            }

        }
    });

    Route::post('checkUserNameAndPass', ['as' => 'checkUserNameAndPass', 'uses' => 'HomeController@checkUserNameAndPass']);

    Route::get('pay/{forWhat}/{additionalId}', ['as' => 'pay', 'uses' => 'PayController@doPayment']);

    Route::post('getMinPrice', ['as' => 'getMinPrice', 'uses' => 'TicketController@getMinPrice']);

    Route::post('getProvidersOfSpecificFlight', ['as' => 'getProvidersOfSpecificFlight', 'uses' => 'TicketController@getProvidersOfSpecificFlight']);

    Route::post('sendJavaRequest', ['as' => 'sendJavaRequest', 'uses' => 'TicketController@sendJavaRequest']);

    Route::post('getMyPassengers', ['as' => 'getMyPassengers', 'uses' => 'TicketController@getMyPassengers']);

    Route::post('getMyTicketInfo', ['as' => 'getMyTicketInfo', 'uses' => 'TicketController@getMyTicketInfo']);

    Route::post('sendPassengersInfo/{ticketId}', ['as' => 'sendPassengersInfo', 'uses' => 'TicketController@sendPassengersInfo']);

    Route::post('checkInnerFlightCapacity', ['as' => 'checkInnerFlightCapacity', 'uses' => 'TicketController@checkInnerFlightCapacity']);

    Route::any('totalSearch', 'HomeController@totalSearch')->name('totalSearch');

    Route::any('searchForStates', array('as' => 'searchForStates', 'uses' => 'HomeController@searchForStates'));

    Route::any('hotelList2/{city}/{mode}', array('as' => 'hotelList2', 'uses' => 'HotelReservationController@showHotelList2'));

    Route::post('notifyFlight/{code}', ['as' => 'notifyFlight', 'uses' => 'TicketController@notifyFlight']);

    Route::get('preBuyInnerFlight/{ticketId}/{adult}/{child}/{infant}/{ticketId2?}', ['as' => 'preBuyInnerFlight', 'uses' => 'TicketController@preBuyInnerFlight']);

    Route::get('buyInnerFlight/{mode}/{ticketId}/{adult}/{child}/{infant}/{ticketId2?}', ['as' => 'buyInnerFlight', 'uses' => 'TicketController@buyInnerFlight']);

    Route::get('testHotel', 'HomeController@testHotel');

    Route::get('tickets', array('as' => 'tickets', 'uses' => 'TicketController@tickets'));

    Route::get('getTickets/{mode}/{src}/{dest}/{adult}/{child}/{infant}/{additional}/{sDate}/{eDate?}/{back?}/{ticketId?}', array('as' => 'getTickets', 'uses' => 'TicketController@getTickets'));

    Route::post('getInnerFlightTicket', ['as' => 'getInnerFlightTicket', 'uses' => 'TicketController@getInnerFlightTicket']);

    Route::post('getTicketWarning', ['as' => 'getTicketWarning', 'uses' => 'TicketController@getTicketWarning']);

    Route::post('newPlaceForMap' ,array('as' => 'newPlaceForMap' , 'uses' =>'PlaceController@newPlaceForMap'));

    Route::post('getPlacePicture' ,array('as' => 'getPlacePicture' , 'uses' =>'PlaceController@getPlacePicture'));

    Route::get('video360' , array('as' => 'video360' , 'uses' => 'PlaceController@video360'));

});
Route::get('provider', function (){
    return view('provider-details');
})->middleware('shareData');
Route::get('provider2', function (){
    return view('provider-details2');
})->middleware('shareData');

// delete contents
Route::group(['middleware' => 'auth'], function () {

    Route::post('album/pics/delete', 'DeleteContentController@deleteAlbumPic')->name('album.pic.delete');

});

Route::get('emailtest/{email}', 'HomeController@emailtest');

Route::get('exportToExcelTT', 'HomeController@exportExcel');

// not use
Route::group(array('middleware' => ['nothing']), function () {
    Route::post('changeAddFriend', array('as' => 'changeAddFriend', 'uses' => 'NotUseController@changeAddFriend'));
    Route::any('majaraList/{city}/{mode}', array('as' => 'majaraList', 'uses' => 'NotUseController@showMajaraList'));
    Route::any('restaurantList/{city}/{mode}/{chert?}', array('as' => 'restaurantList', 'uses' => 'NotUseController@showRestaurantList'));
    Route::any('hotelList/{city}/{mode}/{chert?}', array('as' => 'hotelList', 'uses' => 'NotUseController@showHotelList'));
    Route::any('amakenList/{city}/{mode}/{chert?}', array('as' => 'amakenList', 'uses' => 'NotUseController@showAmakenList'));
    Route::get('userQuestions', 'NotUseController@userQuestions');
    Route::get('userPosts', 'NotUseController@userPosts');
    Route::get('userPhotosAndVideos', 'NotUseController@userPhotosAndVideos');
    Route::get('gardeshnameEdit', 'NotUseController@gardeshnameEdit');
    Route::get('myTripInner', 'NotUseController@myTripInner');
    Route::get('userActivitiesProfile', 'NotUseController@userActivitiesProfile');
    Route::get('amaken-details/{placeId}/{placeName}/{mode?}', 'NotUseController@showAmakenDetail');
    Route::get('restaurant-details/{placeId}/{placeName}/{mode?}', 'NotUseController@showRestaurantDetail');
    Route::get('hotel-details/{placeId}/{placeName}/{mode?}', 'NotUseController@showHotelDetail');
    Route::get('majara-details/{placeId}/{placeName}/{mode?}', 'NotUseController@showMajaraDetail');
    Route::get('sanaiesogat-details/{placeId}/{placeName}/{mode?}', 'NotUseController@showSogatSanaieDetails');
    Route::get('mahaliFood-details/{placeId}/{placeName}/{mode?}', 'NotUseController@showMahaliFoodDetails');

    Route::post('opOnComment', 'NotUseController@opOnComment')->name('opOnComment');
    Route::post('getOpinionRate', 'NotUseController@getOpinionRate')->name('getOpinionRate');
    Route::post('setPlaceRate', 'NotUseController@setPlaceRate')->name('setPlaceRate');
    Route::post('sendComment', 'NotUseController@sendComment')->name('sendComment');
    Route::get('seeAllAns/{questionId}/{mode?}/{logId?}', 'PlaceController@seeAllAns')->name('seeAllAns');

});

Route::get('/getPages/login', 'GetPagesController@getLoginPage')->name('getPage.login');

Route::get('seenLogExport/{num}', 'MainController@seenLogExport');

Route::get('/getVideosFromKoochitaTv', 'AjaxController@getVideosFromKoochitaTv')->name('getVideosFromKoochitaTv');
