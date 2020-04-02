<?php

namespace Potassium;

use Dotenv\Dotenv;
use Potassium\PotassiumPreset;
use Illuminate\Support\Facades\Schema;
use Potassium\App\Observers\Observers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;
use Potassium\App\Console\Commands\NewPageCommand;
use Potassium\App\Http\Controllers\Admin\HomeController;
use Potassium\App\Console\Commands\NamingStrategyCommand;
use Potassium\App\Console\Commands\UploadStrategyCommand;
use Potassium\App\Http\Controllers\Admin\UsersController;
use Potassium\App\Http\Controllers\Admin\ZonesController;
use Potassium\App\Http\Controllers\Admin\DroitsController;
use Potassium\App\Http\Controllers\Admin\LanguesController;
use Potassium\App\Console\Commands\ProcessingStrategyCommand;
use Potassium\App\Http\Controllers\Admin\DashboardController;
use Potassium\App\Http\Controllers\Admin\TraductionsController;
use Potassium\App\Console\Commands\PublishabilityStrategyCommand;
use Potassium\App\Http\Controllers\Front\FrontTraductionsController;
use Potassium\App\Http\Controllers\Admin\TraductionsContentController;

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

        PresetCommand::macro('potassium-install', function($command){
            PotassiumPreset::install($command);
            $command->info('Architecture créée');

            // Node modules + Compilation des assets
            PotassiumPreset::assets($command);
            $command->info('Application installée');
            $command->info('Au travail !');
        });

        $this->init();

        $this->loaders();

        $this->publishes();

        // PresetCommand::macro('potassium-init', function($command){
        //     PotassiumPreset::prepare($command);
        //     $command->info('Application initialisée');
        // });

        // PresetCommand::macro('potassium-folders', function($command){
        //     PotassiumPreset::folders($command);
        //     $command->info('Dossiers installés');
        // });

    }


    public function register()
    {
        $this->app->make(DashboardController::class);
        $this->app->make(DroitsController::class);
        $this->app->make(HomeController::class);
        $this->app->make(LanguesController::class);
        $this->app->make(TraductionsContentController::class);
        $this->app->make(TraductionsController::class);
        $this->app->make(UsersController::class);
        $this->app->make(ZonesController::class);

        $this->app->make(FrontController::class);
        $this->app->make(FrontTraductionsController::class);
    }


    /**
     * Initialise les bases de données (travail et tests)
     *
     * @return void
     */
    public function init()
    {
        // Nécessaire pour les table avec l'encodage utf8mb4
        Schema::defaultStringLength(191);

        /**
         * Force la prise en compte des clés étrangères pour les bases de données sqlite
         * Utile pour les tests
         */
        if (\DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
            \DB::statement(\DB::raw('PRAGMA foreign_keys=1'));
        }

        $observers = new Observers();
        $observers->register();
    }


    public function loaders()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/framework/database/migrations');
        $this->loadViewsFrom(__DIR__.'/framework/views', 'potassium');

        if ($this->app->runningInConsole()) {
            $this->commands([
                NamingStrategyCommand::class,
                NewPageCommand::class,
                ProcessingStrategyCommand::class,
                PublishabilityStrategyCommand::class,
                UploadStrategyCommand::class,
            ]);
        }
    }


    public function publishes()
    {
        // Fichiers de configuration
        $this->publishes([
            __DIR__.'/publishable/config/auth.php' => config_path('auth.php'),
            __DIR__.'/publishable/config/image.php' => config_path('image.php'),
            __DIR__.'/publishable/config/laravellocalization.php' => config_path('laravellocalization.php'),
        ], 'config');


        // Views
        $this->publishes([
            __DIR__.'/publishable/views/front' => base_path('resources/views/front'),
            __DIR__.'/publishable/views/errors' => base_path('resources/views/errors'),
            __DIR__.'/publishable/views/admin/app' => base_path('resources/views/admin/app')
        ], 'views');


        // Data
        $this->publishes([
            __DIR__.'/publishable/data' => public_path('data'),
            __DIR__.'/publishable/fonts' => public_path('fonts'),
            __DIR__.'/publishable/resources/js' => public_path('js'),
            __DIR__.'/publishable/resources/sass' => public_path('sass')
        ], 'public');


        // Http
        $this->publishes([
            __DIR__.'/publishable/Kernel.php' => base_path('app/Http/Controllers/Kernel.php')
        ], 'http');


        // Fichiers de langues
        $this->publishes([
            __DIR__.'/publishable/lang/en/applications' => base_path('resources/lang/en/applications.php'),
            __DIR__.'/publishable/lang/fr/applications' => base_path('resources/lang/fr/applications.php')
        ], 'lang');

        // Fichiers de tests
        $this->publishes([
            __DIR__.'/publishable/tests' => base_path('tests')
        ], 'tests');


        // Fichiers du base_path
        $this->publishes([
            __DIR__.'/publishable/phpunit.xml' => base_path('phpunit.xml'),
            __DIR__.'/publishable/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/publishable/tailwind.js' => base_path('tailwind.js')
        ]);
    }
}
