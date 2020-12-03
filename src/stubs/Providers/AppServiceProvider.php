<?php

namespace App\Providers;

use App\Observers\Observers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
