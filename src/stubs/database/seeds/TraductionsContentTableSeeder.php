<?php

use Illuminate\Database\Seeder;

class TraductionsContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('traductions_content')->truncate();

	    \DB::table('traductions_content')->insert([
			[
                'traduction_id' => 1,
                'body' => "Désolé, cette page est introuvable",
                'lang' => 'fr'
            ],
            [
                'traduction_id' => 1,
                'body' => "Sorry, the page you are looking for could not be found.",
                'lang' => 'en'
            ],
            [
				'traduction_id' => 2,
				'body' => "Retour à l'accueil",
                'lang' => 'fr'
			],
			[
				'traduction_id' => 2,
				'body' => "Back to home page",
                'lang' => 'en'
			]
		]);
    }
}
