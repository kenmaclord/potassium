<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        if(env('APP_ENV') != 'testing'){
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // Seeders
        $this->call(UsersTableSeeder::class);

        $this->call(DroitsTableSeeder::class);

        $this->call(ContinentsTableSeeder::class);

        $this->call(PaysTableSeeder::class);

        $this->call(LanguesTableSeeder::class);

        $this->call(ZonesTableSeeder::class);
        $this->call(TraductionsTableSeeder::class);
        $this->call(TraductionsContentTableSeeder::class);

        if(env('APP_ENV') != 'testing'){
            //enable foreign key check for this connection before running seeders
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
