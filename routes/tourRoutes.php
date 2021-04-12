<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('tour')->group(function (){
    Route::middleware(['shareData'])->group(function(){
        Route::get('main', 'TourController@tourMainPage')->name('tour.main');
        Route::get('/show/{code}', 'TourController@showTour')->name('tour.show');

        Route::prefix('reserve')->group(function(){
            Route::get('/getPassengerInfo', 'TourReservationController@getPassengerInfo')->name('tour.reservation.getPassengerInfo');
            Route::get('/cancelReservation', 'TourReservationController@cancelReservation')->name('tour.reservation.cancel');
            Route::get('/paymentPage', 'TourReservationController@goToPaymentPage')->name('tour.reservation.paymentPage');

            Route::post('/checkCapacity', 'TourReservationController@checkReservationCapacity')->name('tour.reservation.checkCapacity');
            Route::post('/editPassengerCounts', 'TourReservationController@editPassengerCounts')->name('tour.reservation.editPassengerCounts');
            Route::post('/submitReservation', 'TourReservationController@submitReservation')->name('tour.reservation.submitReservation');
            Route::post('/checkDiscountCode', 'TourReservationController@checkDiscountCode')->name('tour.reservation.checkDiscountCode');
        });

        Route::get('/index', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            return view('tour.tour', compact(['placeMode', 'state']));
        });
        Route::get('/lists', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            return view('pages.tour.tour-lists', compact(['placeMode', 'state']));
        });
    });

    Route::get('/getFullTourInformation', 'TourController@getFullTourInformation')->name('tour.getInformation');
    Route::get('/mainPage/search','TourController@getMainPageTours')->name('tour.getMainPageTours');
});
