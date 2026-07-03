<?php

namespace Tests\Feature\Checkout;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreatesCommerceFixtures;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use CreatesCommerceFixtures;
    use RefreshDatabase;

    public function test_guest_cannot_access_checkout(): void
    {
        $this->get(route('checkout.index'))->assertRedirect(route('login'));
    }

    public function test_checkout_redirects_when_cart_is_empty(): void
    {
        [$user] = $this->createCustomerWithCart();
        $user->cart->items()->delete();

        $this->actingAs($user)->get(route('checkout.index'))
            ->assertRedirect(route('cart.index'));
    }

    public function test_customer_can_checkout_with_cod(): void
    {
        $this->seedShippingSetting();
        [$user, $product] = $this->createCustomerWithCart();

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 1',
            'payment_method' => 'cod',
        ]);

        $order = Order::where('user_id', $user->id)->first();
        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'method' => 'cod',
        ]);
        $this->assertSame(19, $product->fresh()->stock);
    }

    public function test_customer_can_checkout_with_bank_transfer(): void
    {
        $this->seedShippingSetting();
        [$user] = $this->createCustomerWithCart();

        $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 1',
            'payment_method' => 'bank_transfer',
        ])->assertRedirect();

        $payment = Payment::whereHas('order', fn ($q) => $q->where('user_id', $user->id))->first();
        $this->assertSame('bank_transfer', $payment->method);
        $this->assertDatabaseHas('order_status_histories', ['step_key' => 'waiting_payment']);
    }

    /**
     * QRIS checkout — dijalankan penuh di MySQL (development & production).
     *
     * Skip HANYA pada SQLite in-memory (phpunit.xml) karena migration enum
     * `payments.method` untuk nilai `qris` di-apply via ALTER TABLE MySQL saja
     * (lihat 2026_07_02_000011_update_payments_method_qris.php).
     * Ini perbedaan dukungan schema test vs runtime, bukan bug aplikasi.
     */
    public function test_customer_can_checkout_with_qris(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->markTestSkipped(
                'SQLite testing: enum payments.method tidak memuat qris (MySQL-only migration). '
                .'Alur QRIS tetap normal di development/production MySQL.'
            );
        }

        $this->seedShippingSetting();
        [$user] = $this->createCustomerWithCart();

        $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 1',
            'payment_method' => 'qris',
        ])->assertRedirect();

        $payment = Payment::whereHas('order', fn ($q) => $q->where('user_id', $user->id))->first();
        $this->assertSame('qris', $payment->method);
    }

    public function test_checkout_creates_unique_order_number(): void
    {
        $this->seedShippingSetting();
        [$user] = $this->createCustomerWithCart();

        $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
            'payment_method' => 'cod',
        ]);

        $order = Order::first();
        $this->assertMatchesRegularExpression('/^WC-\d{8}-\d{4}$/', $order->order_number);
    }
}
