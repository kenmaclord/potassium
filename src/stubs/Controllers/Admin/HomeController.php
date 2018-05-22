<?php

namespace App\Http\Controllers\Admin;

use Entities\Home;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Strategies\Upload\HomeUploadStrategy;
use App\Strategies\Processing\HomeProcessingStrategy;

class HomeController extends Controller
{
	/**
	* Vue principale des images
	*
	* @return  Json | Illuminate\Support\Facades\View
	*/
	public function index()
	{
		if (request()->wantsJson()){
			return Home::all();
		}

		return view('admin.pages.home.index');
	}

	/**
	* Upload une image
	*
	* @param   HomeUploadStrategy          $homeUploadStrategy
	*
	* @return  String
	*/
	public function store()
	{
		$originalFile = (new HomeUploadStrategy)->run();

		$fileInfos = (new HomeProcessingStrategy($originalFile, 'home', null))->process();

		Home::create([
			"url"     => $fileInfos['folder'],
			"desktop" => 1,
			"mobile"  => 1,
		]);

		if(request()->wantsJson()){
			return $this->respond('Image correctement uploadée');
		}

		return $fileInfos;
	}


	/**
	* Alterne la visibilité d'une image en fonction du type de vsibilité (desktop ou mobile)
	*
	* @param   Entities\Home    $image
	* @param   [type]  $type
	*
	* @return  Json
	*/
	public function toggleVisibility(Home $home, $type)
	{
		$home->update([
			"{$type}" => !$home->{$type}
		]);

		return $this->respond("Visibilité {$type} modifiée");
	}


    /**
	* Supprime une image
	* Pour la suppression complète voir le travail de Entities\Observers\HomeObserver
	*
	* @param   Entities\Home    $home
	*
	* @return  Json
	*/
	public function destroy(Home $home)
	{
		$home->delete();

		return $this->respond('Image supprimée');
	}
}
