<?php

use Entities\Langue;
use Entities\Traduction;
use Faker\Generator as Faker;
use Entities\TraductionContent;

$factory->define(TraductionContent::class, function (Faker $faker) {
    return [
		'traduction_id' => function(){
			return factory(Traduction::class)->create();
		},
		'body' => $faker->sentence(4),
		'lang' => 'fr',
		'published' => $faker->boolean,
    ];
});


$factory->state(TraductionContent::class, 'en', function (\Faker\Generator $faker) {
	return [
		'lang' => 'en'
	];
});

$factory->state(TraductionContent::class, 'de', function (\Faker\Generator $faker) {
	return [
		'lang' => 'de'
	];
});


$factory->state(TraductionContent::class, 'ja', function (\Faker\Generator $faker) {
	return [
		'lang' => 'ja'
	];
});


$factory->state(TraductionContent::class, 'publish', function (\Faker\Generator $faker) {
	return [
		'traduction_id' => function(){
			return factory(Traduction::class)->create([
				"zone_id" => 1
			]);
		},
		'body' => $faker->sentence(4),
		'lang' => 'en',
		'published' => 0,
	];
});
