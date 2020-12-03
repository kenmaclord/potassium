<?php

namespace Entities;

use Entities\Entity;
use Entities\Traduction;
use App\Traits\Publishable;
use Entities\TraductionContent;

class Zone extends Entity
{
	use Publishable;

	protected $table="zones";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'nom', 'slug', 'order'
	];


	/**
	 * Relation liant une zone à ses traductions
	 *
	 * @return  Illuminate\Database\Eloquent\Builder
	 */
	public function traductions()
	{
		return $this->hasMany(Traduction::class);
	}


	/**
	 * Relation liant une zone à ses tous ses contenus
	 *
	 * @return  Illuminate\Database\Eloquent\Builder
	 */
	public function contents()
	{
		return $this->hasManyThrough(TraductionContent::class, Traduction::class);
	}


	/**
	 * Relation liant une zone à ses tous ses contenus dans une langue donnée
	 *
	 * @return  Illuminate\Database\Eloquent\Builder
	 */
	public function contentsByLang($lang)
	{
		return $this->hasManyThrough(TraductionContent::class, Traduction::class)->lang($lang);
	}


	/**
	 * Informe si une zone entière dans une langue donnée est publiée
	 *
	 * @param   String $lang
	 *
	 * @return  Boolean
	 */
	public function isPublished($lang)
	{
		$published = true;

		$this->contentsByLang($lang)->get();

		foreach ($this->contentsByLang($lang)->get() as $content) {
			$published = $published && !!$content->published;
		}

		return $published;
	}
}
