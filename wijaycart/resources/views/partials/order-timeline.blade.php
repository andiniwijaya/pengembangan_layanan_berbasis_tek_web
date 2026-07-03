{{-- Timeline status pesanan --}}
<div class="card">
    <h3 class="mb-4 font-semibold">Lacak Pesanan</h3>
    <ol class="relative border-s border-border dark:border-dark-border">
        @foreach($timelineSteps as $index => $step)
        <li class="mb-8 ms-6 last:mb-0">
            <span @class([
                'absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full ring-4 ring-card dark:ring-dark-card',
                'bg-success text-white' => $step['completed'] && !($step['current'] ?? false),
                'bg-primary text-accent' => $step['current'] ?? false,
                'bg-secondary text-text/40 dark:bg-dark-border' => !($step['completed'] ?? false) && !($step['current'] ?? false),
            ])>
                @if($step['completed'] && !($step['current'] ?? false))
                <i data-lucide="check" class="h-3.5 w-3.5"></i>
                @else
                <span class="text-xs font-bold">{{ $index + 1 }}</span>
                @endif
            </span>
            <h4 @class([
                'font-semibold',
                'text-accent dark:text-primary' => $step['current'] ?? false,
                'text-text/50 dark:text-dark-muted' => !($step['completed'] ?? false) && !($step['current'] ?? false),
            ])>{{ $step['label'] }}</h4>
            @if($step['recorded_at'])
            <p class="text-xs text-text/50 dark:text-dark-muted">{{ $step['recorded_at']->format('d M Y, H:i') }}</p>
            @endif
        </li>
        @endforeach
    </ol>
</div>
