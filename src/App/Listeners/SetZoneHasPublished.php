<?php

namespace Potassium\App\Listeners;

use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Potassium\App\Events\ZoneIsPublished;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetZoneHasPublished
{
    /**
     * Handle the event.
     *
     * @param  ZoneIsPublished  $event
     * @return void
     */
    public function handle(ZoneIsPublished $event)
    {
        updateJson($event->zone, 'published', [$event->lang => true]);

        Cache::forget("traductions-{$event->lang}");
        Cache::forget("zones");
    }
}
