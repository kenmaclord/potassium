<?php

namespace Potassium\App\Entities;

use Potassium\App\Entities\Entity;
use Potassium\App\Entities\Traduction;

class TraductionContent extends Entity
{
	protected $table="traductions_content";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'traduction_id', 'body', 'lang', 'published'
	];


	/**
	 * Relation liant un contenu à sa zone
	 *
	 * @return  [type]  [description]
	 */
	public function traduction()
	{
		return $this->belongsTo(Traduction::class);
	}


	/**
	 * Retourne la zone d'un contenu
	 *
	 * @return  Potassium\App\Entities\Zone
	 */
	public function zone()
	{
		return $this->traduction()->first()->zone;
	}
}
