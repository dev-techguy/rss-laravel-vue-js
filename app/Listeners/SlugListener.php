<?php

namespace App\Listeners;

use App\Events\SlugEvent;
use Illuminate\Support\Str;

class SlugListener
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
     * @param SlugEvent $event
     * @return void
     */
    public function handle(SlugEvent $event)
    {
        // set the slug for the model
        $event->model->slug = Str::slug($event->model->name);
    }
}
