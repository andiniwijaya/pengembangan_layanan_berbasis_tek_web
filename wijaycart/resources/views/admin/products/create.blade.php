@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="card">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Kategori</label>
                        <select name="category_id" class="input-field" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Supplier</label>
                        <select name="supplier_id" class="input-field">
                            <option value="">— Pilih Supplier —</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->code }} —
                                    {{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Barcode</label>
                        <input type="text" name="barcode" value="{{ old('barcode', $barcode) }}"
                            class="input-field font-mono" readonly>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="input-field" min="0"
                            required>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" class="input-field"
                            min="0" required>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Status</label>
                        <select name="status" class="input-field">
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Deskripsi</label>
                        <textarea name="description" rows="4" class="input-field" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Foto Produk</label>
                        <input type="file" name="images[]" accept="image/*" multiple class="input-field"
                            data-image-preview="product-preview">
                        <div id="product-preview" class="mt-3 flex flex-wrap gap-3"></div>
                        <p class="mt-1 text-xs text-text/50">Format: JPG, PNG. Maks 2MB per file.</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_featured" value="1"
                                class="rounded text-primary focus:ring-primary">
                            <span class="text-sm">Produk Unggulan</span>
                        </label>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-accent">Simpan Produk</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
