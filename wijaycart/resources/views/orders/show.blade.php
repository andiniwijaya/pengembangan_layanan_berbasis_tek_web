@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('orders.index') }}" class="rounded-lg p-2 hover:bg-secondary dark:hover:bg-dark-border"><i data-lucide="arrow-left" class="h-5 w-5"></i></a>
        <h1 class="section-title">Pesanan {{ $order->order_number }}</h1>
    </div>

    <div class="mb-6 flex flex-wrap items-center gap-3">
        <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
        @if($order->payment)
        <span class="badge badge-warning">{{ $order->payment->status_label }}</span>
        @endif
        @can('cancel', $order)
        <form action="{{ route('orders.cancel', $order) }}" method="POST" data-confirm="Batalkan pesanan ini? Stok akan dikembalikan." data-confirm-title="Batalkan Pesanan">
            @csrf
            <button type="submit" class="btn-secondary text-sm text-danger border-danger/30">
                <i data-lucide="x-circle" class="h-4 w-4"></i> Batalkan Pesanan
            </button>
        </form>
        @endcan
    </div>

    <div class="grid gap-6">
        @include('partials.order-timeline', ['timelineSteps' => $timelineSteps])

        <div class="card">
            <h3 class="mb-4 font-semibold">Item Pesanan</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between border-b border-border pb-4 last:border-0 dark:border-dark-border">
                    <div>
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-xs text-text/50">{{ $item->product_barcode }} x{{ $item->quantity }}</p>
                    </div>
                    <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="card">
                <h3 class="mb-3 font-semibold">Pengiriman</h3>
                <p class="text-sm">{{ $order->shipping_name }}</p>
                <p class="text-sm text-text/60">{{ $order->shipping_phone }}</p>
                <p class="mt-2 text-sm text-text/70">{{ $order->shipping_address }}</p>
            </div>
            <div class="card">
                <h3 class="mb-3 font-semibold">Pembayaran</h3>
                @if($order->payment)
                <p class="text-sm">Metode: {{ $order->payment->method_label }}</p>
                <p class="text-sm">Status: {{ $order->payment->status_label }}</p>

                @if($order->payment->payment_proof_url)
                <div class="mt-4">
                    <p class="mb-2 text-sm font-medium">Bukti Pembayaran</p>
                    <a href="{{ $order->payment->payment_proof_url }}" target="_blank" rel="noopener">
                        <img src="{{ $order->payment->payment_proof_url }}" alt="Bukti pembayaran" class="max-h-48 rounded-lg border border-border dark:border-dark-border">
                    </a>
                </div>
                @endif

                @can('uploadPaymentProof', $order)
                <form action="{{ route('orders.payment-proof', $order) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                    @csrf
                    <label class="block text-sm font-medium">Upload Bukti Pembayaran</label>
                    <img
                        id="payment-proof-preview"
                        src="{{ $order->payment->payment_proof_url ?? '' }}"
                        alt="Preview bukti pembayaran"
                        @class(['max-h-48 rounded-lg border border-border dark:border-dark-border', 'hidden' => ! $order->payment->payment_proof_url])
                    >
                    <input
                        type="file"
                        name="payment_proof"
                        accept="image/jpeg,image/png,image/jpg"
                        class="input-field text-sm"
                        data-payment-proof-preview="payment-proof-preview"
                        required
                    >
                    <p class="text-xs text-text/50 dark:text-dark-muted">JPG/JPEG/PNG, maks. 2 MB</p>
                    <button type="submit" class="btn-accent text-sm">Unggah Bukti</button>
                </form>
                @endcan
                @endif
                <div class="mt-4 space-y-1 text-sm">
                    <div class="flex justify-between"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Ongkir</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-bold"><span>Total</span><span class="text-accent dark:text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
