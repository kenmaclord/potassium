<?php

namespace Potassium;

use Dotenv\Dotenv;
use Illuminate\Foundation\Console\Presets\Preset;

class PotassiumPreset extends Preset
{
    protected static $command;

    public static function prepare($command)
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

        $command->info("Fichier d'environnement prêt");

        // Git
        shell_exec('git init');
        $command->info('Git initialisé');

        // Base de données
        shell_exec('/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot --execute="create database ' .$database.' character set UTF8mb4 collate utf8mb4_unicode_ci;"');
        $command->info("Base de données créee");

        // static::setAppFolder();
        // static::setProviders();
        // static::setTests();
        // static::updateComposer($command);
    }









    public static function install($command)
    {
        if (file_exists($userModel = base_path('app/User.php'))) {
            unlink($userModel);
        }

        static::updateComposer($command);
        static::setDatabase($command);
        static::updatePackages();

        // shell_exec("composer dump-autoload");

        // static::updateMix();
        // static::setAssets();
        // static::setStrategies();
        // static::setConfigFiles();
        // static::setFonts();
        // static::setViews();
        // static::setLangFile();
        // static::setRoutes();
        // static::setData();
        // static::setKernel();
        // static::setControllers();
        // static::setCommands();
   }


    public static function updatePackageArray()
    {
        return [
            "axios" => "^0.19.*",
            "bulma" => "^0.8.*",
            "laravel-mix" => "^5.*",
            "mix-tailwindcss" => "^1.*",
            "lodash" => "^4.*",
            "moment" => "^2.*",
            "dropzone" => "^5.*",
            "promise-polyfill" => "8.*",
            "sortablejs" => "^1.*",
            "tailwindcss" => "^1.*",
            "velocity-animate" => "^1.*",
            "vue" => "^2.*"
        ];
    }


    public static function updateComposer($command)
    {
        // static::copyFile('', 'composer.json', base_path());
        shell_exec("composer update");
        $command->info('Packages Composer à jour');
    }


    // public static function updateMix()
    // {
    //     static::copyFile('', 'webpack.mix.js', base_path());
    // }


    // public static function setAssets()
    // {
    //     static::copyDirectory('assets/js', 'resources');
    //     static::copyDirectory('assets/sass', 'resources');
    // }

    // public static function setCommands()
    // {
    //     $files = [
    //         "NewPageCommand.php",
    //         "NamingStrategyCommand.php",
    //         "PublishabilityStrategyCommand.php",
    //         "UploadStrategyCommand.php"
    //     ];

    //     foreach ($files as $file) {
    //         static::copyFile("commands", $file, base_path('app/Console/Commands'));
    //     }
    // }


    // public static function setStrategies()
    // {
    //     static::copyDirectory('Strategies', 'app');
    // }

    // public static function setAppFolder()
    // {
    //     $folders = [
    //         "Entities",
    //         "Events",
    //         "Helpers",
    //         "Listeners",
    //         "Notifications",
    //         "Observers",
    //         "Policies",
    //         "Traits"
    //     ];

    //     foreach ($folders as $f) {
    //         static::copyDirectory("App/{$f}", 'app');
    //     }

    //     if (file_exists($userModel = base_path('app/User.php'))) {
    //         unlink($userModel);
    //     }
    // }

    // public static function setConfigFiles()
    // {
    //     static::copyFile('config', 'app.php', base_path('config'));
    //     static::copyFile('config', 'image.php', base_path('config'));
    //     static::copyFile('config', 'laravellocalization.php', base_path('config'));
    //     static::copyFile('config', 'auth.php', base_path('config'));
    //     static::copyFile('config', 'filesystems.php', base_path('config'));
    // }

    public static function setDatabase($command)
    {
        // static::copyDirectory('database');

        \Artisan::call('migrate');

        $command->info('Base de donnée prête');
    }


    // public static function setFonts()
    // {
    //     static::copyDirectory('fonts', 'public');
    // }


    // public static function setProviders()
    // {
    //     static::copyFile('Providers', 'AppServiceProvider.php', base_path('app/Providers'));
    //     static::copyFile('Providers', 'AuthServiceProvider.php', base_path('app/Providers'));
    //     static::copyFile('Providers', 'ConfigServiceProvider.php', base_path('app/Providers'));
    //     static::copyFile('Providers', 'EventServiceProvider.php', base_path('app/Providers'));
    // }

    // public static function setViews()
    // {
    //     static::copyDirectory('views', 'resources');
    // }

    // public static function setLangFile()
    // {
    //     static::copyFile('lang/fr', 'application.php', resource_path('lang/fr'));
    //     static::copyFile('lang/fr', 'auth.php', resource_path('lang/fr'));
    //     static::copyFile('lang/fr', 'pagination.php', resource_path('lang/fr'));
    //     static::copyFile('lang/fr', 'passwords.php', resource_path('lang/fr'));
    //     static::copyFile('lang/fr', 'validation.php', resource_path('lang/fr'));

    //     static::copyFile('lang/en', 'application.php', resource_path('lang/en'));
    // }

    // public static function setRoutes()
    // {
    //     static::copyFile('', 'web.php', base_path('routes'));
    //     static::copyFile('', 'api.php', base_path('routes'));
    // }


    // public static function setData()
    // {
    //     static::copyDirectory('data', 'public');
    // }


    // public static function setTests()
    // {
    //     static::copyFile('', 'phpunit.xml', base_path());
    //     static::copyDirectory('tests', '');
    // }


    // public static function setKernel()
    // {
    //     static::copyFile('', 'Kernel.php', base_path('app/Http'));
    // }

    // public static function setControllers()
    // {
    //     static::copyDirectory('Controllers/Admin', 'app/Http/Controllers');
    //     static::copyDirectory('Controllers/Front', 'app/Http/Controllers');
    //     static::copyFile('Controllers', 'Controller.php', base_path('app/Http/Controllers'));
    //     static::copyFile('Controllers/Auth', 'LoginController.php', base_path('app/Http/Controllers/Auth'));
    //     static::copyFile('Controllers/Auth', 'RegisterController.php', base_path('app/Http/Controllers/Auth'));
    //     static::copyFile('Controllers/Auth', 'ResetPasswordController.php', base_path('app/Http/Controllers/Auth'));
    //     static::copyFile('Controllers/Auth', 'VerificationController.php', base_path('app/Http/Controllers/Auth'));
    // }

    /**
     * En cas d'un ajout d'admin à posteriori
     *
     * @return  [type]  [description]
     */
    // public static function folders($command)
    // {
    //     static::setAppFolder();
    //     static::setProviders();
    //     static::setTests();
    //     static::updateComposer($command);
    // }

    public static function assets($command)
    {
        // Nodes modules
        shell_exec('npm install');
        $command->info('Paquets Node installés');

        // Tailwind
        $str = "En attente de tailwind...";

        while(!file_exists("./node_modules/.bin/tailwind")){
            $str.=".";
            $command->info($str);
            sleep(1);
        }

        shell_exec('./node_modules/.bin/tailwind init');
        $command->info('Tailwind initialisé');

        // Compilation des assets
        // shell_exec('npm run dev');
        // $command->info('Assets compilés');
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


    /**
     * Copie un fichier d'un répertorie à un autre en vérifiant que le répertoire de destination existe
     *
     * @param   String  $file
     * @param   String  $destFolder
     * @param   String  $newName
     *
     * @return  Void
     */
    // public static function copyFile($srcFolder, $file, $destFolder, $newName=null)
    // {
    //     $baseFolder = __DIR__."/stubs/{$srcFolder}";

    //     if (!file_exists($destFolder)) {
    //         mkdir($destFolder);
    //     }

    //     $newName = $newName ?: $file;

    //     copy("{$baseFolder}/{$file}", "{$destFolder}/{$newName}");
    // }


    /**
     * Copie un dossier entier depuis le dossiers stubs
     *
     * @param   String  $folder
     * @param   String  $destination
     *
     * @return  Void
     */
    // private static function copyDirectory($folder, $destination='')
    // {
    //     $src = __DIR__."/stubs/{$folder}";
    //     $dest = base_path($destination);

    //     return shell_exec("cp -r $src $dest");
    // }
}
