{{-- Komponen empty state reusable untuk halaman tanpa data --}}
@props(['icon' => 'inbox', 'title' => 'Data Kosong', 'description' => 'Belum ada data untuk ditampilkan.', 'actionUrl' => null, 'actionLabel' => null])

<div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-border bg-card/50 px-6 py-16 text-center dark:border-dark-border dark:bg-dark-card/50">
    <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-secondary dark:bg-dark-border">
        <i data-lucide="{{ $icon }}" class="h-10 w-10 text-text/30 dark:text-dark-muted"></i>
    </div>
    <h3 class="mb-2 text-lg font-semibold text-text dark:text-dark-text">{{ $title }}</h3>
    <p class="mb-6 max-w-sm text-sm text-text/60 dark:text-dark-muted">{{ $description }}</p>
    @if($actionUrl && $actionLabel)
    <a href="{{ $actionUrl }}" class="btn-accent inline-flex text-sm">{{ $actionLabel }}</a>
    @endif
</div>
