<?php

namespace Potassium\App\Traits;

trait ClassUtilities
{
	/**
	* Retourne le nom de la class de Naming correpondant à la class d'Upload
	*
	* @return  String
	*/
	protected function getStrategyClassName($class=null, $type)
	{
		if ($class) {
			$classInstance = new \ReflectionClass($class);

			return "App\\Strategies\\".ucwords($type)."\\". $classInstance->getShortName().ucwords($type)."Strategy";
		}

		return "App\\Strategies\\".ucwords($type)."\\".ucwords($type)."Strategy";
	}
}
