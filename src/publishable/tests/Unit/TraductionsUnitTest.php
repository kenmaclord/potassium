<?php

// @codingStandardsIgnoreStart
namespace Tests\Feature;

use Entities\Zone;
use Tests\TestCase;
use Entities\Traduction;
use Entities\TraductionContent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TraductionsUnitTest extends TestCase
{
    use RefreshDatabase;

	/** @test */
	function a_traduction_belongs_to_a_zone()
	{
		$traduction = factory(Traduction::class)->create();

		$this->assertInstanceOf(Zone::class, $traduction->zone);
	}


	/** @test */
	public function a_traduction_has_a_content()
	{
		$content = factory(TraductionContent::class)->create();

		$this->assertInstanceOf(Collection::class, $content->traduction->content);

		$this->assertInstanceOf(TraductionContent::class, $content->traduction->content[0]);

		$this->assertInstanceOf(Traduction::class, $content->traduction);
	}


	/** @test */
	public function it_gets_the_content_by_lang()
	{
		$content = factory(TraductionContent::class)->create([
			'lang' => 'fr'
		]);

		$content2 = factory(TraductionContent::class)->create([
			'traduction_id' => $content->traduction->id,
			'lang' => 'en'
		]);

		$traduction = $content->traduction->appendContent('en');

		$this->assertEquals($content2->body, $traduction->content[0]->body);
	}

}
