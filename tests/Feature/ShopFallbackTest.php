<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ShopFallbackTest extends TestCase
{
    public function test_shop_shows_filtered_backup_products_when_database_is_unavailable(): void
    {
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => '127.0.0.1',
            'database.connections.mysql.port' => '1',
            'database.connections.mysql.database' => 'halent_test',
            'database.connections.mysql.username' => 'root',
            'database.connections.mysql.password' => '',
            'services.whatsapp.business_phone' => '6283131604835',
        ]);
        DB::purge('mysql');

        $this->get(route('shop', ['category' => 'women-series']))
            ->assertOk()
            ->assertSee('Menampilkan katalog cadangan')
            ->assertSee('Black Opium')
            ->assertDontSee('Ventus')
            ->assertSee('Beli Sekarang')
            ->assertSee(route('checkout', 'black-opium'), false);

        $user = new User(['name' => 'Test Customer']);
        $user->id = 1;

        $this->actingAs($user)
            ->get(route('shop', ['category' => 'women-series']))
            ->assertOk()
            ->assertSee('Halo, Test Customer. Temukan aroma favoritmu hari ini.');
    }

    public function test_backup_product_opens_checkout_when_database_is_unavailable(): void
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
        $user = new User(['name' => 'Test Customer', 'email' => 'customer@example.com']);
        $user->id = 1;

        $this->actingAs($user)
            ->get(route('checkout', 'black-opium'))
            ->assertOk()
            ->assertSee('Checkout Pembelian')
            ->assertSee('Black Opium')
            ->assertSee('SeaBank')
            ->assertSee('GoPay / QRIS')
            ->assertSee('Kirim Pesanan via WhatsApp');

        $response = $this->post(route('checkout.fallback.store'), [
            'product' => 'black-opium',
            'customer_name' => 'Test Customer',
            'customer_whatsapp' => '08123456789',
            'customer_email' => 'customer@example.com',
            'shipping_address' => 'Jl. Contoh No. 1',
            'payment_method' => 'gopay',
        ]);

        $response->assertRedirect();

        $destination = parse_url($response->headers->get('Location'));
        parse_str($destination['query'], $query);

        $this->assertSame('api.whatsapp.com', $destination['host']);
        $this->assertSame('6283131604835', $query['phone']);
        $this->assertStringContainsString('Black Opium', $query['text']);
        $this->assertStringContainsString('GoPay / QRIS', $query['text']);
        $this->assertStringContainsString('Jl. Contoh No. 1', $query['text']);
    }
}
