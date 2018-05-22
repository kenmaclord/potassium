<?php

// @codingStandardsIgnoreStart
namespace Tests\Feature;

use Tests\TestCase;
use Entities\Traduction;
use Entities\TraductionContent;
use Illuminate\Validation\ValidationException;

class TraductionsTest extends TestCase
{
	/** @test */
	function a_traductions_page_is_visible()
	{
		$this->get('/admin/traductions')
			->assertStatus(200)
			->assertSee('Traductions');
	}


	/** @test */
	public function it_fetch_data_by_zone()
	{
		$content = factory(TraductionContent::class)->create();
		$zone = $content->traduction->zone;

		factory(Traduction::class, 5)->create([
			'zone_id' => $zone->id
		]);

		$response = $this->getJson('/admin/traductions')->decodeResponseJson();

		$this->assertArrayHasKey($zone->nom, $response);

		$this->assertCount(6, $response[$zone->nom]);
	}


	/** @test */
	public function it_fetch_data_by_zone_with_the_correct_language_data()
	{
		factory(TraductionContent::class)
			->create()
			->each(function($content){
				factory(TraductionContent::class)->states('en')->create([
					'traduction_id' => $content->traduction->id
				]);

				factory(TraductionContent::class)->states('de')->create([
					'traduction_id' => $content->traduction->id
				]);
			});

		$traduction = TraductionContent::first()->traduction;

		$zone = $traduction->zone;
		$response = $this->getJson('/admin/traductions?lang=de')->decodeResponseJson();

		$this->assertArraySubset([
			'localized' => $traduction->lang('de')
		], $response[$zone->nom][0]);
	}

	/** @test */
	public function it_fetchs_data_by_zone()
	{
		$content = factory(TraductionContent::class)->create([
			'lang' => 'fr'
		]);

		$zone = $content->traduction->zone;

		factory(Traduction::class, 5)->create([
			'zone_id' => $zone->id
		]);

		$response = $this->getJson('/admin/traductions', ['lang' => 'fr'])->decodeResponseJson();

		$this->assertArrayHasKey($zone->nom, $response);

		$this->assertCount(6, $response[$zone->nom]);
	}

	/** @test */
	public function a_key_and_can_be_added()
	{
		$content = factory(TraductionContent::class)->create();
		$zone = $content->traduction->zone;

		$key = "new_key_Agrémentée-d'accent_et de majuscule_etd'espace_et_d'apostrophe";

		$payload = [
			'zone_id' 	=> $zone->id,
			'key' 		=> $key
		];

		$this->post('/admin/traductions', $payload);

		$this->assertDatabaseHas('traductions', [
			'zone_id' 	=> $zone->id,
			'key' 		=> str_slug($key)
		]);
	}

	/** @test */
	public function a_traduction_must_have_a_key()
	{
		$content = factory(TraductionContent::class)->create();
		$zone = $content->traduction->zone;

		$payload = [
			'zone_id' 	=> $zone->id,
			'key' 		=> ""
		];

		$this->expectException(ValidationException::class);

		$this->post('/admin/traductions', $payload);
	}


	/** @test */
	public function a_traduction_must_have_a_zone()
	{
		$content = factory(TraductionContent::class)->create();
		$zone = $content->traduction->zone;

		$payload = [
			'zone_id' 	=> "",
			'key' 		=> "new_key"
		];

		$this->expectException(ValidationException::class);

		$this->post('/admin/traductions', $payload);
	}

	/** @test */
	public function a_traduction_must_have_an_zone_id()
	{
		$content = factory(TraductionContent::class)->create();
		$zone = $content->traduction->zone;

		$payload = [
			'zone_id' 	=> 54,
			'key' 		=> "new_key"
		];

		$this->expectException(ValidationException::class);

		$this->post('/admin/traductions', $payload);
	}

	/** @test */
	public function it_fetchs_langue_infos()
	{
		$response = $this->get('/admin/traductions/langue?lang=en')->decodeResponseJson();

		$this->assertEquals('English', $response['localized']['traduction']);
	}


	/** @test */
	public function a_translation_can_be_modified()
	{
		factory(TraductionContent::class)
			->create()
			->each(function($content){
				factory(TraductionContent::class)->states('en')->create([
					'traduction_id' => $content->traduction->id
				]);

				factory(TraductionContent::class)->states('de')->create([
					'traduction_id' => $content->traduction->id
				]);
			});

		$traduction = TraductionContent::first()->traduction;
		$traduction_before = $traduction;

		$newBody = "new body";

		$this->put("/admin/traductions/content/{$traduction->id}", ['de' => $newBody]);

		$this->assertEquals($traduction_before->key, $traduction->fresh()->key);
		$this->assertEquals($traduction_before->zone, $traduction->fresh()->zone);

		$this->assertEquals($traduction_before->id, $traduction->fresh()->content()->lang('de')->first()->traduction_id);
		$this->assertEquals("de", $traduction->fresh()->content()->lang('de')->first()->lang);
		$this->assertEquals($newBody, $traduction->fresh()->lang('de'));
	}


	/** @test */
	public function a_translation_can_be_deleted()
	{
		$content = factory(TraductionContent::class)->create();
		$traduction = $content->traduction;

		$this->assertEquals(1, Traduction::count());
		$this->assertEquals(1, TraductionContent::count());

		$this->assertDatabaseHas('traductions', [
			'id' => $traduction->id
		]);

		$this->delete("/admin/traductions/{$traduction->id}");

		$this->assertDatabaseMissing('traductions', [
			'id' => $traduction->id
		]);

		$this->assertEquals(0, Traduction::count());
		$this->assertEquals(0, TraductionContent::count());
	}


	public function setUp()
	{
		parent::setUp();

		$this->signIn();

        auth()->user()->grant('traductions');

		$this->withoutExceptionHandling();
	}

}
