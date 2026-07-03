@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <h1 class="section-title mb-2">Checkout</h1>
        <p class="mb-8 text-sm text-text/60 dark:text-dark-muted">Simulasi pembayaran — tidak menggunakan payment gateway.
        </p>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    {{-- Data Customer --}}
                    <div class="card">
                        <h2 class="mb-4 flex items-center gap-2 font-semibold"><i data-lucide="user"
                                class="h-4 w-4 text-accent"></i> Data Customer</h2>
                        <div class="rounded-xl bg-secondary/50 p-4 text-sm dark:bg-dark-border/40">
                            <p class="font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-text/60">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    {{-- Alamat Pengiriman --}}
                    <div class="card">
                        <h2 class="mb-4 flex items-center gap-2 font-semibold"><i data-lucide="map-pin"
                                class="h-4 w-4 text-accent"></i> Alamat Pengiriman</h2>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="shipping_name" class="mb-1.5 block text-sm font-medium">Nama Penerima</label>
                                <input type="text" id="shipping_name" name="shipping_name"
                                    value="{{ old('shipping_name', auth()->user()->name) }}"
                                    class="input-field @error('shipping_name') border-danger @enderror" required>
                                @error('shipping_name')
                                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="shipping_phone" class="mb-1.5 block text-sm font-medium">No. Telepon</label>
                                <input type="text" id="shipping_phone" name="shipping_phone"
                                    value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                    class="input-field @error('shipping_phone') border-danger @enderror" required>
                                @error('shipping_phone')
                                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="shipping_address" class="mb-1.5 block text-sm font-medium">Alamat
                                    Lengkap</label>
                                <textarea id="shipping_address" name="shipping_address" rows="3"
                                    class="input-field @error('shipping_address') border-danger @enderror" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="notes" class="mb-1.5 block text-sm font-medium">Catatan (opsional)</label>
                                <textarea id="notes" name="notes" rows="2" class="input-field">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran Simulasi --}}
                    <div class="card">
                        <h2 class="mb-4 flex items-center gap-2 font-semibold"><i data-lucide="wallet"
                                class="h-4 w-4 text-accent"></i> Metode Pembayaran</h2>
                        <div class="space-y-3">
                            @foreach ([
            'bank_transfer' => ['label' => 'Transfer Bank', 'icon' => 'landmark', 'desc' => 'Simulasi transfer ke rekening WijayCart'],
            'qris' => ['label' => 'QRIS', 'icon' => 'qr-code', 'desc' => 'Simulasi scan QRIS (tanpa gateway)'],
            'cod' => ['label' => 'Bayar di Tempat (COD)', 'icon' => 'banknote', 'desc' => 'Bayar saat barang diterima'],
        ] as $value => $method)
                                <label
                                    class="flex cursor-pointer items-start gap-4 rounded-xl border border-border p-4 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/10 dark:border-dark-border">
                                    <input type="radio" name="payment_method" value="{{ $value }}"
                                        class="mt-1 text-primary focus:ring-primary" @checked(old('payment_method', 'bank_transfer') === $value)>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 font-medium">
                                            <i data-lucide="{{ $method['icon'] }}" class="h-4 w-4 text-accent"></i>
                                            {{ $method['label'] }}
                                        </div>
                                        <p class="mt-1 text-xs text-text/50 dark:text-dark-muted">{{ $method['desc'] }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <p class="mt-2 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Ringkasan Belanja --}}
                <div class="card h-fit sticky top-24">
                    <h2 class="mb-4 font-semibold">Ringkasan Belanja</h2>
                    <div class="max-h-60 space-y-3 overflow-y-auto border-b border-border pb-4 dark:border-dark-border">
                        @foreach ($cart->items as $item)
                            <div class="flex justify-between gap-2 text-sm">
                                <span class="text-text/70 line-clamp-1">{{ $item->product->name }}
                                    x{{ $item->quantity }}</span>
                                <span class="shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-text/60">Subtotal</span><span>Rp
                                {{ number_format($cart->total, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span class="text-text/60">Ongkir</span><span>Rp
                                {{ number_format($shippingCost, 0, ',', '.') }}</span></div>
                    </div>
                    <div
                        class="mt-4 flex justify-between border-t border-border pt-4 text-lg font-bold dark:border-dark-border">
                        <span>Total</span>
                        <span class="text-accent dark:text-primary">Rp
                            {{ number_format($cart->total + $shippingCost, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="btn-accent mt-6 w-full">
                        <i data-lucide="check-circle" class="h-4 w-4"></i> Buat Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
