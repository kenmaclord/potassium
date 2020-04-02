<?php

namespace Potassium\App\Strategies\Naming;

use Potassium\App\Traits\FileManipulation;

class NamingStrategy
{
    use FileManipulation;


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
}
