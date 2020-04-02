<?php

namespace Potassium\App\Entities;

use Potassium\App\Entities\Zone;
use Potassium\App\Entities\Entity;
use Potassium\App\Entities\TraductionContent;
use Illuminate\Support\Facades\File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Traduction extends Entity
{
    protected $table="traductions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zone_id', 'key'
    ];


    /**
     * Relation liant une traduction à sa zone
     *
     * @return  Potassium\App\Entities\Zone
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }


    /**
     * Relation liant une traduction à son contenu
     *
     * @return  Potassium\App\Entities\TraductionContent
     */
    public function content()
    {
        return $this->hasMany(TraductionContent::class);
    }


    // /**
    //  * Récupère le contenu d'une traduction en fonction d'une langue
    //  *
    //  * @param   String $lang
    //  *
    //  * @return  Potassium\App\Entities\TraductionContent
    //  */
    // public function getContent($lang)
    // {
    //     if (is_null($lang)) {
    //         $lang = LaravelLocalization::getCurrentLocale();
    //     }

    //     return $this->content()->lang($lang)->first();
    // }


    /**
     * Retourne un tableau avec toutes les traductions du site
     * pour une disponibilité des traductions dans les composants Vue
     *
     * @return  Array
     */
    public static function getTranslations($lang=null)
    {
        if(is_null($lang)){
            $lang = LaravelLocalization::getCurrentLocale();
        }

        // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . $lang);
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            $trans[$filename] = trans($filename, [], $lang);
        }

        return $trans;
    }


    /**
    * Filtre les résultats par langue
    *
    * @param   Illuminate\Database\Query\Builder  $query
    * @param   String  $lang
    *
    * @return  Illuminate\Database\Query\Builder
    */
    public function lang($lang=null)
    {
        if(is_null($lang)){
            $lang = config('app.fallback_locale');
        }

        if(!is_null($this->content())){
            $item = $this->content()->lang($lang)->first();
            if(!is_null($item)){
                return $item->body;
            }
        }

        return "";
    }


    /**
     * Ajoute ou modifie le contenu d'une traduction
     *
     * @param  String  $body
     * @param  String  $lang
     */
    public function addOrPatch($body, $lang)
    {
        $this->content()->updateOrCreate([
            'traduction_id' => $this->id,
            'lang' => $lang
            ],
            [
            'body' => $body,
            'lang' => $lang,
            'published' => 0
        ]);
    }
}
