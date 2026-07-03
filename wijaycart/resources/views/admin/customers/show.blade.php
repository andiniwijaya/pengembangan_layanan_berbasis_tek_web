@extends('layouts.admin')

@section('title', $customer->name)
@section('page-title', 'Detail Customer')

@section('content')
    <x-admin.detail-toolbar :back-url="route('admin.customers.index')" back-label="Kembali ke Daftar Customer" />

    <div class="grid gap-6 lg:grid-cols-3">
    <div class="card">
        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary text-2xl font-bold text-accent">
            {{ strtoupper(substr($customer->name, 0, 1)) }}
        </div>
        <h2 class="text-xl font-bold">{{ $customer->name }}</h2>
        <div class="mt-4 space-y-2 text-sm">
            <p class="flex items-center gap-2"><i data-lucide="mail" class="h-4 w-4 text-accent"></i> {{ $customer->email }}</p>
            <p class="flex items-center gap-2"><i data-lucide="phone" class="h-4 w-4 text-accent"></i> {{ $customer->phone ?? '-' }}</p>
            <p class="flex items-start gap-2"><i data-lucide="map-pin" class="mt-0.5 h-4 w-4 text-accent"></i> {{ $customer->address ?? '-' }}</p>
        </div>
    </div>
    <div class="card lg:col-span-2">
        <h3 class="mb-4 font-semibold">Riwayat Pesanan</h3>
        @forelse($customer->orders as $order)
        <a href="{{ route('admin.orders.show', $order) }}" class="mb-3 block rounded-xl border border-border p-4 transition-colors hover:bg-secondary dark:border-dark-border dark:hover:bg-dark-border">
            <div class="flex justify-between">
                <span class="font-medium">{{ $order->order_number }}</span>
                <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
            </div>
            <p class="mt-1 text-sm text-accent dark:text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        </a>
        @empty
        <p class="text-sm text-text/50">Belum ada pesanan.</p>
        @endforelse
    </div>
</div>
@endsection
