@extends('layouts.admin')

@section('title', 'Produk')
@section('page-title', 'Kelola Produk')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-text/60 dark:text-dark-muted">{{ $products->total() }} produk</p>
        <a href="{{ route('admin.products.create') }}" class="btn-accent text-sm" data-tooltip-target="tooltip-add-product"
            data-tooltip-placement="top">
            <i data-lucide="plus" class="h-4 w-4" aria-hidden="true"></i> Tambah Produk
        </a>
        <div id="tooltip-add-product" role="tooltip"
            class="tooltip invisible absolute z-50 inline-block rounded-lg bg-accent px-3 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 dark:bg-dark-border">
            Tambah Produk
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>

    @if ($products->isEmpty())
        <x-empty-state icon="package" title="Belum Ada Produk"
            description="Mulai tambahkan produk pertama untuk toko WijayCart." :action-url="route('admin.products.create')"
            action-label="Tambah Produk" />
    @else
        <div class="admin-table-wrap">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Barcode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $product->primary_image_url }}" alt=""
                                            class="h-10 w-10 rounded-lg object-cover ring-1 ring-border dark:ring-dark-border">
                                        <span class="font-medium">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td class="font-mono text-xs">{{ $product->barcode }}</td>
                                <td>
                                    <span
                                        class="badge {{ $product->status === 'active' ? 'badge-success' : 'badge-danger' }}">{{ $product->status_label }}</span>
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        <x-icon-action icon="eye" tooltip="Detail" :href="route('admin.products.show', $product)" />
                                        <x-icon-action icon="pencil" tooltip="Edit" :href="route('admin.products.edit', $product)" />
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            class="inline" data-confirm="Produk akan dihapus permanen beserta datanya."
                                            data-confirm-title="Hapus Produk">
                                            @csrf @method('DELETE')
                                            <x-icon-action icon="trash-2" tooltip="Hapus" type="submit" variant="danger" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
@endsection
