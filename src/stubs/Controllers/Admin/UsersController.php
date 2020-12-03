<?php

namespace App\Http\Controllers\Admin;

use Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Strategies\Publishability\UserPublishabilityStrategy;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
	/**
	 * Affiche ou retourne la liste des utilisateurs
	 *
	 * @return  View || Json
	 */
	public function index()
	{
		if(request()->expectsJson()){
			return User::orderBy('order')->get();
		}

		return view('admin.pages.users.index');
	}


	/**
	 * Affiche la page d'un utilisateur
	 *
	 * @param   Entities\User    $user
	 *
	 * @return  View
	 */
	public function show(User $user)
	{
		$data = $user->load('droits');

		return view('admin.pages.users.show', compact('data'));
	}


	/**
	 * Ajoute un utilisateur
	 *
	 * @return  Json
	 */
	public function store()
	{
		request()->validate([
			'first_name' => "required",
			'last_name' => "required"
		]);

		$this->incrementOrder('users');

		User::create(request()->only('first_name', 'last_name'));

		return $this->respond('Utilisateur ajouté');
	}


	/**
	 * Sauvegarde le profile de l'utilisateur
	 *
	 * @param   Entities\User    $user
	 *
	 * @return  Json | Illuminate\Validation\ValidationException
	 */
	public function update(User $user)
	{
		request()->validate([
			'first_name' 	=> 'required|max:255',
			'last_name' 	=> 'required|max:255',
            'email' 		=> 'required|string|email|max:255|unique:users,email,'.$user->id,
		]);

		$user->update([
			'first_name' 	=> request('first_name'),
			'last_name' 	=> request('last_name'),
			'email' 		=> request('email'),
			'avatar' 		=> request('avatar'),
			'genre' 		=> request('genre')
		]);

		return $this->respond('Informations sauvegardées');
	}


	/**
	 * Vérouille ou dévérouille un compte utilisateur
	 *
	 * @param   Entities\User    $user
	 *
	 * @return  Json
	 */
	public function toggleLock(User $user)
	{
		// if((new UserPublishabilityStrategy($user))->isPublishable() || request('locked')){
		if(isPublishable($user) || request('locked')){
			$user->update([
				'locked' => (int)request('locked'),
			]);

			$status = "activé";
			if(request('locked')){ $status = "vérouillé"; }

			return $this->respond(sprintf("%s %s %s", 'Compte de', $user->fullname, $status));
		}

		return $this->respondError("Ce compte ne peut pas être activé. Vérifiez que l'utilisateur possède un nom, un prénom et un email", ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
	}


	/**
	 * Supprime un utilisateur
	 *
	 * @param   User    $user
	 *
	 * @return  [type]         [description]
	 */
	public function destroy(User $user)
	{
		$user->delete();

		return $this->respond('Utilisateur supprimé');
	}


	/**
	 * Retourne une liste formatée des avatars disponibles
	 *
	 * @return  Array
	 */
	public function avatars()
	{
		$genres = Storage::disk('local')->directories('/data/app/avatars');

		$avatars=[];

		foreach($genres as $genre)
		{
			$files = Storage::disk('local')->allFiles($genre);

			foreach($files as $index=>$file){
				$files[$index] = "/".$file;
			}

			$avatars[pathInfo($genre, PATHINFO_FILENAME)] = $files;
		}

		return $avatars;
	}
}
