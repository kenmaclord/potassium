<?php

namespace Potassium\App\Http\Controllers\Admin;

use Potassium\App\Entities\Zone;
use Potassium\App\Entities\Langue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Potassium\App\Entities\Traduction;
use Potassium\App\Http\Controllers\Controller;

class ZonesController extends Controller
{
	/**
	 * Retourne la liste des zones avec les traductions
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function index()
	{
		return Cache::rememberForEver("zones", function(){
			return Zone::with('traductions.zone')->get();
		});
	}


	/**
	 * Ajoute une Zone
	 *
	 * @return  Json
	 */
	public function store()
	{
		Zone::create(request()->validate([
				'nom' => 'required'
			])
		);

		return $this->respond('Zone ajoutée');
	}


	/**
	 * Met à jour le nom d'une zone
	 *
	 * @param   Potassium\App\Entities\Zone    $zone
	 *
	 * @return  Json
	 */
	public function update(Zone $zone)
	{
		$zone->update(request()->validate([
				'nom' => 'required'
			])
		);

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

		return $this->respond('Zone de traduction en '. mb_strtolower($langue->nom) .' publiée');
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

		return $this->respond('Zone supprimée');
	}
}
