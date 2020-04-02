<?php

namespace Potassium\App\Traits;

use Potassium\App\Traits\ClassUtilities;
use Illuminate\Support\Facades\Storage;

trait Sizes
{
	use ClassUtilities;

	protected function getArrayableAppends()
	{
	    $this->appends = array_unique(array_merge($this->appends, ['xs', 's', 'm', 'l', 'xl', 'xxl']));

	    return parent::getArrayableAppends();
	}

	public static function getSizes()
	{
		if(property_exists(new static, 'sizes')){
			return static::$sizes;
		}

		return config('image.sizes');
	}

  	public function getXsAttribute()
	{
		return $this->size('xs');
	}

	public function getSAttribute()
	{
		return $this->size('s');
	}

	public function getMAttribute()
	{
		return $this->size('m');
	}

	public function getLAttribute()
	{
		return $this->size('l');
	}

	public function getXLAttribute()
	{
		return $this->size('xl');
	}

	public function getXxLAttribute()
	{
		return $this->size('xxl');
	}


	/**
	 * Retourne le nom de fichier correspondant à la taille désirée
	 *
	 * @param   String $size
	 *
	 * @return  String
	 */
	public function size($size)
	{
        $namingClass = $this->getStrategyClassName($this, 'naming');
        $path = (new $namingClass)->path();

		if(!is_null($this->url)){
			$sizedFilename = sprintf('%s/%s/%s-%s.jpg', $path, $this->url, $this->url, $size);

			return $sizedFilename;
		}

		return "";
	}

	/**
	 * Retourne un tableau de toutes les versions de taille d'une image
	 *
	 * @return  Array
	 */
	public function variantes()
	{
		$variantes = [];
		foreach ($this->getSizes() as $name => $value) {
			$variantes[$name] = $this->size($name);
		}

		return $variantes;
	}
}
