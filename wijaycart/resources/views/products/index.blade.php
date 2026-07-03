@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    {{-- Header Katalog --}}
    <div class="mb-8 animate-fade-in">
        <h1 class="section-title">Katalog Produk</h1>
        <p class="mt-2 text-text/60 dark:text-dark-muted">Jelajahi koleksi lifestyle premium WijayCart</p>
    </div>

    <div class="grid gap-8 lg:grid-cols-4">
        {{-- Sidebar Filter --}}
        <aside class="lg:col-span-1">
            <div class="card sticky top-24 space-y-1">
                <h2 class="mb-4 flex items-center gap-2 text-base font-semibold">
                    <i data-lucide="sliders-horizontal" class="h-4 w-4 text-accent"></i> Filter & Urutkan
                </h2>
                <form action="{{ route('products.index') }}" method="GET" class="space-y-4" id="catalog-filter-form">
                    <div>
                        <label for="search" class="mb-1.5 block text-sm font-medium">Cari Produk</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text/40"></i>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" class="input-field pl-10" placeholder="Nama, barcode, kategori...">
                        </div>
                    </div>
                    <div>
                        <label for="category" class="mb-1.5 block text-sm font-medium">Kategori</label>
                        <select id="category" name="category" class="input-field">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }} ({{ $category->active_products_count }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="min_price" class="mb-1.5 block text-sm font-medium">Harga Min</label>
                            <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" class="input-field" placeholder="0" min="0">
                        </div>
                        <div>
                            <label for="max_price" class="mb-1.5 block text-sm font-medium">Harga Max</label>
                            <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" class="input-field" placeholder="999999" min="0">
                        </div>
                    </div>
                    <div>
                        <label for="stock" class="mb-1.5 block text-sm font-medium">Status Stok</label>
                        <select id="stock" name="stock" class="input-field">
                            <option value="">Semua Stok</option>
                            <option value="available" @selected(request('stock') === 'available')>Tersedia</option>
                            <option value="low" @selected(request('stock') === 'low')>Stok Terbatas</option>
                            <option value="out" @selected(request('stock') === 'out')>Habis</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="mb-1.5 block text-sm font-medium">Urutkan</label>
                        <select id="sort" name="sort" class="input-field">
                            <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: Rendah - Tinggi</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: Tinggi - Rendah</option>
                            <option value="name" @selected(request('sort') === 'name')>Nama: A - Z</option>
                            <option value="name_desc" @selected(request('sort') === 'name_desc')>Nama: Z - A</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-accent w-full">
                        <i data-lucide="filter" class="h-4 w-4"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-secondary w-full text-center">Reset Filter</a>
                </form>
            </div>
        </aside>

        {{-- Grid Produk --}}
        <div class="lg:col-span-3">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-text/60 dark:text-dark-muted">
                    Menampilkan <span class="font-semibold text-text dark:text-dark-text">{{ $products->count() }}</span> dari <span class="font-semibold">{{ $products->total() }}</span> produk
                </p>
                @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'stock', 'sort']))
                <span class="badge badge-warning">Filter Aktif</span>
                @endif
            </div>

            @if($products->count())
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product, 'wishlistIds' => $wishlistIds])
                @endforeach
            </div>
            <div class="mt-10">{{ $products->links() }}</div>
            @else
            <x-empty-state
                icon="search-x"
                title="Produk Tidak Ditemukan"
                description="Coba ubah kata kunci pencarian atau reset filter untuk melihat lebih banyak produk."
                :action-url="route('products.index')"
                action-label="Reset Filter"
            />
            @endif
        </div>
    </div>
</div>
@endsection
