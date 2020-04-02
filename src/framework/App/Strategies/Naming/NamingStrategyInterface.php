<?php

namespace Potassium\App\Strategies\Naming;

interface NamingStrategyInterface
{

  /**
   * Strategie de nommage
   *
   * @return  String
   */
  public function name();


  /**
   * Chemin d'enregistrement
   *
   * @return  String
   */
  public function path();



  /**
   * Renommage d'un fichier
   *
   * @return  void
   */
  public function rename();
}
