<?php

namespace Potassium\App\Traits;

trait ImageUtilities
{
	/**
	* Permet d'obtenir le ratio de l'image
	*
	* @param Intervention\Image\Image $img : Fichier source
	*
	* @return Float
	*/
	public function ratio($img)
	{
		return round($img->width()/$img->height(),3);
	}


	/**
	* Permet d'obtenir le point d'origine sur l'axe des ordonnées pour un crop
	*
	* @param Intervention\Image\Image   $file   : Fichier source
	* @param Integer $height : hauteur de l'image cropée
	*
	* @return Float
	*/
	public function getOriginY($img, $height)
	{
		return round(($img->height() - $height)/2);
	}


	/**
	* Permet d'obtenir le point d'origine sur l'axe des abscisses pour un crop
	*
	* @param Intervention\Image\Image   $file   : Fichier source
	* @param Interger $width : largeur de l'image cropée
	*
	* @return Float
	*/
	public function getOriginX($img, $width)
	{
		return round(($img->width()-$width)/2);
	}


/**
	 * Attribue les bonnes informations aux bonnes dimensions en fonctions des options passées
	 *
	 * @param  array $options : tableau d'options
	 * @return Object
	 */
	public function makeDimensions($img, $options)
	{
		// Attribution des dimensions
		$width  = $options->width;
		$height = $options->height;
		$dimension = $width;

		// Si l'option 'keepRatio' est à 'on', on annule une des dimensions en fonction de l'option keepRatioDimension
		if($options->keepRatio){
			if($options->keepRatioDimension == "height"){
				$width = null;
				$dimension = $height;
			}
			if($options->keepRatioDimension == "width"){
				$height = null;
				$dimension = $width;
			}
			if($options->keepRatioDimension == "largest"){
				if($this->ratio($img)>1)
				{
					$width = $options->pixels;
					$height = null;
					$dimension = $width;
				}else{
					$width = null;
					$height = $options->pixels;
					$dimension = $height;
				}
			}
		}

		return (object)[
			'width' 		=> $width,
			'height'		=> $height,
			'dimension'	=> $dimension
		];
	}
}
