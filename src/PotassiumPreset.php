<?php

namespace Potassium;

// use Dotenv\Dotenv;
// use Illuminate\Foundation\Console\Presets\Preset;
use Illuminate\Support\Arr;
use Laravel\Ui\Presets\Preset;
use Potassium\App\Providers\ConfigServiceProvider;

class PotassiumPreset extends Preset
{
    protected static $command;

    public static function configure($command)
    {
        $application = $command->ask("Quel est le nom de l'application ?");
        $url = $command->ask("Quel est l'url de l'application ? (http://domaine.com:port)");
        $database = $command->ask("Quel est le nom de la base de données à créer ?");

        copy(__DIR__.'/publishable/root/env.txt', base_path('.env'));

        static::setEnvironmentValue('APP_NAME', $application);
        static::setEnvironmentValue('APP_URL', $url);

        static::setEnvironmentValue('DB_DATABASE', $database);

        $command->info("Fichier d'environnement prêt");

        // Git
        shell_exec('git init');
        $command->info('Git initialisé');

        // Base de données
        shell_exec('`which mysql` --host=localhost -uroot -proot --execute="create database ' .$database.' character set UTF8mb4 collate utf8mb4_unicode_ci;"');

        $command->info("Base de données créee");

        static::cleanUp();
    }


    /**
     * Compile et publie l'application pour la rendre entièrement fonctionnelle
     *
     * @param   $command
     *
     * @return  void
     */
    public static function launch($command)
    {
        shell_exec('composer dump-autoload');
        $command->info('Autoload mis à jour');

        static::setDatabase($command);

        \App::register(ConfigServiceProvider::class);

        \Artisan::call('vendor:publish --provider="Potassium\\\PotassiumServiceProvider" --force');
        $command->info('Application déployée');

        static::updatePackages();
        $command->info('package.json mis à jour');

        // Nodes modules
        shell_exec('npm install');
        $command->info('Paquets Node installés');

        // Compilation des assets
        shell_exec('npm run dev');
        $command->info('Assets compilés');

        shell_exec('git add .');
        shell_exec('git commit -m "Initial Commit"');
        $command->info('Premier commit effectué');
    }



    public static function setDatabase($command)
    {
        \Artisan::call('migrate');
        \Artisan::call('db:seed --class="Potassium\\\Database\\\Seeds\\\PackageDatabaseSeeder"');

        $command->info('Base de donnée prête');
    }


    public static function cleanUp()
    {
        if (file_exists($userModel = base_path('app/User.php'))) {
            unlink($userModel);
        }

        if (file_exists($exampleTestFile = base_path('tests/Feature/ExampleTest.php'))) {
            unlink($exampleTestFile);
        }

        if (file_exists($exampleTestFile = base_path('tests/Unit/ExampleTest.php'))) {
            unlink($exampleTestFile);
        }

        $migrationFiles = glob(base_path('/database/migrations/*.*'));

        foreach ($migrationFiles as $m) {
            if (strpos($m, "create_users_table")) {
                unlink($m);
            }
        }
    }


    public static function updatePackageArray(array $packages)
    {
        return array_merge([
            "autoprefixer": "^10.0.4",
            "bulma": "^0.9.1",
            "dropzone": "^5.7.2",
            "mix-tailwindcss": "^1.2.0",
            "moment": "^2.29.1",
            "normalize.css": "^8.0.1",
            "postcss": "^8.1.10",
            "promise-polyfill": "^8.2.0",
            "sortablejs": "^1.12.0",
            "tailwindcss": "^2.0.1",
            "velocity-animate": "^1.5.2",
            "vue": "^2.6.12"
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'popper.js',
            'jquery',
        ]));
    }


    /**
     * Insère ou modifie une valeur dans le fichier d'environnement
     *
     * @param  String  $envKey
     * @param  String  $envValue
     */
    public static function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();

        $str = file_get_contents($envFile);

        $split = explode("{$envKey}=", $str);

        if(count($split) > 1){
            $oldValue = static::getEnv($envKey, $str);
            $str = str_replace("{$envKey}={$oldValue}\n", "{$envKey}={$envValue}\n", $str);
        }

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }


    /**
     * Retrouve une valeur dans le fichier d'environnement
     *
     * @param   String  $key
     * @param   String  $str
     *
     * @return  String
     */
    public static function getEnv($key, $str)
    {
        return explode("\n", (explode("{$key}=", $str))[1])[0];
    }
}
