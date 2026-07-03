@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Statistik utama --}}
<div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
    @foreach([
        ['label' => 'Total Produk', 'value' => $stats['total_products'], 'icon' => 'package', 'card' => 'stat-card-yellow', 'iconBg' => 'stat-icon-bg-primary'],
        ['label' => 'Total Customer', 'value' => $stats['total_customers'], 'icon' => 'users', 'card' => 'stat-card-blue', 'iconBg' => 'stat-icon-bg-blue'],
        ['label' => 'Total Pesanan', 'value' => $stats['total_orders'], 'icon' => 'shopping-bag', 'card' => 'stat-card-green', 'iconBg' => 'stat-icon-bg-success'],
        ['label' => 'Pendapatan', 'value' => 'Rp '.number_format($stats['total_revenue'], 0, ',', '.'), 'icon' => 'wallet', 'card' => 'stat-card-orange', 'iconBg' => 'stat-icon-bg-orange'],
        ['label' => 'Kategori', 'value' => $stats['total_categories'], 'icon' => 'tags', 'card' => 'stat-card-purple', 'iconBg' => 'stat-icon-bg-purple'],
    ] as $stat)
    <div class="{{ $stat['card'] }}">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-text/50 dark:text-dark-muted">{{ $stat['label'] }}</p>
                <p class="mt-2 truncate text-2xl font-bold">{{ $stat['value'] }}</p>
            </div>
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full {{ $stat['iconBg'] }} shadow-inner">
                <i data-lucide="{{ $stat['icon'] }}" class="h-5 w-5 text-accent dark:text-primary" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Ringkasan cepat --}}
<div class="mb-8 grid gap-4 sm:grid-cols-3">
    <a href="{{ route('admin.orders.index', ['payment' => 'pending']) }}" class="card card-hover flex items-center gap-4 !p-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-200/60 dark:bg-orange-500/20">
            <i data-lucide="credit-card" class="h-5 w-5 text-accent dark:text-primary"></i>
        </div>
        <div>
            <p class="text-xs text-text/50 dark:text-dark-muted">Pembayaran Pending</p>
            <p class="text-xl font-bold">{{ $stats['pending_payments'] }}</p>
        </div>
    </a>
    <a href="{{ route('admin.contacts.index') }}" class="card card-hover flex items-center gap-4 !p-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-200/60 dark:bg-sky-500/20">
            <i data-lucide="mail" class="h-5 w-5 text-accent dark:text-primary"></i>
        </div>
        <div>
            <p class="text-xs text-text/50 dark:text-dark-muted">Pesan Belum Dibaca</p>
            <p class="text-xl font-bold">{{ $stats['unread_contacts'] }}</p>
        </div>
    </a>
    <a href="{{ route('admin.newsletters.index') }}" class="card card-hover flex items-center gap-4 !p-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-200/60 dark:bg-violet-500/20">
            <i data-lucide="newspaper" class="h-5 w-5 text-accent dark:text-primary"></i>
        </div>
        <div>
            <p class="text-xs text-text/50 dark:text-dark-muted">Subscriber Aktif</p>
            <p class="text-xl font-bold">{{ $stats['active_subscribers'] }}</p>
        </div>
    </a>
</div>

{{-- Grafik --}}
<div class="mb-8 grid gap-6 lg:grid-cols-3">
    <div class="card lg:col-span-2">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-semibold">Grafik Penjualan (30 Hari)</h3>
            <a href="{{ route('admin.reports.index') }}" class="text-xs font-medium text-accent hover:underline dark:text-primary">Lihat Laporan →</a>
        </div>
        <canvas id="salesChart" height="120"></canvas>
        <div id="dashboard-chart-data" class="hidden"
            data-labels="{{ json_encode($salesChart->pluck('date')->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d M'))) }}"
            data-revenue="{{ json_encode($salesChart->pluck('revenue')) }}">
        </div>
    </div>
    <div class="card">
        <h3 class="mb-4 font-semibold">Produk Terlaris</h3>
        @if($topProducts->isNotEmpty())
        <canvas id="topProductsChart" height="200"></canvas>
        <div id="dashboard-top-products-data" class="hidden"
            data-labels="{{ json_encode($topProducts->pluck('product_name')->map(fn ($n) => \Illuminate\Support\Str::limit($n, 18))) }}"
            data-sold="{{ json_encode($topProducts->pluck('total_sold')) }}">
        </div>
        @else
        <x-empty-state icon="bar-chart-2" title="Belum Ada Data Penjualan" description="Grafik produk terlaris akan muncul setelah ada transaksi." />
        @endif
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    {{-- Pesanan terbaru --}}
    <div class="card lg:col-span-1">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-semibold">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-accent dark:text-primary">Semua →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="block rounded-xl border border-border p-3 transition-all duration-200 hover:border-primary/40 hover:bg-secondary/50 dark:border-dark-border dark:hover:bg-dark-border">
                <div class="flex justify-between gap-2">
                    <span class="text-sm font-medium">{{ $order->order_number }}</span>
                    <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
                </div>
                <p class="mt-1 text-xs text-text/50 dark:text-dark-muted">{{ $order->user->name }}</p>
                <p class="mt-1 text-sm font-bold text-accent dark:text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </a>
            @empty
            <x-empty-state icon="shopping-bag" title="Belum Ada Pesanan" description="Pesanan customer akan muncul di sini." :action-url="route('home')" action-label="Lihat Toko" />
            @endforelse
        </div>
    </div>

    {{-- Customer terbaru --}}
    <div class="card lg:col-span-1">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-semibold">Customer Terbaru</h3>
            <a href="{{ route('admin.customers.index') }}" class="text-xs text-accent dark:text-primary">Semua →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentCustomers as $customer)
            <a href="{{ route('admin.customers.show', $customer) }}" class="flex items-center gap-3 rounded-xl border border-border p-3 transition-all hover:bg-secondary/50 dark:border-dark-border dark:hover:bg-dark-border">
                <img src="{{ $customer->avatar_url }}" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-primary/30">
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium">{{ $customer->name }}</p>
                    <p class="truncate text-xs text-text/50">{{ $customer->email }}</p>
                </div>
            </a>
            @empty
            <x-empty-state icon="users" title="Belum Ada Customer" description="Customer terdaftar akan muncul di sini." />
            @endforelse
        </div>
    </div>

    {{-- Stok menipis --}}
    <div class="card lg:col-span-1">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-semibold">Stok Menipis</h3>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-accent dark:text-primary">Produk →</a>
        </div>
        <div class="space-y-2">
            @forelse($lowStockProducts as $product)
            <div class="flex items-center justify-between rounded-xl bg-secondary/50 px-3 py-2.5 dark:bg-dark-border/50">
                <div class="min-w-0 pr-2">
                    <p class="truncate text-sm font-medium">{{ $product->name }}</p>
                    <p class="text-xs text-text/50">{{ $product->category->name }}</p>
                </div>
                <span class="badge badge-warning shrink-0">{{ $product->stock }} unit</span>
            </div>
            @empty
            <x-empty-state icon="package" title="Stok Aman" description="Tidak ada produk dengan stok menipis saat ini." />
            @endforelse
        </div>
    </div>
</div>

{{-- Aktivitas & komunikasi --}}
<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div class="card">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-semibold">Contact Messages Terbaru</h3>
            <a href="{{ route('admin.contacts.index') }}" class="text-xs text-accent dark:text-primary">Semua →</a>
        </div>
        @forelse($recentContacts as $contact)
        <div class="mb-3 rounded-xl border border-border p-3 last:mb-0 dark:border-dark-border">
            <div class="flex items-start justify-between gap-2">
                <p class="text-sm font-medium">{{ $contact->subject }}</p>
                <span class="badge {{ $contact->status === 'unread' ? 'badge-warning' : 'badge-success' }}">{{ ucfirst($contact->status) }}</span>
            </div>
            <p class="mt-1 text-xs text-text/50">{{ $contact->name }} · {{ $contact->email }}</p>
            <p class="mt-2 line-clamp-2 text-sm text-text/70 dark:text-dark-muted">{{ $contact->message }}</p>
        </div>
        @empty
        <x-empty-state icon="mail" title="Belum Ada Pesan" description="Pesan dari form kontak akan muncul di sini." />
        @endforelse
    </div>

    <div class="card">
        <h3 class="mb-4 font-semibold">Ringkasan Newsletter</h3>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-xl bg-violet-100/60 p-4 dark:bg-violet-900/20">
                <p class="text-xs font-medium uppercase text-text/50">Subscriber Aktif</p>
                <p class="mt-1 text-3xl font-bold">{{ $stats['active_subscribers'] }}</p>
            </div>
            <div class="rounded-xl bg-sky-100/60 p-4 dark:bg-sky-900/20">
                <p class="text-xs font-medium uppercase text-text/50">Total Terdaftar</p>
                <p class="mt-1 text-3xl font-bold">{{ \App\Models\NewsletterSubscriber::count() }}</p>
            </div>
        </div>
        <a href="{{ route('admin.newsletters.index') }}" class="btn-secondary mt-4 w-full text-sm">Kelola Newsletter</a>
    </div>
</div>
@endsection
