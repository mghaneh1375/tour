<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapPanelBusinessWebRoutes();

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapLocalShopsWebRoutes();

        $this->mapTourWebRoutes();

        $this->mapNewsRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapPanelBusinessWebRoutes()
    {
        Route::middleware('web')
             ->domain('businessPanel.'.env('ROUTURL'))
            ->namespace($this->namespace.'\PanelBusiness')
            ->group(base_path('routes/businessPanelRoutes.php'));
    }

    protected function mapLocalShopsWebRoutes()
    {
        Route::middleware('web')
//             ->domain('business.'.env('ROUTURL'))
            ->namespace($this->namespace.'\LocalShop')
            ->group(base_path('routes/localShopsRoutes.php'));
    }

    protected function mapTourWebRoutes()
    {
        Route::middleware('web')
//             ->domain('tour.'.env('ROUTURL'))
            ->namespace($this->namespace.'\Tour')
            ->group(base_path('routes/tourRoutes.php'));
    }

    protected function mapNewsRoutes()
    {
        Route::middleware('web')
//             ->domain('news.'.env('ROUTURL'))
            ->namespace($this->namespace.'\News')
            ->group(base_path('routes/newsRoutes.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
