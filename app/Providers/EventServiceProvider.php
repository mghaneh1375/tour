<?php

namespace App\Providers;

use App\Events\SaveErrorEvent;
use App\Listeners\SaveErrorListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Event::listen(
            HandleSaveModelQuery::class,
            [HandleSaveModelQueryListener::class, 'handle']
        );

        Event::listen(
            SaveErrorEvent::class,
            [SaveErrorListener::class, 'handle']
        );
    }
}
