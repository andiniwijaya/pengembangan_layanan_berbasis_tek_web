<header class="sticky top-0 z-20 border-b border-border bg-card/95 backdrop-blur-md dark:border-dark-border dark:bg-dark-card/95">
    <div class="flex h-16 items-center justify-between gap-4 px-4 md:px-6">
        <div class="flex min-w-0 flex-1 items-center gap-3">
            <button
                type="button"
                data-admin-sidebar-toggle
                class="rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary lg:hidden dark:text-dark-muted dark:hover:bg-dark-border"
                data-tooltip-target="tooltip-admin-menu"
                data-tooltip-placement="bottom"
                aria-label="Buka menu"
            >
                <i data-lucide="menu" class="h-5 w-5" aria-hidden="true"></i>
            </button>
            <div id="tooltip-admin-menu" role="tooltip" class="tooltip invisible absolute z-50 inline-block rounded-lg bg-accent px-3 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 dark:bg-dark-border">
                Menu
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <div class="hidden min-w-0 sm:block">
                <h1 class="truncate text-lg font-semibold">@yield('page-title', 'Admin Panel')</h1>
            </div>

            <form action="{{ route('admin.products.index') }}" method="GET" class="ml-auto hidden max-w-xs flex-1 md:flex" role="search">
                <label for="admin-search" class="sr-only">Cari produk</label>
                <div class="relative w-full">
                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text/40" aria-hidden="true"></i>
                    <input
                        id="admin-search"
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari produk..."
                        class="input-field py-2 pl-10 text-sm"
                    >
                </div>
            </form>
        </div>

        <div class="flex shrink-0 items-center gap-1 sm:gap-2">
            <a
                href="{{ route('dashboard') }}"
                class="hidden rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary sm:inline-flex dark:text-dark-muted dark:hover:bg-dark-border"
                data-tooltip-target="tooltip-admin-notif"
                data-tooltip-placement="bottom"
                aria-label="Notifikasi"
            >
                <i data-lucide="bell" class="h-5 w-5" aria-hidden="true"></i>
            </a>
            <div id="tooltip-admin-notif" role="tooltip" class="tooltip invisible absolute z-50 inline-block rounded-lg bg-accent px-3 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 dark:bg-dark-border">
                Notifikasi
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <button
                id="dark-mode-toggle"
                type="button"
                class="rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border"
                data-tooltip-target="tooltip-admin-theme"
                data-tooltip-placement="bottom"
                aria-label="Toggle dark mode"
            >
                <i data-lucide="moon" class="h-5 w-5 dark:hidden" aria-hidden="true"></i>
                <i data-lucide="sun" class="hidden h-5 w-5 dark:block" aria-hidden="true"></i>
            </button>
            <div id="tooltip-admin-theme" role="tooltip" class="tooltip invisible absolute z-50 inline-block rounded-lg bg-accent px-3 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 dark:bg-dark-border">
                Dark Mode
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <div class="relative ml-1" data-dropdown-toggle="admin-profile-dropdown" data-dropdown-placement="bottom-end">
                <button
                    type="button"
                    class="flex items-center gap-2 rounded-xl border border-border bg-secondary/60 px-2 py-1.5 transition-colors hover:bg-secondary dark:border-dark-border dark:bg-dark-border/60 dark:hover:bg-dark-border"
                    aria-label="Menu profil"
                >
                    <img
                        src="{{ auth()->user()->avatar_url }}"
                        alt="Avatar {{ auth()->user()->name }}"
                        class="h-8 w-8 rounded-full object-cover ring-2 ring-primary/40"
                    >
                    <span class="hidden max-w-[120px] truncate text-sm font-medium lg:inline">{{ auth()->user()->name }}</span>
                    <i data-lucide="chevron-down" class="hidden h-4 w-4 text-text/50 lg:inline" aria-hidden="true"></i>
                </button>
                <div id="admin-profile-dropdown" class="z-50 hidden w-52 divide-y divide-border rounded-xl border border-border bg-card shadow-lg dark:divide-dark-border dark:border-dark-border dark:bg-dark-card">
                    <div class="px-4 py-3">
                        <p class="truncate text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-text/50 dark:text-dark-muted">{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="py-1 text-sm">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 hover:bg-secondary dark:hover:bg-dark-border">
                                <i data-lucide="user" class="h-4 w-4" aria-hidden="true"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-4 py-2.5 hover:bg-secondary dark:hover:bg-dark-border">
                                <i data-lucide="settings" class="h-4 w-4" aria-hidden="true"></i>
                                Pengaturan
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <form action="{{ route('logout') }}" method="POST" data-confirm="Anda yakin ingin keluar?" data-confirm-title="Konfirmasi Logout">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-danger hover:bg-danger/10">
                                <i data-lucide="log-out" class="h-4 w-4" aria-hidden="true"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
