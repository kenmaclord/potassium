<?php

use Illuminate\Support\Facades\Cache;

    function isPublishable($entity)
    {
        $namespace = 'App\\Strategies\\Publishability\\';
        $classname = str_replace("App\\Entities\\", '', get_class($entity)).'PublishabilityStrategy';

        $publishabilityClass = $namespace.$classname;

        return (new $publishabilityClass($entity))->isPublishable();
    }


    /**
     * Dépublie une instance
     *
     * @param Illuminate\Database\Eloquent\Model $entity
     * @param String                             $field
     *
     * @return  Void
     */
    function unPublish($entity, $field='visible')
    {
        $entity->update([$field => 0]);
    }


    /**
     * Vérifie si une entité est publiable, et si ce n'est pas le cas
     * la rend indisponible
     *
     * @param Illuminate\Database\Eloquent\Model $entity
     * @param String                             $field
     */
    function setPublishableState($entity, $field="visible")
    {
        if(!isPublishable($entity)) {
            unPublish($entity, $field);
        }
    }


    /**
     * Obfuscate a string to prevent spam-bots from sniffing it.
     *
     * @param string $value
     *
     * @return string
     */
    function obfuscate($value)
    {
        $safe = '';

        foreach (str_split($value) as $letter) {
            if (ord($letter) > 128) {
                return $letter;
            }

            // To properly obfuscate the value, we will randomly convert each letter to
            // its entity or hexadecimal representation, keeping a bot from sniffing
            // the randomly obfuscated letters out of the string on the responses.
            switch (rand(1, 3)) {
                case 1:
                    $safe .= '&#' . ord($letter) . ';';
                    break;

                case 2:
                    $safe .= '&#x' . dechex(ord($letter)) . ';';
                    break;

                case 3:
                    $safe .= $letter;
            }
        }

        return $safe;
    }

    /**
     * Fonction microtime en float
     *
     * @return  [type]  [description]
     */
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    function duration($start)
    {
        return (microtime_float() - $start)*1000 ." ms";
    }

    /**
     * Retourne la visibilité d'une instance
     *
     * @param   Entities\Entity $entity
     *
     * @return  Boolean
     */
    function visible($entity)
    {
        return $entity->visible == 1;
    }

    /**
     * Récupère les valeurs des champs ENUM
     *
     * @param   String  $table
     * @param   String  $field
     *
     * @return  Array
     */
    function getEnumValues($table, $field)
    {
        return Illuminate\Support\Facades\Cache::rememberForEver($field, function () use($table, $field){
            $data = \DB::select(\DB::raw('SHOW COLUMNS FROM '.$table.' WHERE Field = "'.$field.'"'))[0]->Type;

            preg_match('/^enum\((.*)\)$/', $data, $matches);
            $values = array();
            foreach(explode(',', $matches[1]) as $value){
                $values[] = trim($value, "'");
            }

            return $values;
        });
    }


    /**
     * Géolocalise une adresse
     *
     * @return  Json
     */
    function geolocalize()
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json";
        $address="address=".urlencode(request('address'));
        $key = "key=".config('services.google_map.key');

        $curl = curl_init("{$url}?{$address}&{$key}");

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        return json_encode($result);
    }


    /**
     * Retourne le contenu localisé d'un élément
     *
     * @param   [type]  $content
     * @param   [type]  $lang
     *
     * @return  [type]            [description]
     */
    function localized($content, $lang){

        return $content->filter(function($trans) use($lang){
            return $trans->lang == $lang;
        })->first();
    }


    /**
     * Tronque une chaîne de caractères après un certain nombre de mots
     * Se différencie de str_limit qui foncionne avec un nombre de caractères
     */
    function truncate($string, $words, $end){
        return implode(' ', collect(explode(" ", $string))->filter(function($value, $key) use($words){
            return $key <= $words - 1;
        })->toArray()) . $end;
    }


    /**
     * Supprime le cache pour une clé
     *
     * @param   String  $key
     *
     * @return  void
     */
    function bustCache($key)
    {
        Cache::forget($key);
    }
