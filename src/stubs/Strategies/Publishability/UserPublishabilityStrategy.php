<?php

namespace App\Strategies\Publishability;

use App\Strategies\Publishability\PublishabilityStrategy;

class UserPublishabilityStrategy extends PublishabilityStrategy
{
	protected $user;

	protected $conditions = [
		'hasFirstName',
		'hasLastName',
		'hasEmail'
	];


	public function __construct($user){
		$this->user = $user;
	}


 /**
	 * Permet de savoir si un utilisateur a un prénom
	 *
	 *  @return  boolean
	 */
	public function hasFirstName()
	{
		return !empty($this->user->first_name);
	}


	/**
	 * Permet de savoir si un utilisateur a un nom de famille
	 *
	 *  @return  Boolean
	 */
	public function hasLastName()
	{
		return !empty($this->user->last_name);
	}

	/**
	 * Permet de savoir si un utilisateur a un email
	 *
	 *  @return  Boolean
	 */
	public function hasEmail()
	{
		return !empty($this->user->email);
	}

}
