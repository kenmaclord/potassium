<?php

// @codingStandardsIgnoreStart
namespace Potassium\Tests\Feature;

use Illuminate\Support\Str;
use Potassium\Tests\TestCase;
use Potassium\App\Entities\Zone;
use Illuminate\Support\Facades\File;
use Potassium\App\Entities\Traduction;
use Potassium\App\Events\ZoneIsPublished;
use Potassium\App\Entities\TraductionContent;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ZonesTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function a_zone_tab_exists()
	{
		$this->get('/admin/traductions')
			->assertStatus(200)
			->assertSee('Zones');
	}

	/** @test */
	public function a_zone_can_be_added()
	{
		$this->assertCount(0, Zone::all());

		$this->post('/admin/zones', ['nom' => 'Zone 51']);

		$this->assertCount(1, Zone::all());
	}


	/** @test */
	public function a_zone_must_have_a_name_when_created()
	{
		$this->assertCount(0, Zone::all());

		$this->expectException(ValidationException::class);

		$this->post('/admin/zones', ['nom' => '']);

		$this->assertCount(0, Zone::all());
	}


	/** @test */
	public function the_name_of_a_zone_can_be_modified()
	{
		$zone = factory(Zone::class)->create();

		$newName = "Zone 51";

		$this->put("/admin/zones/{$zone->id}", ['nom' => $newName]);

		$this->assertDatabaseHas('zones', ['nom' => $newName]);

		$this->assertEquals($newName, $zone->fresh()->nom);
	}


	/** @test */
	public function a_zone_must_have_a_name_when_updated()
	{
		$zone = factory(Zone::class)->create();

		$this->expectException(ValidationException::class);

		$this->put("/admin/zones/{$zone->id}", ['nom' => ""]);
	}

	/** @test */
	public function zones_can_be_reordered()
	{
		$zones = factory(Zone::class, 5)
			->create()
			->each(function($zone, $index){
				$zone->order = $index;
				$zone->save();
			});

		$this->put('/admin/zones/reorder/zones', ['newOrder' => [2, 1, 3, 4, 5]]);

		$this->assertEquals(0, $zones->fresh()[1]->order);
		$this->assertEquals(1, $zones->fresh()[0]->order);
		$this->assertEquals(2, $zones->fresh()[2]->order);
		$this->assertEquals(3, $zones->fresh()[3]->order);
		$this->assertEquals(4, $zones->fresh()[4]->order);
	}


	/** @test */
	public function a_zone_can_be_deleted()
	{
		factory(TraductionContent::class, 5)->create();

		$zone = Zone::find(1);

		$this->assertCount(5, Zone::all());
		$this->assertCount(5, Traduction::all());
		$this->assertCount(5, TraductionContent::all());

		$this->delete("/admin/zones/{$zone->id}");

		$this->assertCount(4, Zone::all());
		$this->assertCount(4, Traduction::all());
		$this->assertCount(4, TraductionContent::all());
	}


	/** @test */
	public function it_determine_if_a_zone_is_published()
	{
		factory(TraductionContent::class)
			->create([
				'published' => 1
			])
			->each(function($content){
				factory(TraductionContent::class)->states('ja')->create([
					'traduction_id' => $content->traduction->id,
					'published' => 0
				]);
			});
		$zone = TraductionContent::first()->zone();

		$response = $this->get("/admin/zones/is_published/{$zone->id}/ja")->decodeResponseJson();

		$this->assertTrue($response['fr']);
		$this->assertFalse($response['localized']);
	}

	/** @test */
	public function a_zone_can_be_published()
	{
		$lang = 'en';

		factory(Zone::class)->create();
		factory(TraductionContent::class, 5)->states('publish')->create();

		$zone = Zone::find(1);

		$this->put("/admin/zones/publish/{$zone->id}/{$lang}");

		$this->assertTrue($zone->isPublished($lang));

		$localizationFilePath = resource_path()."/lang/{$lang}/".Str::slug($zone->slug).".php";

		$this->assertFileExists($localizationFilePath);

		File::delete($localizationFilePath);
	}

	/** @test */
	public function an_event_is_fired_when_a_zone_is_published()
	{
		factory(Zone::class)->create();
		factory(TraductionContent::class, 5)->states('publish')->create();

		$zone = Zone::find(1);

		$this->expectsEvents(ZoneIsPublished::class);

		$localizationFilePath = $zone->publish('en');

		File::delete($localizationFilePath);
	}


	public function setUp(): void
	{
		parent::setUp();

		$this->signIn();

		auth()->user()->grant('traductions');

		$this->withoutExceptionHandling();
	}

}
