@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="mb-1.5 block text-sm font-medium">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="input-field" placeholder="Auto-generate dari nama">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Deskripsi</label>
                <textarea name="description" rows="3" class="input-field">{{ old('description') }}</textarea>
            </div>
            <div class="rounded-xl border border-border/60 bg-secondary/30 p-4 dark:border-dark-border dark:bg-dark-card/40">
                <p class="mb-2 text-sm font-medium text-text/70 dark:text-dark-muted">Ikon Kategori</p>
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm dark:bg-dark-card">
                    <i data-lucide="tag" class="h-8 w-8 text-accent dark:text-primary" aria-hidden="true"></i>
                </div>
                <p class="mt-2 text-xs text-text/50 dark:text-dark-muted">Ikon Lucide otomatis berdasarkan slug kategori.</p>
            </div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked class="rounded text-primary focus:ring-primary">
                <span class="text-sm">Aktif</span>
            </label>
            <div class="flex gap-3">
                <button type="submit" class="btn-accent">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
