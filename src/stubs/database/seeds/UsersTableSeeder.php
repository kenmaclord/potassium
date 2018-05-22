<?php

use Entities\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();

        factory(User::class)->create([
            'email' => 'karl.morisset@gmail.com',
            'password' => bcrypt('A181wF0d'),
            'first_name' => 'Karl',
            'last_name' => 'Morisset',
            'genre' => 'masculin',
            'avatar' => 1,
            'locked' => 0,
            'order' => 0
        ]);

        factory(User::class)->create([
            'email' => 'testuser@gmail.com',
            'password' => bcrypt('testing'),
            'first_name' => 'Test',
            'last_name' => 'User',
            'genre' => 'masculin',
            'avatar' => 2,
            'locked' => 0,
            'order' => 0
        ]);
    }
}
