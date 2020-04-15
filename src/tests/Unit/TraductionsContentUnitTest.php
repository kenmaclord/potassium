<?php

// @codingStandardsIgnoreStart
namespace Potassium\Tests\Feature;

use Potassium\Tests\TestCase;
use Potassium\App\Entities\Traduction;
use Potassium\App\Entities\TraductionContent;
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
