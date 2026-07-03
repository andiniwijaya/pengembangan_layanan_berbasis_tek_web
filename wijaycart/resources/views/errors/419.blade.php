@extends('errors.layout')

@section('title', '419 — Sesi Kedaluwarsa')

@section('content')
<div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/30">
    <i data-lucide="clock" class="h-8 w-8 text-accent dark:text-primary"></i>
</div>
<h1 class="mb-2 text-3xl font-bold">419</h1>
<h2 class="mb-3 text-lg font-semibold">Sesi Kedaluwarsa</h2>
<p class="text-sm text-text/70 dark:text-dark-muted">
    Token keamanan formulir telah kedaluwarsa. Silakan muat ulang halaman dan coba lagi.
</p>
@endsection
