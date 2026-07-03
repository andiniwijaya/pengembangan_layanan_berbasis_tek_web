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
<body class="min-h-screen bg-background text-text dark:bg-dark-bg dark:text-dark-text">
    <div id="admin-sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/40 backdrop-blur-sm lg:hidden" aria-hidden="true"></div>

    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex flex-1 flex-col lg:ml-64">
            @include('admin.partials.header')

            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @include('partials.flash')
                @yield('content')
            </main>

            @include('admin.partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
