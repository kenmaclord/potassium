<?php

use Entities\Droit;
use Faker\Generator as Faker;

$factory->define(Droit::class, function (Faker $fake) {
    return [
		'slug' => $fake->word,
		'description' =>$fake->sentence(5)
    ];
});
