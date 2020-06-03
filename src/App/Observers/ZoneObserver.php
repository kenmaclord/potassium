<?php

namespace Potassium\App\Observers;

use Potassium\App\Entities\Zone;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class ZoneObserver
{
    public function created(Zone $zone)
    {
        Cache::forget('zones');
    }


    public function updated(Zone $zone)
    {
        if (isset($zone->getDirty()['slug'])) {
            $files = glob(resource_path("lang/**/{$zone->getOriginal()['slug']}.php"));

            foreach ($files as $file) {
                $newName = dirname($file)."/{$zone->getDirty()['slug']}.php";

                File::move($file, $newName);
            }
        }

        Cache::forget('zones');
    }


    public function deleted(Zone $zone)
    {
        foreach (glob(resource_path("lang/**/{$zone->slug}.php")) as $file) {
            File::delete($file);
        }

        Cache::forget('zones');
    }
}
