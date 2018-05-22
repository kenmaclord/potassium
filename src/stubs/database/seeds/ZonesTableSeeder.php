<?php

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('zones')->truncate();

	    \DB::table('zones')->insert([
			[
                'id' => 1,
                'nom' => 'Application'
				'slug' => 'application'
			]
		]);
    }
}
