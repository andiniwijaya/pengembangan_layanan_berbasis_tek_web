@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <div class="w-full max-w-md animate-fade-in">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-primary shadow-md">
                <i data-lucide="user-plus" class="h-7 w-7 text-accent" aria-hidden="true"></i>
            </div>
            <h1 class="text-2xl font-bold">Buat Akun Baru</h1>
            <p class="mt-2 text-sm text-text/60 dark:text-dark-muted">Bergabung dengan WijayCart hari ini</p>
        </div>

        <div class="card shadow-md">
            <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="form-label">Nama Lengkap<span class="form-required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="input-field @error('name') border-danger @enderror" required>
                    @error('name')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="form-label">Email<span class="form-required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="input-field @error('email') border-danger @enderror" required>
                    @error('email')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="input-field">
                    <p class="form-helper">Opsional — untuk keperluan pengiriman.</p>
                </div>
                <div>
                    <label for="password" class="form-label">Password<span class="form-required">*</span></label>
                    <x-password-input name="password" id="password" required autocomplete="new-password"
                        class="@error('password') border-danger @enderror" />
                    @error('password')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password<span
                            class="form-required">*</span></label>
                    <x-password-input name="password_confirmation" id="password_confirmation" required
                        autocomplete="new-password" />
                </div>
                <button type="submit" class="btn-accent w-full">Daftar</button>
            </form>
            <p class="mt-6 text-center text-sm text-text/60 dark:text-dark-muted">
                Sudah punya akun? <a href="{{ route('login') }}"
                    class="font-semibold text-accent hover:underline dark:text-primary">Masuk</a>
            </p>
        </div>
    </div>
@endsection
