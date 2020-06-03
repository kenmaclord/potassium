<?php

namespace Potassium\App\Observers;

use Illuminate\Support\Facades\Cache;
use Potassium\App\Entities\Traduction;


class TraductionObserver
{
    public function created(Traduction $traduction)
    {
        Cache::forget('zones');
    }


    /**
     * Modifie l'état de publication d'une zone à false lors d'un update d'une traduction
     *
     * @param   Potassium\App\Entities\Traduction  $traduction
     *
     * @return  void
     */
    public function updated(Traduction $traduction)
    {
        $langue = array_keys(request()->all())[0];

        updateJson($traduction->zone, 'published', [$langue => false]);

        Cache::forget('zones');
    }
}
