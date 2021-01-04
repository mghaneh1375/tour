<?php
use Illuminate\Support\Facades\Route;

Route::prefix('tour')->group(function (){
    Route::middleware(['shareData'])->group(function(){
        Route::get('/create/complete/{id}', 'TourController@completeCreationTour')->name('tour.create.complete');
        Route::get('/index', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            return view('tour.tour', compact(['placeMode', 'state']));
        });
        Route::get('/details', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            $place = \App\models\places\Hotel::find(1);
            $kindPlaceId = 1;
//        dd($place);
            return view('tour.tour-details', compact(['placeMode', 'state', 'place', 'kindPlaceId']));
        });
        Route::get('/lists', function (){
            $placeMode = 'tour';
            $state = 'تهران';
            return view('tour.tour-lists', compact(['placeMode', 'state']));
        });
    });

    Route::middleware(['auth'])->group(function(){
        Route::middleware(['shareData'])->group(function(){
            Route::get('/create/afterStart', 'TourController@afterStart')->name('afterStart');
            Route::get('/create/stageOne/{id?}', 'TourController@stageOneTour')->name('tour.create.stage.one');
            Route::get('/create/stageTwo/{id}', 'TourController@stageTwoTour')->name('tour.create.stage.two');
            Route::get('/create/stageThree/{id}', 'TourController@stageThreeTour')->name('tour.create.stage.three');
            Route::get('/create/stageFour/{id}', 'TourController@stageFourTour')->name('tour.create.stage.four');
            Route::get('/create/stageFive/{id}', 'TourController@stageFiveTour')->name('tour.create.stage.five');
        });

        Route::post('/create/stageOneTourStore', 'TourController@storeStageOneTour')->name('tour.create.stage.one.store');
        Route::post('/create/stageTwoTourStore', 'TourController@stageTwoTourStore')->name('tour.create.stage.two.store');
        Route::post('/create/stageThreeTourStore', 'TourController@stageThreeTourStore')->name('tour.create.stage.three.store');
        Route::post('/create/stageFourTourStore', 'TourController@stageFourTourStore')->name('tour.create.stage.four.store');
        Route::post('/create/stageFiveTourStore', 'TourController@stageFiveTourStore')->name('tour.create.stage.five.store');
        Route::post('/create/storeTourPics', 'TourController@storeTourPics')->name('tour.create.store.pics');
        Route::post('/create/deleteTourPics', 'TourController@deleteTourPics')->name('tour.create.store.delete');
    });
});
