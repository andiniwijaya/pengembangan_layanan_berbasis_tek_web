<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesCommerceFixtures;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use CreatesCommerceFixtures;
    use RefreshDatabase;

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewIs('admin.dashboard');
    }

    public function test_admin_can_update_order_status_and_notify_customer(): void
    {
        $customer = User::factory()->create();
        $admin = $this->createAdminUser();
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'WC-20260703-7001',
            'status' => 'pending',
            'subtotal' => 100000,
            'shipping_cost' => 15000,
            'total' => 115000,
            'shipping_name' => 'Test',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => \App\Models\Product::factory()->create()->id,
            'product_name' => 'Item',
            'product_barcode' => 'PRD000001',
            'price' => 100000,
            'quantity' => 1,
            'subtotal' => 100000,
        ]);

        $this->actingAs($admin)->put(route('admin.orders.update-status', $order), [
            'status' => 'processing',
        ])->assertRedirect();

        $this->assertSame('processing', $order->fresh()->status);
        $this->assertTrue(UserNotification::where('user_id', $customer->id)->exists());
    }

    public function test_admin_can_view_orders_index(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin)->get(route('admin.orders.index'))
            ->assertOk()
            ->assertViewIs('admin.orders.index');
    }
}
