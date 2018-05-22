<?php

namespace Potassium\\Preset;

use Potassium\\Preset\PotassiumPreset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class PotassiumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('scaffold', function($command){
            PotassiumPreset::install();
        });
    }
}
