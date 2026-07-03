@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-sm text-text/60 dark:text-dark-muted">{{ $categories->total() }} kategori</p>
    <a href="{{ route('admin.categories.create') }}" class="btn-accent text-sm"><i data-lucide="plus" class="h-4 w-4"></i> Tambah Kategori</a>
</div>

@if($categories->isEmpty())
<x-empty-state icon="tags" title="Belum Ada Kategori" description="Tambahkan kategori produk untuk mengorganisir katalog." :action-url="route('admin.categories.create')" action-label="Tambah Kategori" />
@else
<div class="admin-table-wrap">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Produk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="font-medium">{{ $category->name }}</td>
                    <td class="text-text/60">{{ $category->slug }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-1">
                            <x-icon-action icon="pencil" tooltip="Edit Kategori" :href="route('admin.categories.edit', $category)" />
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" data-confirm="Kategori akan dihapus permanen. Lanjutkan?" data-confirm-title="Hapus Kategori">
                                @csrf @method('DELETE')
                                <x-icon-action icon="trash-2" tooltip="Hapus Kategori" type="submit" variant="danger" />
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $categories->links() }}</div>
@endif
@endsection
