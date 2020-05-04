<?php

namespace App\Providers;

use App\Events\SlugEvent;
use App\Events\VacancyEvent;
use App\Listeners\SlugListener;
use App\Listeners\VacancyListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        SlugEvent::class => [
            SlugListener::class,
        ],
        VacancyEvent::class => [
            VacancyListener::class,
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

        //
    }
}
