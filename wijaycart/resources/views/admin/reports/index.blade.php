@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan Admin')

@section('content')
@php
$tabs = [
    'sales' => ['label' => 'Penjualan', 'icon' => 'trending-up'],
    'products' => ['label' => 'Produk', 'icon' => 'package'],
    'customers' => ['label' => 'Customer', 'icon' => 'users'],
    'orders' => ['label' => 'Pesanan', 'icon' => 'shopping-bag'],
];
@endphp

<div class="mb-6 flex flex-wrap gap-2">
    @foreach($tabs as $key => $t)
    <a href="{{ route('admin.reports.index', ['tab' => $key]) }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition-all {{ $tab === $key ? 'bg-primary text-accent shadow-sm' : 'bg-card border border-border text-text/70 hover:bg-secondary dark:bg-dark-card dark:border-dark-border' }}">
        <i data-lucide="{{ $t['icon'] }}" class="h-4 w-4"></i> {{ $t['label'] }}
    </a>
    @endforeach
</div>

@if($tab === 'sales')
<div class="mb-8 grid gap-4 sm:grid-cols-3">
    <div class="card"><p class="text-xs uppercase text-text/50">Total Pendapatan</p><p class="mt-1 text-2xl font-bold text-accent dark:text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p></div>
    <div class="card"><p class="text-xs uppercase text-text/50">Total Pesanan</p><p class="mt-1 text-2xl font-bold">{{ $totalOrders }}</p></div>
    <div class="card"><p class="text-xs uppercase text-text/50">Rata-rata Order</p><p class="mt-1 text-2xl font-bold">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p></div>
</div>
<div class="grid gap-6 lg:grid-cols-2">
    <div class="card"><h3 class="mb-4 font-semibold">Penjualan Bulanan</h3><canvas id="monthlyChart" height="200"></canvas></div>
    <div class="card"><h3 class="mb-4 font-semibold">Status Pesanan</h3><canvas id="statusChart" height="200"></canvas></div>
</div>
<div class="card mt-6">
    <h3 class="mb-4 font-semibold">Produk Terlaris</h3>
    <table class="w-full text-left text-sm">
        <thead class="border-b border-border dark:border-dark-border"><tr><th class="py-2">Produk</th><th class="py-2">Terjual</th><th class="py-2">Pendapatan</th></tr></thead>
        <tbody>@foreach($topProducts as $p)<tr class="border-b border-border/50 dark:border-dark-border/50"><td class="py-3">{{ $p->product_name }}</td><td>{{ $p->total_sold }}</td><td class="font-semibold">Rp {{ number_format($p->revenue, 0, ',', '.') }}</td></tr>@endforeach</tbody>
    </table>
</div>
<div id="report-chart-data" class="hidden" data-monthly="{{ json_encode($monthlySales) }}" data-status="{{ json_encode($statusBreakdown) }}"></div>

@elseif($tab === 'products')
<div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
    @foreach($productStats as $label => $value)
    <div class="card"><p class="text-xs uppercase text-text/50">{{ str_replace('_', ' ', $label) }}</p><p class="mt-1 text-2xl font-bold">{{ $value }}</p></div>
    @endforeach
</div>
<div class="grid gap-6 lg:grid-cols-2">
    <div class="card">
        <h3 class="mb-4 font-semibold">Produk per Kategori</h3>
        @foreach($productsByCategory as $cat)
        <div class="mb-3 flex justify-between text-sm"><span>{{ $cat->name }}</span><span class="font-semibold">{{ $cat->products_count }}</span></div>
        @endforeach
    </div>
    <div class="card">
        <h3 class="mb-4 font-semibold">Stok Menipis</h3>
        @forelse($lowStockProducts as $p)
        <div class="mb-3 flex justify-between text-sm"><span>{{ $p->name }}</span><span class="badge badge-warning">{{ $p->stock }} tersisa</span></div>
        @empty
        <p class="text-sm text-text/50">Semua stok aman.</p>
        @endforelse
    </div>
</div>

@elseif($tab === 'customers')
<div class="mb-8 grid gap-4 sm:grid-cols-3">
    @foreach($customerStats as $label => $value)
    <div class="card"><p class="text-xs uppercase text-text/50">{{ str_replace('_', ' ', $label) }}</p><p class="mt-1 text-2xl font-bold">{{ $value }}</p></div>
    @endforeach
</div>
<div class="card">
    <h3 class="mb-4 font-semibold">Top Customer</h3>
    <table class="w-full text-left text-sm">
        <thead class="border-b border-border dark:border-dark-border"><tr><th class="py-2">Nama</th><th class="py-2">Pesanan</th><th class="py-2">Total Belanja</th></tr></thead>
        <tbody>@foreach($topCustomers as $c)<tr class="border-b border-border/50 dark:border-dark-border/50"><td class="py-3">{{ $c->name }}</td><td>{{ $c->orders_count }}</td><td class="font-semibold">Rp {{ number_format($c->orders_sum_total ?? 0, 0, ',', '.') }}</td></tr>@endforeach</tbody>
    </table>
</div>

@else
<div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
    @foreach(['pending' => 'Pending', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'delivered' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
    <div class="card"><p class="text-xs uppercase text-text/50">{{ $label }}</p><p class="mt-1 text-2xl font-bold">{{ $orderStats[$key] }}</p></div>
    @endforeach
</div>
<div class="card">
    <h3 class="mb-4 font-semibold">Pesanan Terbaru</h3>
    <table class="w-full text-left text-sm">
        <thead class="border-b border-border dark:border-dark-border"><tr><th class="py-2">No. Pesanan</th><th class="py-2">Customer</th><th class="py-2">Status</th><th class="py-2">Total</th></tr></thead>
        <tbody>@foreach($recentOrders as $o)<tr class="border-b border-border/50 dark:border-dark-border/50"><td class="py-3"><a href="{{ route('admin.orders.show', $o) }}" class="font-medium hover:text-accent">{{ $o->order_number }}</a></td><td>{{ $o->user->name }}</td><td><span class="badge badge-{{ $o->status_color }}">{{ $o->status_label }}</span></td><td class="font-semibold">Rp {{ number_format($o->total, 0, ',', '.') }}</td></tr>@endforeach</tbody>
    </table>
</div>
@endif
@endsection
