<?php

use App\Http\Controllers\Tour\TourController;
use App\Http\Controllers\Tour\TourReservationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('tour')->group(function (){
    Route::middleware(['shareData'])->group(function(){
        Route::get('main', [TourController::class, 'tourMainPage'])->name('tour.main');
        Route::get('/show/{code}', [TourController::class, 'showTour'])->name('tour.show');

        Route::prefix('reserve')->group(function(){
            Route::get('/getPassengerInfo', [TourReservationController::class, 'getPassengerInfo'])->name('tour.reservation.getPassengerInfo');
            Route::get('/cancelReservation', [TourReservationController::class, 'cancelReservation'])->name('tour.reservation.cancel');
            Route::get('/paymentPage', [TourReservationController::class, 'goToPaymentPage'])->name('tour.reservation.paymentPage');

            Route::post('/checkCapacity', [TourReservationController::class, 'checkReservationCapacity'])->name('tour.reservation.checkCapacity');
            Route::post('/editPassengerCounts', [TourReservationController::class, 'editPassengerCounts'])->name('tour.reservation.editPassengerCounts');
            Route::post('/submitReservation', [TourReservationController::class, 'submitReservation'])->name('tour.reservation.submitReservation');
            Route::post('/checkDiscountCode', [TourReservationController::class, 'checkDiscountCode'])->name('tour.reservation.checkDiscountCode');
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

    Route::get('/getFullTourInformation', [TourController::class, 'getFullTourInformation'])->name('tour.getInformation');
    Route::get('/mainPage/search',[TourController::class, 'getMainPageTours'])->name('tour.getMainPageTours');
});
