<?php

use Entities\User;

  /**
   * Forge sans la créer une instance d'un modèle
   *
   * @param  App\Model $class         Classe à instancier
   * @param  Array|null $attributes   Attributs à faire passer à la création
   * @param  Integer $howMany         Nombre d'instances à créer
   *
   * @return Instance
   */
  function make($class, $attributes = [], $howMany=1)
  {
    if($howMany==1){
      return factory($class)->make($attributes);
    }

    return factory($class, $howMany)->make($attributes);
  }


  /**
   * Forge une instance d'un modèle
   *
   * @param  App\Model $class         Classe à instancier
   * @param  Array|null $attributes   Attributs à faire passer à la création
   * @param  Integer $howMany         Nombre d'instances à créer
   *
   * @return Instance
   */
  function create($class, $attributes = [], $howMany=1)
  {
    if($howMany==1){
      return factory($class)->create($attributes);
    }

    return factory($class, $howMany)->create($attributes);
  }
