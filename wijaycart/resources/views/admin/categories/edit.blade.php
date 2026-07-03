@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="card">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="input-field"
                        required>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="input-field">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Deskripsi</label>
                    <textarea name="description" rows="3" class="input-field">{{ old('description', $category->description) }}</textarea>
                </div>
                <div
                    class="rounded-xl border border-border/60 bg-secondary/30 p-4 dark:border-dark-border dark:bg-dark-card/40">
                    <p class="mb-2 text-sm font-medium text-text/70 dark:text-dark-muted">Ikon Kategori</p>
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm dark:bg-dark-card">
                        <i data-lucide="{{ $category->icon }}" class="h-8 w-8 text-accent dark:text-primary"
                            aria-hidden="true"></i>
                    </div>
                    <p class="mt-2 text-xs text-text/50 dark:text-dark-muted">Ikon Lucide otomatis berdasarkan slug: <code
                            class="text-accent">{{ $category->slug }}</code></p>
                </div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))
                        class="rounded text-primary focus:ring-primary">
                    <span class="text-sm">Aktif</span>
                </label>
                <div class="flex gap-3">
                    <button type="submit" class="btn-accent">Perbarui</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
