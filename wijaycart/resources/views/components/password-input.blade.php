@props(['name', 'id' => null, 'required' => false, 'autocomplete' => null, 'class' => ''])

@php
    $inputId = $id ?? $name;
@endphp

<div class="relative" data-password-toggle>
    <input
        type="password"
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if($required) required @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        {{ $attributes->merge(['class' => 'input-field pr-11 ' . $class]) }}
    >
    <button
        type="button"
        data-password-toggle-btn
        class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-text/40 transition-colors hover:bg-secondary hover:text-accent dark:text-dark-muted dark:hover:bg-dark-border dark:hover:text-primary"
        data-tooltip-target="tooltip-pw-{{ $inputId }}"
        data-tooltip-placement="top"
        aria-label="Tampilkan password"
    >
        <i data-lucide="eye" class="h-4 w-4 password-icon-show" aria-hidden="true"></i>
        <i data-lucide="eye-off" class="hidden h-4 w-4 password-icon-hide" aria-hidden="true"></i>
    </button>
    <div id="tooltip-pw-{{ $inputId }}" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-accent px-3 py-2 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 dark:bg-dark-border">
        Tampilkan / Sembunyikan Password
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
