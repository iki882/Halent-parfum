<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_orders(): void
    {
        $this->get(route('admin.orders.index'))
            ->assertRedirect(route('login'));
    }

    public function test_customer_cannot_access_admin_orders_or_filament_panel(): void
    {
        $customer = User::factory()->create();
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-TEST-ADMIN-0001',
            'total_price' => 10000,
            'shipping_fee' => 0,
            'customer_name' => 'Test Customer',
            'customer_whatsapp' => '08123456789',
            'customer_email' => 'customer@example.com',
            'shipping_address' => 'Jl. Contoh No. 1',
            'payment_method' => 'seabank',
            'status' => 'pending',
        ]);

        $this->actingAs($customer)
            ->get(route('admin.orders.index'))
            ->assertForbidden();

        $this->get('/admin')->assertForbidden();

        $this->patch(route('admin.orders.updateStatus', $order), [
            'status' => 'completed',
        ])->assertForbidden();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_access_admin_orders_and_filament_panel(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk();

        $this->get('/admin')->assertOk();
    }

    public function test_public_registration_cannot_grant_admin_access(): void
    {
        $this->post(route('register'), [
            'name' => 'New Customer',
            'email' => 'new-customer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_admin' => true,
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'new-customer@example.com',
            'is_admin' => false,
        ]);
    }
}
