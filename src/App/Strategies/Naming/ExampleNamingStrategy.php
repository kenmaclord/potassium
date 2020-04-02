<?php

namespace Potassium\App\Strategies\Naming;

use Illuminate\Support\Facades\Storage;
use Potassium\App\Strategies\Naming\NamingStrategy;
use Potassium\App\Strategies\Naming\NamingStrategyInterface;

class NewsPhotoNamingStrategy extends NamingStrategy implements NamingStrategyInterface
{
	public $file;
	public $modele;

	public function __construct($file, $modele){
		$this->file = $file;
		$this->modele = $modele;
	}


	/**
	 * Strategie de nommage de l'image de finition
	 *
	 * @return  String
	 */
	public function name()
	{
		$name = $this->bakeName($this->file, [
			"prefix"       => "",
			"suffix"       => "",
			"pattern"      => "prefix.suffix.random"
		]);

		return $name;
	}


	/**
	 * Génère le chemin d'enregistrement de la news
	 *
	 * @return  String
	 */
	public function path()
	{
		return "{$this->resourcesPath()}"
	}


	/**
	 * Renomme le fichier de finition
	 *
	 * @return  void
	 */
	public function rename(){
        $newName = $this->path()."/".$this->name();

        Storage::move($this->modele->url, $newName);

        return $newName;
	}
}
