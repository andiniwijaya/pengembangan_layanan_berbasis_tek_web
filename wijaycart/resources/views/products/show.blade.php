@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-text/50 dark:text-dark-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-accent">Beranda</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <a href="{{ route('products.index') }}" class="hover:text-accent">Katalog</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                class="hover:text-accent">{{ $product->category->name }}</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <span class="text-text dark:text-dark-text">{{ $product->name }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-2">
            {{-- Gallery Foto --}}
            <div id="product-gallery">
                <div
                    class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm dark:border-dark-border dark:bg-dark-card">
                    <img id="product-main-image" src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                        class="aspect-square w-full object-cover transition-transform duration-300">
                </div>
                @if ($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3 sm:grid-cols-5">
                        @foreach ($product->images as $index => $image)
                            <button type="button" data-gallery-thumb="{{ $image->url }}"
                                class="overflow-hidden rounded-xl border border-border transition-all hover:opacity-80 dark:border-dark-border {{ $index === 0 ? 'ring-2 ring-primary' : '' }}"
                                aria-label="Lihat foto {{ $index + 1 }}">
                                <img src="{{ $image->url }}" alt="Foto {{ $product->name }} {{ $index + 1 }}"
                                    class="aspect-square w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Informasi Produk --}}
            <div class="animate-slide-up">
                <span class="badge badge-warning mb-3">{{ $product->category->name }}</span>
                <h1 class="mb-4 text-3xl font-bold leading-tight md:text-4xl">{{ $product->name }}</h1>

                {{-- Rating --}}
                <div class="mb-4">
                    @include('partials.product-rating', [
                        'rating' => $product->average_rating,
                        'count' => $product->review_count,
                        'size' => 'lg',
                    ])
                </div>

                <p class="mb-6 text-3xl font-bold text-accent dark:text-primary">Rp
                    {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="mb-6 grid gap-3 rounded-xl bg-secondary/60 p-4 dark:bg-dark-border/40 sm:grid-cols-2">
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="barcode" class="h-4 w-4 text-accent"></i>
                        <span class="text-text/60">Barcode:</span>
                        <span class="font-mono font-medium">{{ $product->barcode }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="package" class="h-4 w-4 text-accent"></i>
                        <span class="text-text/60">Stok:</span>
                        <span class="badge badge-{{ $product->stock_color }}">{{ $product->stock_label }}
                            ({{ $product->stock }})</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm sm:col-span-2">
                        <i data-lucide="tag" class="h-4 w-4 text-accent"></i>
                        <span class="text-text/60">Kategori:</span>
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                            class="font-medium text-accent hover:underline dark:text-primary">{{ $product->category->name }}</a>
                    </div>
                    @if ($product->supplier)
                        <div class="flex items-center gap-2 text-sm sm:col-span-2">
                            <i data-lucide="truck" class="h-4 w-4 text-accent"></i>
                            <span class="text-text/60">Supplier:</span>
                            <span class="font-medium">{{ $product->supplier->name }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-8">
                    <h2 class="mb-2 text-sm font-semibold uppercase tracking-wider text-accent dark:text-primary">Deskripsi
                    </h2>
                    <p class="leading-relaxed text-text/70 dark:text-dark-muted">{{ $product->description }}</p>
                </div>

                @auth
                    @if (auth()->user()->isCustomer())
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <form action="{{ route('cart.store') }}" method="POST" class="flex flex-1 items-center gap-3"
                                data-add-to-cart data-ajax="true">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <label for="quantity" class="sr-only">Jumlah pembelian</label>
                                <div class="flex items-center rounded-xl border border-border dark:border-dark-border">
                                    <button type="button" id="qty-minus"
                                        class="px-3 py-3 hover:bg-secondary dark:hover:bg-dark-border" aria-label="Kurangi jumlah">
                                        <i data-lucide="minus" class="h-4 w-4"></i>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ max(1, $product->stock) }}"
                                        class="w-16 border-x border-border bg-transparent py-3 text-center text-sm font-semibold dark:border-dark-border"
                                        @disabled(!$product->isInStock())>
                                    <button type="button" id="qty-plus"
                                        class="px-3 py-3 hover:bg-secondary dark:hover:bg-dark-border" aria-label="Tambah jumlah"
                                        @disabled(!$product->isInStock())>
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                    </button>
                                </div>
                                <button type="submit" class="btn-accent flex-1" @disabled(!$product->isInStock())>
                                    <i data-lucide="shopping-cart" class="h-4 w-4"></i>
                                    {{ $product->isInStock() ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                                </button>
                            </form>
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn-secondary px-5 py-3 {{ $inWishlist ? 'border-danger text-danger' : '' }}"
                                    aria-label="Wishlist">
                                    <i data-lucide="heart" class="h-4 w-4 {{ $inWishlist ? 'fill-current' : '' }}"></i>
                                </button>
                            </form>
                        </div>
                    @elseif (auth()->user()->isAdmin())
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-secondary inline-flex">
                            <i data-lucide="pencil" class="h-4 w-4"></i> Kelola Produk di Admin
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-accent inline-flex">Login untuk Membeli</a>
                @endauth
            </div>
        </div>

        @if ($relatedProducts->count())
            <section class="mt-16 border-t border-border pt-12 dark:border-dark-border">
                <h2 class="section-title mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                        @include('partials.product-card', [
                            'product' => $related,
                            'wishlistIds' => $wishlistIds,
                        ])
                    @endforeach
                </div>
            </section>
        @endif

        <section class="mt-16 border-t border-border pt-12 dark:border-dark-border">
            <h2 class="section-title mb-6">Ulasan Pelanggan ({{ $product->review_count }})</h2>

            @if ($userReview)
                <div class="card mb-6 !border-primary/30">
                    <p class="mb-2 text-sm font-semibold">Ulasan Anda</p>
                    @include('partials.product-rating', [
                        'rating' => $userReview->rating,
                        'count' => 0,
                        'size' => 'lg',
                        'showCount' => false,
                    ])
                    @if ($userReview->comment)
                        <p class="mt-2 text-sm text-text/70 dark:text-dark-muted">{{ $userReview->comment }}</p>
                    @endif
                </div>
            @elseif($canReview && $eligibleOrders->isNotEmpty())
                <div class="card mb-6">
                    <h3 class="mb-4 font-semibold">Tulis Ulasan</h3>
                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="order_id" class="mb-1 block text-sm font-medium">Pesanan</label>
                            <select name="order_id" id="order_id" class="input-field" required>
                                @foreach ($eligibleOrders as $order)
                                    <option value="{{ $order->id }}">{{ $order->order_number }} — Selesai</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="rating" class="mb-1 block text-sm font-medium">Rating (1–5)</label>
                            <select name="rating" id="rating" class="input-field max-w-xs" required>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} Bintang</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="comment" class="mb-1 block text-sm font-medium">Komentar (opsional)</label>
                            <textarea name="comment" id="comment" rows="3" class="input-field" maxlength="1000"
                                placeholder="Bagikan pengalaman Anda..."></textarea>
                        </div>
                        <button type="submit" class="btn-accent">Kirim Ulasan</button>
                    </form>
                </div>
            @elseif(auth()->check() && !$userReview)
                <p class="mb-6 text-sm text-text/60 dark:text-dark-muted">Anda dapat memberikan ulasan setelah pesanan
                    produk ini selesai.</p>
            @endif

            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <article class="card !p-4">
                        <div class="mb-2 flex items-center justify-between gap-2">
                            <p class="font-medium">{{ $review->user->name }}</p>
                            @include('partials.product-rating', [
                                'rating' => $review->rating,
                                'count' => 0,
                                'size' => 'sm',
                                'showCount' => false,
                            ])
                        </div>
                        @if ($review->comment)
                            <p class="text-sm text-text/70 dark:text-dark-muted">{{ $review->comment }}</p>
                        @endif
                        <p class="mt-2 text-xs text-text/40 dark:text-dark-muted">
                            {{ $review->created_at->format('d M Y') }}</p>
                    </article>
                @empty
                    <p class="text-sm text-text/60 dark:text-dark-muted">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
