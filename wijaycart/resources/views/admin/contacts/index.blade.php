@extends('layouts.admin')

@section('title', 'Pesan Kontak')
@section('page-title', 'Pesan Kontak')

@section('content')
    <div class="mb-6 card !p-4">
        <form action="{{ route('admin.contacts.index') }}" method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, subjek..."
                class="input-field max-w-xs">
            <select name="status" class="input-field max-w-xs">
                <option value="">Semua Status</option>
                <option value="unread" @selected(request('status') === 'unread')>Belum Dibaca</option>
                <option value="read" @selected(request('status') === 'read')>Dibaca</option>
            </select>
            <button type="submit" class="btn-accent text-sm">Filter</button>
        </form>
    </div>

    @if ($messages->isEmpty())
        <x-empty-state icon="mail" title="Belum Ada Pesan Kontak"
            description="Pesan dari halaman kontak akan muncul di sini." :action-url="route('pages.contact')"
            action-label="Lihat Halaman Kontak" />
    @else
        <div class="admin-table-wrap">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Pengirim</th>
                            <th>Subjek</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td>
                                    <p class="font-medium">{{ $message->name }}</p>
                                    <p class="text-xs text-text/50">{{ $message->email }}</p>
                                </td>
                                <td class="font-medium">{{ $message->subject }}</td>
                                <td class="max-w-xs truncate text-text/70">{{ $message->message }}</td>
                                <td>
                                    @php
                                        $contactStatus = $message->status === 'unread' ? 'Belum Dibaca' : 'Dibaca';
                                    @endphp
                                    <span
                                        class="badge {{ $message->status === 'unread' ? 'badge-warning' : 'badge-success' }}">{{ $contactStatus }}</span>
                                </td>
                                <td class="text-text/60">{{ $message->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $messages->links() }}</div>
    @endif
@endsection
