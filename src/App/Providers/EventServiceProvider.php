<?php

namespace Potassium\App\Providers;

use Illuminate\Support\Facades\Event;
use Potassium\App\Events\ZoneIsPublished;
use Potassium\App\Listeners\SetZoneHasPublished;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ZoneIsPublished::class => [
            SetZoneHasPublished::class
        ]
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
