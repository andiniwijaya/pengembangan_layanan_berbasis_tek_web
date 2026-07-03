<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Controller laporan admin WijayCart.
 * Menyediakan laporan produk, penjualan, customer, dan pesanan.
 */
class ReportController extends Controller
{
    /**
     * Halaman laporan dengan tab produk, penjualan, customer, dan pesanan.
     */
    public function index(Request $request): View
    {
        $tab = $request->get('tab', 'sales');

        // Laporan Penjualan
        $totalRevenue = Order::whereIn('status', ['delivered', 'shipped', 'processing'])->sum('total');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $monthlySales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total) as revenue'),
            DB::raw('COUNT(*) as orders')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        $statusBreakdown = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Laporan Produk
        $productStats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'featured' => Product::where('is_featured', true)->count(),
        ];

        $productsByCategory = Category::withCount('products')->get();

        $lowStockProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(10)
            ->get();

        // Laporan Customer
        $customerStats = [
            'total' => User::where('role', 'customer')->count(),
            'with_orders' => User::where('role', 'customer')->has('orders')->count(),
            'new_this_month' => User::where('role', 'customer')->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $topCustomers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total')
            ->orderByDesc('orders_sum_total')
            ->take(10)
            ->get();

        // Laporan Pesanan
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.reports.index', compact(
            'tab',
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'monthlySales',
            'topProducts',
            'statusBreakdown',
            'productStats',
            'productsByCategory',
            'lowStockProducts',
            'customerStats',
            'topCustomers',
            'orderStats',
            'recentOrders'
        ));
    }
}
