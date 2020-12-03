<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Traits\ClassUtilities;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

trait Uploadable
{
	use ClassUtilities;

	/**
	* Récupère le fichier depuis la Request
	*
	* @see Illuminate\Http\Request
	* @see App\Exceptions\UploadException
	* @see Symfony\Component\HttpFoundation\File\UploadedFile
	*
	* @param Request $request       : Request
	* @param String  $fileInputName : Nom du champ file du formulaire
	*
	* @return UploadedFile | UploadException
	**/
	public function getFile($fileInputName='file')
	{
		$files = request()->file($fileInputName);

		if(!is_array($files)){
			$files = [$files];
		}

		foreach ($files as $f) {
			if(!$f instanceof UploadedFile){
				throw new UploadException("Le fichier n'est pas valide.", ResponseCode::HTTP_UNSUPPORTED_MEDIA_TYPE);
			}
		}

		return $files;
	}


	/**
	 * Lance le processus d'upload et de traitement de l'image
	 *
	 * @param   [type]  $class
	 * @param   [type]  $modele
	 *
	 * @return  [type]           [description]
	 */
	public function upload($class, $modele=null, $processing=true)
	{
		$uploadClass = $this->getStrategyClassName($class, "upload");

		if (!class_exists($uploadClass)) {
			$uploadClass = $this->getStrategyClassName(null, "upload");
		}

        $originalFile = (new $uploadClass)->run($class, $modele);

		if ($processing) {
			$processingClass = $this->getStrategyClassName($class, "processing");

			if (!class_exists($processingClass)) {
				$processingClass = $this->getStrategyClassName(null, "processing");
			}

        	$file = (new $processingClass($class, $originalFile, $modele))->process();

			$class::create(['url'=>$file['folder']]);

			return $file;
		}

		$class::create(['url'=>$originalFile]);

		return $originalFile;
	}


	/**
	* Fonction générique d'upload
	*
	* @see App\Exceptions\UploadException
	* @see Symfony\Component\HttpFoundation\File\UploadedFile
	*
	* @param UploadedFile 	$file 				: Fichier reçu de la Request
	* @param String 		$leafPath			: Dossier terminal de l'upload
	* @param String 		$newName (optional) : Nom du fichier uploadé
	*
	* @return String | UploadException
	**/
	private function uploadFile($file, $name=null, $path=null)
	{
		if($file->isValid()) {
			$this->checkMimes($file);
			$this->checkMaxSize($file);

			try{
				return Storage::disk('public')->putFileAs($path, $file, $name);
			}
			catch(FileException $e){
				throw new UploadException("Erreur lors du déplacement du fichier",ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
			}
		}
	}

	/**
	* Vérifie que le mimeType du fichier correspond aux mimeTypes de la stratégie
	*
	* @see App\Exceptions\UploadException
	* @see Symfony\Component\HttpFoundation\File\UploadedFile
	*
	* @param UploadedFile $file : Fichier reçu de la Request
	*
	* @return void | UploadException
	**/
	public function checkMimes($file)
	{
		$mimeTypesAllowed = [
			"jpg" => "image/jpeg",
			"png" => "image/png",
			"gif" => "image/gif"
		];

		$extensions = "jpg, png, gif";

		if (!empty($this->mimeTypesAllowed)){
			$mimeTypesAllowed = array_values($this->mimeTypesAllowed);
			$extensions = implode(', ', array_keys($this->mimeTypesAllowed));
		}

		if(!in_array($file->getClientMimeType(), $mimeTypesAllowed)) {
			throw new UploadException("Ce type de fichier n'est pas autorisé. {$extensions} seulement.", ResponseCode::HTTP_UNSUPPORTED_MEDIA_TYPE);
		}
	}


	/**
	* Attribue le nom de fichier à son nom original si aucun nom n'est passé
	*
	* @see Symfony\Component\HttpFoundation\File\UploadedFile
	*
	* @param UploadedFile $file : Fichier reçu de la Request
	* @param String 			$name : Nom du fichier uploadé
	*
	* @return String
	**/
	public function check_if_has_name($file, $name=null)
	{
		if($name==null){
			return $file->getClientOriginalName();
		}

		return $name;
	}


	/**
	* Vérifie que la taille du fichier ne dépasse pas le maximum autorisé
	*
	* @see App\Exceptions\UploadException
	* @see Symfony\Component\HttpFoundation\File\UploadedFile
	*
	* @param UploadedFile $file : Fichier reçu de la Request
	*
	* @return String | UploadException
	**/
	public function checkMaxSize($file)
	{
		if($file->getMaxFilesize() - $file->getClientSize() < 0){
			throw new UploadException("La taille du fichier est trop grande.", ResponseCode::HTTP_REQUEST_ENTITY_TOO_LARGE);
		}
	}
}
