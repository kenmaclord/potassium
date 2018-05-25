<?php

namespace Potassium\Preset;

use Illuminate\Foundation\Console\Presets\Preset;

class PotassiumPreset extends Preset
{
    public static function install()
    {
        static::setAppFolder();
        static::setTestUtilities();
        static::updateComposer();
        static::updatePackages();
        static::updateMix();
        static::setAssets();
        static::setCommandStubs();
        static::setStrategies();
        static::setConfigFiles();
        static::setFonts();
        static::setProviders();
        static::setViews();
        static::setLangFile();
        static::setRoutes();
        static::setData();
        static::setKernel();
        static::setControllers();
    }


    public static function updatePackageArray()
    {
        return [
            "axios" => "^0.18",
            "cross-env" => "^5.1",
            "laravel-mix" => "^2.0",
            "lodash" => "^4.17.10",
            "bulma" => "^0.7.1",
            "moment" => "^2.22.1",
            "sortablejs" => "^1.7.0",
            "velocity-animate" => "^1.5.1",
            "vue" => "^2.5.16",
            "laravel-mix-tailwind" => "^0.1.0"
        ];
    }


    public static function updateComposer()
    {
        static::copyFile('', 'composer.json', base_path());
        shell_exec("~/composer.phar update");
        //copy(__DIR__.'/stubs/composer.json', base_path('composer.json'));
    }


    public static function updateMix()
    {
        static::copyFile('', 'webpack.mix.js', base_path());
        //copy(__DIR__.'/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }


    public static function setAssets()
    {
        static::copyDirectory('assets', 'resources');
    }

    public static function setCommands()
    {
        $files = [
            "Install.php",
            "NamingStrategyCommand.php",
            "Prepare.php",
            "PublishabilityStrategyCommand.php",
            "UploadStrategyCommand.php"
        ];

        // static::copyFile('commands/Install.php', base_path('app/Console/Commands'));
        // static::copyFile('commands/NamingStrategyCommand.php', base_path('app/Console/Commands'));
        // static::copyFile('commands/Prepare.php', base_path('app/Console/Commands'));
        // static::copyFile('commands/PublishabilityStrategyCommand.php', base_path('app/Console/Commands'));
        // static::copyFile('commands/UploadStrategyCommand.php', base_path('app/Console/Commands'));

        foreach ($files as $file) {
            static::copyFile("commands", $file, base_path('app/Console/Commands'));
        }



        // copy(__DIR__.'/stubs/commands/Install.php', base_path('app/Console/Commands/Install.php'));
        // copy(__DIR__.'/stubs/commands/NamingStrategyCommand.php', base_path('app/Console/Commands/NamingStrategyCommand.php'));
        // copy(__DIR__.'/stubs/commands/Prepare.php', base_path('app/Console/Commands/Prepare.php'));
        // copy(__DIR__.'/stubs/commands/PublishabilityStrategyCommand.php', base_path('app/Console/Commands/PublishabilityStrategyCommand.php'));
        // copy(__DIR__.'/stubs/commands/UploadStrategyCommand.php', base_path('app/Console/Commands/UploadStrategyCommand.php'));
    }


    public static function setStrategies()
    {
        static::copyDirectory('Strategies', 'app');
    }


    public static function setCommandStubs()
    {
        // if (!file_exists(resource_path('stubs'))) {
        //     mkdir(resource_path('stubs'));
        // }

        static::copyFile('commandStubs', 'naming.stub', resource_path('stubs'));
        static::copyFile('commandStubs', 'publishable.stub', resource_path('stubs'));
        static::copyFile('commandStubs', 'uploadable.stub', resource_path('stubs'));

        // copy(__DIR__.'/stubs/commandStubs/naming.stub', resource_path('stubs/naming.stub'));
        // copy(__DIR__.'/stubs/commandStubs/publishable.stub', resource_path('stubs/publishable.stub'));
        // copy(__DIR__.'/stubs/commandStubs/uploadable.stub', resource_path('stubs/uploadable.stub'));
    }


    public static function setAppFolder()
    {
        $folders = [
            "Entities",
            "Events",
            "Helpers",
            "Listeners",
            "Notifications",
            "Observers",
            "Policies",
            "Traits"
        ];

        foreach ($folders as $f) {
            static::copyDirectory("App/{$f}", 'app');
        }
    }

    public static function setConfigFiles()
    {
        static::copyFile('config', 'laravellocalization.php', base_path('config'));
        static::copyFile('config', 'app.php', base_path('config'));
        // copy(__DIR__.'/stubs/laravellocalization.php', resource_path('stubs/laravellocalization.php'));
    }

    public static function setDatabase()
    {
        static::copyDirectory('database');
    }


    public static function setFonts()
    {
        static::copyDirectory('fonts', 'public');
    }


    public static function setProviders()
    {
        static::copyFile('Providers', 'AppServiceProvider.php', base_path('app/Providers'));
        static::copyFile('Providers', 'AuthServiceProvider.php', base_path('app/Providers'));
        static::copyFile('Providers', 'ConfigServiceProvider.php', base_path('app/Providers'));
        static::copyFile('Providers', 'EventServiceProvider.php', base_path('app/Providers'));
        // copy(__DIR__.'/stubs/Providers/AppServiceProvider.php', base_path('app/Providers/AppServiceProvider.php'));
        // copy(__DIR__.'/stubs/Providers/AuthServiceProvider.php', base_path('app/Providers/AuthServiceProvider.php'));
        // copy(__DIR__.'/stubs/Providers/ConfigServiceProvider.php', base_path('app/Providers/ConfigServiceProvider.php'));
        // copy(__DIR__.'/stubs/Providers/EventServiceProvider.php', base_path('app/Providers/EventServiceProvider.php'));
    }

    public static function setViews()
    {
        static::copyDirectory('views', 'resources');
    }

    public static function setLangFile()
    {
        static::copyFile('lang/fr', 'application.php', resource_path('lang/fr'));
        static::copyFile('lang/en', 'application.php', resource_path('lang/en'));
        // copy(__DIR__.'/stubs/lang/fr/application.php', resource_path('lang/fr/application.php'));
        // copy(__DIR__.'/stubs/lang/en/application.php', resource_path('lang/en/application.php'));
    }

    public static function setRoutes()
    {
        static::copyFile('', 'web.php', base_path('routes'));
        // copy(__DIR__.'/stubs/web.php', base_path('routes/web.php'));
    }


    public static function setData()
    {
        static::copyDirectory('data', 'public');
    }


    public static function setTestUtilities()
    {
        static::copyDirectory('tests', '');
    }


    public static function setKernel()
    {
        static::copyFile('', 'Kernel.php', base_path('app/Http'));
    }

    public static function setControllers()
    {
        static::copyDirectory('Controllers/Admin', 'app/Http');
        static::copyDirectory('Controllers/Front', 'app/Http');
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
    public static function copyFile($srcFolder, $file, $destFolder, $newName=null)
    {
        $baseFolder = __DIR__."/stubs/{$srcFolder}";

        if (!file_exists($destFolder)) {
            mkdir($destFolder);
        }

        $newName = $newName ?: $file;

        copy("{$baseFolder}/{$file}", "{$destFolder}/{$newName}");
    }


    /**
     * Copie un dossier entier depuis le dossiers stubs
     *
     * @param   String  $folder
     * @param   String  $destination
     *
     * @return  Void
     */
    private static function copyDirectory($folder, $destination='')
    {
        $src = __DIR__."/stubs/{$folder}";
        $dest = base_path($destination);

        shell_exec("cp -r $src $dest");
    }

    /**
     * Insère ou modifie une valeur dans le fichier d'environnement
     *
     * @param  String  $envKey
     * @param  String  $envValue
     */
    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();

        $str = file_get_contents($envFile);

        $split = explode("{$envKey}=", $str);

        if(count($split) > 1){
            $oldValue = $this->getEnv($envKey, $str);
            $str = str_replace("{$envKey}={$oldValue}\n", "{$envKey}={$envValue}\n", $str);
        }else{
            $pass = $this->getEnv('DB_PASSWORD', $str);
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
    public function getEnv($key, $str)
    {
        return explode("\n", (explode("{$key}=", $str))[1])[0];
    }
}
