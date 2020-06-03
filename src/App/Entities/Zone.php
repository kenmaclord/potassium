<?php

namespace Potassium\App\Entities;

use Illuminate\Support\Str;
use Potassium\App\Entities\Entity;
use Potassium\App\Traits\Publishable;
use Potassium\App\Entities\Traduction;
use Potassium\App\Entities\TraductionContent;

class Zone extends Entity
{
	use Publishable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'nom', 'slug', 'published'
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
	 * Enregistre en même temps le nom de la zone et le slug associé
	 *
	 * @param  String  $value
	 */
	public function setNomAttribute($value)
	{
		$this->attributes['nom'] = $value;
		$this->attributes['slug'] = Str::slug($value);
	}
}
