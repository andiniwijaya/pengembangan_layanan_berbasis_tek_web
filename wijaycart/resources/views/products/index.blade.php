@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h1 class="section-title">Katalog Produk</h1>
            <p class="mt-2 text-text/60 dark:text-dark-muted">Jelajahi koleksi lifestyle premium WijayCart</p>
        </div>

        <x-store.catalog-filters :categories="$categories" />

        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-text/60 dark:text-dark-muted">
                Menampilkan <span class="font-semibold text-text dark:text-dark-text">{{ $products->count() }}</span> dari
                <span class="font-semibold">{{ $products->total() }}</span> produk
            </p>
            @if (request()->hasAny(['search', 'category', 'min_price', 'max_price', 'stock', 'sort']))
                <span class="badge badge-warning">Filter Aktif</span>
            @endif
        </div>

        @if ($products->count())
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-5">
                @foreach ($products as $product)
                    @include('partials.product-card', ['product' => $product, 'wishlistIds' => $wishlistIds])
                @endforeach
            </div>
            <div class="mt-10">{{ $products->links() }}</div>
        @else
            <x-empty-state icon="search-x" title="Produk Tidak Ditemukan"
                description="Coba ubah kata kunci pencarian atau reset filter untuk melihat lebih banyak produk."
                :action-url="route('products.index')" action-label="Reset Filter" />
        @endif
    </div>
@endsection
