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
    <title>@yield('title', 'Error') — WijayCart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-text dark:bg-dark-bg dark:text-dark-text">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary">
                    <i data-lucide="shopping-bag" class="h-6 w-6 text-accent"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-accent dark:text-primary">WijayCart</span>
            </a>
        </div>

        <div class="card w-full max-w-lg text-center">
            @yield('content')
        </div>

        <a href="{{ route('home') }}" class="btn-accent mt-8">
            <i data-lucide="home" class="h-4 w-4"></i>
            Kembali ke Home
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const html = document.documentElement;
            if (html.dataset.auth !== 'true' && localStorage.getItem('theme') === 'dark') {
                html.classList.add('dark');
                html.dataset.theme = 'dark';
            }
            window.initLucideIcons?.();
        });
    </script>
</body>
</html>
