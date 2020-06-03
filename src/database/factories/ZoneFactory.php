<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Potassium\App\Entities\Zone;

$factory->define(Zone::class, function (Faker $faker) {
	$nom = $faker->word;

    return [
		'nom' 	=> $nom,
		'slug' 	=> Str::slug($nom),
		'order' => $faker->randomDigit
    ];
});
