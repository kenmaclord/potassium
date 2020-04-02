<?php

use Illuminate\Database\Seeder;

class LanguesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('langues')->truncate();

	    \DB::table('langues')->insert([
			[
				'id' => 1,
				'nom' => 'Français',
				'traduction' => 'Français',
				'code' => 'fr',
				'fullCode' => 'fr-FR',
				'visible' => 1,
				'available' => 1,
				'order' => 0
			],

			[
				'id' => 2,
				'nom' => 'Anglais',
				'traduction' => 'English',
				'code' => 'en',
				'fullCode' => 'en-GB',
				'visible' => 1,
				'available' => 1,
				'order' => 1,
			],

			[
				'id' => 3,
				'nom' =>  'Allemand',
				'traduction' =>  'Deutsch',
				'code' =>  'de',
				'fullCode' =>  'de-DE',
				'visible' =>  0,
				'available' =>  0,
				'order' =>  2,
			],

			[
				'id' => 4,
				'nom' => 'Italien',
				'traduction' => 'Italiano',
				'code' => 'it',
				'fullCode' => 'it-IT',
				'visible' => 0,
				'available' => 0,
				'order' => 3,
			],

			[
				'id' => 5,
				'nom' => 'Espagnol',
				'traduction' => 'Español',
				'code' => 'es',
				'fullCode' => 'es-ES',
				'visible' => 0,
				'available' => 0,
				'order' => 4,
			],

			[
				'id' => 6,
				'nom' => 'Chinois',
				'traduction' => '中文',
				'code' => 'zh',
				'fullCode' => 'zh-CN',
				'visible' => 0,
				'available' => 0,
				'order' => 5
			],

			[
				'id' => 7,
				'nom' => 'Portugais',
				'traduction' => 'Português ',
				'code' => 'pt',
				'fullCode' => 'pt-PT',
				'visible' => 0,
				'available' => 0,
				'order' => 6,
			],

			[
				'id' => 8,
				'nom' => 'Japonais',
				'traduction' => '日本語',
				'code' => 'ja',
				'fullCode' => 'ja',
				'visible' => 0,
				'available' => 0,
				'order' => 7,
			],

			[
				'id' => 9,
				'nom' => 'Arabe',
				'traduction' => 'العربية',
				'code' => 'ar',
				'fullCode' => 'ar-SA',
				'visible' => 0,
				'available' => 0,
				'order' => 8,
			],

			[
				'id' => 10,
				'nom' => 'Russe',
				'traduction' => 'Pусский язык',
				'code' => 'ru',
				'fullCode' => 'ru-RU',
				'visible' => 0,
				'available' => 0,
				'order' => 9,
			],

			[
				'id' => 11,
				'nom' => 'Polonais',
				'traduction' => 'Polski',
				'code' => 'pl',
				'fullCode' => 'pl',
				'visible' => 0,
				'available' => 0,
				'order' => 10,
			]
	    ]);
	}
}
