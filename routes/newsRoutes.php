<?php
use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function(){

    Route::middleware(['shareNews', 'shareData'])->group(function (){
        Route::get('/main', 'NewsController@newsMainPage')->name('news.main');

        Route::get('/show/{slug}', 'NewsController@newsShow')->name('news.show');


    });



});
