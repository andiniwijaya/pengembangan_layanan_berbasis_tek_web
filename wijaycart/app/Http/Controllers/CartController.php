<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller keranjang belanja customer.
 * Menangani tampilan keranjang dan operasi CRUD item dengan dukungan AJAX.
 */
class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function index(): View
    {
        $cart = $this->cartService->getOrCreateCart();

        return view('cart.index', compact('cart'));
    }

    /**
     * Tambahkan produk ke keranjang (form submit atau AJAX).
     */
    public function store(CartStoreRequest $request): RedirectResponse|JsonResponse
    {
        $result = $this->cartService->addItem(
            (int) $request->product_id,
            (int) $request->quantity
        );

        if ($request->wantsJson()) {
            if (! $result['success']) {
                return response()->json(['message' => $result['message']], 422);
            }

            $cart = $this->cartService->getOrCreateCart();

            return response()->json([
                'message' => $result['message'],
                'cart' => $this->cartService->toArray($cart),
            ]);
        }

        return $result['success']
            ? back()->with('success', $result['message'])
            : back()->with('error', $result['message']);
    }

    /**
     * Update jumlah item keranjang.
     */
    public function update(CartUpdateRequest $request, CartItem $cartItem): RedirectResponse|JsonResponse
    {
        $result = $this->cartService->updateItem($cartItem, (int) $request->quantity);

        if ($request->wantsJson()) {
            if (! $result['success']) {
                return response()->json(['message' => $result['message']], 422);
            }

            $cart = $this->cartService->getOrCreateCart();

            return response()->json([
                'message' => $result['message'],
                'cart' => $this->cartService->toArray($cart),
            ]);
        }

        return $result['success']
            ? back()->with('success', $result['message'])
            : back()->with('error', $result['message']);
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy(Request $request, CartItem $cartItem): RedirectResponse|JsonResponse
    {
        $this->authorize('delete', $cartItem);

        $result = $this->cartService->removeItem($cartItem);

        if ($request->wantsJson()) {
            $cart = $this->cartService->getOrCreateCart();

            return response()->json([
                'message' => $result['message'],
                'cart' => $this->cartService->toArray($cart),
            ]);
        }

        return back()->with('success', $result['message']);
    }
}
