<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\api\APIController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CookController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalShop\CreateLocalShopController;
use App\Http\Controllers\LocalShop\LocalShopController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyTripsController;
use App\Http\Controllers\PhotographerController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SafarnamehController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\UserLoginController;
use App\models\ConfigModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;

//Route::get('exportPhonesToExcels', 'HomeController@exporPhone');

Route::get('/checkServerNumber', function(){dd(config('app.ServerNumber'));});

Route::get('/getVideosFromKoochitaTv', 'AjaxController@getVideosFromKoochitaTv')->name('getVideosFromKoochitaTv');
Route::get('/getNewestVideoFromKoochitaTv', 'AjaxController@getNewestVideoFromKoochitaTv')->name('koochitatv.getNewestVideoFromKoochitaTv');

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
    Route::get('/sitemap.xml/places', [SitemapController::class, 'places']);

    Route::get('/sitemap.xml', [SitemapController::class, 'index']);
    Route::get('/sitemap.xml/places/{kpi}', [SitemapController::class, 'placesKind']);
    Route::get('/sitemap.xml/mainPages', [SitemapController::class, 'mainPages']);
    Route::get('/sitemap.xml/lists', [SitemapController::class, 'lists']);
    Route::get('/sitemap.xml/posts', [SitemapController::class, 'posts']);
    Route::get('/sitemap.xml/city', [SitemapController::class, 'city']);
    Route::get('/sitemap.xml/village', [SitemapController::class, 'village']);
    Route::get('/sitemap.xml/news', [SitemapController::class, 'news']);
});

Route::post('log/storeSeen', 'LogController@storeUserSeenLog')->name('log.storeSeen');
Route::get('edver/get', 'AdvertisementController@getAdvertisement')->name('advertisement.get');


Route::group(array('middleware' => ['throttle:60', 'web']), function () {

    Route::get('/', [MainController::class, 'showMainPage'])->name('home')->middleware('shareData');

    Route::get('main', function (){ return redirect(\route('home')); })->name('main');

    Route::get('main/{mode?}', function(){ return redirect(url('/')); })->name('mainMode');

    Route::get('/landingPage', [MainController::class, 'landingPage'])->name('landingPage')->middleware('shareData');

    Route::post('getNearby', [PlaceController::class, 'getNearby'])->name('getNearby');


    //PDF creator

    Route::get('printPage/{tripId}', 'HomeController@printPage')->name('printPage');

    Route::get('soon', array('as' => 'soon', 'uses' => 'HomeController@soon'));

    Route::post('fillMyDivWithAdv', ['as' => 'fillMyDivWithAdv', 'uses' => 'PlaceController@fillMyDivWithAdv']);

    Route::post('getSimilarsHotel', array('as' => 'getSimilarsHotel', 'uses' => 'HotelController@getSimilarsHotel'));
\
    Route::post('getSimilarsAmaken', array('as' => 'getSimilarsAmaken', 'uses' => 'AmakenController@getSimilarsAmaken'));

    Route::post('getSimilarsRestaurant', array('as' => 'getSimilarsRestaurant', 'uses' => 'RestaurantController@getSimilarsRestaurant'));

    Route::post('getSimilarsMajara', array('as' => 'getSimilarsMajara', 'uses' => 'MajaraController@getSimilarsMajara'));


    Route::post('getQuestions', array('as' => 'getQuestions', 'uses' => 'PlaceController@getQuestions'));

    Route::post('askQuestion', array('as' => 'askQuestion', 'uses' => 'PlaceController@askQuestion'));

    Route::post('deleteQuestion', 'PlaceController@deleteQuestion')->name('deleteQuestion');

    Route::post('getCommentsCount', array('as' => 'getCommentsCount', 'uses' => 'PlaceController@getCommentsCount'));

    Route::post('showAllAns', array('as' => 'showAllAns', 'uses' => 'PlaceController@showAllAns'));

    Route::post('getComment', array('as' => 'getComment', 'uses' => 'PlaceController@getComment'));

    Route::post('filterComments', array('as' => 'filterComments', 'uses' => 'PlaceController@filterComments'));

    Route::post('showUserBriefDetail', array('as' => 'showUserBriefDetail', 'uses' => 'PlaceController@showUserBriefDetail'));

    Route::post('getPhotos', array('as' => 'getPhotos', 'uses' => 'PlaceController@getPhotos'));

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

// Searches
Route::group(['middleware' => ['web']], function(){

    Route::any('totalSearch', [HomeController::class, 'totalSearch'])->name('totalSearch');

    Route::get('searchPlace', [AjaxController::class, 'searchPlace'])->name('search.place');

    Route::get('searchForFoodMaterial', [AjaxController::class, 'searchForFoodMaterial'])->name('search.foodMaterial');

    Route::post('searchSuggestion', [AjaxController::class, 'searchSuggestion'])->name('searchSuggestion');

    Route::post('searchForMyContacts', [AjaxController::class, 'searchForMyContacts'])->name('searchForMyContacts');

    Route::post('searchEstelah', [AjaxController::class, 'searchEstelah'])->name('searchEstelah');

    Route::post('proSearch', [AjaxController::class, 'proSearch'])->name('proSearch');

    Route::post('searchForCity', [AjaxController::class, 'searchForCity'])->name('searchForCity');

    Route::post('searchForLine', [AjaxController::class, 'searchForLine'])->name('searchForLine');

    Route::get('searchSpecificKindPlace', [AjaxController::class, 'searchSpecificKindPlace'])->name('search.place.with.name.kindPlaceId');

    Route::get('searchInCounty', [AjaxController::class, 'searchInCounty'])->name('ajax.searchInCounty');

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
        Route::get('myLocation', [MainController::class, 'myLocation'])->name('myLocation');
        Route::get('placeList/{kindPlaceId}/{mode}/{city?}', [PlaceController::class, 'showPlaceList'])->name('place.list');
        Route::get('show-place-details/{kindPlaceName}/{slug}', [PlaceController::class, 'showPlaceDetails'])->name('show.place.details');
        Route::get('cityPage/{kind}/{city}', [CityController::class, 'cityPage'])->name('cityPage');
    });

    Route::get('getPlacesWithLocation', [MainController::class, 'getPlacesWithLocation'])->name('getPlaces.location');

    Route::get('placeDetails/getPics', [PlaceController::class, 'getPlacePics'])->name('place.getPics');
    Route::post('getPlaceListElems', [PlaceController::class, 'getPlaceListElems'])->name('place.list.getElems');

    Route::get('getCityPageTopPlace', [CityController::class, 'getCityPageTopPlace'])->name('cityPage.topPlaces');
    Route::post('getCityAllPlaces', [CityController::class, 'getCityAllPlaces'])->name('getCityAllPlaces');

    Route::middleware(['auth'])->group(function(){
        Route::post('places/setRateToPlace', [PlaceController::class, 'setRateToPlace'])->name('places.setRateToPlaces');
    });

});

Route::middleware(['throttle:60'])->group(function (){

    Route::middleware(['shareData', 'localShopsShareData'])->group(function (){
        Route::get('/business/show/{id?}', [LocalShopController::class, 'showLocalShops'])->name('business.show');
        Route::get('/localShops/show/{id?}', [LocalShopController::class, 'showLocalShops'])->name('localShops.show');
    });

    Route::get('localShops/getFeatures', [LocalShopController::class, 'getFeatures'])->name('localShop.getFeatureList');
    Route::get('localShops/getNears/{id}', [LocalShopController::class, 'getNears'])->name('localShop.getNears');

    Route::middleware(['auth'])->group(function(){
        Route::get('localShops/create', [CreateLocalShopController::class, 'createLocalShopPage'])->name('localShop.create.page')->middleware(['shareData', 'localShopsShareData']);

        Route::post('localShops/addIAmHere', [LocalShopController::class, 'addImAmHereLocalShop'])->name('localShop.addIAmHere');
        Route::post('localShops/store', [CreateLocalShopController::class, 'storeLocalShop'])->name('upload.localShop.store');
        Route::post('localShops/store/pics', [CreateLocalShopController::class, 'storeLocalShopPics'])->name('upload.localShop.store.pics');
        Route::delete('localShops/store/delete', [CreateLocalShopController::class, 'deleteLocalShopPics'])->name('upload.localShop.store.delete');
    });
});


//ajaxController
Route::middleware(['nothing'])->group(function () {

    Route::get('getMyInfoForPassenger', 'AjaxController@getMyInfoForPassenger')->name('getMyInfoForPassenger');

    Route::get('getLastPassengers', 'AjaxController@getLastPassengers')->name('getLastPassengers');

    Route::post('getSingleQuestion', 'AjaxController@getSingleQuestion')->name('getSingleQuestion');

    Route::post('getTags', 'AjaxController@getTags')->name('getTags');

    Route::post('getCities', 'AjaxController@getCitiesDir')->name('getCitiesDir');

    Route::post('getStates', array('as' => 'getStates', 'uses' => 'AjaxController@getStates'));

    Route::post('getGoyesh', array('as' => 'getGoyesh', 'uses' => 'AjaxController@getGoyesh'));

    Route::post('getPlaceKinds', array('as' => 'getPlaceKinds', 'uses' => 'AjaxController@getPlaceKinds'));

    Route::post('getPlacePic', array('as' => 'getPlacePic', 'uses' => 'AjaxController@getPlacePic'));


    Route::post('findKoochitaAccount', 'AjaxController@findKoochitaAccount')->name('findKoochitaAccount');

    Route::post('log/like', 'AjaxController@likeLog')->name('likeLog');

    Route::get('findCityWithState', 'AjaxController@findCityWithState')->name('findCityWithState');


    Route::get('findUser', 'AjaxController@findUser')->name('findUser');

    Route::get('getMainPageSuggestion', 'AjaxController@getMainPageSuggestion')->name('getMainPageSuggestion');

});

//review section
Route::middleware(['nothing'])->group(function () {
    Route::get('reviewPage/{id}', 'ReviewsController@showReviewPage')->name('review.page')->middleware('shareData');

    Route::get('review/getUserReviews', 'ReviewsController@getUserReviews')->name('review.getUserReviews');

    Route::get('review/getSingleReview', 'ReviewsController@getSingleReview')->name('review.getSingleReview');

    Route::get('review/getCityPageReview', 'ReviewsController@getCityPageReview')->name('review.getCityPageReview');

    Route::get('review/searchInReviewTags', 'ReviewsController@searchInReviewTags')->name('review.searchInReviewTags');

    Route::get('review/searchForContent', 'ReviewsController@searchForReview')->name('review.search.reviewContent');

    Route::post('getReviews', 'ReviewsController@getReviews')->name('getReviews');

    Route::middleware(['auth'])->group(function (){
        Route::get('review/getReviewsForExplore', [ReviewsController::class, 'getReviewExplore'])->name('review.explore');

        Route::post('review/getNewCodeForUploadNewReview', [ReviewsController::class, 'getNewCodeForUploadNewReview'])->name('review.getNewCodeForUploadNewReview');

        Route::post('reviewUploadFile', [ReviewsController::class, 'reviewUploadFile'])->name('upload.review.uploadFile');

        Route::post('reviewUploadPic', [ReviewsController::class, 'reviewUploadPic'])->name('upload.reviewUploadPic');

        Route::post('doEditReviewPic', [ReviewsController::class, 'doEditReviewPic'])->name('upload.doEditReviewPic');

        Route::post('deleteReviewPic', [ReviewsController::class, 'deleteReviewPic'])->name('upload.deleteReviewPic');

        Route::post('review/store', [ReviewsController::class, 'storeReview'])->name('upload.storeReview');

        Route::post('review/delete', [ReviewsController::class, 'deleteReview'])->name('upload.review.delete');

        Route::post('review/ans', [ReviewsController::class, 'ansReview'])->name('ansReview');

        Route::post('review/bookMark', [ReviewsController::class, 'addReviewToBookMark'])->name('review.bookMark');

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

    Route::get('/getSafarnamehComments', 'SafarnamehController@getSafarnamehComments')->name('safarnameh.comment.get');

    Route::group(['middleware' => ['auth']], function (){
        Route::post('/safarnameh/like', [SafarnamehController::class, 'LikeSafarnameh'])->name('safarnameh.like');

        Route::post('/safarnameh/comment/store', [SafarnamehController::class, 'StoreSafarnamehComment'])->name('safarnameh.comment.store');

        Route::post('/safarnameh/comment/like',  [SafarnamehController::class, 'likeSafarnamehComment'])->name('safarnameh.comment.like');

        Route::post('/safarnameh/bookMark', [SafarnamehController::class, 'addSafarnamehBookMark'])->name('safarnameh.bookMark');

        Route::post('safarnameh/getForEdit', [SafarnamehController::class, 'getSafarnameh'])->name('safarnameh.get');

        Route::post('safarnameh/store', [SafarnamehController::class, 'storeSafarnameh'])->name('upload.safarnameh.store');
        Route::post('safarnameh/delete', [SafarnamehController::class, 'deleteSafarnameh'])->name('upload.safarnameh.delete');
        Route::post('safarnameh/storePic', [SafarnamehController::class, 'storeSafarnamehPics'])->name('upload.safarnameh.storePic');
    });
});

//reports
Route::group(array('middleware' => 'nothing'), function(){
    Route::post('getReportQuestions', [ReportController::class, 'getReportQuestions'])->name('getReportQuestions');

    Route::post('getReports', [ReportController::class, 'getReports1'])->name('getReportsDir');

    Route::post('getReports2', [ReportController::class, 'getReports2'])->name('getReports');

    Route::post('report', [ReportController::class, 'report'])->name('report');

    Route::get('getReports', [ReportController::class, 'getReports'])->name('getReports');

    Route::get('getReports/{page}', [ReportController::class, 'getReports'])->name('getReports2');

    Route::post('storeReport', [ReportController::class, 'storeReport'])->name('storeReport');

    Route::post('sendReceiveReport', [ReportController::class, 'sendReceiveReport'])->name('sendReceiveReport');

    Route::post('sendReport', [ReportController::class, 'sendReport'])->name('sendReport');
});

// profile common
Route::group(['middleware' => ['throttle:60']], function(){
    Route::get('addPlace/index', [ProfileController::class, 'addPlaceByUserPage'])->name('addPlaceByUser.index')->middleware('shareData');

    Route::get('profile/index/{username?}', [ProfileController::class, 'showProfile'])->name('profile')->middleware('shareData');

    Route::get('/profile/getUserPicsAndVideo', [ProfileController::class, 'getUserPicsAndVideo'])->name('profile.getUserPicsAndVideo');

    Route::post('/profile/getFollower', [FollowerController::class, 'getFollower'])->name('profile.getFollower');

    Route::post('/profile/getUserMedals', [ProfileController::class, 'getUserMedals'])->name('profile.getUserMedals');

    Route::post('/profile/getSafarnameh', [ProfileController::class, 'getSafarnameh'])->name('profile.getSafarnameh');

    Route::post('/profile/getQuestions', [ProfileController::class, 'getQuestions'])->name('profile.getQuestions');

    Route::group(array('middleware' => ['throttle:60', 'auth']), function () {

        Route::middleware(['shareData'])->group(function() {

            Route::get('profile/editPhoto', [ProfileController::class, 'editPhoto'])->name('profile.editPhoto');

            Route::get('profile/accountInfo', [ProfileController::class, 'accountInfo'])->name('profile.accountInfo');

            Route::get('profile/message', [MessageController::class, 'messagingPage'])->name('profile.message.page');

            Route::get('messages',[MessageController::class, 'showMessages'])->name('msgs');

            Route::get('messagesErr/{err}', [MessageController::class, 'showMessages'])->name('msgsErr');

            Route::get('profile/myTrips', [MyTripsController::class, 'myTrips'])->name('myTrips');

            Route::get('profile/tripPlaces/{tripId}/{sortMode?}', [MyTripsController::class, 'myTripsInner'])->name('tripPlaces');

            Route::get('profile/recentlyView', [MyTripsController::class, 'recentlyViewTotal'])->name('recentlyViewTotal');

            Route::get('travel', [TravelController::class, 'showTravel'])->name('travel');

        });

        Route::middleware(['throttle:20'])->group(function() {
            Route::post('profile/accountInfo/editUsername', [UserLoginController::class, 'editUsernameAccountInfo'])->name('profile.accountInfo.editUsername');
            Route::post('profile/accountInfo/editPhoneNumber', [UserLoginController::class, 'editPhoneNumberAccountInfo'])->name('profile.accountInfo.editPhoneNumber');
            Route::post('profile/accountInfo/editGeneralInfo', [UserLoginController::class, 'editGeneralAccountInfo'])->name('profile.accountInfo.editGeneralInfo');
            Route::post('profile/accountInfo/editSocialInfo', [UserLoginController::class, 'editSocialInfo'])->name('profile.accountInfo.editSocialInfo');
            Route::post('profile/accountInfo/editPassword', [UserLoginController::class, 'editPassword'])->name('profile.accountInfo.editPassword');

            Route::post('profile/updateUserPhoto', [ProfileController::class, 'updateUserPhoto'])->name('upload.profile.updateUserPhoto');
            Route::post('profile/updateBannerPic', [ProfileController::class, 'updateBannerPic'])->name('upload.profile.updateBannerPic');
        });

        Route::post('photographer/uploadFile', [PhotographerController::class, 'storePhotographerFile'])->name('upload.photographer.uploadFile');
        Route::post('photographer/likePicture', [PhotographerController::class, 'likePhotographer'])->name('photographer.likePicture');
        Route::post('album/pics/delete', [PhotographerController::class, 'deleteAlbumPic'])->name('upload.album.pic.delete');

        Route::get('profile/getUserInfoFooter', [ProfileController::class, 'getUserInfoFooter'])->name('profile.getUserInfoFooter');

        Route::get('profile/getBookMarks', [ProfileController::class, 'getBookMarks'])->name('profile.getBookMarks');

        Route::get('profile/getMainFestival', [ProfileController::class, 'getMainFestival'])->name('profile.getMainFestival');

        Route::get('profile/festival/getMyWorks', [ProfileController::class, 'getFestivalContent'])->name('profile.festival.getMyWorks');

        Route::delete('profile/festival/deleteMyWork', [ProfileController::class, 'deleteFestivalContent'])->name('profile.festival.deleteMyWork');

        Route::post('profile/bookMark/delete', [ProfileController::class, 'deleteBookMarkWithId'])->name('profile.bookMark.delete');

        Route::post('profile/safarnameh/placeSuggestion', [ProfileController::class, 'placeSuggestion'])->name('profile.safarnameh.placeSuggestion');

        Route::post('profile/updateMyBio', [ProfileController::class, 'updateMyBio'])->name('profile.updateMyBio');

        Route::post('profile/message/get', [MessageController::class, 'getMessages'])->name('profile.message.get');

        Route::post('profile/message/update', [MessageController::class, 'updateMessages'])->name('profile.message.update');

        Route::post('profile/message/send', [MessageController::class, 'sendMessages'])->name('profile.message.send');

        Route::get('profile/myTrips/getTrips', [MyTripsController::class, 'getTrips'])->name('myTrips.getTrips');

        Route::post('profile/setFollower', [FollowerController::class, 'setFollower'])->name('profile.setFollower');

        Route::post('getRecentlyViewElems', [MyTripsController::class, 'getRecentlyViewElems'])->name('getRecentlyViewElems');

        Route::post('doEditPhoto', [ProfileController::class, 'doEditPhoto'])->name('upload.doEditPhoto');

        Route::post('submitPhoto', [ProfileController::class, 'submitPhoto'])->name('upload.submitPhoto');


        Route::post('addPlace/createStepLog', [ProfileController::class, 'createStepLog'])->name('addPlaceByUser.createStepLog');

        Route::post('addPlace/store', [ProfileController::class, 'storeAddPlaceByUser'])->name('addPlaceByUser.store');

        Route::post('addPlace/storeImg', [ProfileController::class, 'storeImgAddPlaceByUser'])->name('upload.addPlaceByUser.storeImg');

        Route::post('addPlace/deleteImg', [ProfileController::class, 'deleteImgAddPlaceByUser'])->name('upload.addPlaceByUser.deleteImg');

        Route::post('getTripStyles', array('as' => 'getTripStyles', 'uses' => 'TripStyleController@getTripStyles'));

        Route::post('updateTripStyles', array('as' => 'updateTripStyles', 'uses' => 'TripStyleController@updateTripStyles'));

        Route::post('sendMyInvitationCode', array('as' => 'sendMyInvitationCode', 'uses' => 'ProfileController@sendMyInvitationCode'));

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

        Route::post('updateProfile2', array('as' => 'updateProfile2', 'uses' => 'ProfileController@updateProfile2'));

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

        Route::post('sendAns', array('as' => 'sendAns', 'uses' => 'PlaceController@sendAns'));

        Route::post('sendAns2', array('as' => 'sendAns2', 'uses' => 'PlaceController@sendAns2'));

        Route::post('setBookMarkPlaces',  [PlaceController::class, 'setBookMarkPlaces'])->name('setBookMark');

        Route::get('/alert/get', [HomeController::class, 'getAlerts'])->name('getAlerts');

        Route::post('/alert/seen', [HomeController::class, 'seenAlerts'])->name('alert.seen');

    });
});

//festival
Route::group(['middleware' => ['web', 'shareData']], function(){

    Route::group(['middleware' => 'nothing'], function(){
        Route::get('/ashpazi', [CookController::class, 'cookFestival'])->name('festival.cook');
        Route::get('/Ashpazi', [CookController::class, 'cookFestival']);
        Route::get('/ASHPAZI', [CookController::class, 'cookFestival']);

        Route::post('/festival/cook/checkFirstStepRegister', [CookController::class, 'checkFirstStepRegister'])->name('festival.cook.firstStepRegister');

        Route::post('/festival/cook/fullRegister', [CookController::class, 'fullRegister'])->name('festival.cook.fullRegister');

        Route::group(['middleware' => ['auth']], function() {
            Route::post('/festival/cook/uploadFile', [CookController::class, 'uploadFile'])->name('upload.festival.cook.uploadFile');

            Route::delete('/festival/cook/deleteFile', [CookController::class, 'deleteFile'])->name('upload.festival.cook.deleteFile');

            Route::post('/festival/cook/submitFiles', [CookController::class, 'submitFiles'])->name('upload.festival.cook.submitFiles');
        });
    });

    Route::get('/festival', [FestivalController::class, 'festivalIntroduction'])->name('festival');

    Route::get('/festival/main', [FestivalController::class, 'mainPageFestival'])->name('festival.main');

    Route::get('/festival/uploadWorks', [FestivalController::class, 'festivalUploadWorksPage'])->name('festival.uploadWorks');

    Route::post('/festival/getContent', [FestivalController::class, 'getFestivalContent'])->name('festival.getContent');

    Route::group(['middleware' => ['auth']], function(){
        Route::post('/festival/uploadFile', [FestivalController::class, 'uploadFile'])->name('upload.festival.uploadFile');

        Route::post('/festival/uploadFile/delete', [FestivalController::class, 'deleteUploadFile'])->name('upload.festival.uploadFile.delete');

        Route::post('/festival/submitWorks', [FestivalController::class, 'submitWorks'])->name('upload.festival.submitWorks');

        Route::post('/festival/likeWork', [FestivalController::class, 'likeWork'])->name('festival.likeWork');

        Route::post('/festival/getMySurvey', [FestivalController::class, 'getMySurvey'])->name('festival.getMySurvey');
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

    Route::post('mainSliderStore', 'HomeController@mainSliderStore')->name('upload.mainSlider.image.store');

    Route::post('mainSliderImagesDelete', 'HomeController@mainSliderImagesDelete')->name('upload.mainSlider.image.delete');

    Route::post('middleBannerImage', 'HomeController@middleBannerImages')->name('upload.middleBanner.image.store');

    Route::post('middleBannerImagesDelete', 'HomeController@middleBannerImagesDelete')->name('upload.middleBanner.image.delete');

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
    Route::get('seeAllAns/{questionId}/{mode?}/{logId?}', 'NotUseController@seeAllAns')->name('seeAllAns');
    Route::post('getPhotoFilter', 'NotUseController@getPhotoFilter')->name('getPhotoFilter');


    Route::post('checkAuthCode', 'NotUseController@checkAuthCode')->name('checkAuthCode');
    Route::post('resendAuthCode', 'NotUseController@resendAuthCode')->name('resendAuthCode');

    Route::post('findPlace', 'NotUseController@findPlace')->name('findPlace');

    Route::get('alaki/{tripId}', 'HomeController@alaki')->name('alaki');

});

Route::get('emailtest/{email}', 'HomeController@emailtest');
Route::get('exportToExcelTT', 'HomeController@exportExcel');

Route::get('getPages/login', 'GetPagesController@getLoginPage')->name('getPage.login');

Route::get('exampleExportCode/{num}', 'MainController@exampleExportCode');

Route::get('exportDistanceFromCityCenter/alakiii', 'MainController@exportDistanceFromCityCenter')->middleware(['auth']);

Route::post('updateUserName', [APIController::class, 'updateUser']);

Route::post('addUser', [APIController::class, 'addUser']);

Route::post('checkPhone', [APIController::class, 'checkPhone']);
