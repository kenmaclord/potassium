<?php

use Entities\Zone;
use Entities\Traduction;
use Faker\Generator as Faker;

$factory->define(Traduction::class, function (Faker $faker) {
    return [
		'zone_id' => function(){
			return factory(Zone::class)->create();
		},
		'key' => $faker->word
    ];
});
