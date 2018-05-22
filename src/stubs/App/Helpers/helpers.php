<?php

	function isPublishable($entity)
	{
		$namespace = 'App\\Strategies\\Publishability\\';
		$classname = str_replace("Entities\\", '', get_class($entity)).'PublishabilityStrategy';

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
