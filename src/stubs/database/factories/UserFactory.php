<?php

use Entities\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'genre' => $faker->randomElement(['masculin', 'feminin']),
        'avatar' => $faker->numberBetween(1,6),
        'locked' => false,
        'order' => 0,
        'remember_token' => str_random(10),
    ];
});
