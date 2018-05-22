<?php

namespace Tests\Unit;

use Entities\User;
use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUnitTest extends TestCase
{
    /** @test */
    public function a_user_has_a_full_name()
    {
        $this->signIn();

        $this->assertEquals(
            sprintf("%s %s", auth()->user()->first_name, auth()->user()->last_name),
            auth()->user()->fullname
        );
    }

    /** @test */
    public function a_user_has_an_avatar()
    {
        $this->signIn();

        $this->assertTrue(File::exists(public_path().'/'.auth()->user()->avatarPath));
    }


    /** @test */
    public function a_user_can_be_locked()
    {
        $user = User::find(1);

        $user->update(['locked'=>0]);

        $this->assertFalse($user->fresh()->isLocked());

        $user->update(['locked'=>1]);

        $this->assertTrue($user->fresh()->isLocked());
    }


    /** @test */
    public function a_right_can_be_granted_and_revoked_to_a_user()
    {
        $user = User::find(1);

        $user->grant('users');

        $this->assertTrue($user->canManage('users'));

        $user->revoke('users');

        $this->assertFalse($user->canManage('users'));
    }
}
