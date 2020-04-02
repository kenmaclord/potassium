<?php

namespace Potassium\App\Http\Controllers\Admin;

use Potassium\App\Entities\Traduction;
use Potassium\App\Entities\TraductionContent;
use Potassium\App\Http\Controllers\Controller;

class TraductionsContentController extends Controller
{
	/**
	 * Met à jour l'état de publication d'un contenu de traduction
	 *
	 * @param  TraductionContent  $traduction_content
	 */
	public function setPublishedState(TraductionContent $traduction_content)
	{
		$traduction_content->update([
			'published' => request('value')
		]);
	}


	/**
	 * Met à jour le contenu d'une traduction
	 *
	 * @param  Entities\Traduction  $traduction
	 *
	 * @return Json
	 */
	public function update(Traduction $traduction)
	{
		$code = array_keys(request()->all())[0];
		$body = request($code);

		$traduction->addOrPatch($body, $code);

		return $this->respond('Contenu mis à jour');
	}
}
