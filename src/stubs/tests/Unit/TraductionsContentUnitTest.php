<?php

// @codingStandardsIgnoreStart
namespace Tests\Feature;

use Tests\TestCase;
use Entities\Traduction;
use Entities\TraductionContent;

class TraductionsContentUnitTest extends TestCase
{
	/** @test */
	function a_traduction_content_belongs_to_a_traduction()
	{
		$content = factory(TraductionContent::class)->create();

		$this->assertInstanceOf(Traduction::class, $content->traduction);
	}

}
