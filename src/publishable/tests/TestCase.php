<?php

namespace Tests;

use Entities\User;
use Entities\Droit;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Seed certaines tables de la base de données
     *
     * @return  [type]  [description]
     */
    public function seedMe()
    {
        Artisan::call('db:seed', ['--class' => \TestDatabaseSeeder::class]);
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->seedMe();
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
    protected function fakeRequest($data)
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
