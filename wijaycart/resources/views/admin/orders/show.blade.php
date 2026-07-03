@extends('layouts.admin')

@section('title', $order->order_number)
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="mb-6 flex flex-wrap gap-3">
    <span class="badge badge-{{ $order->status_color }} text-sm">{{ $order->status_label }}</span>
    @if($order->payment)
    <span class="badge badge-warning text-sm">{{ $order->payment->status_label }}</span>
    @endif
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-6">
        @include('partials.order-timeline', ['timelineSteps' => $timelineSteps])

        <div class="card">
            <h3 class="mb-4 font-semibold">Item Pesanan</h3>
            @foreach($order->items as $item)
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
            <h3 class="mb-4 font-semibold">Update Status</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-wrap gap-3">
                @csrf @method('PUT')
                <select name="status" class="input-field max-w-xs">
                    @foreach(['pending', 'waiting_payment', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-accent text-sm">Update Status</button>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card">
            <h3 class="mb-3 font-semibold">Info Customer</h3>
            <p class="text-sm font-medium">{{ $order->user->name }}</p>
            <p class="text-sm text-text/60">{{ $order->user->email }}</p>
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
                <div class="flex justify-between"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span>Ongkir</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                <div class="flex justify-between font-bold"><span>Total</span><span class="text-accent dark:text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
            </div>
            @if($order->payment)
            <p class="text-sm">Metode: {{ $order->payment->method_label }}</p>
            @if($order->payment->payment_proof_url)
            <div class="mt-3">
                <p class="mb-2 text-sm font-medium">Bukti Pembayaran</p>
                <a href="{{ $order->payment->payment_proof_url }}" target="_blank" rel="noopener">
                    <img src="{{ $order->payment->payment_proof_url }}" alt="Bukti pembayaran" class="max-h-40 rounded-lg border border-border dark:border-dark-border">
                </a>
            </div>
            @endif
            <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST" class="mt-4 flex gap-2">
                @csrf @method('PUT')
                <select name="status" class="input-field flex-1 py-2 text-sm">
                    @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                    <option value="{{ $status }}" @selected($order->payment->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-accent py-2 text-sm">Update</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
