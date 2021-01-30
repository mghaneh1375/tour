<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

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
        date_default_timezone_set('Asia/Tehran');

//        if(env('APP_ENV') !== 'local')
//            $urlGenerator->forceScheme('https');
    }
}
