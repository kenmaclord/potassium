<?php

namespace App\Http\Controllers\Admin;

use Entities\User;
use Entities\Droit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class DroitsController extends Controller
{
	/**
	 * Retourne tous les droits
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function index()
	{
		return Droit::all();
	}


	/**
	 * Met à jour les droits de l'utilisateur
	 *
	 * @param   User    $user
	 *
	 * @return  Json
	 */
	public function update(User $user)
	{
		$user->bustCache(Droit::find(request('droit'))->slug);

		if(!!request('granted')){
			$user->droits()->sync(request('droit'), false);
			return $this->respond('Droit attribué');
		}

		$user->droits()->detach(request('droit'));
		return $this->respond('Droit retiré');
	}
}
