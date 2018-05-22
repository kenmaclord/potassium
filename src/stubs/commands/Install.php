<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'potassium:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate database and install dependencies';

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
        Artisan::call('key:generate');
        $this->info('Clé générée');

        shell_exec('~/composer.phar dump-autoload');
        $this->info('Autoload régénéré');

        Artisan::call('migrate');
        $this->info('Migrations terminée');

        Artisan::call('db:seed');
        $this->info('Données insérées');

        shell_exec('git init');
        $this->info('Git initialisé');

        shell_exec('npm install');
        $this->info('Paquets Node installés');

        shell_exec('./node_modules/.bin/tailwind init');
        $this->info('Tailwind initialisé');

        shell_exec('npm run dev');
        $this->info('Assets compilés');
    }
}
