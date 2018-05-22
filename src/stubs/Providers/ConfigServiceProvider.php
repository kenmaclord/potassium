<?php namespace App\Providers;

use Entities\Langue;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider {

	public function register()
	{
		if(env('APP_ENV')!='testing'){
			config([
				'laravellocalization.supportedLocales' => Langue::getFormatedVisibleLanguages(),

				'laravellocalization.useAcceptLanguageHeader' => true,

				'laravellocalization.hideDefaultLocaleInURL' => false
			]);
		}
	}
}
