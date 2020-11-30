<?php

namespace Potassium\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Potassium\Database\Seeds\TestDatabaseSeeder;
use Potassium\Tests\utilities\TestHelpers;

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
        Artisan::call('db:seed', ['--class' => TestDatabaseSeeder::class]);
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->seedMe();
    }
}
