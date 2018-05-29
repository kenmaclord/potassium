<?php
namespace App\Console\Commands;

use Dotenv\Dotenv;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Potassium\Preset\PotassiumPreset;

class Prepare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'potassium:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Prepare l'environnement pour un nouveau projet";

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
        $this->info('Paquets PHP installés');

        $application = $this->ask("Quel est le nom de l'application ?");
        $url = $this->ask("Quel est l'url de l'application ? (http://domaine.com:port)");
        $database = $this->ask("Quel est le nom de la base de données à créer ?");

        shell_exec('cp .env.example .env');
        (new Dotenv(base_path()))->load(app()->environmentPath(), app()->environmentFile());

        shell_exec('/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot --execute="create database ' .$database.';"');
        $this->info('Base de données générée');

        $this->setEnvironmentValue('APP_NAME', $application);
        $this->setEnvironmentValue('APP_URL', $url);

        $this->setEnvironmentValue('DB_SOCKET', '/Applications/MAMP/tmp/mysql/mysql.sock');
        $this->setEnvironmentValue('DB_DATABASE', $database);
        $this->setEnvironmentValue('DB_USERNAME', 'root');
        $this->setEnvironmentValue('DB_PASSWORD', 'root');

        $this->setEnvironmentValue('MAIL_HOST', 'smtp.mailtrap.io');
        $this->setEnvironmentValue('MAIL_PORT', '2525');
        $this->setEnvironmentValue('MAIL_USERNAME', 'b17cc32811a9cb');
        $this->setEnvironmentValue('MAIL_PASSWORD', '5c66a0d83de453');

        $this->info("Fichier d'environnement prêt");
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
