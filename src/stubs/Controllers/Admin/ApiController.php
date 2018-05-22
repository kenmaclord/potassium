<?php

namespace App\Http\Controllers\Admin;

use Entities\Zone;
use Entities\Continent;
use Entities\Revendeur;
use Entities\Collection;
use Entities\Traduction;
use Illuminate\Http\Request;
use App\Entities\DocumentType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
	/**
	 * Retourne les valeurs IP
	 *
	 * @return  Array
	 */
	public function ip()
	{
		if(env('APP_ENV')=='testing'){
			return ['20', '64'];
		}

		return $this->getEnumValues('modeles', 'ip');
	}


	/**
	 * Retourne les classes
	 *
	 * @return  Array
	 */
	public function classes()
	{
		if(env('APP_ENV')=='testing'){
			return ['I', 'II', 'III'];
		}

		return $this->getEnumValues('modeles', 'classe');
	}


	/**
	 * Récupère les valeurs des champs ENUM
	 *
	 * @param   String  $table
	 * @param   String  $field
	 *
	 * @return  Array
	 */
	public function getEnumValues($table, $field)
	{
		return Cache::rememberForEver($field, function () use($table, $field){
			$data = DB::select(DB::raw('SHOW COLUMNS FROM '.$table.' WHERE Field = "'.$field.'"'))[0]->Type;

			preg_match('/^enum\((.*)\)$/', $data, $matches);
			$values = array();
			foreach(explode(',', $matches[1]) as $value){
				$values[] = trim($value, "'");
			}

			return $values;
		});
	}


	/**
	 * Retourne les personnalisations visibles d'une collection incluant
	 * les couleurs visibles de chaque personnalisation
	 *
	 * @param   Collection  $collection
	 *
	 * @return  [type]                   [description]
	 */
	public function personnalisations(Collection $collection)
	{
		return $collection->personnalisations()->with(['colors' => function($query){
			return $query->visible()->orderBy('order');
		}, 'traduction'])->visible()->orderBy('order')->get();
	}



	/**
	 * Retourne tous les types de documents
	 *
	 * @return  [type]  [description]
	 */
	public function document_types()
	{
		return DocumentType::with('traduction')->orderBy('order')->get();
	}


	/**
	 * Retourne tous les revendeurs
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function revendeurs()
	{
		return Revendeur::orderBy('id', 'DESC')->get();
	}



	/**
	 * Retourne la liste des pays par continent
	 *
	 * @param   Entities\Continent  $continent
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function pays(Continent $continent)
	{
		return $continent->pays;
	}


	/**
	 * Géolocalise une adresse
	 *
	 * @return  Json
	 */
	public function geolocalize()
	{
		$url = "https://maps.googleapis.com/maps/api/geocode/json";
		$address="address=".urlencode(request('address'));
		$key = "key=".config('services.google_map.key');

  		$curl = curl_init("{$url}?{$address}&{$key}");

	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

		$result = curl_exec($curl);
	    curl_close($curl);

	    return json_encode($result);
	}
}
