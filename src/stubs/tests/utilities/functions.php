<?php

use Entities\User;

  /**
   * Forge sans la créer une instance d'un modèle
   *
   * @param  App\Model $class      [description]
   * @param  Array|null $attributes : Attributs à faire passer à la création
   * @return Instance
   */
  function make($class, $howMany=1, $attributes = [])
  {
    if($howMany==1){
      return factory($class)->make($attributes);
    }

    return factory($class, $howMany)->make($attributes);
  }


  /**
   * Forge une instance d'un modèle
   *
   * @param  App\Model $class      [description]
   * @param  Array|null $attributes : Attributs à faire passer à la création
   * @return Instance
   */
  function create($class, $howMany=1, $attributes = [])
  {
    if($howMany==1){
      return factory($class)->create($attributes);
    }

    return factory($class, $howMany)->create($attributes);
  }
