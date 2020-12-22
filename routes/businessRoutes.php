<?php

use Illuminate\Support\Facades\Route;

Route::prefix('business')->middleware(['BusinessShareData', 'shareData'])->group( function (){
    Route::get('/show/{id?}', 'MainBusinessController@showBusiness')->name('business.show');

    Route::middleware(['auth'])->group(function(){
        Route::get('/create', 'LocalShopController@createLocalShopPage')->name('localShop.create.page');

        Route::post('/store', 'LocalShopController@storeLocalShop')->name('localShop.store');

        Route::post('/store/pics', 'LocalShopController@storeLocalShopPics')->name('localShop.store.pics');

        Route::delete('/store/delete', 'LocalShopController@deleteLocalShopPics')->name('localShop.store.delete');

        Route::post('/review/store/picture', 'LocalShopController@storeReviewPic')->name('localShop.review.storePic');

        Route::delete('/review/delete/picture', 'LocalShopController@deleteReviewPic')->name('localShop.review.deletePic');

        Route::post('/review/store', 'LocalShopController@storeReview')->name('localShop.review.store');
    });
});

