<?php

use Illuminate\Database\Seeder;

class TraductionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('traductions')->truncate();

	    \DB::table('traductions')->insert([
			[
                'id' => 1,
				'zone_id' => 1,
				'key' => 'not-found'
			],
			[
                'id' => 2,
				'zone_id' => 1,
				'key' => 'back-home'
			]
		]);
    }
}
