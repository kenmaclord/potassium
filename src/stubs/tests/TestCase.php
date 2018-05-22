<?php

namespace Tests;

use Entities\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }

    /**
    * Define hooks to migrate the database before and after each test.
    *
    * @return void
    */
    public function runDatabaseMigrations()
    {
        $this->baseRunDatabaseMigrations();
    }


    /**
     * Seed certaines tables de la base de données
     *
     * @return  [type]  [description]
     */
    public function seedMe()
    {
        Artisan::call('db:seed', ['--class' => \TestDatabaseSeeder::class]);
    }


    protected function setUp()
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
    public function signIn($user = null)
    {
        $user = $user ?: create(User::class);

        $this->actingAs($user);

        return $this;
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
    * Créé une request fictive pour alimenter les requêtes POST
    *
    * @return  Illuminate\Http\Request
    */
    protected function fakeRequest($data)
    {
        app()->make(Request::class)->replace($data);
    }
}
