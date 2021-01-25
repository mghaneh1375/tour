<?php
use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function(){

    Route::middleware(['shareNews', 'shareData'])->group(function (){
        Route::get('/main', 'NewsController@newsMainPage')->name('news.main');

        Route::get('/list/{kind}/{content?}', 'NewsController@newsListPage')->name('news.list');

        Route::get('/show/{slug}', 'NewsController@newsShow')->name('news.show');
    });

    Route::get('/listGetElemes', 'NewsController@newsListElements')->name('news.list.getElements');
});
