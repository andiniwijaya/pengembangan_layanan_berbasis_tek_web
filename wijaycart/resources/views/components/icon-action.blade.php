@props([
    'icon',
    'tooltip',
    'href' => null,
    'type' => 'button',
    'variant' => 'default',
    'form' => null,
])

@php
    $tooltipId = 'tt-' . md5($tooltip . ($href ?? $type));
    $baseClass = match ($variant) {
        'danger' => 'rounded-lg p-2 text-danger transition-colors hover:bg-danger/10 focus:outline-none focus:ring-2 focus:ring-danger/30',
        'success' => 'rounded-lg p-2 text-success transition-colors hover:bg-success/10 focus:outline-none focus:ring-2 focus:ring-success/30',
        default => 'rounded-lg p-2 text-text/70 transition-colors hover:bg-primary/20 focus:outline-none focus:ring-2 focus:ring-primary/30 dark:text-dark-muted',
    };
@endphp

@if($href)
<a
    href="{{ $href }}"
    class="{{ $baseClass }}"
    data-tooltip-target="{{ $tooltipId }}"
    data-tooltip-placement="top"
    aria-label="{{ $tooltip }}"
>
    <i data-lucide="{{ $icon }}" class="h-4 w-4" aria-hidden="true"></i>
</a>
@else
<button
    type="{{ $type }}"
    @if($form) form="{{ $form }}" @endif
    class="{{ $baseClass }}"
    data-tooltip-target="{{ $tooltipId }}"
    data-tooltip-placement="top"
    aria-label="{{ $tooltip }}"
    {{ $attributes }}
>
    <i data-lucide="{{ $icon }}" class="h-4 w-4" aria-hidden="true"></i>
</button>
@endif
<div id="{{ $tooltipId }}" role="tooltip" class="tooltip invisible absolute z-50 inline-block rounded-lg bg-accent px-3 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 dark:bg-dark-border">
    {{ $tooltip }}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
