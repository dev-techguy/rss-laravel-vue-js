<?php

namespace App\Listeners;

use App\Events\VacancyEvent;
use App\Mail\VacancyAlert;
use App\Subscribe;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VacancyListener implements ShouldQueue
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
     * @param VacancyEvent $event
     * @return void
     */
    public function handle(VacancyEvent $event)
    {
        // send email to all subscribers
        DB::table((new Subscribe())->getTable())->latest()->chunk(100, function ($subscribers) use ($event) {
            foreach ($subscribers as $subscriber) {
                try {
                    Mail::to($subscriber->email)->send((new VacancyAlert(
                        $event->name,
                        $event->company,
                        $event->description
                    )));
                } catch (Exception $exception) {
                    Log::critical($exception->getMessage());
                    continue;
                }
            }
        });
    }
}
