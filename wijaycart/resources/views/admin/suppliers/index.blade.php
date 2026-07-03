@extends('layouts.admin')

@section('title', 'Supplier')
@section('page-title', 'Kelola Supplier')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form action="{{ route('admin.suppliers.index') }}" method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kode, email..."
                class="input-field w-full sm:w-64">
            <select name="status" class="input-field w-full sm:w-40">
                <option value="">Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
            <button type="submit" class="btn-secondary text-sm"><i data-lucide="search" class="h-4 w-4"></i> Cari</button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.suppliers.index') }}" class="btn-secondary text-sm">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.suppliers.create') }}" class="btn-accent text-sm"><i data-lucide="plus"
                class="h-4 w-4"></i> Tambah Supplier</a>
    </div>

    <p class="mb-4 text-sm text-text/60 dark:text-dark-muted">{{ $suppliers->total() }} supplier</p>

    @if ($suppliers->isEmpty())
        <x-empty-state icon="truck" title="Belum Ada Supplier"
            description="Tambahkan supplier untuk melengkapi data master produk." :action-url="route('admin.suppliers.create')"
            action-label="Tambah Supplier" />
    @else
        <div class="admin-table-wrap">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Contact Person</th>
                            <th>Telepon</th>
                            <th>Produk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td class="font-mono text-xs">{{ $supplier->code }}</td>
                                <td class="font-medium">{{ $supplier->name }}</td>
                                <td class="text-text/70">{{ $supplier->contact_person ?? '-' }}</td>
                                <td class="text-text/70">{{ $supplier->phone ?? '-' }}</td>
                                <td>{{ $supplier->products_count }}</td>
                                <td>
                                    <span
                                        class="badge {{ $supplier->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $supplier->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        <x-icon-action icon="eye" tooltip="Detail Supplier" :href="route('admin.suppliers.show', $supplier)" />
                                        <x-icon-action icon="pencil" tooltip="Edit Supplier" :href="route('admin.suppliers.edit', $supplier)" />
                                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                                            class="inline" data-confirm="Supplier akan dihapus permanen. Lanjutkan?"
                                            data-confirm-title="Hapus Supplier">
                                            @csrf @method('DELETE')
                                            <x-icon-action icon="trash-2" tooltip="Hapus Supplier" type="submit"
                                                variant="danger" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $suppliers->links() }}</div>
    @endif
@endsection
