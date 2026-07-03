@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        @if ($product->images->count())
            <div class="card">
                <label class="mb-2 block text-sm font-medium">Foto Saat Ini</label>
                <div class="flex flex-wrap gap-3">
                    @foreach ($product->images as $image)
                        <div class="relative">
                            <img src="{{ $image->url }}" alt="" class="h-20 w-20 rounded-lg object-cover">
                            <form action="{{ route('admin.product-images.destroy', $image) }}" method="POST"
                                class="absolute -right-2 -top-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded-full bg-danger p-1 text-white"><i data-lucide="x"
                                        class="h-3 w-3"></i></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="card">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf @method('PUT')
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="input-field"
                            required>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Kategori</label>
                        <select name="category_id" class="input-field" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Supplier</label>
                        <select name="supplier_id" class="input-field">
                            <option value="">— Pilih Supplier —</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>{{ $supplier->code }} —
                                    {{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Barcode</label>
                        <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}"
                            class="input-field font-mono">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                            class="input-field" min="0" required>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="input-field" min="0" required>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Status</label>
                        <select name="status" class="input-field">
                            <option value="active" @selected($product->status === 'active')>Aktif</option>
                            <option value="inactive" @selected($product->status === 'inactive')>Nonaktif</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Deskripsi</label>
                        <textarea name="description" rows="4" class="input-field" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Tambah Foto</label>
                        <input type="file" name="images[]" accept="image/*" multiple class="input-field">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))
                                class="rounded text-primary focus:ring-primary">
                            <span class="text-sm">Produk Unggulan</span>
                        </label>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-accent">Perbarui Produk</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
