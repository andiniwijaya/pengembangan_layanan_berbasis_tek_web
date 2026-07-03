@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-3">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center rounded-xl border border-border bg-card px-4 py-2.5 text-sm font-medium text-text/40 dark:border-dark-border dark:bg-dark-card dark:text-dark-muted">
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-secondary inline-flex items-center px-4 py-2.5 text-sm">
                Sebelumnya
            </a>
        @endif

        <span class="text-sm text-text/60 dark:text-dark-muted">
            Halaman {{ $paginator->currentPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-accent inline-flex items-center px-4 py-2.5 text-sm">
                Selanjutnya
            </a>
        @else
            <span class="inline-flex items-center rounded-xl border border-border bg-card px-4 py-2.5 text-sm font-medium text-text/40 dark:border-dark-border dark:bg-dark-card dark:text-dark-muted">
                Selanjutnya
            </span>
        @endif
    </nav>
@endif
