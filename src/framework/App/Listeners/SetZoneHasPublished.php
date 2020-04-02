<?php

namespace Potassium\App\Listeners;

use Potassium\App\Events\ZoneIsPublished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetZoneHasPublished
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
     * @param  ZoneIsPublished  $event
     * @return void
     */
    public function handle(ZoneIsPublished $event)
    {
        $event->zone->contentsByLang($event->lang)->get()->each(function($content){
            $content->update([
                'published' => 1
            ]);
        });
    }
}
