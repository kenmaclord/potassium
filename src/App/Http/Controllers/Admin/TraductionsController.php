<?php

namespace Potassium\App\Http\Controllers\Admin;

use Potassium\App\Entities\Traduction;
use Potassium\App\Http\Controllers\Controller;

class TraductionsController extends Controller
{

	/**
	 * Affichage de la vue principale
	 *
	 * @return  Illuminate\View\View
	 */
	public function index()
	{
		return view('potassium::admin.pages.traductions.index');
	}


	/**
	 * Ajoute une clé de traduction
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function store()
	{
		$traduction = Traduction::create(request()->validate([
			'zone_id' => 'required|exists:zones,id',
			'key' => 'required',
			], [
				'zone_id.exists' => "Cette zone n'existe pas",
			])
		);

		return $this->respond('Clé ajoutée');
	}


	/**
	 * Met à jour une traduction
	 *
	 * @param   Potassium\App\Entities\Traduction  $traduction
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function update(Traduction $traduction)
	{
		updateJson($traduction, "content", request()->all());

		return $this->respond('Traduction mise à jour');
	}
}
