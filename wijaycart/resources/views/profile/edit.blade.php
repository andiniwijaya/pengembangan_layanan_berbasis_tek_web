@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-accent hover:underline dark:text-primary">
            <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
            Kembali ke Dashboard
        </a>

        <div class="mb-8">
            <h1 class="section-title">Edit Profil</h1>
            <p class="mt-2 text-sm text-text/60 dark:text-dark-muted">Perbarui informasi akun dan keamanan Anda.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_17rem]">
            <div class="card !p-6 md:!p-8">
                @include('profile.partials.form', ['user' => $user])

                <div class="mt-8 flex flex-wrap gap-3 border-t border-border pt-6 dark:border-dark-border">
                    <button type="submit" form="profile-form" class="btn-accent">
                        <i data-lucide="save" class="h-4 w-4" aria-hidden="true"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="card !p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-wider text-text/50 dark:text-dark-muted">Akun Anda</p>
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->avatar_url }}" alt="" class="h-12 w-12 rounded-xl object-cover ring-2 ring-primary/30">
                        <div class="min-w-0">
                            <p class="truncate font-semibold">{{ $user->name }}</p>
                            <p class="truncate text-xs text-text/50">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="mt-3 inline-flex badge badge-warning">{{ $user->isAdmin() ? 'Admin' : 'Customer' }}</span>
                </div>
                <div class="rounded-2xl border border-gold-border/35 bg-gradient-to-b from-gold-light/40 via-primary/10 to-secondary/30 p-5 dark:border-primary/15 dark:from-primary/10 dark:to-dark-border/30">
                    <p class="mb-2 text-xs font-bold uppercase tracking-wider text-accent/60 dark:text-dark-muted">Tips</p>
                    <ul class="space-y-2 text-xs leading-relaxed text-text/60 dark:text-dark-muted">
                        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-success"></i> Lengkapi alamat untuk checkout lebih cepat.</li>
                        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-success"></i> Gunakan password kuat minimal 8 karakter.</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
@endsection
