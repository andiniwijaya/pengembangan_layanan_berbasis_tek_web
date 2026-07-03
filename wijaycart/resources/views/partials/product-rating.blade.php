{{-- Rating bintang produk --}}
@php
    $rating = $rating ?? 0;
    $count = $count ?? 0;
    $size = $size ?? 'sm';
    $showCount = $showCount ?? true;
    $iconClass = $size === 'lg' ? 'h-4 w-4' : 'h-3.5 w-3.5';
    $textClass = $size === 'lg' ? 'text-sm' : 'text-xs';
@endphp
<div class="flex items-center gap-1.5">
    @for($i = 1; $i <= 5; $i++)
    <i data-lucide="star" class="{{ $iconClass }} {{ $i <= round($rating) ? 'fill-primary text-primary' : 'text-border' }}"></i>
    @endfor
    @if($showCount)
    <span class="ml-1 {{ $textClass }} text-text/50 dark:text-dark-muted">
        @if($count > 0)
            {{ number_format($rating, 1) }} ({{ $count }})
        @else
            Belum ada ulasan
        @endif
    </span>
    @endif
</div>
