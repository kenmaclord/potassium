<?php

namespace Potassium;

use Dotenv\Dotenv;
use Illuminate\Foundation\Console\Presets\Preset;

class PotassiumPreset extends Preset
{
    protected static $command;

    public static function configure($command)
    {
        $application = $command->ask("Quel est le nom de l'application ?");
        $url = $command->ask("Quel est l'url de l'application ? (http://domaine.com:port)");
        $database = $command->ask("Quel est le nom de la base de données à créer ?");

        static::setEnvironmentValue('APP_NAME', $application);
        static::setEnvironmentValue('APP_URL', $url);

        static::setEnvironmentValue('DB_SOCKET', '/Applications/MAMP/tmp/mysql/mysql.sock');
        static::setEnvironmentValue('DB_DATABASE', $database);
        static::setEnvironmentValue('DB_USERNAME', 'root');
        static::setEnvironmentValue('DB_PASSWORD', 'root');

        static::setEnvironmentValue('MAIL_HOST', 'smtp.mailtrap.io');
        static::setEnvironmentValue('MAIL_PORT', '2525');

        static::setEnvironmentValue('MAIL_USERNAME', 'b17cc32811a9cb');
        static::setEnvironmentValue('MAIL_PASSWORD', '5c66a0d83de453');

        static::setEnvironmentValue('MAIL_FROM_ADDRESS', 'info@domain.com');
        static::setEnvironmentValue('MAIL_FROM_NAME', '${APP_NAME}');

        $command->info("Fichier d'environnement prêt");

        // Git
        shell_exec('git init');
        $command->info('Git initialisé');

        shell_exec('git add .');
        shell_exec('git commit -m "Initial Commit"');

        // Base de données
        shell_exec('/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot --execute="create database ' .$database.' character set UTF8mb4 collate utf8mb4_unicode_ci;"');

        $command->info("Base de données créee");

        static::cleanUp();
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


    // public static function assets()
    // {
    //     static::updatePackages();
    // }


    public static function updatePackageArray()
    {
        return [
            "axios" => "^0.19.*",
            "bulma" => "^0.8.*",
            "cross-env" => "^7.*",
            "dropzone" => "^5.*",
            "laravel-mix" => "^5.*",
            "lodash" => "^4.*",
            "mix-tailwindcss" => "^1.*",
            "moment" => "^2.*",
            "promise-polyfill" => "8.*",
            "resolve-url-loader" => "^3.1.0",
            "sass" => "^1.26.3",
            "sass-loader" => "^8.0.2",
            "sortablejs" => "^1.*",
            "tailwindcss" => "^1.*",
            "velocity-animate" => "^1.*",
            "vue" => "^2.*",
            "vue-template-compiler" => "^2.6.*"
        ];
    }


    // public static function updateComposer($command)
    // {
    //     shell_exec("composer update");
    //     $command->info('Packages Composer à jour');
    // }


    public static function setDatabase($command)
    {
        \Artisan::call('migrate');
        \Artisan::call('db:seed --class="Potassium\\\Database\\\Seeds\\\PackageDatabaseSeeder"');

        $command->info('Base de donnée prête');
    }


    public static function launch($command)
    {
        shell_exec('composer dump-autoload');
        $command->info('Autoload mis à jour');

        static::setDatabase($command);

        \Artisan::call('vendor:publish --provider="Potassium\\\PotassiumServiceProvider" --force');
        $command->info('Application publiée');

        static::updatePackages();
        $command->info('package.json mis à jour');

        // Nodes modules
        shell_exec('npm install');
        $command->info('Paquets Node installés');

        // Compilation des assets
        shell_exec('npm run dev');
        $command->info('Assets compilés');
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
        }else{
            $pass = static::getEnv('DB_PASSWORD', $str);
            $str = str_replace("DB_PASSWORD={$pass}\n", "DB_PASSWORD={$pass}\n{$envKey}={$envValue}\n", $str);
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
