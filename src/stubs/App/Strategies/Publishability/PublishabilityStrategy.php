<?php

namespace App\Strategies\Publishability;


class PublishabilityStrategy
{

  /**
   * Permet de savoir si on peut publier une entité
   * Pour cela, les conditions désignées dans la variable $conditions doivent
   * toutes être true
   *
   * @return  Boolean
   */
  public function isPublishable()
  {
    $result = true;

    foreach ($this->conditions as $c) {
      $result = call_user_func([$this, $c]) && $result;
    }

    return $result;
  }

}