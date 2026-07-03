<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::whereIn('status', ['delivered', 'shipped', 'processing'])
                ->sum('total'),
            'total_categories' => Category::count(),
            'pending_payments' => Order::whereHas('payment', fn ($q) => $q->where('status', 'pending'))->count(),
            'unread_contacts' => ContactMessage::where('status', 'unread')->count(),
            'active_subscribers' => NewsletterSubscriber::where('is_active', true)->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentCustomers = User::where('role', 'customer')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $recentContacts = ContactMessage::latest()->take(3)->get();

        $salesChart = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as revenue'),
            DB::raw('COUNT(*) as orders')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->whereIn('status', ['delivered', 'shipped', 'processing', 'pending'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentCustomers',
            'lowStockProducts',
            'topProducts',
            'recentContacts',
            'salesChart',
        ));
    }
}
