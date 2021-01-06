<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('tour')->group(function (){
    Route::middleware(['shareData'])->group(function(){
        Route::get('/show/{code}', 'TourController@showTour')->name('tour.show');
        Route::get('/getFullTourInformation', 'TourController@getFullTourInformation')->name('tour.getInformation');

        Route::get('/index', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            return view('tour.tour', compact(['placeMode', 'state']));
        });
        Route::get('/lists', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            return view('tour.tour-lists', compact(['placeMode', 'state']));
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