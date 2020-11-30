<?php

namespace Tests\utilities;


use Potassium\App\Entities\User;
use Potassium\App\Entities\Droit;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


trait TestHelpers
{
   /**
   * Forge sans la créer une instance d'un modèle
   *
   * @param  App\Model $class         Classe à instancier
   * @param  Array|null $attributes   Attributs à faire passer à la création
   * @param  Integer $howMany         Nombre d'instances à créer
   *
   * @return Instance
   */
  public function make($class, $attributes = [], $howMany=1)
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
  public function create($class, $attributes = [], $howMany=1)
  {
    if($howMany==1){
      return factory($class)->create($attributes);
    }

    return factory($class, $howMany)->create($attributes);
  }


    /**
    * Créé un utilisateur et le log in
    *
    * @param  App\Models\User|null $user : Utilisateur à logger
    * @return Void
    */
    public function signIn($user = null, $model=User::class, $guard='web')
    {
        $user = $user ?: create($model);

        $this->actingAs($user, $guard);

        return $this;
    }

    /**
     * Ajoute un droit à la base et l'attribue à l'utilisateur connecté
     *
     * @param  String  $droit
     */
    public function addDroit($droit)
    {
        $droit = create(Droit::class, 1, [
            'slug' => $droit,
            'description' => ""
        ]);
    }

    /**
     * Créé une image et l'associe à un modèle
     *
     * @return  String : Le nom de l'image uploadée
    */

    public function addImage($route, $id=null, $json=false)
    {
        $image = UploadedFile::fake()->image('avatar.jpg');

        if($json){
            return $this->json('post', "{$route}/{$id}", ['file' => $image])->json()['extraData'];
        }

        return $this->post("{$route}/{$id}", ['file' => $image])->json()['filename'];
    }

    /**
     * Créé un fichier et l'associe à un modèle si nécessaire
     *
     * @return  String : Le nom du fichier uploadé
    */

    public function addFile($route, $id=null, $json=false)
    {
        $sizeInKilobytes = 1200;

        $file = UploadedFile::fake()->create('document.pdf', $sizeInKilobytes);

        if($json){
            return $this->json('post', "{$route}/{$id}", ['file' => $file])->json()['extraData'];
        }

        return $this->post("{$route}/{$id}", ['file' => $file]);
    }


    /**
    * Créé une request fictive pour alimenter les requêtes POST
    *
    * @return  Illuminate\Http\Request
    */
    public function fakeRequest($data)
    {
        app()->make(Request::class)->replace($data);
    }


    /**
     * Ajoute le token API à chaque requête
     *
     * @param  String $url
     * @return  String
     */
    public function setApiUrl($url)
    {
        return "{$url}?api_token=".auth()->user()->api_token;
    }
}
