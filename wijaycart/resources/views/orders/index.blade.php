@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="section-title mb-8">Riwayat Pesanan</h1>

    @if($orders->count())
    <div class="space-y-4">
        @foreach($orders as $order)
        <a href="{{ route('orders.show', $order) }}" class="card block transition-all hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-semibold">{{ $order->order_number }}</p>
                    <p class="text-sm text-text/50">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="badge badge-{{ $order->status_color }} w-fit">{{ $order->status_label }}</span>
                <p class="text-lg font-bold text-accent dark:text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $orders->links() }}</div>
    @else
    <x-empty-state
        icon="package"
        title="Belum Ada Pesanan"
        description="Pesanan Anda akan muncul di sini setelah checkout. Yuk, mulai belanja produk favorit!"
        :action-url="route('products.index')"
        action-label="Jelajahi Produk"
    />
    @endif
</div>
@endsection
