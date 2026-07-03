@extends('layouts.page')

@section('page-title', 'Kontak')

@section('page-content')
<div class="grid gap-6 sm:grid-cols-2">
    <div class="card !p-5">
        <h2 class="mb-3 flex items-center gap-2 font-semibold">
            <i data-lucide="mail" class="h-5 w-5 text-accent dark:text-primary" aria-hidden="true"></i>
            Email
        </h2>
        <p class="text-text/70 dark:text-dark-muted">{{ $storeSettings['email'] ?? 'hello@wijaycart.com' }}</p>
    </div>
    <div class="card !p-5">
        <h2 class="mb-3 flex items-center gap-2 font-semibold">
            <i data-lucide="phone" class="h-5 w-5 text-accent dark:text-primary" aria-hidden="true"></i>
            Telepon
        </h2>
        <p class="text-text/70 dark:text-dark-muted">{{ $storeSettings['phone'] ?? '+62 812-3456-7890' }}</p>
    </div>
    <div class="card !p-5 sm:col-span-2">
        <h2 class="mb-3 flex items-center gap-2 font-semibold">
            <i data-lucide="map-pin" class="h-5 w-5 text-accent dark:text-primary" aria-hidden="true"></i>
            Alamat
        </h2>
        <p class="text-text/70 dark:text-dark-muted">{{ $storeSettings['address'] ?? 'Jl. Lifestyle No. 88, Jakarta Selatan' }}</p>
    </div>
</div>

<div class="card mt-8">
    <h2 class="mb-4 text-lg font-semibold">Kirim Pesan</h2>
    <form action="{{ route('pages.contact.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-field" required>
            </div>
            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="input-field" required>
            </div>
        </div>
        <div>
            <label for="subject" class="mb-1 block text-sm font-medium">Subjek</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="input-field" required>
        </div>
        <div>
            <label for="message" class="mb-1 block text-sm font-medium">Pesan</label>
            <textarea name="message" id="message" rows="5" class="input-field" required>{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn-accent">Kirim Pesan</button>
    </form>
</div>

<p class="mt-6 text-sm text-text/60 dark:text-dark-muted">Jam operasional: Senin–Jumat, 09.00–17.00 WIB.</p>
@endsection
