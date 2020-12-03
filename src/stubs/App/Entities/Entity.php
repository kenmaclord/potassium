<?php

namespace Entities;

use App\Traits\AjaxResponder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class Entity extends Eloquent
{
	use AjaxResponder;

	protected $guarded = [];

	/**
	* Ne retourne que les éléments visibles
	*
	* @return Illuminate\Support\Collection
	*/
	public function scopeVisible($query)
	{
		return $query->where('visible', 1);
	}


	/**
	* Retourne le contenu du Model en fonction de la langue passée
	*
	* @param  Illuminate\Database\Eloquent\QueryBuilder $query
	* @param  String $lang  : La langue du contenu que l'on veut récupérer
	*
	* @return Illuminate\Database\Eloquent\QueryBuilder
	*/
	public function scopeWithContentByLang($query, $lang=null)
	{
		if(is_null($lang)){
			$lang= 'fr';
		}

		return $query->with(['content'=>function($query) use($lang) {$query->lang($lang);}]);
	}


	/**
	* Récupère la news et l'ensemble de son contenu dans la langue choisie
	*
	* @param  String $lang : langue du contenu que l'on veut récupérer
	* @return Collection
	*/
	public function appendContent($lang=null)
	{
		if(is_null($lang)){
			$lang= LaravelLocalization::getCurrentLocale();
		}

		return $this->load(['content' => function($query) use($lang){
			return $query->lang($lang)->first();
		}]);
	}


	/**
	* Filtre les résultats par langue
	*
	* @param   Illuminate\Database\Query\Builder  $query
	* @param   String  $lang
	*
	* @return  Illuminate\Database\Query\Builder
	*/
	public function scopeLang($query, $lang=null)
	{
		if(is_null($lang)){$lang='fr';}

		return $query->where('lang', $lang);
	}

	/**
	 * Ne retourne que les entités d'une collection donnée
	 *
	 * @param   Illuminate\Database\Eloquent\Builder  $query
	 * @param   Entities\Collection  $collection
	 *
	 * @return  Illuminate\Database\Eloquent\Builder
	 */
	public function scopeForCollection($query, $collection)
	{
		return $query->where('collection_id', $collection->id);
	}


	/**
	 * Alterne la visibilité d'une entité
	 *
	 * @param   $entite
	 *
	 * @return  Json
	 */
	public function visibility($messageError=null, $messageOK=null)
	{
		if(isPublishable($this) || request('visibility')==false){
			$this->update([
				'visible' => request('visibility')
			]);

			$this->fireModelEvent("enabled", false);

			if(is_null($messageOK)){
				$messageOK = 'Visibilité mise à jour';
			}

			return $this->respond($messageOK);
		}

		if(is_null($messageError)){
			$messageError = 'Les conditions de publication ne sont pas réunies';
		}

		return $this->respondError($messageError, ResponseCode::HTTP_FORBIDDEN);
	}


	/**
	 * Déclenche un évènement de model personnalisé
	 *
	 * @param   String  $event
	 *
	 * @return  void
	 */
	public function fireEvent($event)
	{
		$this->fireModelEvent($event, false);
	}

}
