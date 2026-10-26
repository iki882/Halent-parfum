<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthDatabaseUnavailableTest extends TestCase
{
    public function test_login_returns_a_clear_error_when_database_is_unavailable(): void
    {
        $this->useUnavailableDatabase();

        $this->from(route('login'))->post(route('login'), [
            'email' => 'customer@example.com',
            'password' => 'password123',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email' => 'Login sementara tidak tersedia karena koneksi database bermasalah. Silakan coba lagi nanti.']);
    }

    public function test_registration_returns_a_clear_error_when_database_is_unavailable(): void
    {
        $this->useUnavailableDatabase();

        $this->from(route('register'))->post(route('register'), [
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors(['email' => 'Pendaftaran sementara tidak tersedia karena koneksi database bermasalah. Silakan coba lagi nanti.']);
    }

    private function useUnavailableDatabase(): void
    {
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => '127.0.0.1',
            'database.connections.mysql.port' => '1',
            'database.connections.mysql.database' => 'halent_test',
            'database.connections.mysql.username' => 'root',
            'database.connections.mysql.password' => '',
        ]);
        DB::purge('mysql');
    }
}
