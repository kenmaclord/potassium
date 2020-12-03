<?php

namespace App\Strategies\Naming;

use App\Traits\FileManipulation;

class NamingStrategy
{
    use FileManipulation;

    public $file;
    public $modele;

    public function __construct($file=null, $modele=null){
        $this->file = $file;
        $this->modele = $modele;
    }

    /**
     * [imgPath description]
     *
     * @return  [type]  [description]
     */
    public function resourcesPath()
    {
        if(config('filesystems.data_directory')){
            return config('filesystems.data_directory');
        }

        return '/data';
    }


    /**
    * Strategie de nommage de l'image des variantes
    *
    * @return  String
    */
    public function sizeName($size)
    {
        $name = $this->bakeName($this->file, [
            "suffix"   => $size,
            "pattern"  => "name.suffix"
        ]);

        return $name;
    }

    /**
     * Renomme le fichier
     *
     * @return  void
     */
    public function rename(){
        $newName = $this->path()."/".$this->name();

        Storage::move($this->modele->url, $newName);

        return $newName;
    }
}
