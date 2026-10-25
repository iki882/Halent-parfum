<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_customer_can_place_an_order_at_the_database_price(): void
    {
        config()->set('services.whatsapp.business_phone', '6283131604835');

        $user = User::factory()->create();
        $product = $this->createProduct();

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'product' => $product->slug,
            'customer_name' => 'Test Customer',
            'customer_whatsapp' => '08123456789',
            'customer_email' => 'customer@example.com',
            'shipping_address' => 'Jl. Contoh No. 1',
            'payment_method' => 'seabank',
            'price' => 1,
        ]);

        $order = Order::query()->firstOrFail();

        $response->assertRedirect();

        $destination = parse_url($response->headers->get('Location'));
        parse_str($destination['query'], $query);

        $this->assertSame('api.whatsapp.com', $destination['host']);
        $this->assertSame('/send', $destination['path']);
        $this->assertSame('6283131604835', $query['phone']);
        $this->assertSame(
            "Halo Halent Parfum, saya ingin mengonfirmasi pesanan.\n\n"
                ."*Nomor pesanan:* {$order->order_number}\n"
                ."*Nama:* Test Customer\n"
                ."*WhatsApp pembeli:* 08123456789\n"
                ."*Email:* customer@example.com\n"
                ."*Produk:* Water Kiss\n"
                ."*Jumlah:* 1\n"
                ."*Harga produk:* Rp 47.679\n"
                ."*Ongkos kirim:* Rp 15.000\n"
                ."*Total pembayaran:* Rp 62.679\n"
                ."*Metode pembayaran:* SeaBank (Transfer Rekening)\n"
                ."*Alamat pengiriman:*\n"
                .'Jl. Contoh No. 1',
            $query['text']
        );

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'total_price' => '62679.00',
            'shipping_fee' => '15000.00',
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => '47679.00',
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 1,
        ]);
    }

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = $this->createProduct();
        $order = Order::create([
            'user_id' => $owner->id,
            'order_number' => 'ORD-TEST-0001',
            'total_price' => 62679,
            'shipping_fee' => 15000,
            'customer_name' => 'Test Customer',
            'customer_whatsapp' => '08123456789',
            'customer_email' => 'customer@example.com',
            'shipping_address' => 'Jl. Contoh No. 1',
            'payment_method' => 'seabank',
            'status' => 'pending',
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 47679,
        ]);

        $this->actingAs($otherUser)
            ->get(route('orders.show', $order))
            ->assertNotFound();
    }

    public function test_customer_cannot_order_a_product_without_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 0);

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'product' => $product->slug,
                'customer_name' => 'Test Customer',
                'customer_whatsapp' => '08123456789',
                'customer_email' => 'customer@example.com',
                'shipping_address' => 'Jl. Contoh No. 1',
                'payment_method' => 'seabank',
            ])
            ->assertSessionHasErrors('product');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 0,
        ]);
    }

    public function test_shop_is_public_but_checkout_requires_authentication(): void
    {
        $product = $this->createProduct();

        $this->get(route('shop'))
            ->assertOk()
            ->assertSee($product->name);

        $this->get(route('checkout', $product->slug))
            ->assertRedirect(route('login'));
    }

    public function test_homepage_is_available_to_guests_and_customers(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('pages.home');

        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('pages.home');
    }

    public function test_successful_login_redirects_to_home(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('home'));
    }

    public function test_login_returns_customer_to_requested_checkout(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $this->get(route('checkout', $product->slug))
            ->assertRedirect(route('login'));

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('checkout', $product->slug));
    }

    public function test_successful_registration_redirects_to_home(): void
    {
        $this->post(route('register'), [
            'name' => 'New Customer',
            'email' => 'new-customer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'new-customer@example.com',
        ]);
    }

    private function createProduct(int $stock = 2): Product
    {
        $brand = Brand::create([
            'name' => 'Halent Signature',
            'slug' => 'halent-signature',
        ]);
        $category = Category::create([
            'name' => 'Women Series',
            'slug' => 'women-series',
        ]);

        return Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Water Kiss',
            'slug' => 'water-kiss',
            'price' => 47679,
            'stock' => $stock,
            'is_active' => true,
        ]);
    }
}
