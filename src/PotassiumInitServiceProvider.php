<?php

namespace Potassium\Preset;

use Potassium\Preset\PotassiumPreset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class PotassiumInitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('potassium_init', function($command){
            PotassiumPreset::setCommands();
        });
    }
}
