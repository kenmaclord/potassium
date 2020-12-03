<?php

namespace Entities;

use Entities\Entity;
use Entities\Langue;
use Illuminate\Support\Facades\Schema;

class Langue extends Entity
{
	protected $table="langues";
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'nom', 'traduction', 'code', 'fullCode', 'available', 'visible', 'order'
	];

	protected $casts = [
        'visible' 	=> 'boolean',
        'available' => 'boolean'
    ];


	/**
	* Get the route key for the model.
	*
	* @return string
	*/
	public function getRouteKeyName()
	{
		return 'code';
	}


	/**
	 * Filtre les langues visible dans le Front
	 *
	 * @param   Illuminate\Database\Query\Builder  $query
	 *
	 * @return  Illuminate\Database\Query\Builder
	 */
	public function scopeVisible($query)
	{
		return $query->where('visible', 1);
	}


	/**
	 * Filtre les langues disponibles dans l'Admin
	 *
	 * @param   Illuminate\Database\Query\Builder  $query
	 *
	 * @return  Illuminate\Database\Query\Builder
	 */
	public function scopeAvailable($query)
	{
		return $query->where('available', 1);
	}


	/**
	 * Retourne un tableau avec les langues visibles pour le Front
	 *
	 * @return  Array
	 */
	public static function getFormatedVisibleLanguages()
	{
		$allLangues = [
			'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'Français', 'regional' => 'fr_FR'],
 			'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
	        'de' => ['name' => 'German','script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
	        'it' => ['name' => 'Italian','script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
			'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'Español', 'regional' => 'es_ES'],
	        'zh' => ['name' => 'Chinese (Simplified)',   'script' => 'Hans', 'native' => '简体中文', 'regional' => 'zh_CN'],
	        'pt' => ['name' => 'Portuguese','script' => 'Latn', 'native' => 'português', 'regional' => 'pt_PT'],
	        'ja' => ['name' => 'Japanese','script' => 'Jpan', 'native' => '日本語', 'regional' => 'ja_JP'],
	        'ar' => ['name' => 'Arabic','script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_AE'],
	        'ru' => ['name' => 'Russian','script' => 'Cyrl', 'native' => 'русский', 'regional' => 'ru_RU'],
	        'pl' => ['name' => 'Polish','script' => 'Latn', 'native' => 'polski', 'regional' => 'pl_PL'],
		];

		return self::findVisibleLanguages($allLangues);
	}


	/**
	 * Retourne un tableau avec seulement les langues visibles pour le Front
	 *
	 * @return  Array
	 */
	private static function findVisibleLanguages($allLangues)
	{
		$visibleLangues = [];

		foreach ($allLangues as $code => $langue) {
			if(self::isVisible($code)){
				$visibleLangues[$code] = $langue;
			}
		}

		return $visibleLangues;
	}


	/**
	 * Indique si une langue est visible pour le Front pour un code donné
	 *
	 * @param   String   $code
	 *
	 * @return  Boolean
	 */
	private static function isVisible($code)
	{
		if (Schema::hasTable('langues')) {
			return \DB::table('langues')->where('code', $code)->first() ? \DB::table('langues')->where('code', $code)->first()->visible : true;
		}

		return true;
	}
}
