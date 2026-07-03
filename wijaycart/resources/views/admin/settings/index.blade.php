@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Toko')

@section('content')
    <x-admin.form-page :back-url="route('admin.dashboard')" back-label="Kembali ke Dashboard"
        subtitle="Kelola informasi toko dan biaya pengiriman default." wide>
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-accent/60 dark:text-dark-muted">Identitas Toko</p>
                    <div>
                        <label for="store_name" class="form-label">Nama Toko <span class="form-required">*</span></label>
                        <input type="text" name="store_name" id="store_name"
                            value="{{ old('store_name', $settings['store_name']) }}" class="input-field" required>
                    </div>
                    <div>
                        <label for="store_email" class="form-label">Email <span class="form-required">*</span></label>
                        <input type="email" name="store_email" id="store_email"
                            value="{{ old('store_email', $settings['store_email']) }}" class="input-field" required>
                    </div>
                    <div>
                        <label for="store_phone" class="form-label">Telepon</label>
                        <input type="text" name="store_phone" id="store_phone"
                            value="{{ old('store_phone', $settings['store_phone']) }}" class="input-field">
                    </div>
                </div>

                <div class="space-y-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-accent/60 dark:text-dark-muted">Operasional</p>
                    <div>
                        <label for="store_address" class="form-label">Alamat</label>
                        <textarea name="store_address" id="store_address" rows="2" class="input-field">{{ old('store_address', $settings['store_address']) }}</textarea>
                    </div>
                    <div>
                        <label for="store_description" class="form-label">Deskripsi Toko</label>
                        <textarea name="store_description" id="store_description" rows="3" class="input-field">{{ old('store_description', $settings['store_description']) }}</textarea>
                    </div>
                    <div>
                        <label for="shipping_cost" class="form-label">Biaya Ongkir Default (Rp) <span class="form-required">*</span></label>
                        <input type="number" name="shipping_cost" id="shipping_cost"
                            value="{{ old('shipping_cost', $settings['shipping_cost']) }}" class="input-field" min="0"
                            required>
                    </div>
                </div>
            </div>

            <x-admin.form-actions>
                <button type="submit" class="btn-accent">
                    <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                    Simpan Pengaturan
                </button>
            </x-admin.form-actions>
        </form>
    </x-admin.form-page>
@endsection
