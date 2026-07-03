{{-- Product card katalog e-commerce dengan informasi lengkap --}}
@php
    $inWishlist = isset($wishlistIds) && in_array($product->id, $wishlistIds);
@endphp

<article
    class="product-card group flex flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-dark-border dark:bg-dark-card">
    {{-- Foto Produk --}}
    <div class="relative aspect-square overflow-hidden bg-secondary dark:bg-dark-border">
        <a href="{{ route('products.show', $product->slug) }}" tabindex="-1" aria-hidden="true">
            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
        </a>
        @if ($product->is_featured)
            <span class="absolute left-3 top-3 badge badge-warning">Unggulan</span>
        @endif
        <span class="absolute right-3 top-3 badge badge-{{ $product->stock_color }}">{{ $product->stock_label }}</span>
    </div>

    <div class="flex flex-1 flex-col p-4">
        {{-- Kategori --}}
        <p class="mb-1 text-xs font-semibold uppercase tracking-wider text-accent/80 dark:text-primary/80">
            {{ $product->category->name }}</p>

        {{-- Nama Produk --}}
        <a href="{{ route('products.show', $product->slug) }}"
            class="mb-2 line-clamp-2 font-semibold text-text transition-colors hover:text-accent dark:text-dark-text dark:hover:text-primary">
            {{ $product->name }}
        </a>

        {{-- Rating --}}
        @include('partials.product-rating', [
            'rating' => $product->average_rating,
            'count' => $product->review_count,
        ])

        {{-- Harga --}}
        <p class="mb-1 text-lg font-bold text-accent dark:text-primary">Rp
            {{ number_format($product->price, 0, ',', '.') }}</p>

        {{-- Barcode --}}
        <p class="mb-4 flex items-center gap-1 text-xs text-text/50 dark:text-dark-muted">
            <i data-lucide="barcode" class="h-3 w-3"></i> {{ $product->barcode }}
        </p>

        {{-- Tombol Aksi --}}
        <div class="mt-auto flex flex-col gap-2">
            <a href="{{ route('products.show', $product->slug) }}" class="btn-secondary w-full py-2.5 text-xs">
                <i data-lucide="eye" class="h-3.5 w-3.5"></i> Detail
            </a>

            @auth
                <div class="flex gap-2">
                    <form action="{{ route('cart.store') }}" method="POST" class="flex-1" data-add-to-cart
                        data-ajax="true">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                            class="flex w-full items-center justify-center gap-1.5 rounded-xl bg-primary py-2.5 text-xs font-semibold text-accent transition-all hover:bg-primary-dark hover:scale-[1.02] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
                            @disabled(!$product->isInStock())>
                            <i data-lucide="shopping-cart" class="h-3.5 w-3.5"></i> Keranjang
                        </button>
                    </form>
                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="rounded-xl border border-border p-2.5 transition-all hover:border-danger hover:text-danger dark:border-dark-border {{ $inWishlist ? 'bg-danger/10 text-danger border-danger/30' : 'text-text/60 dark:text-dark-muted' }}"
                            aria-label="{{ $inWishlist ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}">
                            <i data-lucide="heart" class="h-4 w-4 {{ $inWishlist ? 'fill-current' : '' }}"></i>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-primary w-full py-2.5 text-xs text-center">Login untuk Beli</a>
            @endauth
        </div>
    </div>
</article>
