<?php

namespace Potassium\App\Http\Controllers\Admin;

use Potassium\App\Entities\Zone;
use Potassium\App\Entities\Langue;
use Potassium\App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;

class ZonesController extends Controller
{
	public function index()
	{
		if(request()->wantsJson())
		{
			return Cache::rememberForEver('zones', function() {
				return Zone::orderBy('order')->get();
			});
		}
	}


	/**
	 * Ajoute une Zone
	 *
	 * @return  Json
	 */
	public function store()
	{
		request()->validate([
			'nom' => 'required'
		]);

		$this->incrementOrder('zones');

		Zone::create([
			'nom' 	=> request('nom'),
			'slug' 	=> str_slug(request('nom'))
		]);

		Cache::forget('zones');

		return $this->respond('Zone ajoutée');
	}


	/**
	 * Met une Zone à jour
	 *
	 * @param   Entities\Zone    $zone
	 *
	 * @return  Json
	 */
	public function update(Zone $zone)
	{
		$zone->update(request()->validate(['nom' => 'required']));

		Cache::forget('zones');

		return $this->respond('Nom modifié');
	}


	/**
	 * Publie une zone dans une langue donnée
	 *
	 * @param   Entities\Zone    $zone
	 * @param   Entities\Langue  $langue
	 *
	 * @return  Json
	 */
	public function publish(Zone $zone, Langue $langue)
	{
		$zone->publish($langue->code);

		return $this->respond('Zone de traduction en '.strtolower($langue->nom).' publiée');
	}


	/**
	 * Supprime une zone de traduction
	 *
	 * @param   Entities\Zone    $zone
	 *
	 * @return  Json
	 */
	public function destroy(Zone $zone)
	{
		$zone->delete();

		Cache::forget('zones');

		return $this->respond('Zone supprimée');
	}


	/**
	 * Détermine si une zone dans une langue donnée est publiée
	 *
	 * @param   Entities\Zone     $zone
	 * @param   Entities\Langue   $langue
	 *
	 * @return  Integer
	 */
	public function isPublished(Zone $zone, Langue $langue)
	{
		return [
			'fr' 		=> $zone->isPublished('fr'),
			'localized' => $zone->isPublished($langue->code),
		];
	}
}
