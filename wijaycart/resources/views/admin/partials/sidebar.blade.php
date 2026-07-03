@php
    $menuGroups = [
        [
            'label' => null,
            'items' => [
                [
                    'route' => 'admin.dashboard',
                    'icon' => 'layout-dashboard',
                    'label' => 'Dashboard',
                    'match' => 'admin.dashboard',
                ],
            ],
        ],
        [
            'label' => 'Master Data',
            'items' => [
                [
                    'route' => 'admin.products.index',
                    'icon' => 'package',
                    'label' => 'Produk',
                    'match' => 'admin.products.*',
                ],
                [
                    'route' => 'admin.categories.index',
                    'icon' => 'tags',
                    'label' => 'Kategori',
                    'match' => 'admin.categories.*',
                ],
                [
                    'route' => 'admin.suppliers.index',
                    'icon' => 'truck',
                    'label' => 'Supplier',
                    'match' => 'admin.suppliers.*',
                ],
            ],
        ],
        [
            'label' => 'Transaksi',
            'items' => [
                [
                    'route' => 'admin.orders.index',
                    'icon' => 'shopping-bag',
                    'label' => 'Pesanan',
                    'match' => 'admin.orders.*',
                    'params' => [],
                ],
                [
                    'route' => 'admin.orders.index',
                    'icon' => 'credit-card',
                    'label' => 'Pembayaran',
                    'match' => null,
                    'params' => ['payment' => 'pending'],
                ],
            ],
        ],
        [
            'label' => 'Pengguna',
            'items' => [
                [
                    'route' => 'admin.customers.index',
                    'icon' => 'users',
                    'label' => 'Customer',
                    'match' => 'admin.customers.*',
                ],
                ['route' => 'admin.staff.index', 'icon' => 'shield', 'label' => 'Admin', 'match' => 'admin.staff.*'],
            ],
        ],
        [
            'label' => 'Komunikasi',
            'items' => [
                [
                    'route' => 'admin.contacts.index',
                    'icon' => 'mail',
                    'label' => 'Pesan Kontak',
                    'match' => 'admin.contacts.*',
                ],
                [
                    'route' => 'admin.newsletters.index',
                    'icon' => 'newspaper',
                    'label' => 'Newsletter',
                    'match' => 'admin.newsletters.*',
                ],
            ],
        ],
        [
            'label' => 'Sistem',
            'items' => [
                [
                    'route' => 'admin.reports.index',
                    'icon' => 'bar-chart-3',
                    'label' => 'Laporan',
                    'match' => 'admin.reports.*',
                ],
                [
                    'route' => 'admin.settings.index',
                    'icon' => 'settings',
                    'label' => 'Pengaturan',
                    'match' => 'admin.settings.*',
                ],
            ],
        ],
    ];

    $isActive = function (array $item): bool {
        if (($item['params']['payment'] ?? null) === 'pending') {
            return request()->routeIs('admin.orders.*') && request('payment') === 'pending';
        }

        if ($item['match'] && request()->routeIs($item['match'])) {
            if ($item['match'] === 'admin.orders.*' && request('payment') === 'pending') {
                return false;
            }

            return true;
        }

        return false;
    };
@endphp

<aside id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-30 flex w-64 -translate-x-full flex-col border-r border-border bg-card transition-transform duration-300 lg:translate-x-0 dark:border-dark-border dark:bg-dark-card">
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-border px-5 dark:border-dark-border">
        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary shadow-sm">
            <i data-lucide="shopping-bag" class="h-4 w-4 text-accent" aria-hidden="true"></i>
        </div>
        <div>
            <span class="block font-bold text-accent dark:text-primary">WijayCart</span>
            <span class="text-[10px] font-medium uppercase tracking-wider text-text/40 dark:text-dark-muted">Admin
                Panel</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-3">
        @foreach ($menuGroups as $group)
            @if ($group['label'])
                <p class="admin-nav-section">{{ $group['label'] }}</p>
            @endif
            <div class="mb-2 space-y-0.5">
                @foreach ($group['items'] as $item)
                    <a href="{{ route($item['route'], $item['params'] ?? []) }}"
                        class="admin-nav-link {{ $isActive($item) ? 'admin-nav-link-active' : 'admin-nav-link-inactive' }}">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg {{ $isActive($item) ? 'bg-primary/50 dark:bg-primary/30' : 'bg-secondary/80 dark:bg-dark-border/50' }}">
                            <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4" aria-hidden="true"></i>
                        </span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="border-t border-border p-3 dark:border-dark-border">
        <a href="{{ route('home') }}" class="admin-nav-link admin-nav-link-inactive">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-secondary/80 dark:bg-dark-border/50">
                <i data-lucide="store" class="h-4 w-4" aria-hidden="true"></i>
            </span>
            Lihat Toko
        </a>
    </div>
</aside>
