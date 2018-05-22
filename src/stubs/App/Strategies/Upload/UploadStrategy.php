<?php

namespace App\Strategies\Upload;

use App\Traits\Uploadable;
use App\Traits\ClassUtilities;

class UploadStrategy
{
    use ClassUtilities, Uploadable;

    public $mimeTypesAllowed = [
      "jpg" => "image/jpeg",
      "jpeg" => "image/jpeg",
      "png" => "image/png",
    ];


    /**
     * Traite le ou les fichiers uploadés
     *
     * @return void
     */
    public function run($modele=null)
    {
      $file = $this->getFile()[0];

      $namingStrategyClass = $this->getNamingStrategyClassName('Upload');

      $namingStrategy = new $namingStrategyClass($file, $modele);

      return $this->add($file, $namingStrategy, $modele);
    }


    /**
    * Stratégie d'upload d'un fichier
    *
    * @param  Illuminate\Http\UploadedFile    $file
    * @param                                  $namingStrategy
    * @param                                  $modele
    *
    * @return  String
    */
    public function add($file, $namingStrategy, $modele)
    {
      $path = $namingStrategy->path();
      $name = $namingStrategy->name();

      $this->upload($file, $name, $path);

      return "{$path}/{$name}";
    }
}
