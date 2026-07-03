@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
    <x-admin.form-page :back-url="route('admin.categories.index')" back-label="Kembali ke Kategori"
        subtitle="Buat kategori baru untuk mengelompokkan produk di katalog WijayCart.">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="admin-form-grid">
                <div class="space-y-5">
                    <div>
                        <label for="name" class="form-label">Nama Kategori <span class="form-required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-field"
                            placeholder="Contoh: Home Living" required>
                    </div>
                    <div>
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="input-field"
                            placeholder="Kosongkan untuk auto-generate dari nama">
                        <p class="form-helper">URL filter katalog: /products?category=slug-kategori</p>
                    </div>
                    <div>
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="input-field"
                            placeholder="Jelaskan singkat jenis produk dalam kategori ini...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <x-admin.form-aside title="Tampilan">
                    <div class="admin-icon-preview">
                        <div class="admin-icon-preview-box">
                            <i data-lucide="tag" class="h-9 w-9 text-accent dark:text-primary" aria-hidden="true"></i>
                        </div>
                        <p class="text-sm font-semibold text-accent dark:text-primary">Ikon Kategori</p>
                        <p class="mt-1 text-xs text-text/55 dark:text-dark-muted">Ikon Lucide otomatis dari slug</p>
                    </div>

                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-gold-border/35 bg-white/60 p-4 transition-colors hover:bg-primary/15 dark:border-primary/15 dark:bg-dark-card/60 dark:hover:bg-primary/10">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="h-4 w-4 rounded border-gold-border text-primary focus:ring-primary/40">
                        <span>
                            <span class="block text-sm font-semibold">Kategori Aktif</span>
                            <span class="text-xs text-text/55 dark:text-dark-muted">Tampil di katalog toko</span>
                        </span>
                    </label>

                    <div class="admin-tip-box">
                        Gunakan nama kategori yang singkat dan mudah dipahami pelanggan, misalnya Mug, Home Decor, atau Home Living.
                    </div>
                </x-admin.form-aside>
            </div>

            <x-admin.form-actions>
                <button type="submit" class="btn-accent">
                    <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
            </x-admin.form-actions>
        </form>
    </x-admin.form-page>
@endsection
