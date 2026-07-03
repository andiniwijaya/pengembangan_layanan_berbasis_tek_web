@extends('layouts.admin')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
    <x-admin.form-page :back-url="route('admin.dashboard')" back-label="Kembali ke Dashboard"
        subtitle="Perbarui informasi akun admin, foto profil, dan password Anda.">
        <div class="admin-form-grid">
            <div>
                @include('profile.partials.form', ['user' => $user])

                <x-admin.form-actions>
                    <button type="submit" form="profile-form" class="btn-accent">
                        <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Batal</a>
                </x-admin.form-actions>
            </div>

            <x-admin.form-aside title="Akun Admin">
                <div class="admin-icon-preview">
                    <img src="{{ $user->avatar_url }}" alt=""
                        class="mb-3 h-24 w-24 rounded-2xl object-cover ring-2 ring-gold-border/50 dark:ring-primary/30">
                    <p class="text-sm font-semibold text-accent dark:text-primary">{{ $user->name }}</p>
                    <p class="mt-1 text-xs text-text/55 dark:text-dark-muted">{{ $user->email }}</p>
                </div>
                <div class="admin-tip-box">
                    <p class="font-semibold text-text/70 dark:text-dark-text">Keamanan akun</p>
                    <p class="mt-1">Ganti password secara berkala dan jangan bagikan kredensial login admin kepada siapa pun.</p>
                </div>
            </x-admin.form-aside>
        </div>
    </x-admin.form-page>
@endsection
