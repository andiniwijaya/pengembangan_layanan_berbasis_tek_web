<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller katalog dan detail produk customer.
 * Menangani pencarian, filter, sorting, dan pagination produk.
 */
class ProductController extends Controller
{
    /**
     * Halaman katalog produk dengan search, filter, dan sort.
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'primaryImage'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'active');

        // Pencarian berdasarkan nama, barcode, atau nama kategori
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($cat) => $cat->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        // Filter rentang harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter status stok
        if ($request->filled('stock')) {
            match ($request->stock) {
                'available' => $query->where('stock', '>', 0),
                'low' => $query->whereBetween('stock', [1, 10]),
                'out' => $query->where('stock', '<=', 0),
                default => null,
            };
        }

        // Sorting produk
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->withCount('activeProducts')->get();

        // ID produk dalam wishlist user untuk tampilan icon aktif
        $wishlistIds = auth()->check()
            ? auth()->user()->wishlists()->pluck('product_id')->toArray()
            : [];

        return view('products.index', compact('products', 'categories', 'wishlistIds'));
    }

    /**
     * Halaman detail produk dengan gallery foto.
     */
    public function show(string $slug): View
    {
        $product = Product::with(['category', 'images', 'reviews.user', 'supplier'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $relatedProducts = Product::with(['primaryImage', 'category'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        $wishlistIds = auth()->check()
            ? auth()->user()->wishlists()->pluck('product_id')->toArray()
            : [];

        $inWishlist = in_array($product->id, $wishlistIds);

        $canReview = auth()->check() && auth()->user()->can('review', $product);
        $userReview = auth()->check()
            ? Review::where('user_id', auth()->id())->where('product_id', $product->id)->first()
            : null;
        $eligibleOrders = auth()->check()
            ? Order::where('user_id', auth()->id())
                ->where('status', 'delivered')
                ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
                ->latest()
                ->get()
            : collect();

        return view('products.show', compact(
            'product',
            'relatedProducts',
            'inWishlist',
            'wishlistIds',
            'canReview',
            'userReview',
            'eligibleOrders'
        ));
    }
}
