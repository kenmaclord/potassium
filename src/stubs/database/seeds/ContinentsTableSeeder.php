<?php

use Illuminate\Database\Seeder;

class ContinentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('continents')->truncate();

	    \DB::table('continents')->insert([
			[
				'slug' => 'afrique',
				'name' => 'Afrique'
			],
			[
				'slug' => 'ameriques',
				'name' => 'Amériques'
			],
			[
				'slug' => 'asie',
				'name' => 'Asie'
			],
			[
				'slug' => 'europe',
				'name' => 'Europe'
			],
			[
				'slug' => 'oceanie',
				'name' => 'Océanie'
			]
		]);
    }
}
