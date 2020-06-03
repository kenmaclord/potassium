<?php

namespace Potassium\App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Potassium\App\Entities\Traduction;
use Potassium\App\Events\ZoneIsPublished;

trait Publishable
{
	 /**
	 * Publie les traductions dans des fichiers de langues
	 *
	 * @return Json
	 */
	public function publish($lang)
	{
		$traductions = Traduction::where('zone_id', $this->id)->get();

		$formatedData = $this->formatData($traductions, $lang);

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
	private function formatData($eloquentData, $lang)
	{
		$rawData = [];

		foreach ($eloquentData as $traduction) {
			$key = $traduction->key;

			if (isset(json_decode($traduction->content, true)[$lang])) {
				$rawData[$key] = json_decode($traduction->content, true)[$lang];
			}
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
			'filename' => sprintf("%s/lang/%s/%s.php", resource_path(), $lang, Str::slug($zone)),
			'langPath' => sprintf("%s/lang/%s", resource_path(), $lang)
		];
	}
}
