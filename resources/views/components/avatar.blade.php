@props(['name' => '?', 'initials' => null, 'photo' => null, 'size' => 'md', 'color' => 'mint', 'ring' => false])

@php
    $computedInitials = $initials;

    if (! $computedInitials) {
        $computedInitials = collect(explode(' ', trim($name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    }
@endphp

<span {{ $attributes->merge(['class' => "avatar avatar-{$size} avatar-{$color}" . ($ring ? ' avatar-ring' : '')]) }}>
    @if ($photo)
        <img src="{{ asset($photo) }}" alt="{{ $name }}">
    @else
        {{ $computedInitials }}
    @endif
</span>
