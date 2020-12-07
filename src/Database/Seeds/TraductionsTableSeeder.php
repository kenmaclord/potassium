<?php
namespace Potassium\Database\Seeds;

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
                'key' => 'not-found',
                'content' => json_encode([
                    'fr' => "Désolé, cette page est introuvable",
                    'en' => "Sorry, the page you are looking for could not be found."
                ])
            ],
            [
                'id' => 2,
                'zone_id' => 1,
                'key' => 'back-home',
                'content' => json_encode([
                    'fr' => "Retour à l'accueil",
                    'en' => "Back to home page"
                ])
            ]
        ]);
    }
}
