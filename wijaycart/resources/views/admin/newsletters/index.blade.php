@extends('layouts.admin')

@section('title', 'Buletin')
@section('page-title', 'Buletin')

@section('content')
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="stat-card-purple !p-4">
            <p class="text-xs uppercase text-text/50">Total</p>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="stat-card-green !p-4">
            <p class="text-xs uppercase text-text/50">Aktif</p>
            <p class="text-2xl font-bold">{{ $stats['active'] }}</p>
        </div>
        <div class="stat-card-orange !p-4">
            <p class="text-xs uppercase text-text/50">Nonaktif</p>
            <p class="text-2xl font-bold">{{ $stats['inactive'] }}</p>
        </div>
    </div>

    <div class="mb-6 card !p-4">
        <form action="{{ route('admin.newsletters.index') }}" method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari email..."
                class="input-field max-w-xs">
            <select name="status" class="input-field max-w-xs">
                <option value="">Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
            <button type="submit" class="btn-accent text-sm">Filter</button>
        </form>
    </div>

    @if ($subscribers->isEmpty())
        <x-empty-state icon="newspaper" title="Belum Ada Subscriber"
            description="Email yang mendaftar newsletter akan muncul di sini." />
    @else
        <div class="admin-table-wrap">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $subscriber)
                            <tr>
                                <td class="font-medium">{{ $subscriber->email }}</td>
                                <td><span
                                        class="badge {{ $subscriber->is_active ? 'badge-success' : 'badge-danger' }}">{{ $subscriber->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </td>
                                <td class="text-text/60">{{ $subscriber->subscribed_at?->format('d M Y') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $subscribers->links() }}</div>
    @endif
@endsection
