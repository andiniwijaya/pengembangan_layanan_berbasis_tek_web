<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Support\HeroSlides;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->take(8)
            ->get();

        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::with(['category', 'primaryImage'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $wishlistIds = auth()->check()
            ? auth()->user()->wishlists()->pluck('product_id')->toArray()
            : [];

        $heroSlides = HeroSlides::all();

        return view('home', compact('categories', 'featuredProducts', 'latestProducts', 'wishlistIds', 'heroSlides'));
    }
}
