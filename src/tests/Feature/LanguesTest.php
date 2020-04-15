<?php

namespace Potassium\Tests\Feature;

use Potassium\Tests\TestCase;
use Potassium\App\Entities\Langue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LanguesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_langues()
    {
        $langues = $this->json('get', '/admin/traductions/langues')->json();

        $this->assertCount(11, $langues);
    }

    /** @test */
    public function it_toggles_langue_visibility()
    {
        $fr = Langue::where('code','fr')->first();

        $this->assertTrue($fr->visible);

        $this->put('/admin/traductions/langues/visibility/fr', ['visibility'=>0]);

        $this->assertFalse($fr->fresh()->visible);

        $this->put('/admin/traductions/langues/visibility/fr', ['visibility'=>1]);

        $this->assertTrue($fr->fresh()->visible);
    }

    /** @test */
    public function it_toggles_langue_availability()
    {
        $fr = Langue::where('code','fr')->first();

        $this->assertTrue($fr->available);

        $this->put('/admin/traductions/langues/availability/fr', ['availability'=>0]);

        $this->assertFalse($fr->fresh()->available);

        $this->put('/admin/traductions/langues/availability/fr', ['availability'=>1]);

        $this->assertTrue($fr->fresh()->available);
    }


    /**
     * Initalisation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();

        signIn();

        auth()->user()->grant('traductions');

        $this->withoutExceptionHandling();
    }
}




        // Route::put('langues/visibility/{langue}','LanguesController@toggleVisibility');
        // Route::put('langues/availability/{langue}','LanguesController@toggleAvailability');
        // Route::get('langues/available','LanguesController@available');
