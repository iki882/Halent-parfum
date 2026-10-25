<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('users:set-admin {email : Email address of an existing user} {--revoke : Remove admin access instead of granting it}')]
#[Description('Grant or revoke admin access for an existing user')]
class SetUserAdminAccess extends Command
{
    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $user = User::query()->where('email', $email)->first();

        if ($user === null) {
            $this->error("No user exists with the email [{$email}].");

            return self::FAILURE;
        }

        $isAdmin = ! $this->option('revoke');

        $user->forceFill(['is_admin' => $isAdmin])->save();

        $action = $isAdmin ? 'granted' : 'revoked';
        $this->info("Admin access {$action} for [{$user->email}].");

        return self::SUCCESS;
    }
}
