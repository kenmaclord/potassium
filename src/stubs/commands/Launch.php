<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Launch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'potassium:launch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Lance la création complète d'une nouvelle application avec une base d'administration fonctionnelle";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('potassium:prepare');
        $this->info('Application initialisée');

        Artisan::call('preset potassium');
        $this->info('Application préparée');

        Artisan::call('potassium:install');
        $this->info('Application installée');
        $this->info('Au travail !');
    }
}
