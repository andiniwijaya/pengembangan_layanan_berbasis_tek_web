<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Service class untuk logika keranjang belanja.
 * Memusatkan operasi tambah, update, dan hapus item agar controller tetap ringkas.
 */
class CartService
{
    /**
     * Ambil keranjang user yang sedang login, buat baru jika belum ada.
     */
    public function getOrCreateCart(?User $user = null): Cart
    {
        $user = $user ?? Auth::user();
        $cart = $user->cart;

        if (! $cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        return $cart->load(['items.product.primaryImage', 'items.product.category']);
    }

    /**
     * Tambahkan produk ke keranjang atau tambah jumlah jika sudah ada.
     *
     * @return array{success: bool, message: string}
     */
    public function addItem(int $productId, int $quantity): array
    {
        $product = Product::findOrFail($productId);

        if (! $product->isActive() || ! $product->isInStock()) {
            return ['success' => false, 'message' => 'Produk tidak tersedia.'];
        }

        if ($quantity > $product->stock) {
            return ['success' => false, 'message' => 'Stok tidak mencukupi.'];
        }

        $cart = $this->getOrCreateCart();
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = $item->quantity + $quantity;
            if ($newQty > $product->stock) {
                return ['success' => false, 'message' => 'Stok tidak mencukupi.'];
            }
            $item->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return ['success' => true, 'message' => 'Produk ditambahkan ke keranjang.'];
    }

    /**
     * Ubah jumlah item di keranjang.
     */
    public function updateItem(CartItem $item, int $quantity): array
    {
        if ($quantity > $item->product->stock) {
            return ['success' => false, 'message' => 'Stok tidak mencukupi.'];
        }

        $item->update(['quantity' => $quantity]);

        return ['success' => true, 'message' => 'Keranjang diperbarui.'];
    }

    /**
     * Hapus item dari keranjang.
     */
    public function removeItem(CartItem $item): array
    {
        $item->delete();

        return ['success' => true, 'message' => 'Item dihapus dari keranjang.'];
    }

    /**
     * Format data keranjang untuk response JSON (update AJAX).
     */
    public function toArray(Cart $cart): array
    {
        $cart->load(['items.product.primaryImage']);

        return [
            'items' => $cart->items->map(fn (CartItem $item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'slug' => $item->product->slug,
                'barcode' => $item->product->barcode,
                'price' => (float) $item->product->price,
                'price_formatted' => 'Rp '.number_format($item->product->price, 0, ',', '.'),
                'quantity' => $item->quantity,
                'stock' => $item->product->stock,
                'subtotal' => $item->subtotal,
                'subtotal_formatted' => 'Rp '.number_format($item->subtotal, 0, ',', '.'),
                'image' => $item->product->primary_image_url,
            ]),
            'subtotal' => $cart->total,
            'subtotal_formatted' => 'Rp '.number_format($cart->total, 0, ',', '.'),
            'item_count' => $cart->item_count,
            'total_formatted' => 'Rp '.number_format($cart->total, 0, ',', '.'),
        ];
    }
}
