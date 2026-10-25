<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_products_are_visible_to_guests_and_authenticated_customers(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();

        $this->get(route('shop'))
            ->assertOk()
            ->assertViewIs('components.shop')
            ->assertSee('Water Kiss Eau De Parfum')
            ->assertSee('Ventus');

        $this->actingAs($user)
            ->get(route('shop'))
            ->assertOk()
            ->assertSee('Water Kiss Eau De Parfum')
            ->assertSee('Ventus');
    }
}
