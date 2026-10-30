<nav class="bottom-nav" aria-label="Navigasi cepat pelanggan">
    <a href="{{ route('customer.dashboard') }}" class="bottom-nav-link {{ request()->routeIs('customer.dashboard') ? 'is-active' : '' }}">
        <i data-lucide="home"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('customer.services') }}" class="bottom-nav-link {{ request()->routeIs('customer.services*') ? 'is-active' : '' }}">
        <i data-lucide="scissors"></i>
        <span>Layanan</span>
    </a>
    <a href="{{ route('customer.booking') }}" class="bottom-nav-link {{ request()->routeIs('customer.booking*') ? 'is-active' : '' }}">
        <i data-lucide="plus"></i>
        <span>Booking</span>
    </a>
    <a href="{{ route('customer.bookings') }}" class="bottom-nav-link {{ request()->routeIs('customer.bookings') ? 'is-active' : '' }}">
        <i data-lucide="calendar-check"></i>
        <span>Riwayat</span>
    </a>
    <a href="{{ route('customer.profile') }}" class="bottom-nav-link {{ request()->routeIs('customer.profile') ? 'is-active' : '' }}">
        <i data-lucide="user-round"></i>
        <span>Profil</span>
    </a>
</nav>
