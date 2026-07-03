@extends('layouts.admin')

@section('title', $product->name)
@section('page-title', 'Detail Produk & Barcode')

@section('content')
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card">
            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                class="mb-4 w-full rounded-xl object-cover">
            <h2 class="text-xl font-bold">{{ $product->name }}</h2>
            <p class="mt-2 text-text/70">{{ $product->description }}</p>
            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-text/50">Kategori</span>
                    <p class="font-medium">{{ $product->category->name }}</p>
                </div>
                <div><span class="text-text/50">Supplier</span>
                    <p class="font-medium">{{ $product->supplier?->name ?? '-' }}</p>
                </div>
                <div><span class="text-text/50">Harga</span>
                    <p class="font-bold text-accent dark:text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>
                <div><span class="text-text/50">Stok</span>
                    <p class="font-medium">{{ $product->stock }}</p>
                </div>
                <div><span class="text-text/50">Status</span>
                    <p class="font-medium">{{ $product->status_label }}</p>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn-accent text-sm">Edit</a>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary text-sm">Kembali</a>
            </div>
        </div>
        <div class="card">
            <h3 class="mb-4 flex items-center gap-2 font-semibold"><i data-lucide="barcode" class="h-4 w-4"></i> Barcode
                Produk</h3>
            <p class="mb-4 font-mono text-lg">{{ $product->barcode }}</p>
            <div id="barcode-display" class="flex justify-center rounded-xl bg-white p-6">
                {!! $barcodeSvg !!}
            </div>
            <div class="mt-4 flex flex-wrap gap-3">
                <button type="button" id="barcode-print" class="btn-secondary text-sm"><i data-lucide="printer"
                        class="h-4 w-4"></i> Cetak</button>
                <button type="button" id="barcode-download" data-code="{{ $product->barcode }}"
                    class="btn-accent text-sm"><i data-lucide="download" class="h-4 w-4"></i> Unduh SVG</button>
            </div>
        </div>
    </div>
@endsection
