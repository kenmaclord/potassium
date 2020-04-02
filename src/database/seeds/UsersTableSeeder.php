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
            'email' => 'potassium@gmail.com',
            'password' => bcrypt('potassium'),
            'first_name' => 'Test',
            'last_name' => 'User',
            'genre' => 'masculin',
            'avatar' => 2,
            'locked' => 0,
            'order' => 0
        ]);
    }
}
