<?php

namespace Potassium\App\Traits;

use Potassium\App\Events\ZoneIsPublished;
use Illuminate\Support\Facades\File;

trait Publishable
{
	 /**
	 * Publie les traductions dans des fichiers de langues
	 *
	 * @return Json
	 */
	public function publish($lang)
	{
		$traductions = $this->contentsByLang($lang)->get();

		$formatedData = $this->formatData($traductions);

		$filename = $this->writeTranslationFile($formatedData, $this->slug, $lang);

		event(new ZoneIsPublished($this, $lang));

		return $filename;
	}


	/**
	 * Génère le fichier de traduction en fonction de la langue
	 * passée en paramètres
	 *
	 * @param  String  $data : Data à écrire dans le fichier
	 * @param  String  $zone : Zone de traduction
	 * @param  String  $lang : Langue du fichier à générer
	 *
	 * @return void
	 */
	private function writeTranslationFile($data, $zone, $lang)
	{
		$fileInfos = $this->buildFileName($zone, $lang);

		/** Créé le répertoire de la langue si nécessaire */
		if(!File::isDirectory($fileInfos['langPath'])){
			File::makeDirectory($fileInfos['langPath']);
		}

		/** Efface le fichier complètement s'il existe */
		if(File::exists($fileInfos['filename'])){
			File::delete($fileInfos['filename']);
		}

		/** Écrit le fichier */
		File::put($fileInfos['filename'], $data);

		return $fileInfos['filename'];
	}


	/**
	 * Construit le texte du fichier de langue à partir
	 * du tableau de données d'une zone
	 *
	 * @param  Illuminate\Database\Eloquent\Collection $eloquentData : Tableau des traductions d'une zone
	 *
	 * @return String $formatedData : Contenu du fichier à écrire par les fonctions d'écriture
	 */
	private function formatData($eloquentData)
	{
		$rawData = [];

		foreach ($eloquentData as $traduction) {
			$key = $traduction->traduction->key;
			$rawData[$key] = $traduction->body;
		}

		$formatedData = "<?php".PHP_EOL."return ".PHP_EOL.var_export($rawData,true).";";

		return $formatedData;
	}


	/**
	 * Construit le chemin du fichier à enregister
	 *
	 * @param   [type]  $zone
	 * @param   [type]  $lang
	 *
	 * @return  [type]         [description]
	 */
	private function buildFileName($zone, $lang)
	{
		return [
			'filename' => sprintf("%s/lang/%s/%s.php", resource_path(), $lang, str_slug($zone)),
			'langPath' => sprintf("%s/lang/%s", resource_path(), $lang)
		];
	}
}
