@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md animate-fade-in">
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-primary shadow-md">
            <i data-lucide="shopping-bag" class="h-7 w-7 text-accent" aria-hidden="true"></i>
        </div>
        <h1 class="text-2xl font-bold">Selamat Datang Kembali</h1>
        <p class="mt-2 text-sm text-text/60 dark:text-dark-muted">Masuk ke akun WijayCart Anda</p>
    </div>

    <div class="card shadow-md">
        <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="form-label">Email<span class="form-required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field @error('email') border-danger @enderror" required autofocus>
                @error('email')<p class="mt-1 text-xs text-danger">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="form-label">Password<span class="form-required">*</span></label>
                <x-password-input name="password" id="password" required autocomplete="current-password" class="@error('password') border-danger @enderror" />
                @error('password')<p class="mt-1 text-xs text-danger">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="rounded border-border text-primary focus:ring-primary">
                Ingat saya
            </label>
            <button type="submit" class="btn-accent w-full">Masuk</button>
        </form>
        <p class="mt-6 text-center text-sm text-text/60 dark:text-dark-muted">
            Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-accent hover:underline dark:text-primary">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
