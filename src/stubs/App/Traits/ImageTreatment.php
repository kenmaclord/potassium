<?php

namespace App\Traits;

use App\Traits\ImageUtilities;
use App\Traits\FileManipulation;
use Intervention\Image\Facades\Image;
use App\Exceptions\ImageTreatmentException;
use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ImageTreatment
{
	use ImageUtilities, FileManipulation;

	public $file;

	function __construct($file){
		$this->file = Image::make($file);
	}

	/**
	*--------------------------------------------------------------------------
	* Fonction de redimensionnement des images
	*--------------------------------------------------------------------------
	*
	* @param : Array $options (optional) : Options de redimensionnement.
	*
	*	Options disponibles :
	*		width
	*		height
	*		keepRatio
	*		keepRatioDimension : ['width', 'height', 'largest']
	*
	* @return String
	*/
	public function resize($options=[])
	{
		// Définition des options par défaut
		$settings = [
			"width"              => 600,
			"height"             => 400,
			"pixels"             => 400,
			"keepRatio"          => true,
			"keepRatioDimension" => "width"
		];

		// Fusion des paramètres
		$options = (object)array_merge($settings,$options);

		// Obtient les bonnes dimensions en fonction des options
		$dimensions = $this->makeDimensions($this->file, $options);

		try
		{
			return $this->file->resize($dimensions->width, $dimensions->height, function ($constraint) { $constraint->aspectRatio();});
		}
		catch(InvalidArgumentException $e)
		{
            throw new ImageTreatmentException("Erreur lors du redimensionnement de l'image : ".$e->getMessage());
		}
	}


	/**
	*--------------------------------------------------------------------------
	* Fonction pour cropper une image
	*--------------------------------------------------------------------------
	*
	* @param : Array $options (optional) : Options de redimensionnement.
	*
	*	Options disponibles :
	*		width
	*		height
	*		originX
	*		originY
	*
	* @return String
	*/
	public function crop($options=[])
	{
		// Définition des options par défaut
		$settings = [
			"width"   => 300,
			"height"  => 300,
			"originX" => 0,
			"originY" => 0
		];

		// Fusion des paramètres
		$options = (object)array_merge($settings,$options);

		// Crop de l'image
		try{
			return $this->file->crop($options->width, $options->height,$options->originX, $options->originY);
		} catch(Exception $e){
			throw new ImageTreatmentException("Erreur lors du crop de l'image",ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
		}
	}


	/**
	* Permet de générer une image avec un ratio défini de la taille voulue
	* (taille de la plus grande dimension) en coupant l'image source
	*
	* @param Float $ratio    : Ratio de l'image à générer
	* @param Integer $size   : Taille en pixels du côté du carré
	*
	* @return Intervention\Image\Image
	*/
	public function resizeRatio($ratio, $size)
	{
		$smallSide = round($size/$ratio);
		$largeSide = round($size);

		$narrowerThanRatio = $this->ratio($this->file)<(1/$ratio);
		$narrowerThanSquareButWiderThanRatio = ($this->ratio($this->file)>=(1/$ratio)) && ($this->ratio($this->file)<1);
		$widerThanSquareButNarrowerThanRatio = ($this->ratio($this->file)>=1) && ($this->ratio($this->file)<=$ratio);
		$widerThanRatio = $this->ratio($this->file)>$ratio;

		if($narrowerThanRatio){
			$keepRatioDimension = "width";
			$origin = "originY";
			$width  = $smallSide;
			$height = $largeSide;
			$resizeDimension = $smallSide;
		}

		if($narrowerThanSquareButWiderThanRatio){
			$keepRatioDimension = "height";
			$origin = "originX";
			$width  = $smallSide;
			$height = $largeSide;
			$resizeDimension = $largeSide;
		}

		if($widerThanSquareButNarrowerThanRatio){
			$keepRatioDimension = "width";
			$origin = "originY";
			$width = $largeSide;
			$height = $smallSide;
			$resizeDimension = $largeSide;
		}

		if($widerThanRatio){
			$keepRatioDimension = "height";
			$origin = "originX";
			$width = $largeSide;
			$height = $smallSide;
			$resizeDimension = $smallSide;
		}

		$this->resize([
			"width" 			 => $resizeDimension,
			"height"			 => $resizeDimension,
			"keepRatioDimension" => $keepRatioDimension
		]);

		/**
		 * Récupération des coordonnées du point de crop
		 */
		if($narrowerThanRatio){
			$originY = $this->getOriginY($this->file, $largeSide);
		}

		if($narrowerThanSquareButWiderThanRatio){
			$originX = $this->getOriginX($this->file, $smallSide);
		}

		if($widerThanSquareButNarrowerThanRatio){
			$originY = $this->getOriginY($this->file, $smallSide);
		}

		if($widerThanRatio){
			$originX = $this->getOriginX($this->file, $largeSide);
		}

		return $this->crop(["width" => $width, "height" => $height, $origin => $$origin]);
	}


	/**
	* Permet de générer une image carrée de la taille voulue en coupant l'image source
	*
	* @param Integer $size   : Taille en pixels du côté du carré
	*
	* @return Intervention\Image\Image
	*/
	public function squarify($size)
	{
		return $this->resizeRatio(1, $size);
	}


	/**
	 * Sauvegarde l'image courante
	 *
	 * @param   String $path
	 *
	 * @return  Boolean
	 */
	public function saveTo($path, $quality=90)
	{
		return $this->file->save($path, $quality);
	}


	/**
	 * Converti l'image en jpg
	 *
	 * @param   String  			$format
	 * @param   Integer ([0->100])  $quality
	 *
	 * @return  [type]            [description]
	 */
	public function encode($format, $quality)
	{
		$this->file = $this->file->encode($format, $quality);
	}
}

?>
