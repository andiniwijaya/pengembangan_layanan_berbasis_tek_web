@props([
    'categories',
])

@php
    $hasFilters = request()->hasAny(['search', 'category', 'min_price', 'max_price', 'stock', 'sort']);
@endphp

<div class="card !p-4 md:!p-5">
    <h2 class="mb-4 flex items-center gap-2 text-base font-semibold">
        <i data-lucide="sliders-horizontal" class="h-4 w-4 text-accent dark:text-primary" aria-hidden="true"></i>
        Filter & Pencarian
    </h2>
    <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="md:col-span-2 xl:col-span-1">
                <label for="catalog-search" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Pencarian</label>
                <div class="relative">
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text/40"
                        aria-hidden="true"></i>
                    <input type="search" id="catalog-search" name="search" value="{{ request('search') }}"
                        class="input-field py-2.5 pl-10" placeholder="Nama, barcode, kategori...">
                </div>
            </div>
            <div>
                <label for="catalog-category" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Kategori</label>
                <select id="catalog-category" name="category" class="input-field py-2.5">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                            {{ $category->name }} ({{ $category->active_products_count }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="catalog-stock" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Status Stok</label>
                <select id="catalog-stock" name="stock" class="input-field py-2.5">
                    <option value="">Semua Stok</option>
                    <option value="available" @selected(request('stock') === 'available')>Tersedia</option>
                    <option value="low" @selected(request('stock') === 'low')>Stok Terbatas</option>
                    <option value="out" @selected(request('stock') === 'out')>Habis</option>
                </select>
            </div>
            <div>
                <label for="catalog-min-price" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Harga Min</label>
                <input type="number" id="catalog-min-price" name="min_price" value="{{ request('min_price') }}"
                    class="input-field py-2.5" placeholder="0" min="0">
            </div>
            <div>
                <label for="catalog-max-price" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Harga Max</label>
                <input type="number" id="catalog-max-price" name="max_price" value="{{ request('max_price') }}"
                    class="input-field py-2.5" placeholder="999999" min="0">
            </div>
            <div>
                <label for="catalog-sort" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Urutkan</label>
                <select id="catalog-sort" name="sort" class="input-field py-2.5">
                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: Rendah - Tinggi</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: Tinggi - Rendah</option>
                    <option value="name" @selected(request('sort') === 'name')>Nama: A - Z</option>
                    <option value="name_desc" @selected(request('sort') === 'name_desc')>Nama: Z - A</option>
                </select>
            </div>
        </div>
        <div class="flex flex-wrap gap-3 border-t border-border pt-4 dark:border-dark-border">
            <button type="submit" class="btn-accent min-w-[10rem] flex-1 sm:flex-none">
                <i data-lucide="filter" class="h-4 w-4" aria-hidden="true"></i>
                Terapkan Filter
            </button>
            @if ($hasFilters)
                <a href="{{ route('products.index') }}" class="btn-secondary min-w-[10rem] flex-1 sm:flex-none">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>
</div>
