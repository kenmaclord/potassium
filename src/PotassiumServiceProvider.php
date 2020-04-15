<?php

namespace Potassium;

use Dotenv\Dotenv;
use App\Observers\Observers;
use Potassium\PotassiumPreset;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

use Potassium\App\Providers\AuthServiceProvider;
use Potassium\App\Providers\EventServiceProvider;
use Potassium\App\Providers\ConfigServiceProvider;

use Potassium\App\Commands\NewPageCommand;
use Potassium\App\Commands\NamingStrategyCommand;
use Potassium\App\Commands\UploadStrategyCommand;
use Potassium\App\Commands\ProcessingStrategyCommand;
use Potassium\App\Commands\PublishabilityStrategyCommand;

class PotassiumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('potassium-configure', function($command){
            PotassiumPreset::configure($command);
            $command->info('Application configurée');
        });

        PresetCommand::macro('potassium-install', function($command){
            // Node modules + Compilation des assets
            PotassiumPreset::launch($command);

            $command->info('Application installée');
        });

        $this->init();
        $this->loaders();
        $this->publishCommands();
    }


    public function register(){}


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


        if (file_exists(base_path('app/Observers/Observers.php'))) {
            $observers = new Observers();
            $observers->register();
        }
    }


    public function loaders()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'potassium');
        $this->loadFactoriesFrom(__DIR__.'/database/factories', 'potassium');

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


    public function publishCommands()
    {
        $this->publishes([
            __DIR__.'/publishable/entities' => base_path('app/Entities')
        ], 'models');


        // Fichiers de configuration
        $this->publishes([
            __DIR__.'/publishable/config/app.php' => config_path('app.php'),
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


        // Public Data
        $this->publishes([
            __DIR__.'/publishable/data' => public_path('data'),
            __DIR__.'/publishable/fonts' => public_path('fonts'),
            __DIR__.'/publishable/resources/js' => resource_path('js'),
            __DIR__.'/publishable/resources/sass' => resource_path('sass')
        ], 'public');


        // Assets
        $this->publishes([
            __DIR__.'/publishable/resources/js' => resource_path('js'),
            __DIR__.'/publishable/resources/sass' => resource_path('sass')
        ], 'assets');


        // Database
        $this->publishes([
            __DIR__.'/publishable/database/factories/UserFactory.php' => base_path('database/factories/UserFactory.php'),
            __DIR__.'/publishable/database/seeds/TestDatabaseSeeder.php' => base_path('database/seeds/TestDatabaseSeeder.php'),
            __DIR__.'/publishable/database/migrations/2017_10_07_000000_create_users_table.php' => base_path('database/migrations/2017_10_07_000000_create_users_table.php'),
        ], 'database');


        // Http
        $this->publishes([
            __DIR__.'/publishable/app/Kernel.php' => base_path('app/Http/Kernel.php'),
            __DIR__.'/publishable/app/RedirectIfAuthenticated.php' => base_path('app/Http/Middleware/RedirectIfAuthenticated.php'),
            __DIR__.'/publishable/app/Authenticate.php' => base_path('app/Http/Middleware/Authenticate.php')
        ], 'http');


        // Controllers
        $this->publishes([
            __DIR__.'/publishable/controllers/admin/ApiController.php' => base_path('app/Http/Controllers/Admin/ApiController.php'),
            __DIR__.'/publishable/controllers/admin/DashboardController.php' => base_path('app/Http/Controllers/Admin/DashboardController.php'),
            __DIR__.'/publishable/controllers/admin/UsersController.php' => base_path('app/Http/Controllers/Admin/UsersController.php'),
            __DIR__.'/publishable/controllers/front/FrontController.php' => base_path('app/Http/Controllers/Front/FrontController.php'),
            __DIR__.'/publishable/controllers/front/FrontTraductionsController.php' => base_path('app/Http/Controllers/Front/FrontTraductionsController.php')
        ], 'controllers');


        // Obervers
        $this->publishes([
            __DIR__.'/publishable/observers' => base_path('app/Observers')
        ], 'observers');


        // Policies
        $this->publishes([
            __DIR__.'/publishable/policies' => base_path('app/Policies')
        ], 'policies');


        // Providers
        $this->publishes([
            __DIR__.'/publishable/providers/EventServiceProvider.php' => base_path('app/Providers/EventServiceProvider.php'),
            __DIR__.'/publishable/providers/ConfigServiceProvider.php' => base_path('app/Providers/ConfigServiceProvider.php'),
            __DIR__.'/publishable/providers/AuthServiceProvider.php' => base_path('app/Providers/AuthServiceProvider.php')
        ], 'providers');


        // Routes
        $this->publishes([
            __DIR__.'/publishable/routes/web.php' => base_path('routes/web.php'),
            __DIR__.'/publishable/routes/partials/admin/users.php' => base_path('routes/partials/admin/users.php')
        ], 'routes');


        // Strategies
        $this->publishes([
            __DIR__.'/publishable/strategies' => base_path('app/Strategies'),
        ], 'strategies');


        // Fichiers de langues
        $this->publishes([
            base_path('/vendor/caouecs/laravel-lang/src/fr') => base_path('resources/lang/fr'),
            __DIR__.'/publishable/lang/en/application.php' => base_path('resources/lang/en/application.php'),
            __DIR__.'/publishable/lang/fr/application.php' => base_path('resources/lang/fr/application.php')
        ], 'lang');


        // Fichiers de tests
        $this->publishes([
            __DIR__.'/publishable/tests' => base_path('tests')
        ], 'tests');


        // Fichiers du base_path
        $this->publishes([
            __DIR__.'/publishable/root/phpunit.xml' => base_path('phpunit.xml'),
            __DIR__.'/publishable/root/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/publishable/root/tailwind.config.js' => base_path('tailwind.config.js')
        ]);
    }
}
