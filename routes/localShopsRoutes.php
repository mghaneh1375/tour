<?php

use Illuminate\Support\Facades\Route;

Route::get('business/show/{id?}', 'LocalShopController@showLocalShops')->name('business.show')->middleware(['localShopsShareData', 'shareData']);


Route::prefix('localShops')->middleware(['localShopsShareData', 'shareData'])->group( function (){
    Route::get('/show/{id?}', 'LocalShopController@showLocalShops')->name('localShops.show');

    Route::middleware(['auth'])->group(function(){
        Route::get('/create', 'CreateLocalShopController@createLocalShopPage')->name('localShop.create.page');
        Route::post('/store', 'CreateLocalShopController@storeLocalShop')->name('localShop.store');
        Route::post('/store/pics', 'CreateLocalShopController@storeLocalShopPics')->name('localShop.store.pics');
        Route::delete('/store/delete', 'CreateLocalShopController@deleteLocalShopPics')->name('localShop.store.delete');

        Route::post('/review/store/picture', 'LocalShopController@storeReviewPic')->name('localShop.review.storePic');

        Route::delete('/review/delete/picture', 'LocalShopController@deleteReviewPic')->name('localShop.review.deletePic');

        Route::post('/review/store', 'LocalShopController@storeReview')->name('localShop.review.store');
    });
});

