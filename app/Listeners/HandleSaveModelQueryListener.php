<?php

namespace App\Listeners;

use App\Events\HandleSaveModelQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleSaveModelQueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  HandleSaveModelQuery  $event
     * @return void
     */
    public function handle(HandleSaveModelQuery $event)
    {
        //
    }
}
