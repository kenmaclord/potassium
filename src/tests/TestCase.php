<?php

namespace Potassium\Tests;

use Potassium\Database\Seeds\TestDatabaseSeeder;

use Illuminate\Support\Facades\Artisan;
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
        Artisan::call('db:seed', ['--class' => TestDatabaseSeeder::class]);
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->seedMe();
    }
}
