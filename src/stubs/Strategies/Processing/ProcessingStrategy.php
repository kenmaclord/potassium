<?php

namespace App\Strategies\Processing;

use Entities\Home;
use App\Traits\ClassUtilities;
use App\Traits\ImageTreatment;
use Illuminate\Support\Facades\Storage;

class ProcessingStrategy
{
	use ClassUtilities;

	protected $originalFile;
	protected $img;
	protected $sizes;

	/**
	 * Constructeur
	 *
	 * @param  Entity  $class
	 * @param  String  $uploadedFile
	 * @param  Illuminate\Database\Eloquent\Model  $entity  $entity
	 */
	function __construct($class, $uploadedFile, $entity=null){
		$this->namingClassName = $this->getStrategyClassName($class, 'naming');
		$this->naming = new $this->namingClassName($uploadedFile, $entity);

		$this->originalFile = $uploadedFile;

		$this->img = new ImageTreatment(Storage::disk('public')->url($this->originalFile));

		$this->sizes = $this->sizes ?? config('image.sizes');
	}


	/**
	 * Construit le chemin serveur de l'image
	 *
	 * @param   String  $file
	 *
	 * @return  String
	 */
	public function serverUrlOf($file)
	{
		return Storage::disk('public')->url($this->naming->path().'/'.$file);
	}

	/**
	 * Traite les images uploadées
	 *
	 * @param   Array   $files
	 *
	 * @return  void
	 */
	public function process()
	{
		$fileInfos = $this->makeSizes();

		Storage::disk('public')->delete($this->originalFile);

		return $fileInfos;
	}

	/**
	* Strategie de traitement des tailles du fichier
	*
	* @param  Illuminate\Http\UploadedFile      $file
	* @param  String                            $folder
	*/
	public function makeSizes()
	{
		$sizesRootFolder = pathinfo($this->originalFile, PATHINFO_FILENAME);

		Storage::disk('public')->makeDirectory($this->naming->path().'/'.$sizesRootFolder);

		$filenames = [];
		foreach ($this->sizes as $sizeName => $value) {
			$img = new ImageTreatment(Storage::disk('public')->url($this->originalFile));

			$img->resize([
				"pixels"             => $value,
				"keepRatioDimension" => "largest"
			]);

			$sizeFilename = $this->naming->sizeName($sizeName);

			$img->saveTo($this->serverUrlOf("{$sizesRootFolder}/{$sizeFilename}"));

			$filenames[] = $sizeFilename;
		}

		return [
			"originalFile" => $this->originalFile,
			"folder" => $sizesRootFolder,
			"filenames" => $filenames
		];
	}
}
