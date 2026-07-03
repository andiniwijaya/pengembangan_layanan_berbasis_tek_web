@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <x-admin.form-page :back-url="route('admin.products.index')" back-label="Kembali ke Produk"
        subtitle="Tambahkan produk baru ke katalog WijayCart." wide>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-accent/60 dark:text-dark-muted">Informasi Produk</p>
                    <div>
                        <label for="name" class="form-label">Nama Produk <span class="form-required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-field" required>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="category_id" class="form-label">Kategori <span class="form-required">*</span></label>
                            <select name="category_id" id="category_id" class="input-field" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="input-field">
                                <option value="">— Pilih Supplier —</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                                        {{ $supplier->code }} — {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="description" class="form-label">Deskripsi <span class="form-required">*</span></label>
                        <textarea name="description" id="description" rows="4" class="input-field" required>{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="space-y-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-accent/60 dark:text-dark-muted">Harga & Stok</p>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $barcode) }}"
                                class="input-field font-mono" readonly>
                        </div>
                        <div>
                            <label for="price" class="form-label">Harga (Rp) <span class="form-required">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" class="input-field"
                                min="0" required>
                        </div>
                        <div>
                            <label for="stock" class="form-label">Stok <span class="form-required">*</span></label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" class="input-field"
                                min="0" required>
                        </div>
                        <div>
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="input-field">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="images" class="form-label">Foto Produk</label>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple class="input-field"
                            data-image-preview="product-preview">
                        <div id="product-preview" class="mt-3 flex flex-wrap gap-3"></div>
                        <p class="form-helper">Format JPG/PNG/WebP. Maks 2MB per file.</p>
                    </div>
                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-gold-border/35 bg-gold-light/30 p-4 dark:border-primary/15 dark:bg-primary/5">
                        <input type="checkbox" name="is_featured" value="1"
                            class="h-4 w-4 rounded border-gold-border text-primary focus:ring-primary/40">
                        <span>
                            <span class="block text-sm font-semibold">Produk Unggulan</span>
                            <span class="text-xs text-text/55 dark:text-dark-muted">Tampil di beranda toko</span>
                        </span>
                    </label>
                </div>
            </div>

            <x-admin.form-actions>
                <button type="submit" class="btn-accent">
                    <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">Batal</a>
            </x-admin.form-actions>
        </form>
    </x-admin.form-page>
@endsection
