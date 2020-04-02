<?php

namespace Potassium\App\Providers;

use Potassium\App\Entities\Langue;
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
