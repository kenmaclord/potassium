<?php

namespace Potassium\\Preset;

use Illuminate\Foundation\Console\Presets\Preset;

class PotassiumPreset extends Preset
{
    public static function install()
    {
        static::updateComposer();
        static::updatePackages();
        static::updateMix();
        static::setAssets();
        static::setCommands();
        static::setCommandStubs();
        static::setStrategies();
        static::setAppFolder();
        static::setConfigFiles();
        static::setDatabase();
        static::setFonts();
        static::setProviders();
        static::setViews();
        static::setLangFile();
        static::setRoutes();
        static::setData();
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
        copy(__DIR__.'/stubs/composer.json', base_path('composer.json'));
    }


    public static function updateMix()
    {
        copy(__DIR__.'/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }


    public static function setAssets()
    {
        static::copyDirectory('assets', 'resources');
    }

    public static function setCommands()
    {
        copy(__DIR__.'/stubs/commands/Install.php', base_path('app/Console/Commands/Install.php'));
        copy(__DIR__.'/stubs/commands/NamingStrategyCommand.php', base_path('app/Console/Commands/NamingStrategyCommand.php'));
        copy(__DIR__.'/stubs/commands/Prepare.php', base_path('app/Console/Commands/Prepare.php'));
        copy(__DIR__.'/stubs/commands/PublishabilityStrategyCommand.php', base_path('app/Console/Commands/PublishabilityStrategyCommand.php'));
        copy(__DIR__.'/stubs/commands/UploadStrategyCommand.php', base_path('app/Console/Commands/UploadStrategyCommand.php'));
    }


    public static function setStrategies()
    {
        static::copyDirectory('Strategies', 'app');
    }


    public static function setCommandStubs()
    {
        if (!file_exists(resource_path('stubs'))) {
            mkdir(resource_path('stubs'));
        }

        copy(__DIR__.'/stubs/commandStubs/naming.stub', resource_path('stubs/naming.stub'));
        copy(__DIR__.'/stubs/commandStubs/publishable.stub', resource_path('stubs/publishable.stub'));
        copy(__DIR__.'/stubs/commandStubs/uploadable.stub', resource_path('stubs/uploadable.stub'));
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
        copy(__DIR__.'/stubs/laravellocalization.php', resource_path('stubs/laravellocalization.php'));
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
        copy(__DIR__.'/stubs/Providers/AppServiceProvider.php', base_path('app/Providers/AppServiceProvider.php'));
        copy(__DIR__.'/stubs/Providers/AuthServiceProvider.php', base_path('app/Providers/AuthServiceProvider.php'));
        copy(__DIR__.'/stubs/Providers/ConfigServiceProvider.php', base_path('app/Providers/ConfigServiceProvider.php'));
        copy(__DIR__.'/stubs/Providers/EventServiceProvider.php', base_path('app/Providers/EventServiceProvider.php'));
    }

    public static function setViews()
    {
        static::copyDirectory('views', 'resources');
    }

    public static function setLangFile()
    {
        copy(__DIR__.'/stubs/lang/fr/application.php', resource_path('lang/fr/application.php'));
        copy(__DIR__.'/stubs/lang/en/application.php', resource_path('lang/en/application.php'));
    }

    public static function setRoutes()
    {
        copy(__DIR__.'/stubs/web.php', base_path('routes/web.php'));
    }


    public static function setData()
    {
        static::copyDirectory('data', 'public');
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
}
