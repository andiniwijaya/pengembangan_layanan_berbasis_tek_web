@props([
    'backUrl',
    'backLabel' => 'Kembali',
])

<div class="admin-detail-toolbar">
    <a href="{{ $backUrl }}" class="admin-back-link">
        <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
        {{ $backLabel }}
    </a>

    @if (! $slot->isEmpty())
        <div class="mt-4 flex flex-wrap items-center gap-3">
            {{ $slot }}
        </div>
    @endif
</div>
