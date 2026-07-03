@extends('layouts.admin')

@section('title', $supplier->name)
@section('page-title', 'Detail Supplier')

@section('content')
    <x-admin.detail-toolbar :back-url="route('admin.suppliers.index')" back-label="Kembali ke Daftar Supplier" />

    <div class="grid gap-6 lg:grid-cols-3">
    <div class="card lg:col-span-1">
        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-primary">
            <i data-lucide="truck" class="h-7 w-7 text-accent"></i>
        </div>
        <p class="font-mono text-xs text-text/50">{{ $supplier->code }}</p>
        <h2 class="mt-1 text-xl font-bold">{{ $supplier->name }}</h2>
        <div class="mt-4">
            <span class="badge {{ $supplier->status === 'active' ? 'badge-success' : 'badge-danger' }}">{{ $supplier->status_label }}</span>
        </div>
        <div class="mt-6 space-y-3 text-sm">
            <p class="flex items-center gap-2"><i data-lucide="user" class="h-4 w-4 text-accent"></i> {{ $supplier->contact_person ?? '-' }}</p>
            <p class="flex items-center gap-2"><i data-lucide="phone" class="h-4 w-4 text-accent"></i> {{ $supplier->phone ?? '-' }}</p>
            <p class="flex items-center gap-2"><i data-lucide="mail" class="h-4 w-4 text-accent"></i> {{ $supplier->email ?? '-' }}</p>
            <p class="flex items-start gap-2"><i data-lucide="map-pin" class="mt-0.5 h-4 w-4 text-accent"></i> {{ $supplier->address ?? '-' }}</p>
        </div>
        @if($supplier->notes)
        <div class="mt-6 rounded-xl bg-secondary/60 p-4 dark:bg-dark-border/40">
            <p class="text-xs font-semibold uppercase text-text/50">Catatan</p>
            <p class="mt-1 text-sm text-text/70">{{ $supplier->notes }}</p>
        </div>
        @endif
        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn-accent text-sm">Edit</a>
            <a href="{{ route('admin.suppliers.index') }}" class="btn-secondary text-sm">Kembali</a>
        </div>
    </div>
    <div class="card lg:col-span-2">
        <h3 class="mb-4 flex items-center gap-2 font-semibold"><i data-lucide="package" class="h-4 w-4"></i> Produk dari Supplier ({{ $supplier->products->count() }})</h3>
        @forelse($supplier->products as $product)
        <a href="{{ route('admin.products.show', $product) }}" class="mb-3 block rounded-xl border border-border p-4 transition-colors hover:bg-secondary dark:border-dark-border dark:hover:bg-dark-border">
            <div class="flex justify-between gap-4">
                <div>
                    <span class="font-medium">{{ $product->name }}</span>
                    <p class="mt-1 text-xs text-text/50">{{ $product->category->name ?? '-' }}</p>
                </div>
                <span class="font-bold text-accent dark:text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
        </a>
        @empty
        <p class="text-sm text-text/50">Belum ada produk dari supplier ini.</p>
        @endforelse
    </div>
</div>
@endsection
