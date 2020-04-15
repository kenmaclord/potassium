<?php

namespace App\Http\Controllers\Front;

use Potassium\App\Entities\Traduction;
use Potassium\App\Http\Controllers\Controller;

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
