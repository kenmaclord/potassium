<?php

// @codingStandardsIgnoreStart
namespace Potassium\Tests\Feature;

use Potassium\Tests\TestCase;

use Potassium\App\Entities\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_user_can_not_log_if_its_account_is_locked()
	{
		$this->withExceptionHandling();

		Auth::logout();

		$user = User::find(1);

		$user->update(['locked' => 1]);

		$this->post('/login', [
			'email' => $user->email,
			'password' => 'potassium'
		]);

		$this->assertFalse(Auth::check());

		$user->update(['locked' => 0]);

		$this->post('/login', [
			'email' => $user->email,
			'password' => 'potassium'
		]);

		$this->assertTrue(Auth::check());
	}

	/** @test */
	function a_user_page_is_existing()
	{
		$this->get('/admin/utilisateurs')
			->assertStatus(200)
			->assertSee('utilisateurs');
	}

	/** @test */
	public function it_fetches_users()
	{
		$response = $this->getJson('/admin/utilisateurs')->json();

		$this->assertCount(1, $response);

		$this->assertArrayHasKey("email", $response[0]);
		$this->assertContains("potassium@gmail.com", $response[0]);
		$this->assertEquals("potassium@gmail.com", $response[0]['email']);
	}


	/** @test */
	public function it_shows_a_user_page()
	{
		$this->get('/admin/utilisateurs/1')
			->assertStatus(200)
			->assertSee('potassium@gmail.com');
	}


	/** @test */
	public function it_delete_a_user()
	{
		factory(User::class)->create();

		$user = User::find(2);

		$this->assertCount(2, User::all());

		$this->delete("/admin/utilisateurs/{$user->id}");

		$this->assertCount(1, User::all());
	}


	/** @test */
	public function it_activate_and_deactivate_a_user()
	{
		$user = User::find(1);

		$this->assertTrue(!$user->isLocked());

		$this->put("/admin/utilisateurs/toggleLock/{$user->id}", ["locked" => 1]);

		$this->assertTrue($user->fresh()->isLocked());
	}


	/** @test */
	public function a_user_can_not_be_activate_if_first_name_is_missing()
	{
		$user = User::find(1);

		$user->update([
			'first_name' => "",
			'locked' => 1
		]);

		$this->put('/admin/utilisateurs/toggleLock/1', [
			'locked' => 0
		])->assertStatus(422);

		$user->update([
			'first_name' => "New Name",
		]);

		$this->put('/admin/utilisateurs/toggleLock/1')->assertStatus(200);
	}


	/** @test */
	public function a_user_can_not_be_activate_if_last_name_is_missing()
	{
		$user = User::find(1);

		$user->update([
			'last_name' => "",
			'locked' => 1
		]);

		$this->put('/admin/utilisateurs/toggleLock/1', [
			'locked' => 0
		])->assertStatus(422);

		$user->update([
			'last_name' => "New Name",
		]);

		$this->put('/admin/utilisateurs/toggleLock/1')->assertStatus(200);
	}


	/** @test */
	public function a_user_can_not_be_activate_if_email_is_missing()
	{
		$user = User::find(1);

		$user->update([
			'email' => "",
			'locked' => 1
		]);

		$this->put('/admin/utilisateurs/toggleLock/1', [
			'locked' => 0
		])->assertStatus(422);

		$user->update([
			'email' => "New Email",
		]);

		$this->put('/admin/utilisateurs/toggleLock/1')->assertStatus(200);
	}


	/** @test */
	public function it_saves_a_user_profile()
	{
		$user = User::find(1);

		$data = [
			'first_name' 	=> "prenom",
			'last_name' 	=> "nom",
			'email' 		=> "email@email.com",
			'avatar' 		=> "5",
			'genre' 		=> "feminin"
		];

		$this->put("/admin/utilisateurs/{$user->id}", $data);

		$this->assertDatabaseHas('users', $data);
	}


	/** @test */
	public function it_fetches_avatars()
	{
		$response = $this->get('/admin/utilisateurs/avatars')->json();

		$file = config('filesystems.data_directory'). "app/avatars/feminin/3.png";

		$this->assertArrayHasKey("feminin", $response);
		$this->assertContains($file, $response['feminin']);
		$this->assertEquals($file, $response['feminin'][2]);
	}


	/** @test */
	public function it_adds_a_user()
	{
		$data = [
			'first_name' => "Jean-Claude",
			'last_name' => "Van Damme"
		];

		$user = $this->post('/admin/utilisateurs', $data);

		$this->assertDatabaseHas('users', $data);
	}

	/** @test */
	public function users_can_be_reordered()
	{
		factory(User::class)->create();

		$this->put('/admin/utilisateurs/reorder/users', ['newOrder' => [2, 1]]);

		$users = User::all();

		$this->assertEquals(0, $users[1]->order);
		$this->assertEquals(1, $users[0]->order);
	}


	public function setUp(): void
	{
		parent::setUp();

		$this->signIn(User::find(1));

		auth()->user()->grant('users');

		$this->withoutExceptionHandling();
	}

}
