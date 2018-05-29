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
            PotassiumPreset::setAppFolder();
            PotassiumPreset::setDatabase();
            PotassiumPreset::setProviders();

            $command->info('Commandes, App folder, Database et Providers installés');

            Artisan::call('potassium:prepare');

            PotassiumPreset::install();

            Artisan::call('potassium:install');
        });
    }
}
