<?php

namespace Potassium\Preset;

use Dotenv\Dotenv;
use Potassium\Preset\PotassiumPreset;
use Illuminate\Support\Facades\Artisan;
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
        PresetCommand::macro('potassium-init', function($command){
            PotassiumPreset::prepare($command);
            $command->info('Application initialisée');
        });

        PresetCommand::macro('potassium-folders', function($command){
            PotassiumPreset::folders($command);
            $command->info('Dossiers installés');
        });

        PresetCommand::macro('potassium-install', function($command){
            PotassiumPreset::install($command);
            $command->info('Architecture créée');

            // Node modules + Compilation des assets
            PotassiumPreset::assets($command);
            $command->info('Application installée');
            $command->info('Au travail !');
        });
    }
}
