@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Welcome --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}"
                    class="h-16 w-16 rounded-2xl border-2 border-primary object-cover shadow-sm">
                <div>
                    <h1 class="section-title text-xl sm:text-2xl">Halo, {{ $user->name }}!</h1>
                    <p class="text-sm text-text/60 dark:text-dark-muted">Selamat datang kembali di WijayCart</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-secondary text-sm">
                <i data-lucide="settings" class="h-4 w-4" aria-hidden="true"></i>
                Kelola Profil
            </a>
        </div>

        {{-- Ringkasan statistik --}}
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <a href="{{ route('orders.index') }}" class="card-hover group flex items-center gap-4">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/30 transition-transform group-hover:scale-105">
                    <i data-lucide="package" class="h-6 w-6 text-accent dark:text-primary" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $orderCount }}</p>
                    <p class="text-sm text-text/60 dark:text-dark-muted">Total Pesanan</p>
                </div>
            </a>
            <a href="{{ route('wishlist.index') }}" class="card-hover group flex items-center gap-4">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-danger/15 transition-transform group-hover:scale-105">
                    <i data-lucide="heart" class="h-6 w-6 text-danger" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $wishlistCount }}</p>
                    <p class="text-sm text-text/60 dark:text-dark-muted">Wishlist</p>
                </div>
            </a>
            <a href="{{ route('cart.index') }}" class="card-hover group flex items-center gap-4">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent/15 transition-transform group-hover:scale-105">
                    <i data-lucide="shopping-cart" class="h-6 w-6 text-accent dark:text-primary" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $cartCount }}</p>
                    <p class="text-sm text-text/60 dark:text-dark-muted">Item Keranjang</p>
                </div>
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-8 lg:col-span-2">
                {{-- Pesanan terbaru --}}
                <section aria-labelledby="recent-orders-heading">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 id="recent-orders-heading" class="text-lg font-bold">Pesanan Terbaru</h2>
                        <a href="{{ route('orders.index') }}"
                            class="text-sm font-medium text-accent hover:underline dark:text-primary">Lihat Semua</a>
                    </div>
                    @if ($recentOrders->isEmpty())
                        <x-empty-state icon="package-open" title="Belum Ada Pesanan"
                            description="Mulai belanja dan pesanan Anda akan muncul di sini." :action-url="route('products.index')"
                            action-label="Mulai Belanja" />
                    @else
                        <div class="card divide-y divide-border dark:divide-dark-border !p-0 overflow-hidden">
                            @foreach ($recentOrders as $order)
                                <a href="{{ route('orders.show', $order) }}"
                                    class="flex items-center justify-between px-5 py-4 transition-colors hover:bg-secondary/50 dark:hover:bg-dark-border/30">
                                    <div>
                                        <p class="font-semibold">{{ $order->order_number }}</p>
                                        <p class="text-xs text-text/50 dark:text-dark-muted">
                                            {{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-accent dark:text-primary">Rp
                                            {{ number_format($order->total, 0, ',', '.') }}</p>
                                        <span
                                            class="badge badge-{{ $order->status === 'delivered' ? 'success' : 'warning' }}">{{ $order->status_label }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- Produk rekomendasi --}}
                <section aria-labelledby="recommended-heading">
                    <h2 id="recommended-heading" class="mb-4 text-lg font-bold">Produk Rekomendasi</h2>
                    @if ($recommendedProducts->isEmpty())
                        <x-empty-state icon="shopping-bag" title="Belum Ada Rekomendasi"
                            description="Produk unggulan akan ditampilkan di sini." :action-url="route('products.index')"
                            action-label="Jelajahi Katalog" />
                    @else
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-2 lg:grid-cols-2">
                            @foreach ($recommendedProducts as $product)
                                @include('partials.product-card', [
                                    'product' => $product,
                                    'wishlistIds' => $wishlistIds,
                                ])
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>

            <div class="space-y-8">
                {{-- Alamat utama --}}
                <section class="card" aria-labelledby="address-heading">
                    <h2 id="address-heading" class="mb-4 flex items-center gap-2 text-lg font-bold">
                        <i data-lucide="map-pin" class="h-5 w-5 text-accent dark:text-primary" aria-hidden="true"></i>
                        Alamat Utama
                    </h2>
                    @if ($user->address)
                        <p class="text-sm leading-relaxed text-text/80 dark:text-dark-muted">{{ $user->address }}</p>
                        @if ($user->phone)
                            <p class="mt-2 flex items-center gap-2 text-sm text-text/60 dark:text-dark-muted">
                                <i data-lucide="phone" class="h-4 w-4" aria-hidden="true"></i>
                                {{ $user->phone }}
                            </p>
                        @endif
                        <a href="{{ route('profile.edit') }}"
                            class="mt-4 inline-flex text-sm font-medium text-accent hover:underline dark:text-primary">Ubah
                            Alamat</a>
                    @else
                        <x-empty-state icon="map-pin" title="Alamat Belum Diisi"
                            description="Lengkapi alamat agar checkout lebih cepat." :action-url="route('profile.edit')"
                            action-label="Tambah Alamat" />
                    @endif
                </section>

                {{-- Kategori populer --}}
                <section aria-labelledby="popular-categories-heading">
                    <h2 id="popular-categories-heading" class="mb-4 text-lg font-bold">Kategori Populer</h2>
                    @if ($popularCategories->isEmpty())
                        <x-empty-state icon="tags" title="Belum Ada Kategori"
                            description="Kategori produk akan muncul di sini." :action-url="route('products.index')"
                            action-label="Lihat Katalog" />
                    @else
                        <div class="space-y-3">
                            @foreach ($popularCategories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                    class="card-hover flex items-center gap-3 !p-3">
                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-border/40 dark:bg-dark-card dark:ring-dark-border">
                                        <i data-lucide="{{ $category->icon }}"
                                            class="h-6 w-6 text-accent dark:text-primary" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-semibold">{{ $category->name }}</p>
                                        <p class="text-xs text-text/50 dark:text-dark-muted">
                                            {{ $category->active_products_count }} produk</p>
                                    </div>
                                    <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 text-text/40"
                                        aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- Quick links --}}
                <section class="card">
                    <h2 class="mb-4 text-lg font-bold">Akses Cepat</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('cart.index') }}" class="btn-secondary py-2.5 text-xs">Keranjang</a>
                        <a href="{{ route('wishlist.index') }}" class="btn-secondary py-2.5 text-xs">Wishlist</a>
                        <a href="{{ route('orders.index') }}" class="btn-secondary py-2.5 text-xs">Pesanan</a>
                        <a href="{{ route('products.index') }}" class="btn-accent py-2.5 text-xs">Belanja</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
