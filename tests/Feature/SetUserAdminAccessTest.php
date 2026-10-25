<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetUserAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_grants_and_revokes_admin_access(): void
    {
        $user = User::factory()->create();

        $this->artisan('users:set-admin', ['email' => $user->email])
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => true,
        ]);

        $this->artisan('users:set-admin', [
            'email' => $user->email,
            '--revoke' => true,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => false,
        ]);
    }

    public function test_command_fails_when_user_does_not_exist(): void
    {
        $this->artisan('users:set-admin', ['email' => 'missing@example.com'])
            ->assertExitCode(1);
    }
}
