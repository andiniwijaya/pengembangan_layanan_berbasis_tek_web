<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerEngagementFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_newsletter_subscribe_stores_subscriber_with_token(): void
    {
        $response = $this->post(route('newsletter.subscribe'), [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'subscriber@example.com',
            'is_active' => true,
        ]);

        $subscriber = NewsletterSubscriber::first();
        $this->assertNotEmpty($subscriber->unsubscribe_token);
        $this->assertNotNull($subscriber->subscribed_at);
    }

    public function test_newsletter_duplicate_email_reactivates_subscriber(): void
    {
        $subscriber = NewsletterSubscriber::subscribe('resub@example.com');
        $subscriber->update(['is_active' => false]);

        $this->post(route('newsletter.subscribe'), ['email' => 'resub@example.com']);

        $this->assertTrue($subscriber->fresh()->is_active);
    }

    public function test_newsletter_unsubscribe_deactivates_subscriber(): void
    {
        $subscriber = NewsletterSubscriber::subscribe('leave@example.com');

        $response = $this->get(route('newsletter.unsubscribe', $subscriber->unsubscribe_token));

        $response->assertRedirect(route('home'));
        $this->assertFalse($subscriber->fresh()->is_active);
    }

    public function test_contact_form_stores_message_with_unread_status(): void
    {
        $response = $this->post(route('pages.contact.store'), [
            'name' => 'Andini',
            'email' => 'andini@example.com',
            'subject' => 'Pertanyaan',
            'message' => 'Halo, saya ingin bertanya.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'andini@example.com',
            'status' => 'unread',
        ]);
    }

    public function test_customer_can_cancel_pending_order_and_restore_stock(): void
    {
        [$user, $product, $order] = $this->makeOrderWithProduct('pending', 2);

        $response = $this->actingAs($user)->post(route('orders.cancel', $order));

        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancelled',
            'stock_restored' => true,
        ]);
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_customer_can_cancel_waiting_payment_order(): void
    {
        [$user, , $order] = $this->makeOrderWithProduct('pending', 1);
        Payment::create([
            'order_id' => $order->id,
            'method' => 'bank_transfer',
            'status' => 'pending',
            'amount' => $order->total,
        ]);

        $response = $this->actingAs($user)->post(route('orders.cancel', $order));

        $response->assertRedirect(route('orders.show', $order));
        $this->assertSame('cancelled', $order->fresh()->status);
    }

    public function test_customer_cannot_cancel_processing_order(): void
    {
        [$user, , $order] = $this->makeOrderWithProduct('processing', 1);

        $this->actingAs($user)->post(route('orders.cancel', $order))->assertForbidden();
    }

    public function test_customer_cannot_cancel_delivered_order(): void
    {
        [$user, , $order] = $this->makeOrderWithProduct('delivered', 1);

        $this->actingAs($user)->post(route('orders.cancel', $order))->assertForbidden();
    }

    public function test_review_requires_delivered_purchase_and_updates_average(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'WC-20260703-0003',
            'status' => 'delivered',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'total' => 65000,
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_barcode' => $product->barcode,
            'price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        $this->actingAs($user)->post(route('reviews.store', $product), [
            'order_id' => $order->id,
            'rating' => 5,
            'comment' => 'Produk bagus!',
        ])->assertRedirect();

        $product->refresh()->loadAvg('reviews', 'rating')->loadCount('reviews');
        $this->assertSame(5.0, $product->average_rating);
        $this->assertSame(1, $product->review_count);
    }

    public function test_duplicate_review_is_blocked(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'WC-20260703-0099',
            'status' => 'delivered',
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
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => 4,
        ]);

        $this->actingAs($user)->post(route('reviews.store', $product), [
            'order_id' => $order->id,
            'rating' => 5,
        ])->assertForbidden();

        $this->assertSame(1, Review::where('product_id', $product->id)->count());
    }

    public function test_notification_mark_read_and_read_all(): void
    {
        $user = User::factory()->create();
        $n1 = UserNotification::create([
            'user_id' => $user->id,
            'title' => 'Test 1',
            'message' => 'Msg 1',
            'type' => 'info',
            'is_read' => false,
        ]);
        UserNotification::create([
            'user_id' => $user->id,
            'title' => 'Test 2',
            'message' => 'Msg 2',
            'type' => 'info',
            'is_read' => false,
        ]);

        $this->actingAs($user)->post(route('notifications.read', $n1))->assertRedirect();
        $this->assertTrue($n1->fresh()->is_read);

        $this->actingAs($user)->post(route('notifications.read-all'))->assertRedirect();
        $this->assertSame(0, UserNotification::where('user_id', $user->id)->where('is_read', false)->count());
    }

    public function test_payment_proof_upload_validates_and_replaces_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'WC-20260703-0088',
            'status' => 'pending',
            'subtotal' => 100000,
            'shipping_cost' => 15000,
            'total' => 115000,
            'shipping_name' => 'Test',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => 'bank_transfer',
            'status' => 'pending',
            'amount' => 115000,
        ]);

        $this->actingAs($user)->post(route('orders.payment-proof', $order), [
            'payment_proof' => UploadedFile::fake()->image('proof.jpg')->size(3000),
        ])->assertSessionHasErrors('payment_proof');

        $file = UploadedFile::fake()->image('proof.jpg');
        $this->actingAs($user)->post(route('orders.payment-proof', $order), [
            'payment_proof' => $file,
        ])->assertRedirect();

        $firstPath = $payment->fresh()->payment_proof;
        Storage::disk('public')->assertExists($firstPath);

        $file2 = UploadedFile::fake()->image('proof2.png');
        $this->actingAs($user)->post(route('orders.payment-proof', $order), [
            'payment_proof' => $file2,
        ])->assertRedirect();

        Storage::disk('public')->assertMissing($firstPath);
        Storage::disk('public')->assertExists($payment->fresh()->payment_proof);
    }

    public function test_payment_observer_records_waiting_payment_history(): void
    {
        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'WC-20260703-0004',
            'status' => 'pending',
            'subtotal' => 100000,
            'shipping_cost' => 15000,
            'total' => 115000,
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'method' => 'bank_transfer',
            'status' => 'pending',
            'amount' => 115000,
        ]);

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'step_key' => 'waiting_payment',
        ]);
    }

    public function test_core_storefront_pages_still_load(): void
    {
        $user = User::factory()->create();

        $this->get(route('home'))->assertOk();
        $this->get(route('products.index'))->assertOk();
        $this->actingAs($user)->get(route('dashboard'))->assertOk();
        $this->actingAs($user)->get(route('cart.index'))->assertOk();
        $this->get(route('pages.about'))->assertOk();
    }

    /** @return array{0: User, 1: Product, 2: Order} */
    private function makeOrderWithProduct(string $status, int $qty): array
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 5,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'WC-20260703-'.random_int(1000, 9999),
            'status' => $status,
            'stock_restored' => false,
            'subtotal' => $product->price * $qty,
            'shipping_cost' => 15000,
            'total' => ($product->price * $qty) + 15000,
            'shipping_name' => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_barcode' => $product->barcode,
            'price' => $product->price,
            'quantity' => $qty,
            'subtotal' => $product->price * $qty,
        ]);

        $product->decrement('stock', $qty);

        return [$user, $product, $order];
    }
}
