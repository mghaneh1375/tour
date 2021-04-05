<?php

use App\Http\Controllers\News\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function(){

    Route::middleware(['shareNews', 'shareData'])->group(function (){
        Route::get('/main', [NewsController::class, 'newsMainPage'])->name('news.main');

        Route::get('/list/{kind}/{content?}', [NewsController::class, 'newsListPage'])->name('news.list');

        Route::get('/show/{slug}', [NewsController::class, 'newsShow'])->name('news.show');
    });

    Route::get('/listGetElemes', [NewsController::class, 'newsListElements'])->name('news.list.getElements');
});
