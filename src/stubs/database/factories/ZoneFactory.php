<?php

use Entities\Zone;
use Faker\Generator as Faker;

$factory->define(Zone::class, function (Faker $faker) {
	$nom = $faker->word;

    return [
		'nom' 	=> $nom,
		'slug' 	=> str_slug($nom),
		'order' => $faker->randomDigit
    ];
});
