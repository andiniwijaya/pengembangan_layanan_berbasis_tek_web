@extends('layouts.admin')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="card">
            <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Kode Supplier</label>
                    <input type="text" name="code" value="{{ old('code', $code) }}" class="input-field font-mono"
                        readonly>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Nama Supplier</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="input-field @error('name') border-danger @enderror" required>
                    @error('name')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="input-field">
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="input-field">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="input-field @error('email') border-danger @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Alamat</label>
                    <textarea name="address" rows="3" class="input-field">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Catatan</label>
                    <textarea name="notes" rows="2" class="input-field">{{ old('notes') }}</textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Status</label>
                    <select name="status" class="input-field" required>
                        <option value="active" @selected(old('status', 'active') === 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>Nonaktif</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-accent">Simpan Supplier</button>
                    <a href="{{ route('admin.suppliers.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
