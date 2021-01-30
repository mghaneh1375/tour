<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('tour')->group(function (){
    Route::middleware(['shareData'])->group(function(){
        Route::get('main', function(){ dd('tour main page'); })->name('tour.main');

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
    });

    Route::get('/getFullTourInformation', 'TourController@getFullTourInformation')->name('tour.getInformation');




    Route::middleware(['shareData'])->group(function(){
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

    Route::middleware(['auth'])->group(function(){
        Route::middleware(['shareData'])->group(function(){
            Route::get('/create/beforeStart', 'TourCreationController@beforeCreateStart')->name('tour.create.beforeStart');
            Route::get('/create/stageOne/{id?}', 'TourCreationController@stageOneTour')->name('tour.create.stage.one');
            Route::get('/create/stageTwo/{id}', 'TourCreationController@stageTwoTour')->name('tour.create.stage.two');
            Route::get('/create/stageThree/{id}', 'TourCreationController@stageThreeTour')->name('tour.create.stage.three');
            Route::get('/create/stageFour/{id}', 'TourCreationController@stageFourTour')->name('tour.create.stage.four');
            Route::get('/create/stageFive/{id}', 'TourCreationController@stageFiveTour')->name('tour.create.stage.five');

            Route::get('/create/complete/{id}', 'TourCreationController@completeCreationTour')->name('tour.create.complete');
        });

        Route::post('/create/stageOneTourStore', 'TourCreationController@storeStageOneTour')->name('tour.create.stage.one.store');
        Route::post('/create/stageTwoTourStore', 'TourCreationController@stageTwoTourStore')->name('tour.create.stage.two.store');
        Route::post('/create/stageThreeTourStore', 'TourCreationController@stageThreeTourStore')->name('tour.create.stage.three.store');
        Route::post('/create/stageFourTourStore', 'TourCreationController@stageFourTourStore')->name('tour.create.stage.four.store');
        Route::post('/create/stageFiveTourStore', 'TourCreationController@stageFiveTourStore')->name('tour.create.stage.five.store');
        Route::post('/create/storeTourPics', 'TourCreationController@storeTourPics')->name('tour.create.store.pics');
        Route::post('/create/deleteTourPics', 'TourCreationController@deleteTourPics')->name('tour.create.store.delete');
    });
});
