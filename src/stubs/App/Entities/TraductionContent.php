<?php

namespace Entities;

use Entities\Entity;
use Entities\Traduction;

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
	 * @return  Entities\Zone
	 */
	public function zone()
	{
		return $this->traduction()->first()->zone;
	}
}
