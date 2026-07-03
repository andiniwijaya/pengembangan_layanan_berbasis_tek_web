<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Data demo tambahan untuk newsletter, kontak, pesanan, ulasan, dan notifikasi.
 *
 * Jalankan setelah DatabaseSeeder:
 *   php artisan db:seed --class=DemoDataSeeder
 *
 * Akun demo:
 *   Customer: customer@wijaycart.com / password
 *   Admin:    admin@wijaycart.com / password
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@wijaycart.com')->first();
        $product = Product::where('slug', 'floral-ceramic-mug')->first()
            ?? Product::first();

        if (! $customer || ! $product) {
            $this->command?->warn('DemoDataSeeder: jalankan DatabaseSeeder terlebih dahulu.');

            return;
        }

        $this->seedNewsletter();
        $this->seedContactMessage();
        $this->seedDemoOrders($customer, $product);
    }

    private function seedNewsletter(): void
    {
        NewsletterSubscriber::updateOrCreate(
            ['email' => 'newsletter.demo@wijaycart.com'],
            [
                'subscribed_at' => now()->subDays(7),
                'is_active' => true,
                'unsubscribe_token' => 'demo-active-token-'.Str::random(16),
            ]
        );

        NewsletterSubscriber::updateOrCreate(
            ['email' => 'unsubscribed.demo@wijaycart.com'],
            [
                'subscribed_at' => now()->subDays(30),
                'is_active' => false,
                'unsubscribe_token' => 'demo-unsub-token-'.Str::random(16),
            ]
        );
    }

    private function seedContactMessage(): void
    {
        ContactMessage::firstOrCreate(
            ['email' => 'demo.contact@example.com', 'subject' => 'Pertanyaan Pengiriman Demo'],
            [
                'name' => 'Demo Kontak',
                'message' => 'Apakah pengiriman ke luar Jabodetabek tersedia?',
                'status' => 'unread',
            ]
        );
    }

    private function seedDemoOrders(User $customer, Product $product): void
    {
        $this->createPendingCodOrder($customer, $product);
        $this->createWaitingPaymentOrder($customer, $product);
        $this->createProcessingOrder($customer, $product);
        $this->createDeliveredDemoFlow($customer, $product);
    }

    private function createPendingCodOrder(User $customer, Product $product): void
    {
        $order = Order::updateOrCreate(
            ['order_number' => 'WC-'.date('Ymd').'-9001'],
            [
                'user_id' => $customer->id,
                'status' => 'pending',
                'stock_restored' => false,
                'subtotal' => $product->price,
                'shipping_cost' => 15000,
                'total' => $product->price + 15000,
                'shipping_name' => $customer->name,
                'shipping_phone' => $customer->phone ?? '081234567890',
                'shipping_address' => $customer->address ?? 'Jl. Demo No. 1, Jakarta',
            ]
        );

        $this->syncOrderItem($order, $product);
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            ['method' => 'cod', 'status' => 'pending', 'amount' => $order->total]
        );
        OrderStatusHistory::record($order, 'order_created', 'Order Created', $order->created_at ?? now());
    }

    private function createWaitingPaymentOrder(User $customer, Product $product): void
    {
        $order = Order::updateOrCreate(
            ['order_number' => 'WC-'.date('Ymd').'-9002'],
            [
                'user_id' => $customer->id,
                'status' => 'pending',
                'stock_restored' => false,
                'subtotal' => $product->price * 2,
                'shipping_cost' => 15000,
                'total' => ($product->price * 2) + 15000,
                'shipping_name' => $customer->name,
                'shipping_phone' => $customer->phone ?? '081234567890',
                'shipping_address' => $customer->address ?? 'Jl. Demo No. 2, Jakarta',
            ]
        );

        $this->syncOrderItem($order, $product, 2);
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'bank_transfer',
                'status' => 'pending',
                'amount' => $order->total,
                'payment_proof' => null,
            ]
        );
        OrderStatusHistory::record($order, 'order_created', 'Order Created', $order->created_at ?? now());
        OrderStatusHistory::record($order, 'waiting_payment', 'Waiting Payment');
    }

    private function createProcessingOrder(User $customer, Product $product): void
    {
        $order = Order::updateOrCreate(
            ['order_number' => 'WC-'.date('Ymd').'-9003'],
            [
                'user_id' => $customer->id,
                'status' => 'processing',
                'stock_restored' => false,
                'subtotal' => $product->price,
                'shipping_cost' => 15000,
                'total' => $product->price + 15000,
                'shipping_name' => $customer->name,
                'shipping_phone' => $customer->phone ?? '081234567890',
                'shipping_address' => $customer->address ?? 'Jl. Demo No. 3, Jakarta',
            ]
        );

        $this->syncOrderItem($order, $product);
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            ['method' => 'qris', 'status' => 'paid', 'amount' => $order->total, 'paid_at' => now()->subDay()]
        );
        foreach (['order_created', 'waiting_payment', 'paid', 'processing'] as $i => $key) {
            $labels = [
                'order_created' => 'Order Created',
                'waiting_payment' => 'Waiting Payment',
                'paid' => 'Paid',
                'processing' => 'Processing',
            ];
            OrderStatusHistory::record($order, $key, $labels[$key], now()->subDays(3 - $i));
        }
    }

    private function createDeliveredDemoFlow(User $customer, Product $product): void
    {
        $order = Order::updateOrCreate(
            ['order_number' => 'WC-'.date('Ymd').'-9004'],
            [
                'user_id' => $customer->id,
                'status' => 'delivered',
                'stock_restored' => false,
                'subtotal' => $product->price,
                'shipping_cost' => 15000,
                'total' => $product->price + 15000,
                'shipping_name' => $customer->name,
                'shipping_phone' => $customer->phone ?? '081234567890',
                'shipping_address' => $customer->address ?? 'Jl. Demo No. 4, Jakarta',
            ]
        );

        $this->syncOrderItem($order, $product);
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'bank_transfer',
                'status' => 'paid',
                'amount' => $order->total,
                'paid_at' => now()->subDays(2),
            ]
        );

        $timeline = [
            ['order_created', 'Order Created', 5],
            ['waiting_payment', 'Waiting Payment', 4],
            ['paid', 'Paid', 3],
            ['processing', 'Processing', 2],
            ['shipped', 'Shipped', 1],
            ['completed', 'Completed', 0],
        ];

        foreach ($timeline as [$key, $label, $daysAgo]) {
            OrderStatusHistory::record($order, $key, $label, now()->subDays($daysAgo));
        }

        Review::updateOrCreate(
            ['user_id' => $customer->id, 'product_id' => $product->id],
            [
                'order_id' => $order->id,
                'rating' => 5,
                'comment' => 'Mug-nya cantik dan kualitas keramiknya bagus. Pengiriman cepat!',
            ]
        );

        UserNotification::where('user_id', $customer->id)->delete();

        $notifications = [
            ['Pesanan Dibuat', "Pesanan {$order->order_number} berhasil dibuat.", 'order', false, now()->subDays(5)],
            ['Menunggu Pembayaran', "Silakan unggah bukti pembayaran untuk {$order->order_number}.", 'payment', true, now()->subDays(4)],
            ['Pembayaran Diterima', "Pembayaran pesanan {$order->order_number} telah dikonfirmasi.", 'payment', true, now()->subDays(3)],
            ['Pesanan Dikirim', "Pesanan {$order->order_number} sedang dalam perjalanan.", 'order', true, now()->subDay()],
            ['Pesanan Selesai', "Pesanan {$order->order_number} telah sampai. Silakan beri ulasan!", 'order', false, now()],
        ];

        foreach ($notifications as [$title, $message, $type, $isRead, $at]) {
            UserNotification::create([
                'user_id' => $customer->id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'is_read' => $isRead,
                'created_at' => $at,
                'updated_at' => $at,
            ]);
        }
    }

    private function syncOrderItem(Order $order, Product $product, int $qty = 1): void
    {
        OrderItem::updateOrCreate(
            ['order_id' => $order->id, 'product_id' => $product->id],
            [
                'product_name' => $product->name,
                'product_barcode' => $product->barcode,
                'price' => $product->price,
                'quantity' => $qty,
                'subtotal' => $product->price * $qty,
            ]
        );
    }
}
