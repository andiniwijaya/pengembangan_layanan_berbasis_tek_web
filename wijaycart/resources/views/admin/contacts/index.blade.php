@extends('layouts.admin')

@section('title', 'Pesan Kontak')
@section('page-title', 'Pesan Kontak')

@section('content')
    <x-admin.list-filters :action="route('admin.contacts.index')" search-placeholder="Cari nama, email, subjek..."
        :status-options="['unread' => 'Belum Dibaca', 'read' => 'Dibaca']" />

    <p class="mb-4 text-sm text-text/60 dark:text-dark-muted">{{ $messages->total() }} pesan</p>

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
