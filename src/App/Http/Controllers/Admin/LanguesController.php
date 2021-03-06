<?php

namespace Potassium\App\Http\Controllers\Admin;

use Potassium\App\Entities\Langue;
use Potassium\App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;

class LanguesController extends Controller
{
	public function index()
	{
		return Langue::all();
	}


	/**
	* Met à jour la visibilité d'une langue
	*
	* @param  Entities\Langue 	$langue
	*
	* @return JSON
	*/
	public function toggleVisibility(Langue $langue)
	{
		$langue->update(['visible'=> request('visibility')]);

		return $this->respond('Visibilité mise à jour');
	}


	/**
	* Met à jour la disponibilité d'une langue
	*
	* @param  Entities\Langue 	$langue
	*
	* @return JSON
	*/
	public function toggleAvailability(Langue $langue)
	{
		$langue->update(['available'=> request('availability')]);

		return $this->respond('Disponibilité mise à jour');
	}


	/**
	 * Retourne toutes les langues visibles pour les visiteurs
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function visible()
	{
		return Langue::visible()->get();
	}


	/**
	 * Retourne toutes les langues disponibles dans l'admin
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function available()
	{
		return Langue::available()->get();
	}


	/**
	 * Retourne les infos de la langue demandée
	 *
	 * @return  Entities\Langue
	 */
	public function getLocalizedLangues()
	{
		return [
			'fr' 		=> 	Cache::rememberForEver('frenchLang', function() {
								return Langue::where('code', 'fr')->first();
							}),
			'localized' => 	Langue::where('code', request('lang'))->first()
		];
	}
}
