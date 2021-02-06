<?php

namespace App\Listeners;

use App\Events\SaveErrorEvent;
use App\models\ErrorToShow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveErrorListener
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
     * @param  SaveErrorEvent  $event
     * @return void
     */
    public function handle(SaveErrorEvent $event)
    {
        $error = new ErrorToShow();
        $error->location = $event->location;
        $error->section = $event->section;
        $error->text = $event->text;
        $error->save();
    }
}
