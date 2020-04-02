<?php

namespace Potassium\App\Strategies\Upload;

use Potassium\App\Traits\Uploadable;

class UploadStrategy
{
    use Uploadable;

    /**
     * Liste des extensions et mimetypes autorisés
     *
     * @var  Array
     */
    public $mimeTypesAllowed = [
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png",
        "pdf" => "application/pdf",
        "png" => "image/png",
        "zip" => "application/zip",
        "obj" => "text/plain",
        "dwg" => "application/octet-stream",
        "skp" => "application/octet-stream",
        "dxf" => "application/octet-stream"
    ];


    /**
     * Traite le ou les fichiers uploadés
     *
     * @return void
     */
    public function run($class, $modele=null)
    {
      $file = $this->getFile()[0];

      $namingStrategyClass = $this->getStrategyClassName($class, 'naming');

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

      $this->uploadFile($file, $name, $path);

      return "{$path}/{$name}";
    }
}
