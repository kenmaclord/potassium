<?php

namespace Potassium\App\Entities;

use Illuminate\Support\Str;
use Potassium\App\Entities\Zone;
use Potassium\App\Entities\Entity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Potassium\App\Entities\TraductionContent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Traduction extends Entity
{
    /**
     * Relation liant une traduction à sa zone
     *
     * @return  Potassium\App\Entities\Zone
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }


    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::slug($value);
    }


    /**
     * Retourne un tableau avec toutes les traductions du site
     * pour une disponibilité des traductions dans les composants Vue
     *
     * Utilise les infos publiées uniquement
     *
     * @return  Array
     */
    public static function getTranslations($lang=null)
    {
        return Cache::rememberForEver("traductions-{$lang}", function() use($lang) {
            if(is_null($lang)){
                $lang = LaravelLocalization::getCurrentLocale();
            }

            // Copie toutes les traductions de /resources/lang/CURRENT_LOCALE/* dans une variable JS globale
            $lang_files = File::files(resource_path() . '/lang/' . $lang);
            $trans = [];

            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename, [], $lang);
            }

            return $trans;
        });
    }
}
