@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        {{-- Mobile --}}
        <div class="flex items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex flex-1 items-center justify-center rounded-xl border border-border bg-card px-4 py-2.5 text-sm font-medium text-text/40 dark:border-dark-border dark:bg-dark-card dark:text-dark-muted">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-secondary inline-flex flex-1 justify-center py-2.5 text-sm">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-accent inline-flex flex-1 justify-center py-2.5 text-sm">
                    Selanjutnya
                </a>
            @else
                <span class="inline-flex flex-1 items-center justify-center rounded-xl border border-border bg-card px-4 py-2.5 text-sm font-medium text-text/40 dark:border-dark-border dark:bg-dark-card dark:text-dark-muted">
                    Selanjutnya
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between">
            <p class="text-sm text-text/60 dark:text-dark-muted">
                @if ($paginator->firstItem())
                    Menampilkan
                    <span class="font-semibold text-text dark:text-dark-text">{{ $paginator->firstItem() }}</span>
                    –
                    <span class="font-semibold text-text dark:text-dark-text">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-text dark:text-dark-text">{{ $paginator->total() }}</span>
                    hasil
                @else
                    {{ $paginator->count() }} hasil
                @endif
            </p>

            <ul class="inline-flex items-center gap-1 rounded-xl border border-border bg-card p-1 dark:border-dark-border dark:bg-dark-card">
                {{-- Previous --}}
                <li>
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-text/30 dark:text-dark-muted" aria-disabled="true">
                            <i data-lucide="chevron-left" class="h-4 w-4"></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border" aria-label="Halaman sebelumnya">
                            <i data-lucide="chevron-left" class="h-4 w-4"></i>
                        </a>
                    @endif
                </li>

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="inline-flex h-9 min-w-9 items-center justify-center px-2 text-sm text-text/50 dark:text-dark-muted">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li>
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-primary px-3 text-sm font-semibold text-accent dark:text-text">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-3 text-sm font-medium text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border" aria-label="Ke halaman {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                <li>
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-text/70 transition-colors hover:bg-secondary dark:text-dark-muted dark:hover:bg-dark-border" aria-label="Halaman selanjutnya">
                            <i data-lucide="chevron-right" class="h-4 w-4"></i>
                        </a>
                    @else
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-text/30 dark:text-dark-muted" aria-disabled="true">
                            <i data-lucide="chevron-right" class="h-4 w-4"></i>
                        </span>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
@endif
