<?php

namespace Potassium\App\Http\Controllers\Front;

use Potassium\App\Entities\Traduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FrontTraductionsController extends Controller
{
	/**
	 * Retourne toutes les traductions pour la langue courante
	 *
	 * @return  Array
	 */
	public function index()
	{
		$trans = Traduction::getTranslations(request('lang'));

		return json_encode($trans);
	}
}
