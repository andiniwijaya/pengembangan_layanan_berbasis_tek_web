<footer class="mt-auto border-t border-border bg-secondary/50 dark:border-dark-border dark:bg-dark-card/50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary">
                        <i data-lucide="shopping-bag" class="h-5 w-5 text-accent" aria-hidden="true"></i>
                    </div>
                    <span class="text-lg font-bold text-accent dark:text-primary">WijayCart</span>
                </div>
                <p class="max-w-sm text-sm leading-relaxed text-text/70 dark:text-dark-muted">
                    Destinasi lifestyle modern dengan nuansa warm minimalist. Temukan produk home living, stationery, coffee, dan lebih banyak lagi.
                </p>
            </div>

            <div>
                <h4 class="mb-4 text-sm font-semibold uppercase tracking-wider text-accent dark:text-primary">Perusahaan</h4>
                <ul class="space-y-2 text-sm text-text/70 dark:text-dark-muted">
                    <li><a href="{{ route('pages.about') }}" class="transition-colors hover:text-accent">Tentang Kami</a></li>
                    <li><a href="{{ route('pages.help') }}" class="transition-colors hover:text-accent">Pusat Bantuan</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="transition-colors hover:text-accent">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h4 class="mb-4 text-sm font-semibold uppercase tracking-wider text-accent dark:text-primary">Legal</h4>
                <ul class="space-y-2 text-sm text-text/70 dark:text-dark-muted">
                    <li><a href="{{ route('pages.privacy') }}" class="transition-colors hover:text-accent">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('pages.terms') }}" class="transition-colors hover:text-accent">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="mb-4 text-sm font-semibold uppercase tracking-wider text-accent dark:text-primary">Kategori</h4>
                <ul class="space-y-2 text-sm text-text/70 dark:text-dark-muted">
                    @forelse($footerCategories ?? [] as $category)
                    <li>
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="transition-colors hover:text-accent">
                            {{ $category->name }}
                        </a>
                    </li>
                    @empty
                    <li><a href="{{ route('products.index') }}" class="transition-colors hover:text-accent">Semua Produk</a></li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="mt-10 grid gap-6 border-t border-border pt-8 dark:border-dark-border md:grid-cols-2">
            <ul class="space-y-3 text-sm text-text/70 dark:text-dark-muted">
                <li class="flex items-center gap-2">
                    <i data-lucide="mail" class="h-4 w-4 text-accent" aria-hidden="true"></i>
                    {{ $storeSettings['email'] ?? 'hello@wijaycart.com' }}
                </li>
                <li class="flex items-center gap-2">
                    <i data-lucide="phone" class="h-4 w-4 text-accent" aria-hidden="true"></i>
                    {{ $storeSettings['phone'] ?? '+62 812-3456-7890' }}
                </li>
                <li class="flex items-start gap-2">
                    <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-accent" aria-hidden="true"></i>
                    {{ $storeSettings['address'] ?? 'Jl. Lifestyle No. 88, Jakarta Selatan' }}
                </li>
            </ul>
            <div class="flex items-center gap-3 md:justify-end">
                <a href="#" class="rounded-lg bg-card p-2 text-text/60 shadow-sm transition-colors hover:text-accent dark:bg-dark-card dark:text-dark-muted" aria-label="Instagram WijayCart"><i data-lucide="instagram" class="h-4 w-4" aria-hidden="true"></i></a>
                <a href="#" class="rounded-lg bg-card p-2 text-text/60 shadow-sm transition-colors hover:text-accent dark:bg-dark-card dark:text-dark-muted" aria-label="Twitter WijayCart"><i data-lucide="twitter" class="h-4 w-4" aria-hidden="true"></i></a>
                <a href="#" class="rounded-lg bg-card p-2 text-text/60 shadow-sm transition-colors hover:text-accent dark:bg-dark-card dark:text-dark-muted" aria-label="Facebook WijayCart"><i data-lucide="facebook" class="h-4 w-4" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-text/50 dark:text-dark-muted">
            &copy; {{ date('Y') }} WijayCart. All rights reserved.
        </div>
    </div>
</footer>
