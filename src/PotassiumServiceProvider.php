<?php

namespace Potassium\Preset;

use Potassium\Preset\PotassiumPreset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\Facades\Artisan;

class PotassiumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('potassium', function($command){
            PotassiumPreset::setCommands();
            $command->info('Commandes installées');

            Artisan::call('potassium:prepare');

            PotassiumPreset::install();

            Artisan::call('potassium:install');
        });
    }
}
