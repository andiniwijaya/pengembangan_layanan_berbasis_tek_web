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

<aside id="admin-sidebar" class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary shadow-sm ring-1 ring-gold-border/40">
            <i data-lucide="shopping-bag" class="h-4 w-4 text-accent" aria-hidden="true"></i>
        </div>
        <div class="min-w-0 flex-1 admin-sidebar-brand-text">
            <span class="block font-bold text-accent dark:text-primary">WijayCart</span>
            <span class="text-[10px] font-medium uppercase tracking-wider text-accent/60 dark:text-dark-muted">Admin
                Panel</span>
        </div>
        <button type="button" data-admin-sidebar-close class="admin-sidebar-close lg:hidden" aria-label="Tutup menu">
            <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden p-3">
        @foreach ($menuGroups as $group)
            @if ($group['label'])
                <p class="admin-nav-section">{{ $group['label'] }}</p>
            @endif
            <div class="mb-2 space-y-0.5">
                @foreach ($group['items'] as $item)
                    <a href="{{ route($item['route'], $item['params'] ?? []) }}"
                        data-nav-tooltip="{{ $item['label'] }}"
                        class="admin-nav-link {{ $isActive($item) ? 'admin-nav-link-active' : 'admin-nav-link-inactive' }}">
                        <span
                            class="admin-nav-icon {{ $isActive($item) ? 'admin-nav-icon-active' : '' }}">
                            <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4" aria-hidden="true"></i>
                        </span>
                        <span class="admin-nav-label">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="admin-sidebar-footer">
        <a href="{{ route('home') }}" data-nav-tooltip="Lihat Toko" class="admin-nav-link admin-nav-link-inactive">
            <span class="admin-nav-icon">
                <i data-lucide="store" class="h-4 w-4" aria-hidden="true"></i>
            </span>
            <span class="admin-nav-label">Lihat Toko</span>
        </a>
    </div>
</aside>
