@extends('errors.layout')

@section('title', '403 — Akses Ditolak')

@section('content')
<div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-danger/15">
    <i data-lucide="shield-x" class="h-8 w-8 text-danger"></i>
</div>
<h1 class="mb-2 text-3xl font-bold">403</h1>
<h2 class="mb-3 text-lg font-semibold">Akses Ditolak</h2>
<p class="text-sm text-text/70 dark:text-dark-muted">
    {{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
</p>
@endsection
