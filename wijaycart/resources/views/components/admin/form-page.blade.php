@props([
    'backUrl',
    'backLabel' => 'Kembali',
    'subtitle' => null,
    'wide' => false,
])

<div class="admin-page">
    <a href="{{ $backUrl }}" class="admin-back-link">
        <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
        {{ $backLabel }}
    </a>

    @if ($subtitle)
        <p class="admin-page-subtitle">{{ $subtitle }}</p>
    @endif

    <div @class(['admin-form-card', 'admin-form-card-wide' => $wide])>
        <div class="admin-form-card-body">
            {{ $slot }}
        </div>
    </div>
</div>
