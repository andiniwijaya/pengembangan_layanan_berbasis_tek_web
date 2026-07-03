<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $orderCount = $user->orders()->count();
        $wishlistCount = $user->wishlists()->count();
        $cartCount = $user->cart?->items()->sum('quantity') ?? 0;

        $recentOrders = $user->orders()
            ->latest()
            ->take(5)
            ->get();

        $recommendedProducts = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $popularCategories = Category::query()
            ->where('is_active', true)
            ->withCount('activeProducts')
            ->orderByDesc('active_products_count')
            ->take(6)
            ->get();

        $wishlistIds = $user->wishlists()->pluck('product_id')->toArray();

        return view('dashboard.index', compact(
            'user',
            'orderCount',
            'wishlistCount',
            'cartCount',
            'recentOrders',
            'recommendedProducts',
            'popularCategories',
            'wishlistIds',
        ));
    }
}
