@extends('layouts.admin')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')

@section('content')
    <x-admin.form-page :back-url="route('admin.suppliers.index')" back-label="Kembali ke Supplier"
        subtitle="Tambahkan mitra supplier untuk produk WijayCart." wide>
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            <div class="admin-form-grid">
                <div class="space-y-5">
                    <div>
                        <label for="name" class="form-label">Nama Supplier <span class="form-required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="input-field @error('name') border-danger @enderror" placeholder="Nama perusahaan supplier"
                            required>
                        @error('name')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="contact_person" class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"
                            class="input-field" placeholder="Nama PIC supplier">
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="input-field"
                                placeholder="021-xxx">
                        </div>
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="input-field @error('email') border-danger @enderror" placeholder="email@supplier.com">
                            @error('email')
                                <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="address" class="form-label">Alamat</label>
                        <textarea name="address" id="address" rows="3" class="input-field"
                            placeholder="Alamat kantor supplier">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea name="notes" id="notes" rows="2" class="input-field"
                            placeholder="Catatan internal (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <x-admin.form-aside title="Referensi">
                    <div class="admin-tip-box">
                        <p class="mb-2 font-semibold text-accent dark:text-primary">Kode Supplier</p>
                        <p class="font-mono text-sm">{{ $code }}</p>
                        <p class="mt-2">Kode dibuat otomatis dan tidak dapat diubah.</p>
                    </div>
                    <input type="hidden" name="code" value="{{ $code }}">
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="input-field" required>
                            <option value="active" @selected(old('status', 'active') === 'active')>Aktif</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Nonaktif</option>
                        </select>
                    </div>
                </x-admin.form-aside>
            </div>

            <x-admin.form-actions>
                <button type="submit" class="btn-accent">
                    <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                    Simpan Supplier
                </button>
                <a href="{{ route('admin.suppliers.index') }}" class="btn-secondary">Batal</a>
            </x-admin.form-actions>
        </form>
    </x-admin.form-page>
@endsection
