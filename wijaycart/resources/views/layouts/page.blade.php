@extends('layouts.app')

@section('title', trim(strip_tags($__env->yieldContent('page-title'))))

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm text-text/50 dark:text-dark-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-accent">Beranda</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <span class="text-text dark:text-dark-text">@yield('page-title')</span>
        </nav>
        <h1 class="section-title mb-6">@yield('page-title')</h1>
        <div class="card max-w-none space-y-4 text-text/80 dark:text-dark-muted">
            @yield('page-content')
        </div>
    </div>
@endsection
