<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = Auth::user()->cart?->load(['items.product']);

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $shippingCost = (float) Setting::get('shipping_cost', 15000);

        return view('checkout.index', compact('cart', 'shippingCost'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $cart = $user->cart?->load(['items.product']);

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
        }

        $shippingCost = (float) Setting::get('shipping_cost', 15000);
        $subtotal = $cart->total;

        $order = DB::transaction(function () use ($user, $cart, $request, $shippingCost, $subtotal) {
            $orderNumber = self::generateOrderNumber();

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $subtotal + $shippingCost,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_barcode' => $item->product->barcode,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
                'amount' => $order->total,
            ]);

            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Generate nomor pesanan harian unik dengan format WC-YYYYMMDD-XXXX.
     * Menggunakan lockForUpdate() untuk mencegah race condition saat checkout concurrent.
     */
    private static function generateOrderNumber(): string
    {
        $dateKey = now()->format('Y-m-d');
        $datePrefix = now()->format('Ymd');

        DB::table('order_number_sequences')->insertOrIgnore([
            'date' => $dateKey,
            'last_number' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sequence = DB::table('order_number_sequences')
            ->where('date', $dateKey)
            ->lockForUpdate()
            ->first();

        $nextNumber = $sequence->last_number + 1;

        DB::table('order_number_sequences')
            ->where('date', $dateKey)
            ->update([
                'last_number' => $nextNumber,
                'updated_at' => now(),
            ]);

        return 'WC-'.$datePrefix.'-'.str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
