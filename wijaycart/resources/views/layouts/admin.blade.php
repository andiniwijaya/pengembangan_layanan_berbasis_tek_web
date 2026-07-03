<!DOCTYPE html>
<html lang="id"
    data-auth="true"
    data-theme="{{ auth()->user()->dark_mode ? 'dark' : 'light' }}"
    @if(auth()->user()->dark_mode) class="dark" @endif
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — WijayCart</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="overflow-hidden bg-background text-text dark:bg-dark-bg dark:text-dark-text">
    <div id="admin-sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/40 backdrop-blur-sm lg:hidden" aria-hidden="true"></div>

    @include('admin.partials.sidebar')

    <div class="admin-main-wrap">
        @include('admin.partials.header')

        <main class="admin-content">
            @include('partials.flash')
            @yield('content')
        </main>

        @include('admin.partials.footer')
    </div>

    @stack('scripts')
</body>
</html>
