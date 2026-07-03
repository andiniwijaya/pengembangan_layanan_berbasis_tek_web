@extends('layouts.admin')

@section('title', $order->order_number)
@section('page-title', 'Detail Pesanan')

@section('content')
    <x-admin.detail-toolbar :back-url="route('admin.orders.index')" back-label="Kembali ke Daftar Pesanan">
        <span class="badge badge-{{ $order->status_color }} text-sm">{{ $order->status_label }}</span>
        @if ($order->payment)
            <span class="badge badge-warning text-sm">{{ $order->payment->status_label }}</span>
        @endif
        <span class="text-sm text-text/50 dark:text-dark-muted">{{ $order->order_number }}</span>
    </x-admin.detail-toolbar>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            @include('partials.order-timeline', ['timelineSteps' => $timelineSteps])

            <div class="card">
                <h3 class="mb-4 font-semibold">Item Pesanan</h3>
                @foreach ($order->items as $item)
                    <div class="flex justify-between border-b border-border py-3 last:border-0 dark:border-dark-border">
                        <div>
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-xs text-text/50">{{ $item->product_barcode }} x{{ $item->quantity }}</p>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="card">
                <h3 class="mb-1 font-semibold">Update Status Pesanan</h3>
                <p class="mb-4 text-sm text-text/60 dark:text-dark-muted">Setelah disimpan, Anda akan kembali ke daftar pesanan.</p>
                <form
                    action="{{ route('admin.orders.update-status', $order) }}"
                    method="POST"
                    class="flex flex-wrap items-end gap-3"
                    data-confirm="Perbarui status pesanan ini?"
                    data-confirm-title="Perbarui Status"
                >
                    @csrf
                    @method('PUT')
                    @php
                        $orderStatusLabels = [
                            'pending' => 'Menunggu',
                            'waiting_payment' => 'Menunggu Pembayaran',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'delivered' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    <div class="min-w-[12rem] flex-1">
                        <label for="order-status" class="mb-1.5 block text-xs font-medium text-text/60">Status baru</label>
                        <select id="order-status" name="status" class="input-field w-full">
                            @foreach ($orderStatusLabels as $status => $label)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-accent text-sm">Simpan Status</button>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card">
                <h3 class="mb-3 font-semibold">Info Customer</h3>
                <p class="text-sm font-medium">{{ $order->user->name }}</p>
                <p class="text-sm text-text/60">{{ $order->user->email }}</p>
                <a href="{{ route('admin.customers.show', $order->user) }}" class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-accent hover:underline dark:text-primary">
                    Lihat profil customer
                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                </a>
            </div>
            <div class="card">
                <h3 class="mb-3 font-semibold">Pengiriman</h3>
                <p class="text-sm">{{ $order->shipping_name }}</p>
                <p class="text-sm text-text/60">{{ $order->shipping_phone }}</p>
                <p class="mt-2 text-sm">{{ $order->shipping_address }}</p>
            </div>
            <div class="card">
                <h3 class="mb-3 font-semibold">Pembayaran</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span>Subtotal</span><span>Rp
                            {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Ongkir</span><span>Rp
                            {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-bold"><span>Total</span><span
                            class="text-accent dark:text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if ($order->payment)
                    <p class="mt-3 text-sm">Metode: {{ $order->payment->method_label }}</p>
                    @if ($order->payment->payment_proof_url)
                        <div class="mt-3">
                            <p class="mb-2 text-sm font-medium">Bukti Pembayaran</p>
                            <a href="{{ $order->payment->payment_proof_url }}" target="_blank" rel="noopener">
                                <img src="{{ $order->payment->payment_proof_url }}" alt="Bukti pembayaran"
                                    class="max-h-40 rounded-lg border border-border dark:border-dark-border">
                            </a>
                        </div>
                    @endif
                    <form
                        action="{{ route('admin.orders.update-payment', $order) }}"
                        method="POST"
                        class="mt-4 space-y-3"
                        data-confirm="Perbarui status pembayaran pesanan ini?"
                        data-confirm-title="Perbarui Pembayaran"
                    >
                        @csrf
                        @method('PUT')
                        <label for="payment-status" class="block text-xs font-medium text-text/60">Status pembayaran</label>
                        <div class="flex gap-2">
                            <select id="payment-status" name="status" class="input-field flex-1 py-2 text-sm">
                                @foreach ([
                                    'pending' => 'Menunggu Pembayaran',
                                    'paid' => 'Lunas',
                                    'failed' => 'Gagal',
                                    'refunded' => 'Dikembalikan',
                                ] as $status => $label)
                                    <option value="{{ $status }}" @selected($order->payment->status === $status)>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-accent shrink-0 py-2 text-sm">Simpan</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
