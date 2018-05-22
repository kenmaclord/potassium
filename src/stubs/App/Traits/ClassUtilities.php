<?php

namespace App\Traits;

trait ClassUtilities
{
  	/**
	* Retourne le nom de la class de Naming correpondant à la class d'Upload
	*
	* @return  String
	*/
	protected function getNamingStrategyClassName($toReplace)
	{
		$classInstance = new \ReflectionClass($this);

		return 'App\\Strategies\\Naming\\'. str_replace($toReplace, 'Naming', $classInstance->getShortName());
	}
}
