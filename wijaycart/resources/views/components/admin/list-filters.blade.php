@props([
    'action',
    'searchPlaceholder' => 'Cari...',
    'showSearch' => true,
    'statusOptions' => null,
    'statusLabel' => 'Semua Status',
    'resetUrl' => null,
    'filterKeys' => ['search', 'status', 'category', 'payment'],
])

@php
    $activeKeys = array_values(array_filter($filterKeys, fn ($key) => $key !== null));
    $hasFilters = collect($activeKeys)->contains(fn ($key) => request()->filled($key));
    $resetHref = $resetUrl ?? $action;
@endphp

<div class="mb-6 card !p-4">
    <form action="{{ $action }}" method="GET" class="flex flex-wrap items-end gap-3">
        @isset($hidden)
            {{ $hidden }}
        @endisset

        @if ($showSearch)
            <div class="min-w-[12rem] flex-1">
                <label for="admin-filter-search" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Pencarian</label>
                <div class="relative">
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text/40"
                        aria-hidden="true"></i>
                    <input id="admin-filter-search" type="search" name="search" value="{{ request('search') }}"
                        placeholder="{{ $searchPlaceholder }}" class="input-field w-full py-2 pl-10 text-sm">
                </div>
            </div>
        @endif

        @if ($statusOptions)
            <div class="min-w-[10rem]">
                <label for="admin-filter-status" class="mb-1.5 block text-xs font-medium text-text/60 dark:text-dark-muted">Status</label>
                <select id="admin-filter-status" name="status" class="input-field w-full py-2 text-sm">
                    <option value="">{{ $statusLabel }}</option>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === (string) $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @isset($filters)
            {{ $filters }}
        @endisset

        <div class="flex flex-wrap gap-2">
            <button type="submit" class="btn-accent text-sm">
                <i data-lucide="filter" class="h-4 w-4" aria-hidden="true"></i>
                Filter
            </button>
            @if ($hasFilters)
                <a href="{{ $resetHref }}" class="btn-secondary text-sm">Reset</a>
            @endif
        </div>
    </form>
</div>
