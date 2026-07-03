<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cancel_order_restores_stock_and_creates_notification(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'category_id' => Category::factory()->create()->id,
            'stock' => 3,
        ]);
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'WC-20260703-8001',
            'status' => 'pending',
            'stock_restored' => false,
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'total' => 65000,
            'shipping_name' => 'Test',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_barcode' => $product->barcode,
            'price' => $product->price,
            'quantity' => 2,
            'subtotal' => $product->price * 2,
        ]);

        app(OrderService::class)->cancelOrder($order);

        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertTrue($order->fresh()->stock_restored);
        $this->assertSame(5, $product->fresh()->stock);
        $this->assertTrue(UserNotification::where('user_id', $user->id)->exists());
    }

    public function test_record_history_does_not_duplicate_step(): void
    {
        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'order_number' => 'WC-20260703-8002',
            'status' => 'pending',
            'subtotal' => 10000,
            'shipping_cost' => 0,
            'total' => 10000,
            'shipping_name' => 'Test',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);

        $service = app(OrderService::class);
        $service->recordHistory($order, 'processing', 'Processing');
        $service->recordHistory($order, 'processing', 'Processing');

        $this->assertSame(1, $order->statusHistories()->where('step_key', 'processing')->count());
    }
}
