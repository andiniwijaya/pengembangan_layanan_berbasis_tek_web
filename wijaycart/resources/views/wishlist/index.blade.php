@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="section-title mb-2">Wishlist Saya</h1>
    <p class="mb-8 text-sm text-text/60 dark:text-dark-muted">{{ $wishlists->count() }} produk disimpan</p>

    @if($wishlists->count())
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($wishlists as $wishlist)
            @include('partials.product-card', ['product' => $wishlist->product, 'wishlistIds' => $wishlists->pluck('product_id')->toArray()])
        @endforeach
    </div>
    @else
    <x-empty-state
        icon="heart"
        title="Wishlist Masih Kosong"
        description="Simpan produk favorit Anda ke wishlist agar mudah ditemukan kembali nanti."
        :action-url="route('products.index')"
        action-label="Jelajahi Produk"
    />
    @endif
</div>
@endsection
