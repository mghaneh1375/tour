<?php

namespace App\Providers;

use App\models\places\Place;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use PhpOffice\PhpSpreadsheet\Calculation\Database;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $urlGenerator)
    {
        config(['userPictureArr' => []]);
        config(['isGetBookMarks' => false]);
        config(['userBookMarked' => []]);
        config(['kindPlace' => Place::all()]);

        date_default_timezone_set('Asia/Tehran');

        if(config('app.env') !== 'local')
            $urlGenerator->forceScheme('https');
        else if(config('app.env') == 'local')
            $urlGenerator->forceScheme('http');
    }
}
