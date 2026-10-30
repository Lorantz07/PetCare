@props(['dark' => false, 'href' => null])

<a href="{{ $href ?? route('home') }}" class="brand" aria-label="PetCare — Beranda">
    <span class="brand-mark">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="4" r="2"></circle>
            <circle cx="18" cy="8" r="2"></circle>
            <circle cx="20" cy="16" r="2"></circle>
            <path d="M9 10c-2 0-3.5 1.5-3.5 3.5 0 1.5.8 2.5 2 3.1 1.2.6 2.2 1.4 3.5 1.4s2.3-.8 3.5-1.4c1.2-.6 2-1.6 2-3.1C16.5 11.5 15 10 13 10c-.7 0-1.4.2-2 .6-.6-.4-1.3-.6-2-.6Z"></path>
        </svg>
    </span>
    <span class="brand-name {{ $dark ? 'text-white' : '' }}">PetCare</span>
</a>
