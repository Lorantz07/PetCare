@props([
    'label',
    'value',
    'trend' => null,
    'caption' => null,
    'icon' => 'activity',
    'accent' => 'mint',
    'up' => true,
])

<div {{ $attributes->merge(['class' => 'stat-card']) }}>
    <div class="relative z-10 flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="stat-label">{{ $label }}</p>
            <p class="stat-value">{{ $value }}</p>
        </div>
        <span class="icon-tile icon-tile-{{ $accent }} shrink-0">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </span>
    </div>

    @if ($trend || $caption)
        <div class="relative z-10 mt-2 flex flex-wrap items-center gap-1.5">
            @if ($trend)
                <span class="stat-trend {{ $up ? 'stat-trend-up' : 'stat-trend-down' }}">
                    <i data-lucide="{{ $up ? 'trending-up' : 'trending-down' }}" class="h-3 w-3"></i>
                    {{ $trend }}
                </span>
            @endif
            @if ($caption)
                <span class="stat-caption">{{ $caption }}</span>
            @endif
        </div>
    @endif
</div>
