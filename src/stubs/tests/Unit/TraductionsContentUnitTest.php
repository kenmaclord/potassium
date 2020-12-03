<?php

// @codingStandardsIgnoreStart
namespace Tests\Feature;

use Tests\TestCase;
use Entities\Traduction;
use Entities\TraductionContent;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TraductionsContentUnitTest extends TestCase
{
    use RefreshDatabase;

	/** @test */
	function a_traduction_content_belongs_to_a_traduction()
	{
		$content = factory(TraductionContent::class)->create();

		$this->assertInstanceOf(Traduction::class, $content->traduction);
	}

}
