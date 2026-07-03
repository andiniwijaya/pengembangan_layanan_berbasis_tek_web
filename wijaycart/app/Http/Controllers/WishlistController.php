<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlists = Wishlist::with(['product.category', 'product.primaryImage'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $this->authorize('delete', $wishlist);
            $wishlist->delete();

            return back()->with('success', 'Dihapus dari wishlist.');
        }

        $this->authorize('create', Wishlist::class);

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Ditambahkan ke wishlist.');
    }

    public function destroy(Wishlist $wishlist): RedirectResponse
    {
        $this->authorize('delete', $wishlist);

        $wishlist->delete();

        return back()->with('success', 'Dihapus dari wishlist.');
    }
}
