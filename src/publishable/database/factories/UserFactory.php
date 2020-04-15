<?php

use App\Entities\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'api_token' => Str::random(60),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'genre' => $faker->randomElement(['masculin', 'feminin']),
        'avatar' => $faker->numberBetween(1,6),
        'locked' => false,
        'order' => 0,
        'remember_token' => Str::random(10),
    ];
});
