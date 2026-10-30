<header class="public-header">
    <div class="nav-shell relative">
        <x-logo />

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'is-active' : '' }}">Beranda</a>
            <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.*') ? 'is-active' : '' }}">Layanan</a>
            <a href="{{ route('home') }}#tentang" class="nav-link">Tentang</a>
            <a href="{{ route('home') }}#cara-kerja" class="nav-link">Cara Kerja</a>
            <a href="{{ route('home') }}#kontak" class="nav-link">Kontak</a>
        </nav>

        <div class="hidden items-center gap-2 sm:flex">
            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                Daftar
                <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
            </a>
        </div>

        <button type="button" class="btn-icon lg:hidden" data-menu-toggle="#publicMobileMenu"
                aria-controls="publicMobileMenu" aria-expanded="false" aria-label="Buka menu navigasi">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>

        <div id="publicMobileMenu" class="mobile-menu lg:hidden">
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="mobile-menu-link">Beranda <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="{{ route('services.index') }}" class="mobile-menu-link">Layanan <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="{{ route('home') }}#tentang" class="mobile-menu-link">Tentang <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="{{ route('home') }}#cara-kerja" class="mobile-menu-link">Cara Kerja <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="{{ route('home') }}#kontak" class="mobile-menu-link">Kontak <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2 border-t border-slate-100 pt-3">
                <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            </div>
        </div>
    </div>
</header>
