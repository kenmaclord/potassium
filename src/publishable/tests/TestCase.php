<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Tests\utilities\TestHelpers;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers;

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
}
