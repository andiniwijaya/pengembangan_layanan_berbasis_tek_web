@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @php
        $statCards = [
            [
                'label' => 'Total Produk',
                'value' => $stats['total_products'],
                'icon' => 'package',
                'card' => 'stat-card-yellow',
                'iconBg' => 'stat-icon-bg-primary',
                'url' => route('admin.products.index'),
            ],
            [
                'label' => 'Total Customer',
                'value' => $stats['total_customers'],
                'icon' => 'users',
                'card' => 'stat-card-blue',
                'iconBg' => 'stat-icon-bg-blue',
                'url' => route('admin.customers.index'),
            ],
            [
                'label' => 'Total Pesanan',
                'value' => $stats['total_orders'],
                'icon' => 'shopping-bag',
                'card' => 'stat-card-green',
                'iconBg' => 'stat-icon-bg-success',
                'url' => route('admin.orders.index'),
            ],
            [
                'label' => 'Pendapatan',
                'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'),
                'icon' => 'wallet',
                'card' => 'stat-card-orange',
                'iconBg' => 'stat-icon-bg-orange',
                'url' => route('admin.reports.index'),
            ],
            [
                'label' => 'Kategori',
                'value' => $stats['total_categories'],
                'icon' => 'tags',
                'card' => 'stat-card-purple',
                'iconBg' => 'stat-icon-bg-purple',
                'url' => route('admin.categories.index'),
            ],
        ];
    @endphp

    {{-- Statistik utama --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ($statCards as $stat)
            <a href="{{ $stat['url'] }}" class="{{ $stat['card'] }} card-hover block transition-transform hover:scale-[1.02]">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-text/50 dark:text-dark-muted">
                            {{ $stat['label'] }}</p>
                        <p class="mt-2 truncate text-2xl font-bold">{{ $stat['value'] }}</p>
                    </div>
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full {{ $stat['iconBg'] }} shadow-inner">
                        <i data-lucide="{{ $stat['icon'] }}" class="h-5 w-5 text-accent dark:text-primary"
                            aria-hidden="true"></i>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Ringkasan cepat --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('admin.orders.index', ['payment' => 'pending']) }}"
            class="card card-hover flex items-center gap-4 !p-4 transition-transform hover:scale-[1.02]">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-200/60 dark:bg-orange-500/20">
                <i data-lucide="credit-card" class="h-5 w-5 text-accent dark:text-primary"></i>
            </div>
            <div>
                <p class="text-xs text-text/50 dark:text-dark-muted">Pembayaran Pending</p>
                <p class="text-xl font-bold">{{ $stats['pending_payments'] }}</p>
            </div>
        </a>
        <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}"
            class="card card-hover flex items-center gap-4 !p-4 transition-transform hover:scale-[1.02]">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-200/60 dark:bg-sky-500/20">
                <i data-lucide="mail" class="h-5 w-5 text-accent dark:text-primary"></i>
            </div>
            <div>
                <p class="text-xs text-text/50 dark:text-dark-muted">Pesan Belum Dibaca</p>
                <p class="text-xl font-bold">{{ $stats['unread_contacts'] }}</p>
            </div>
        </a>
        <a href="{{ route('admin.newsletters.index', ['status' => 'active']) }}"
            class="card card-hover flex items-center gap-4 !p-4 transition-transform hover:scale-[1.02]">
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
        <a href="{{ route('admin.reports.index') }}"
            class="card card-hover lg:col-span-2 transition-transform hover:scale-[1.005]">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold">Grafik Penjualan (30 Hari)</h3>
                <span class="text-xs font-medium text-accent dark:text-primary">Lihat Laporan →</span>
            </div>
            <canvas id="salesChart" height="120"></canvas>
            <div id="dashboard-chart-data" class="hidden"
                data-labels="{{ json_encode($salesChart->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) }}"
                data-revenue="{{ json_encode($salesChart->pluck('revenue')) }}">
            </div>
        </a>
        <div class="card">
            <h3 class="mb-4 font-semibold">Produk Terlaris</h3>
            @if ($topProducts->isNotEmpty())
                <canvas id="topProductsChart" height="200"></canvas>
                <div id="dashboard-top-products-data" class="hidden"
                    data-labels="{{ json_encode($topProducts->pluck('product_name')->map(fn($n) => \Illuminate\Support\Str::limit($n, 18))) }}"
                    data-sold="{{ json_encode($topProducts->pluck('total_sold')) }}">
                </div>
            @else
                <x-empty-state icon="bar-chart-2" title="Belum Ada Data Penjualan"
                    description="Grafik produk terlaris akan muncul setelah ada transaksi." />
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
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="block rounded-xl border border-border p-3 transition-all duration-200 hover:border-primary/40 hover:bg-secondary/50 dark:border-dark-border dark:hover:bg-dark-border">
                        <div class="flex justify-between gap-2">
                            <span class="text-sm font-medium">{{ $order->order_number }}</span>
                            <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
                        </div>
                        <p class="mt-1 text-xs text-text/50 dark:text-dark-muted">{{ $order->user->name }}</p>
                        <p class="mt-1 text-sm font-bold text-accent dark:text-primary">Rp
                            {{ number_format($order->total, 0, ',', '.') }}</p>
                    </a>
                @empty
                    <x-empty-state icon="shopping-bag" title="Belum Ada Pesanan"
                        description="Pesanan customer akan muncul di sini." :action-url="route('home')" action-label="Lihat Toko" />
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
                    <a href="{{ route('admin.customers.show', $customer) }}"
                        class="flex items-center gap-3 rounded-xl border border-border p-3 transition-all hover:bg-secondary/50 dark:border-dark-border dark:hover:bg-dark-border">
                        <img src="{{ $customer->avatar_url }}" alt=""
                            class="h-10 w-10 rounded-full object-cover ring-2 ring-primary/30">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">{{ $customer->name }}</p>
                            <p class="truncate text-xs text-text/50">{{ $customer->email }}</p>
                        </div>
                    </a>
                @empty
                    <x-empty-state icon="users" title="Belum Ada Customer"
                        description="Customer terdaftar akan muncul di sini." />
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
                    <a href="{{ route('admin.products.show', $product) }}"
                        class="flex items-center justify-between rounded-xl bg-secondary/50 px-3 py-2.5 transition-colors hover:bg-secondary dark:bg-dark-border/50 dark:hover:bg-dark-border">
                        <div class="min-w-0 pr-2">
                            <p class="truncate text-sm font-medium">{{ $product->name }}</p>
                            <p class="text-xs text-text/50">{{ $product->category->name }}</p>
                        </div>
                        <span class="badge badge-warning shrink-0">{{ $product->stock }} unit</span>
                    </a>
                @empty
                    <x-empty-state icon="package" title="Stok Aman"
                        description="Tidak ada produk dengan stok menipis saat ini." />
                @endforelse
            </div>
        </div>
    </div>

    {{-- Aktivitas & komunikasi --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="card">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold">Pesan Kontak Terbaru</h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-accent dark:text-primary">Semua →</a>
            </div>
            @forelse($recentContacts as $contact)
                <a href="{{ route('admin.contacts.index', ['search' => $contact->email]) }}"
                    class="mb-3 block rounded-xl border border-border p-3 transition-all last:mb-0 hover:border-primary/40 hover:bg-secondary/50 dark:border-dark-border dark:hover:bg-dark-border">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-sm font-medium">{{ $contact->subject }}</p>
                        @php
                            $recentContactStatus = $contact->status === 'unread' ? 'Belum Dibaca' : 'Dibaca';
                        @endphp
                        <span
                            class="badge {{ $contact->status === 'unread' ? 'badge-warning' : 'badge-success' }}">{{ $recentContactStatus }}</span>
                    </div>
                    <p class="mt-1 text-xs text-text/50">{{ $contact->name }} · {{ $contact->email }}</p>
                    <p class="mt-2 line-clamp-2 text-sm text-text/70 dark:text-dark-muted">{{ $contact->message }}</p>
                </a>
            @empty
                <x-empty-state icon="mail" title="Belum Ada Pesan"
                    description="Pesan dari form kontak akan muncul di sini." />
            @endforelse
        </div>

        <div class="card">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold">Subscriber Terbaru</h3>
                <a href="{{ route('admin.newsletters.index') }}" class="text-xs text-accent dark:text-primary">Semua →</a>
            </div>
            <div class="space-y-2">
                @forelse($recentSubscribers as $subscriber)
                    <a href="{{ route('admin.newsletters.index', ['search' => $subscriber->email]) }}"
                        class="flex items-center justify-between rounded-xl border border-border px-3 py-2.5 transition-colors hover:bg-secondary/50 dark:border-dark-border dark:hover:bg-dark-border">
                        <span class="truncate text-sm font-medium">{{ $subscriber->email }}</span>
                        <span
                            class="badge {{ $subscriber->is_active ? 'badge-success' : 'badge-danger' }} shrink-0">{{ $subscriber->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </a>
                @empty
                    <x-empty-state icon="newspaper" title="Belum Ada Subscriber"
                        description="Email yang mendaftar newsletter akan muncul di sini." />
                @endforelse
            </div>
        </div>
    </div>
@endsection
