<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\UserNotification;
use App\Models\Wishlist;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Payment::observe(\App\Observers\PaymentObserver::class);

        Paginator::defaultView('pagination.flowbite');
        Paginator::defaultSimpleView('pagination.flowbite-simple');

        View::composer('layouts.app', function ($view) {
            $cartCount = 0;
            $wishlistCount = 0;
            $notifications = collect();
            $unreadNotificationCount = 0;

            if (Auth::check()) {
                $cartCount = Auth::user()->cart?->items()->sum('quantity') ?? 0;
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
                $notifications = UserNotification::where('user_id', Auth::id())
                    ->latest()
                    ->take(10)
                    ->get();
                $unreadNotificationCount = UserNotification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }

            $view->with(compact('cartCount', 'wishlistCount', 'notifications', 'unreadNotificationCount'));
        });

        View::composer(['partials.footer', 'layouts.app', 'pages.contact'], function ($view) {
            $footerCategories = Category::query()
                ->where('is_active', true)
                ->withCount('activeProducts')
                ->orderByDesc('active_products_count')
                ->take(6)
                ->get();

            $storeSettings = [
                'email' => Setting::get('store_email', 'hello@wijaycart.com'),
                'phone' => Setting::get('store_phone', '+62 812-3456-7890'),
                'address' => Setting::get('store_address', 'Jl. Lifestyle No. 88, Jakarta Selatan'),
            ];

            $view->with(compact('footerCategories', 'storeSettings'));
        });
    }
}
