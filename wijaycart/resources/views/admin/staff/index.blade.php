@extends('layouts.admin')

@section('title', 'Admin Staff')
@section('page-title', 'Kelola Admin')

@section('content')
<div class="mb-6 card !p-4">
    <form action="{{ route('admin.staff.index') }}" method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="input-field max-w-xs">
        <button type="submit" class="btn-accent text-sm">Cari</button>
    </form>
</div>

@if($staff->isEmpty())
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
                @foreach($staff as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url }}" alt="" class="h-9 w-9 rounded-full object-cover ring-2 ring-primary/30">
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
