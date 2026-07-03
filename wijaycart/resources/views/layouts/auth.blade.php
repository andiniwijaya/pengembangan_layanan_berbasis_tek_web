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
</head>
<body class="min-h-screen bg-gradient-to-br from-secondary via-background to-primary/20 text-text dark:from-dark-bg dark:via-dark-card dark:to-primary/5 dark:text-dark-text">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        @include('partials.flash')
        @yield('content')
    </div>
</body>
</html>
