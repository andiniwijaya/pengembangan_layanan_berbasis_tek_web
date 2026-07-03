@extends('errors.layout')

@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')
<div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/30">
    <i data-lucide="search-x" class="h-8 w-8 text-accent dark:text-primary"></i>
</div>
<h1 class="mb-2 text-3xl font-bold">404</h1>
<h2 class="mb-3 text-lg font-semibold">Halaman Tidak Ditemukan</h2>
<p class="text-sm text-text/70 dark:text-dark-muted">
    Halaman yang Anda cari tidak ada atau telah dipindahkan.
</p>
@endsection
