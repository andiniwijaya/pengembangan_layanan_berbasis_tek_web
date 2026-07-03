@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8" id="cart-page">
        <h1 class="section-title mb-2">Keranjang Belanja</h1>
        <p class="mb-8 text-sm text-text/60 dark:text-dark-muted">{{ $cart->item_count }} item di keranjang</p>

        @if ($cart->items->count())
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-5">
                @foreach ($cart->items as $item)
                    <article class="cart-item-card flex flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-sm dark:border-dark-border dark:bg-dark-card"
                        data-cart-item="{{ $item->id }}">
                        <a href="{{ route('products.show', $item->product->slug) }}"
                            class="relative aspect-square overflow-hidden bg-secondary dark:bg-dark-border">
                            <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}"
                                class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                        </a>
                        <div class="flex flex-1 flex-col p-3">
                            <a href="{{ route('products.show', $item->product->slug) }}"
                                class="line-clamp-2 text-sm font-semibold hover:text-accent dark:hover:text-primary">
                                {{ $item->product->name }}
                            </a>
                            <p class="mt-1 text-xs text-text/50">{{ $item->product->barcode }}</p>
                            <p class="mt-2 text-sm font-bold text-accent dark:text-primary">Rp
                                {{ number_format($item->product->price, 0, ',', '.') }}</p>

                            <div class="mt-3 flex items-center justify-center gap-1.5">
                                <button type="button" data-qty-minus
                                    class="rounded-lg border border-border p-1.5 hover:bg-secondary dark:border-dark-border dark:hover:bg-dark-border"
                                    aria-label="Kurangi">
                                    <i data-lucide="minus" class="h-3.5 w-3.5"></i>
                                </button>
                                <input type="number" data-qty-input value="{{ $item->quantity }}" min="1"
                                    max="{{ $item->product->stock }}"
                                    class="input-field w-12 px-1 py-1.5 text-center text-sm" aria-label="Jumlah">
                                <button type="button" data-qty-plus
                                    class="rounded-lg border border-border p-1.5 hover:bg-secondary dark:border-dark-border dark:hover:bg-dark-border"
                                    aria-label="Tambah">
                                    <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                </button>
                            </div>

                            <p class="mt-3 text-center text-sm font-bold" data-item-subtotal>Rp
                                {{ number_format($item->subtotal, 0, ',', '.') }}</p>

                            <button type="button" data-cart-delete
                                class="mt-3 flex w-full items-center justify-center gap-1.5 rounded-xl border border-danger/30 py-2 text-xs font-medium text-danger transition-colors hover:bg-danger/10"
                                aria-label="Hapus item">
                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                Hapus
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 flex justify-end">
                <div class="card w-full max-w-md">
                    <h2 class="mb-4 font-semibold">Ringkasan Belanja</h2>
                    <div class="space-y-3 border-b border-border pb-4 dark:border-dark-border">
                        <div class="flex justify-between text-sm">
                            <span class="text-text/60">Subtotal</span>
                            <span class="font-medium" id="cart-subtotal">Rp
                                {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-text/60">Total Item</span>
                            <span id="cart-item-count">{{ $cart->item_count }}</span>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between text-lg font-bold">
                        <span>Total Belanja</span>
                        <span class="text-accent dark:text-primary" id="cart-total">Rp
                            {{ number_format($cart->total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn-accent mt-6 w-full">Lanjut Checkout</a>
                    <a href="{{ route('products.index') }}" class="btn-secondary mt-3 w-full text-center">Lanjut
                        Belanja</a>
                </div>
            </div>
        @else
            <x-empty-state icon="shopping-cart" title="Keranjang Masih Kosong"
                description="Yuk, tambahkan produk lifestyle favorit Anda ke keranjang belanja."
                :action-url="route('products.index')" action-label="Mulai Belanja" />
        @endif
    </div>
@endsection
