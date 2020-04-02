<?php

namespace Potassium\App\Traits;

use Illuminate\Support\Facades\Storage;
use Potassium\App\Exceptions\FileManipulationException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

trait FileManipulation
{

	/**
	* Fonctions permettant de renommer un fichier
	*
	* @param  Illuminate\Http\UploadedFile | String 		$file    : Fichier reçu de la Request
	* @param  Array											$options : tableau des options
	*
	*		Options disponibles :
	*	 		prefix
  	*			suffix
  	*	    	slugify
 	*      		randomLength
  	*			separator
	*			pattern
	*
	* @return String
	**/
	public function bakeName($file,$options=[])
	{
		// Définition des options par défaut
		$settings = [
			"prefix"       => "",
			"suffix"       => "",
			"slugify"      => true,
			"randomLength" => 8,
			"separator"    => '_',
			"pattern"      => "name.random"
		];

		// Fusion des paramètres
		$options = (object)array_merge($settings,$options);


		// Préconstruit les éléments du nom de fichier
		$name["prefix"] = $options->prefix;
		$name["suffix"] = $options->suffix;
		$name["random"] = $this->random($options->randomLength);
		$name["name"] = $this->getName($file);

		/**
		*  Construit un tableau avec les élements du nom de fichier en fonction
		*  du pattern passé en paramètre
		**/
		$newName = [];
		$pattern = explode(".",$options->pattern);

		foreach($pattern as $element){
			$newName[] = $name[$element];
		}

		/** Constuit la chaine de caractères du nom de fichier à partir du tableau **/
		$newName = implode($options->separator, $newName);

		/** Slugifie le nom de fichier si l'option est demandée **/
		if($options->slugify){
			$newName = str_slug($newName);
		}

		// Ajoute l'extension
		if(is_string($file)){
			$newName .= ".".strtolower(pathinfo($file,PATHINFO_EXTENSION));
		}else{
			$newName .= ".".strtolower($file->getClientOriginalExtension());
		}

		return $newName;
	}


	/**
	 * Retourne le nom du fichier seul
	 *
	 * @param   String | Illuminate\Http\UploadedFile  $file
	 *
	 * @return  String
	 */
	public function getName($file)
	{
		if(is_string($file)){
			return pathinfo($file,PATHINFO_FILENAME);
		}

		return pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
	}

	/**
	* Fonctions permettant de renommer un fichier.
	* Cette fonction suppose que le fichier reste dans le même répertoire
	*
	* @param File $file : Fichier à renommer
	* @param String $newname : nouveau nom du fichier.
	*
	* @return String
	**/
	// public function rename($file, $newname)
	// {
	// 	$path = pathinfo($file, PATHINFO_DIRNAME);
	// 	Storage::move($file, $path.'/'.$newname);

	// 	return $path.'/'.$newname;
	// }


	/**
	*	Génération d'une chaîne de caractère aléatoire 	d'une longueur de $car caractères
	*
	*	@param Integer $car : longueur de la chaîne à générer
	*
	* @return String
	**/
	private function random($car){
		$string = "";
		$usableCharacters = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXY0123456789";

		/* Initialise le compteur aléatoire de PHP */
		srand((double)microtime()*1000000);

		/* Construit la chaine aléatoire */
		for($i=0; $i<$car; $i++){
			$string .= $usableCharacters[rand()%strlen($usableCharacters)];
		}

		return $string;
	}


	/**
	*	Génération du chemin d'un fichier
	*
	*	@param string $file      :  fichier réél
	*	@param string $folder    :  chemin du fichier
	*	@param boolean $relative :  Indique si $folder est un chemin relatif ou absolu par rapport au fichier passé
	*
	* @return String
	**/
	private function makePath($file, $folder=null, $relative=true){

		if(is_null($folder))
		{
			return $file;
		}
		else
		{
			$fileInfos = pathinfo($file);

			if($relative){
				$folder = sprintf("%s/%s",$fileInfos['dirname'], $folder);
			}

			/* Créé le dossier s'il n'existe pas */
			if(!file_exists($folder) || !is_dir($folder)){
				if(!mkdir($folder)){
    			throw new FileManipulationException("Le répertoire de destination n'a pas pu être créé",ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
				}
			}

			return sprintf("%s/%s",$folder,$fileInfos['basename']);
  	}
	}


	/**
	*	Téléchargement d'un fichier
	*
	*	@param string $file :  nom du fichier à télécharger
	*
	* @return String
	**/
	private function download($file, $mime="application/octet-stream")
	{
		// return response()->download($fichier);
		$fichier=public_path($file);

		if(\File::exists($fichier)){
			$basename = basename($fichier);
			$filesize = filesize($fichier);

	  	header('Accept:'.$mime);
	  	header('Content-Type:'.$mime);
	  	// header("Content-Transfer-Encoding: Binary");
	    header('Content-Length:'.$filesize);
	    header('Content-Disposition:attachment; filename='.$basename);

	    header('Pragma: no-cache');
	    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	    header('Expires: 0');
	    readfile($fichier);
		}else{
			abort(404);
		}
	}

}

?>
