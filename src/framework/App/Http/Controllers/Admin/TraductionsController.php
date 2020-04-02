<?php

namespace Potassium\App\Http\Controllers\Admin;

use Potassium\App\Entities\Langue;
use Potassium\App\Entities\Traduction;
use Potassium\App\Entities\TraductionContent;
use Potassium\App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;

class TraductionsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if(request()->wantsJson()){
			return $this->listeByZoneName(request('lang'));
		}

		return view('potassium::admin.pages.traductions.index');
	}


	/**
	 * Ajoute une traduction
	 *
	 * @return Json
	 */
	public function store()
	{
		request()->validate([
			'zone_id' => 'required|exists:zones,id',
			'key' => 'required',
		], [
			'zone_id' => "Cette zone n'existe pas",
		]);

		Traduction::create([
			'zone_id' => request('zone_id'),
			'key' => str_slug(request('key')),
		]);

		return $this->respond('Clé ajoutée');
	}


	/**
	 * Supprime une traduction
	 *
	 * @param  Entities\Traduction  $traduction
	 *
	 * @return Json
	 */
	public function destroy(Traduction $traduction)
	{
		$traduction->delete();

		return $this->respond('Traduction supprimée');
	}


	/**
	 * Retourne les infos de la langue demandée
	 *
	 * @return  Entities\Langue
	 */
	public function getLangue()
	{
		return [
			'fr' 		=> 	Cache::rememberForEver('frenchLang', function() {
								return Langue::where('code', 'fr')->first();
							}),
			'localized' => 	Langue::where('code', request('lang'))->first()
		];
	}


	/**
	 * Retourne la liste des Traductions
	 *
	 * @return Array
	 */
	private function listeByZoneName($lang)
  	{
		// On ordonne toute la liste par la clé
		$rawTraductions = Traduction::with(
			['content' => function($query) use($lang){
				return $query->whereIn('lang', ['fr', $lang]);
			}])->with('zone')->orderBy('key')->get();

		/**
		 * Construction de l'objet à retourner à Vue.js
		 */
		foreach ($rawTraductions as $traduction) {
			$export['id'] = $traduction['id'];
			$export['key'] = $traduction['key'];
			$export['zone'] = $traduction->zone;
			$export['fr'] = $traduction->lang('fr');
			$export['localized'] = $traduction->lang($lang);

			$traductions[] = collect($export);
		}

		$traductions = collect($traductions);

		// On groupe la liste par le nom de la zone
		$traductions = $traductions->groupBy(function($item){
		  if($item['zone']){
		  	return $item['zone']->nom;
		  }
		});

		// On tri le tableau des zones par la clé (ici le nom de la zone)
		$traductions = $traductions->sortBy(function($traduction){ return $traduction[0]['zone']->nom; });

		return $traductions;
	}
}
