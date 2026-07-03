@extends('layouts.admin')

@section('title', 'Buletin')
@section('page-title', 'Buletin')

@section('content')
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('admin.newsletters.index') }}"
            class="stat-card-purple card-hover !p-4 transition-transform hover:scale-[1.02]">
            <p class="text-xs uppercase text-text/50">Total</p>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </a>
        <a href="{{ route('admin.newsletters.index', ['status' => 'active']) }}"
            class="stat-card-green card-hover !p-4 transition-transform hover:scale-[1.02]">
            <p class="text-xs uppercase text-text/50">Aktif</p>
            <p class="text-2xl font-bold">{{ $stats['active'] }}</p>
        </a>
        <a href="{{ route('admin.newsletters.index', ['status' => 'inactive']) }}"
            class="stat-card-orange card-hover !p-4 transition-transform hover:scale-[1.02]">
            <p class="text-xs uppercase text-text/50">Nonaktif</p>
            <p class="text-2xl font-bold">{{ $stats['inactive'] }}</p>
        </a>
    </div>

    <x-admin.list-filters :action="route('admin.newsletters.index')" search-placeholder="Cari email..."
        :status-options="['active' => 'Aktif', 'inactive' => 'Nonaktif']" />

    <p class="mb-4 text-sm text-text/60 dark:text-dark-muted">{{ $subscribers->total() }} subscriber</p>

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
