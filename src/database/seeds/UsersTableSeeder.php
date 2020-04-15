<?php
namespace Potassium\Database\Seeds;

use Potassium\App\Entities\User;
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
            'first_name' => 'Admin',
            'last_name' => 'User',
            'genre' => 'masculin',
            'avatar' => 3,
            'locked' => 0,
            'order' => 0
        ]);
    }
}
