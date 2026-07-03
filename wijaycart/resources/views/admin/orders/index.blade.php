@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page-title', request('payment') === 'pending' ? 'Kelola Pembayaran' : 'Kelola Pesanan')

@section('content')
<div class="mb-6 card !p-4">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-3">
        @if(request('payment') === 'pending')
        <input type="hidden" name="payment" value="pending">
        @endif
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan..." class="input-field max-w-xs">
        <select name="status" class="input-field max-w-xs">
            <option value="">Semua Status</option>
            @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-accent text-sm">Filter</button>
    </form>
</div>

@if($orders->isEmpty())
<x-empty-state icon="shopping-bag" title="Belum Ada Transaksi" description="Pesanan dari customer akan muncul di sini setelah checkout." />
@else
<div class="admin-table-wrap">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="font-medium">{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                    <td>
                        @if($order->payment)
                        <span class="badge {{ $order->payment->status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($order->payment->status) }}</span>
                        @else
                        <span class="text-text/40">-</span>
                        @endif
                    </td>
                    <td class="text-text/60">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <x-icon-action icon="eye" tooltip="Detail Pesanan" :href="route('admin.orders.show', $order)" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
