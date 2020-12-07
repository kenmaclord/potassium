<?php

namespace Potassium\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Initalisation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        $this->withoutExceptionHandling();
    }
}
