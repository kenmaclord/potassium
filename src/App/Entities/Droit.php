<?php

namespace Potassium\App\Entities;

use App\Entities\User;
use Potassium\App\Entities\Entity;

class Droit extends Entity
{
	public $table = "droits";
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'slug', 'description'
	];


	/**
	 * Relation liant un droits et ses utilisateurs
	 *
	 * @return  Illuminate\Database\Eloquent\Builder
	 */
	public function users()
	{
		return $this->belongsToMany(User::class);
	}
}
