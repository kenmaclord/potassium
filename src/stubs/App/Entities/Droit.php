<?php

namespace Entities;

use Entities\User;
use Entities\Entity;

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
