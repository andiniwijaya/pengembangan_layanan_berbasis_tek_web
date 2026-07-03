@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
    <x-admin.form-page :back-url="route('admin.categories.index')" back-label="Kembali ke Kategori"
        subtitle="Perbarui informasi kategori {{ $category->name }}.">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="space-y-5">
                    <div>
                        <label for="name" class="form-label">Nama Kategori <span class="form-required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                            class="input-field" required>
                    </div>
                    <div>
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                            class="input-field">
                        <p class="form-helper">URL filter katalog: /products?category={{ $category->slug }}</p>
                    </div>
                    <div>
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="input-field">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>

                <x-admin.form-aside title="Tampilan">
                    <div class="admin-icon-preview">
                        <div class="admin-icon-preview-box">
                            <i data-lucide="{{ $category->icon }}" class="h-9 w-9 text-accent dark:text-primary"
                                aria-hidden="true"></i>
                        </div>
                        <p class="text-sm font-semibold text-accent dark:text-primary">{{ $category->name }}</p>
                        <p class="mt-1 text-xs text-text/55 dark:text-dark-muted">Slug: <code
                                class="text-accent">{{ $category->slug }}</code></p>
                    </div>

                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-gold-border/35 bg-white/60 p-4 transition-colors hover:bg-primary/15 dark:border-primary/15 dark:bg-dark-card/60 dark:hover:bg-primary/10">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))
                            class="h-4 w-4 rounded border-gold-border text-primary focus:ring-primary/40">
                        <span>
                            <span class="block text-sm font-semibold">Kategori Aktif</span>
                            <span class="text-xs text-text/55 dark:text-dark-muted">{{ $category->products()->count() }} produk terhubung</span>
                        </span>
                    </label>
                </x-admin.form-aside>
            </div>

            <x-admin.form-actions>
                <button type="submit" class="btn-accent">
                    <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                    Perbarui Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
            </x-admin.form-actions>
        </form>
    </x-admin.form-page>
@endsection
