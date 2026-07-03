@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8" id="cart-page">
    <h1 class="section-title mb-8">Keranjang Belanja</h1>

    @if($cart->items->count())
    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart->items as $item)
            <div class="card flex flex-col gap-4 sm:flex-row sm:items-center" data-cart-item="{{ $item->id }}">
                <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="h-24 w-24 shrink-0 rounded-xl object-cover">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('products.show', $item->product->slug) }}" class="font-semibold hover:text-accent">{{ $item->product->name }}</a>
                    <p class="text-xs text-text/50">{{ $item->product->barcode }}</p>
                    <p class="mt-1 font-bold text-accent dark:text-primary">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" data-qty-minus class="rounded-lg border border-border p-2 hover:bg-secondary dark:border-dark-border dark:hover:bg-dark-border" aria-label="Kurangi">
                        <i data-lucide="minus" class="h-4 w-4"></i>
                    </button>
                    <input type="number" data-qty-input value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="input-field w-16 text-center py-2" aria-label="Jumlah">
                    <button type="button" data-qty-plus class="rounded-lg border border-border p-2 hover:bg-secondary dark:border-dark-border dark:hover:bg-dark-border" aria-label="Tambah">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                    </button>
                </div>
                <p class="font-bold whitespace-nowrap" data-item-subtotal>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                <button type="button" data-cart-delete class="rounded-lg p-2 text-danger hover:bg-danger/10" aria-label="Hapus item">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                </button>
            </div>
            @endforeach
        </div>

        <div class="card h-fit sticky top-24">
            <h2 class="mb-4 font-semibold">Ringkasan Belanja</h2>
            <div class="space-y-3 border-b border-border pb-4 dark:border-dark-border">
                <div class="flex justify-between text-sm">
                    <span class="text-text/60">Subtotal</span>
                    <span class="font-medium" id="cart-subtotal">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-text/60">Total Item</span>
                    <span id="cart-item-count">{{ $cart->item_count }}</span>
                </div>
            </div>
            <div class="mt-4 flex justify-between text-lg font-bold">
                <span>Total Belanja</span>
                <span class="text-accent dark:text-primary" id="cart-total">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn-accent mt-6 w-full">Lanjut Checkout</a>
            <a href="{{ route('products.index') }}" class="btn-secondary mt-3 w-full text-center">Lanjut Belanja</a>
        </div>
    </div>
    @else
    <x-empty-state
        icon="shopping-cart"
        title="Keranjang Masih Kosong"
        description="Yuk, tambahkan produk lifestyle favorit Anda ke keranjang belanja."
        :action-url="route('products.index')"
        action-label="Mulai Belanja"
    />
    @endif
</div>
@endsection
