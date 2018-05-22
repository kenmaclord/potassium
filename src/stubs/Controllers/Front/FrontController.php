<?php

namespace App\Http\Controllers\Front;

use Entities\Home;
use Entities\News;
use Entities\User;
use Entities\Filtre;
use Entities\Langue;
use Entities\Modele;
use Entities\Projet;
use Entities\Designer;
use Entities\Catalogue;
use Entities\Permalink;
use Entities\Revendeur;
use Entities\Accessoire;
use Entities\Collection;
use App\Traits\MailJetApi;
use Entities\ModeleDocument;
use App\Traits\SendInBlueApi;
use App\Entities\DocumentType;
use Entities\Personnalisation;
use App\Traits\FileManipulation;
use App\Http\Controllers\Controller;
use App\Notifications\MessageSentFromContactPage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FrontController extends Controller
{
	use FileManipulation, MailJetApi;

	public function index()
	{
		$images 	= Home::getRandomImage();
		$collections = Collection::visible()->with('designer')->orderBy('order')->get();

		$data = [
			'images' => $images,
			'collections' => $collections,
			'news' => News::with(
				[
					'content',
					'photos'=>function($query)
					{
						$query->orderBy('order');
					}
				])->visible()->orderBy('updated_at', 'DESC')->get(),

			'highlight' => News::visible()->where('highlight', 1)->with(
				[
					'content',
					'photos'=>function($query)
					{
						$query->orderBy('order');
					}
				])->first()
		];

		return view('front.pages.home', $data);
	}

	/**
	 * Charge la page des news
	 *
	 * @return  Illuminate\View\View
	 */
	public function news()
	{
		return view("front.pages.actualites.liste");
	}


	public function newsShow(News $news)
	{
		$data = $news
				->load('content')
				->load(['photos'=>function($query)
					{
						$query->orderBy('order');
					}
				]);

		return view('front.pages.actualites.show', compact('data'));
	}

	/**
	 * Charge la page des collections
	 *
	 * @return  Illuminate\View\View
	 */
	public function collections()
	{
		return view("front.pages.collections");
	}


	/**
	 * Charge une page de collection
	 *
	 * @param   String $page
	 *
	 * @return  Illuminate\View\View
	 */
	public function collection(Collection $collection, $name)
	{
		return view("front.pages.collection");
	}


	/**
	 * Charge une page avec les portraits des designers
	 *
	 * @return  Illuminate\View\View
	 */
	public function designers()
	{
		$data = Designer::visible()->get();

		return view("front.pages.designers", compact('data'));
	}

	/**
	 * Charge une page avec le designer
	 *
	 * @return  Illuminate\View\View
	 */
	public function designer(Designer $designer)
	{
		$data = $designer->load(['photosVisibles.designer', 'traduction', 'collections' => function($q){
			$q->visible();
		}]);

		return view("front.pages.designer",compact('data'));
	}


	/**
	 * Charge une page de modèle
	 *
	 * @param   Entities\Modele $modele
	 * @param   String $name
	 *
	 * @return  Illuminate\View\View
	 */
	public function modele(Modele $modele, $name)
	{
		$modele =  $modele
						->load('collection.designer.photosVisibles')
						->load(['photos' => function($query){
							$query->visible();
						}])
						->load('infos')
						->load('documentsVisibles.type.traduction');

		$accessoires = Accessoire::forCollection($modele->collection)
			->visible()
			->orderBy('order')
			->with('content')
			->get();

		$personnalisations = Personnalisation::forCollection($modele->collection)
			->visible()
			->orderBy('order')
			->with(['colors'=> function($q){
				return $q->orderBy('order');
			}, 'traduction'])
			->get();

		$finitions = $modele->finitions()
			->visible()
			->with('personnalisations.colorsVisible')
			->get();

		$typologies = Filtre::with('traduction.content')->visible()->type()->orderBy('order')->get();

		$schema = $modele->schema();

		$designer = $modele->collection->designer->load('traduction');

		$langues = $this->localizedUrls($modele);

        $product = [
            "name"=> $modele->name,
            'url' => "http://www.dcw-editions.fr/" .LaravelLocalization::getCurrentLocale(). "/modele/{$modele->id}/" . str_slug($modele->name),
            "image"=> $modele->url
        ];

		$data = [
			'modele' => $modele,
			'accessoires' => $accessoires,
			'personnalisations' => $personnalisations,
			'finitions' => $finitions,
			'filtres' => $typologies,
			'schema' => $schema,
			'designer' => $designer,
			'langues' => $langues,
			'product' => $product,
		];

		return view("front.pages.modele.modele", ['data' => json_encode($data)]);
		return view("front.pages.modele.modele", ['data' => json_encode($data)]);
	}


	public function localizedUrls($modele)
	{
    	$data = [];

        foreach(Langue::visible()->get() as $lang){
        	$data[] = [
				'lang' =>  $lang->code,
                'url' => "http://www.dcw-editions.fr/{$lang->code}/modele/{$modele->id}/" . str_slug($modele->name)
            ];
        }

        return $data;
	}


	/**
	 * Affiche la page des téléchargements
	 *
	 * @return  Illuminate\View\View
	 */
	public function telechargements()
	{
		return view('front.pages.telechargements.types');
	}

	/**
	 * Affiche la page des revendeurs
	 *
	 * @return  Illuminate\View\View
	 */
	public function revendeurs()
	{
		$key = config('services.google_map.key');

		return view('front.pages.revendeurs', compact('key'));
	}

	/**
	 * Retrouve les revendeurs dans le rayon défini dans le fichier de configuration
	 * en fontion du point (lat, lng) donné par le code postal
	 *
	 * @return  [type]  [description]
	 */
	public function revendeursFind()
	{
		$radius = config('revendeurs.radius');
		$baseDistance = config('revendeurs.oneDegreLatitudeDistance');
		$lat = request('lat');
		$lng = request('lng');

		$lowLat = $lat - $radius/($baseDistance);
		$highLat = $lat + $radius/($baseDistance);

		$lowLng = $lng - $radius/(($baseDistance*cos(2*Pi()*$lat/360)));
		$highLng = $lng + $radius/(($baseDistance*cos(2*Pi()*$lat/360)));

		$ids = \DB::table('revendeurs')
                    ->whereBetween('latitude', [$lowLat, $highLat])
                    ->whereBetween('longitude', [$lowLng, $highLng])
                    ->pluck('id')
                    ->toArray();

        return Revendeur::whereIn('id', array_values($ids))->with('pays')->get();
	}

	/**
	 * Affiche la page des projets
	 *
	 * @return  Illuminate\View\View
	 */
	public function projets()
	{
		$data = Projet::visible()->get();

		return view('front.pages.projets.projets', compact('data'));
	}


	/**
	 * Charge la page d'un projet en paticulier
	 *
	 * @param   Projet  $projet
	 *
	 * @return  [type]           [description]
	 */
	public function projet(Projet $projet)
	{
		$data = $projet->load('modelesVisibles')
			   		   ->load('type')
			   		   ->load('photosVisibles');

		return view('front.pages.projets.projet', compact('data'));
	}

	/**
	 * Charge la page des téléchargements par type
	 *
	 * @param   [type]  $type
	 *
	 * @return  [type]         [description]
	 */
	public function telechargementsByType($type)
	{
		if($type=='catalogues'){
			$data = Catalogue::visible()->get();

			return view('front.pages.telechargements.catalogues', compact('data'));
		}

		if(DocumentType::where('translation_key', $type)->count() > 0){
			$modelesIds = ModeleDocument::visible()
					->ofType($type)
					->distinct()
					->pluck('modele_id');

			$collectionsIds = Modele::visible()->whereIn('id', $modelesIds)->distinct()->pluck('collection_id');

			$collections  = Collection::visible()->whereIn('id', $collectionsIds)->orderBy('order')->get();

			$data = json_encode([
				'collections' => $collections,
				'document_type' => DocumentType::where('translation_key', $type)->with('traduction')->first()
			]);


			return view('front.pages.telechargements.telechargements', compact('data'));
		}

		abort(404);
	}


	/**
	 * Charge une page avec des modèles filtrés
	 *
	 * @param   String $page
	 *
	 * @return  Illuminate\View\View
	 */
	public function filtre($type, Filtre $filtre)
	{
		if ($type=='projets') {
			$data = json_encode([
				'filtre' => $filtre->load('traduction'),
				'content' => $filtre->projetsVisible
			]);
		} else{
			$data = json_encode([
				'filtre' => $filtre->load('traduction'),
				'content' => $filtre->modeles->load('collection')
			]);
		}
		return view("front.pages.filtres", compact('data'));
	}


	/**
	 * Charge la page de contact
	 *
	 * @param   String $page
	 *
	 * @return  Illuminate\View\View
	 */
	public function contact()
	{
		return view("front.pages.contact");
	}


	/**
	 * Charge la page des mentions légales
	 *
	 * @return  Illuminate\View\View
	 */
	public function mentions()
	{
		return view('front.pages.mentions');
	}


	/**
	 * Redirige le permalink vers une url réelle
	 *
	 * @param   Entities\Permalink  $permalink
	 *
	 * @return  Illuminate\Support\Facades\Redirect
	 */
	public function permalink(Permalink $permalink)
	{
		return redirect($permalink->target);
	}


	/**
	 * Envoie l'email de contact depuuis le formulaire Front
	 *
	 * @return  [type]  [description]
	 */
	public function send()
	{
		request()->validate([
			'nom' => 'required',
			'email' => 'required|email',
			'pays' => 'required',
			'msg' => 'required',
		]);

		/** Retrouve le destinataire de l'email de contact */
		$user = User::where('email', config('mail.contact-email'))->first();

		/** Inscription à la newsletter */
		if(request('subscribe')){
			$this->mailJetSubscribeCustomer();
		}

		/** Envoi du message */
		try {
			$user->notify(new MessageSentFromContactPage($user, request()->all()));

			return $this->respond(trans('contact.sent-success'));

		} catch (Exception $e) {
			return $this->respondErrorBag(trans('contact.sent-error'), 500);
		}
	}


	/**
	 * Télécharge un document
	 *
	 * @param   Entities\ModeleDocument  $document
	 *
	 * @return  Void
	 */
	public function downloadDocument(ModeleDocument $document)
	{
		$this->download($document->url);
	}

	/**
	 * Télécharge un catalogue
	 *
	 * @param   Entities\Catalogue  $catalogue
	 *
	 * @return  Void
	 */
	public function downloadCatalogue(Catalogue $catalogue)
	{
		$this->download($catalogue->url);
	}
}
