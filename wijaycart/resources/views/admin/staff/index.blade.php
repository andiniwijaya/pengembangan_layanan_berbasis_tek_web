@extends('layouts.admin')

@section('title', 'Admin Staff')
@section('page-title', 'Kelola Admin')

@section('content')
    <x-admin.list-filters :action="route('admin.staff.index')" search-placeholder="Cari nama atau email..."
        :status-options="null" :filter-keys="['search']" />

    <p class="mb-4 text-sm text-text/60 dark:text-dark-muted">{{ $staff->total() }} admin</p>

    @if ($staff->isEmpty())
        <x-empty-state icon="shield" title="Belum Ada Admin" description="Akun dengan role admin akan muncul di sini." />
    @else
        <div class="admin-table-wrap">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Admin</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->avatar_url }}" alt=""
                                            class="h-9 w-9 rounded-full object-cover ring-2 ring-primary/30">
                                        <span class="font-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td class="text-text/70">{{ $user->phone ?? '-' }}</td>
                                <td class="text-text/60">{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $staff->links() }}</div>
    @endif
@endsection
