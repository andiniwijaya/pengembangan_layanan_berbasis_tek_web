@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Toko')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="mb-1.5 block text-sm font-medium">Nama Toko</label>
                <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" class="input-field" required>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Email</label>
                <input type="email" name="store_email" value="{{ old('store_email', $settings['store_email']) }}" class="input-field" required>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Telepon</label>
                <input type="text" name="store_phone" value="{{ old('store_phone', $settings['store_phone']) }}" class="input-field">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Alamat</label>
                <textarea name="store_address" rows="2" class="input-field">{{ old('store_address', $settings['store_address']) }}</textarea>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Deskripsi Toko</label>
                <textarea name="store_description" rows="3" class="input-field">{{ old('store_description', $settings['store_description']) }}</textarea>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Biaya Ongkir (Rp)</label>
                <input type="number" name="shipping_cost" value="{{ old('shipping_cost', $settings['shipping_cost']) }}" class="input-field" min="0" required>
            </div>
            <button type="submit" class="btn-accent">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
