@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="section-title">Kategori</h2>
                <p class="mt-2 text-text/60 dark:text-dark-muted">Jelajahi koleksi berdasarkan kategori</p>
            </div>
            <div class="mx-auto grid max-w-5xl grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach ($categories as $category)
                    @include('partials.category-card', ['category' => $category])
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-secondary/50 py-16 dark:bg-dark-card/30">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="section-title">Produk Unggulan</h2>
                <p class="mt-2 text-text/60 dark:text-dark-muted">Produk pilihan terbaik untuk Anda</p>
            </div>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-6">
                @foreach ($featuredProducts as $product)
                    @include('partials.product-card', [
                        'product' => $product,
                        'wishlistIds' => $wishlistIds ?? [],
                    ])
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="section-title">Produk Terbaru</h2>
                <p class="mt-2 text-text/60 dark:text-dark-muted">Koleksi terbaru yang baru saja hadir</p>
            </div>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-6">
                @foreach ($latestProducts as $product)
                    @include('partials.product-card', [
                        'product' => $product,
                        'wishlistIds' => $wishlistIds ?? [],
                    ])
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-r from-primary/20 to-secondary py-16 dark:from-primary/10 dark:to-dark-card">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
            <i data-lucide="mail" class="mx-auto mb-4 h-10 w-10 text-accent dark:text-primary" aria-hidden="true"></i>
            <h2 class="mb-3 text-2xl font-bold">Dapatkan Update Terbaru</h2>
            <p class="mb-6 text-text/60 dark:text-dark-muted">Berlangganan newsletter untuk penawaran eksklusif dan produk
                baru.</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mx-auto flex max-w-md gap-2"
                aria-label="Form newsletter">
                @csrf
                <label for="newsletter-email" class="sr-only">Email</label>
                <input id="newsletter-email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="Email Anda" class="input-field flex-1" required>
                <button type="submit" class="btn-accent shrink-0"
                    aria-label="Berlangganan newsletter">Berlangganan</button>
            </form>
        </div>
    </section>
@endsection
