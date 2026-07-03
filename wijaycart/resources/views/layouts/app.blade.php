<!DOCTYPE html>
<html lang="id"
    @auth
        data-auth="true"
        data-theme="{{ auth()->user()->dark_mode ? 'dark' : 'light' }}"
        @if(auth()->user()->dark_mode) class="dark" @endif
    @else
        data-auth="false"
        data-theme="light"
    @endauth
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WijayCart') — Lifestyle Store</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-background text-text dark:bg-dark-bg dark:text-dark-text">
    @include('partials.navbar')

    <main>
        @include('partials.flash')
        @yield('content')
    </main>

    @if (request()->routeIs('home'))
        @include('partials.footer-full')
    @else
        @include('partials.footer-simple')
    @endif

    @stack('scripts')
</body>
</html>
