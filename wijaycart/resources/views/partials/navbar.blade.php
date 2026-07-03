<nav id="main-navbar"
    class="sticky top-0 z-40 border-b border-border bg-card/95 backdrop-blur-md transition-shadow duration-300 dark:border-dark-border dark:bg-dark-card/95">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex items-center gap-4 md:gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2" aria-label="WijayCart Home">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary">
                        <i data-lucide="shopping-bag" class="h-5 w-5 text-accent" aria-hidden="true"></i>
                    </div>
                    <span class="text-lg font-bold tracking-tight text-accent dark:text-primary">WijayCart</span>
                </a>

                <div class="hidden items-center gap-6 md:flex">
                    <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                    <a href="{{ route('products.index') }}" class="nav-link">Katalog</a>
                    @auth
                        @if (auth()->user()->isCustomer())
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        @elseif (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">Panel Admin</a>
                        @endif
                    @endauth
                </div>
            </div>

            <form action="{{ route('products.index') }}" method="GET" class="hidden flex-1 max-w-md sm:block"
                role="search">
                <label for="navbar-search" class="sr-only">Cari produk</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text/40"
                        aria-hidden="true"></i>
                    <input id="navbar-search" type="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari produk..." class="input-field pl-10 py-2.5">
                </div>
            </form>

            <div class="flex items-center gap-1 sm:gap-2">
                <button id="dark-mode-toggle" type="button"
                    class="rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border"
                    aria-label="Alihkan mode gelap">
                    <i data-lucide="moon" class="h-5 w-5 dark:hidden" aria-hidden="true"></i>
                    <i data-lucide="sun" class="hidden h-5 w-5 dark:block" aria-hidden="true"></i>
                </button>

                @auth
                    @if (auth()->user()->isCustomer())
                        <a href="{{ route('wishlist.index') }}"
                            class="relative rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border"
                            aria-label="Wishlist{{ $wishlistCount > 0 ? ', ' . $wishlistCount . ' produk' : '' }}">
                            <i data-lucide="heart" class="h-5 w-5" aria-hidden="true"></i>
                            @if ($wishlistCount > 0)
                                <span
                                    class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-danger text-[10px] font-bold text-white"
                                    aria-hidden="true">{{ $wishlistCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('cart.index') }}"
                            class="relative rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border"
                            aria-label="Keranjang{{ $cartCount > 0 ? ', ' . $cartCount . ' produk' : '' }}">
                            <i data-lucide="shopping-cart" class="h-5 w-5" aria-hidden="true"></i>
                            @if ($cartCount > 0)
                                <span id="navbar-cart-count"
                                    class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-accent text-[10px] font-bold text-white"
                                    aria-hidden="true">{{ $cartCount }}</span>
                            @else
                                <span id="navbar-cart-count"
                                    class="absolute -right-0.5 -top-0.5 hidden h-4 w-4 items-center justify-center rounded-full bg-accent text-[10px] font-bold text-white"
                                    aria-hidden="true">0</span>
                            @endif
                        </a>

                        <div class="relative">
                            <button id="notification-menu-button" data-dropdown-toggle="notification-dropdown" type="button"
                                class="relative rounded-xl p-2.5 text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border"
                                aria-label="Notifikasi{{ ($unreadNotificationCount ?? 0) > 0 ? ', ' . $unreadNotificationCount . ' belum dibaca' : '' }}">
                                <i data-lucide="bell" class="h-5 w-5" aria-hidden="true"></i>
                                @if (($unreadNotificationCount ?? 0) > 0)
                                    <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-danger"
                                        aria-hidden="true"></span>
                                @endif
                            </button>
                            <div id="notification-dropdown"
                                class="z-50 hidden w-72 divide-y divide-border rounded-xl border border-border bg-card shadow-lg dark:divide-dark-border dark:border-dark-border dark:bg-dark-card">
                                <div class="flex items-center justify-between px-4 py-3">
                                    <div>
                                        <p class="text-sm font-semibold">Notifikasi</p>
                                        @if (($unreadNotificationCount ?? 0) > 0)
                                            <p class="text-xs text-text/50 dark:text-dark-muted">{{ $unreadNotificationCount }}
                                                belum dibaca</p>
                                        @endif
                                    </div>
                                    @if (($unreadNotificationCount ?? 0) > 0)
                                        <form action="{{ route('notifications.read-all') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs font-medium text-accent hover:underline dark:text-primary">Tandai
                                                semua</button>
                                        </form>
                                    @endif
                                </div>
                                <ul class="max-h-64 overflow-y-auto py-1 text-sm">
                                    @forelse($notifications ?? [] as $notification)
                                        <li
                                            class="px-4 py-3 hover:bg-secondary dark:hover:bg-dark-border {{ $notification->is_read ? 'opacity-70' : '' }}">
                                            <div class="flex items-start justify-between gap-2">
                                                <div>
                                                    <p class="font-medium">{{ $notification->title }}</p>
                                                    <p class="text-xs text-text/50 dark:text-dark-muted">
                                                        {{ $notification->message }}</p>
                                                    <p class="mt-1 text-[10px] text-text/40">
                                                        {{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if (!$notification->is_read)
                                                    <form action="{{ route('notifications.read', $notification) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-xs text-accent dark:text-primary"
                                                            title="Tandai dibaca">✓</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <li class="px-4 py-6 text-center text-text/50 dark:text-dark-muted">Belum ada
                                            notifikasi.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="relative">
                        <button id="user-menu-button" data-dropdown-toggle="user-dropdown" type="button"
                            class="flex items-center gap-2 rounded-xl px-2 py-1.5 text-sm font-medium transition-colors hover:bg-secondary dark:hover:bg-dark-border"
                            aria-label="Menu akun {{ auth()->user()->name }}">
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar {{ auth()->user()->name }}"
                                class="h-8 w-8 rounded-full object-cover ring-2 ring-primary/50">
                            <span class="hidden max-w-[100px] truncate md:inline">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="hidden h-4 w-4 md:block" aria-hidden="true"></i>
                        </button>
                        <div id="user-dropdown"
                            class="z-50 hidden w-48 divide-y divide-border rounded-xl border border-border bg-card shadow-lg dark:divide-dark-border dark:border-dark-border dark:bg-dark-card">
                            <ul class="py-1 text-sm">
                                @if (auth()->user()->isAdmin())
                                    <li><a href="{{ route('admin.dashboard') }}"
                                            class="flex items-center gap-2 px-4 py-2 hover:bg-secondary dark:hover:bg-dark-border"><i
                                                data-lucide="layout-dashboard" class="h-4 w-4" aria-hidden="true"></i>
                                            Panel Admin</a></li>
                                @endif
                                @if (auth()->user()->isCustomer())
                                    <li><a href="{{ route('dashboard') }}"
                                            class="flex items-center gap-2 px-4 py-2 hover:bg-secondary dark:hover:bg-dark-border"><i
                                                data-lucide="home" class="h-4 w-4" aria-hidden="true"></i> Dashboard</a></li>
                                    <li><a href="{{ route('orders.index') }}"
                                            class="flex items-center gap-2 px-4 py-2 hover:bg-secondary dark:hover:bg-dark-border"><i
                                                data-lucide="package" class="h-4 w-4" aria-hidden="true"></i> Pesanan
                                            Saya</a></li>
                                @endif
                                <li><a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-2 px-4 py-2 hover:bg-secondary dark:hover:bg-dark-border"><i
                                            data-lucide="user" class="h-4 w-4" aria-hidden="true"></i> Profil</a></li>
                            </ul>
                            <div class="py-1">
                                <form action="{{ route('logout') }}" method="POST"
                                    data-confirm="Anda yakin ingin keluar dari akun?"
                                    data-confirm-title="Konfirmasi Logout">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-left text-danger hover:bg-secondary dark:hover:bg-dark-border">
                                        <i data-lucide="log-out" class="h-4 w-4" aria-hidden="true"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden rounded-xl px-4 py-2 text-sm font-medium text-text/70 transition-colors hover:bg-secondary sm:inline-flex dark:text-dark-muted dark:hover:bg-dark-border">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary py-2 px-4 text-sm">Daftar</a>
                @endauth

                <button data-collapse-toggle="mobile-menu" type="button" class="rounded-xl p-2.5 md:hidden"
                    aria-label="Buka menu navigasi">
                    <i data-lucide="menu" class="h-5 w-5" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-border py-4 md:hidden dark:border-dark-border">
            <form action="{{ route('products.index') }}" method="GET" class="mb-4" role="search">
                <label for="mobile-search" class="sr-only">Cari produk</label>
                <input id="mobile-search" type="search" name="search" placeholder="Cari produk..."
                    class="input-field">
            </form>
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="nav-link px-2 py-2">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link px-2 py-2">Katalog</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link px-2 py-2">Panel Admin</a>
                    @endif
                    @if (auth()->user()->isCustomer())
                        <a href="{{ route('dashboard') }}" class="nav-link px-2 py-2">Dashboard</a>
                        <a href="{{ route('cart.index') }}" class="nav-link px-2 py-2">Keranjang ({{ $cartCount }})</a>
                        <a href="{{ route('wishlist.index') }}" class="nav-link px-2 py-2">Wishlist
                            ({{ $wishlistCount }})</a>
                        <a href="{{ route('orders.index') }}" class="nav-link px-2 py-2">Pesanan Saya</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="nav-link px-2 py-2">Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="px-2 pt-2">
                        @csrf
                        <button type="submit" class="nav-link w-full py-2 text-left text-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link px-2 py-2">Login</a>
                    <a href="{{ route('register') }}" class="nav-link px-2 py-2">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
