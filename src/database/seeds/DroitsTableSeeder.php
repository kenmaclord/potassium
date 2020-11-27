<?php

namespace Potassium\Database\Seeds;

use Potassium\App\Entities\User;
use Potassium\App\Entities\Droit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DroitsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('droits')->truncate();
		\DB::table('droit_user')->truncate();

		$user  = User::first();

		$droit = factory(Droit::class)->create([
			'slug' => 'users',
			'description' => 'Gérer les utilisateurs'
		]);
		$user->droits()->attach($droit);


		$droit = factory(Droit::class)->create([
			'slug' => 'traductions',
			'description' => 'Gérer les traductions'
		]);
		$user->droits()->attach($droit);
	}
}


