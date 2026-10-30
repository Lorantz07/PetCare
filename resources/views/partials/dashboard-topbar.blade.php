@php
    $role = $role ?? 'admin';

    $topbarConfig = [
        'admin' => [
            'greeting' => 'Halo, Admin',
            'subtitle' => 'Berikut ringkasan operasional PetCare hari ini.',
            'name' => 'Admin PetCare',
            'initials' => 'AP',
            'color' => 'mint',
            'profile' => 'admin.settings',
            'notification_route' => 'admin.bookings',
            'notifications' => [
                ['icon' => 'calendar-clock', 'title' => '3 booking menunggu konfirmasi', 'copy' => 'Segera tinjau jadwal hari ini.', 'color' => 'amber'],
                ['icon' => 'credit-card', 'title' => '1 pembayaran perlu verifikasi', 'copy' => 'INV-2610-004 · Andi Wijaya.', 'color' => 'sky'],
                ['icon' => 'star', 'title' => 'Ulasan baru masuk', 'copy' => 'Rina Pratama memberi 5 bintang.', 'color' => 'mint'],
            ],
        ],
        'staff' => [
            'greeting' => 'Halo, Nadia',
            'subtitle' => 'Siap membuat hari para hewan lebih baik?',
            'name' => 'Nadia Groomer',
            'initials' => 'NG',
            'color' => 'violet',
            'profile' => 'staff.profile',
            'notification_route' => 'staff.bookings',
            'notifications' => [
                ['icon' => 'calendar-check', 'title' => 'Booking hari ini siap', 'copy' => '3 jadwal menanti Anda.', 'color' => 'mint'],
                ['icon' => 'message-circle', 'title' => 'Catatan pelanggan baru', 'copy' => 'Milo perlu sampo hypoallergenic.', 'color' => 'sky'],
                ['icon' => 'award', 'title' => 'Rating Anda 4,9', 'copy' => 'Pertahankan pelayanan terbaik.', 'color' => 'amber'],
            ],
        ],
        'customer' => [
            'greeting' => 'Halo, Rina',
            'subtitle' => 'Semoga hari Anda dan Milo menyenangkan.',
            'name' => 'Rina Pratama',
            'initials' => 'RP',
            'color' => 'mint',
            'profile' => 'customer.profile',
            'notification_route' => 'customer.bookings',
            'notifications' => [
                ['icon' => 'calendar-check', 'title' => 'Booking hari ini pukul 09.00', 'copy' => 'Grooming Milo · Nadia Groomer.', 'color' => 'mint'],
                ['icon' => 'sparkles', 'title' => 'Poin bertambah 120', 'copy' => 'Terima kasih sudah setia bersama PetCare.', 'color' => 'amber'],
                ['icon' => 'heart', 'title' => 'Waktunya cek kesehatan Luna', 'copy' => 'Sudah 18 hari sejak kunjungan terakhir.', 'color' => 'rose'],
            ],
        ],
    ];

    $current = $topbarConfig[$role] ?? $topbarConfig['admin'];
@endphp

<header class="topbar">
    <div class="flex min-w-0 items-center gap-2.5">
        <button type="button" class="btn-icon xl:hidden" data-sidebar-toggle aria-controls="appSidebar" aria-expanded="false" aria-label="Buka menu dashboard">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>

        <div class="min-w-0">
            <p class="text-[9px] font-extrabold uppercase tracking-[0.16em] text-primary-600/70">PetCare Workspace</p>
            <h1 class="topbar-title truncate">{{ $current['greeting'] }}</h1>
            <p class="topbar-subtitle truncate">{{ $current['subtitle'] }}</p>
        </div>
    </div>

    <div class="flex shrink-0 items-center gap-2">
        <span class="topbar-date">
            <i data-lucide="calendar" class="h-3.5 w-3.5 text-primary-600"></i>
            {{ $today_short }}
        </span>

        <div class="dropdown" data-dropdown>
            <button type="button" class="btn-icon relative" data-dropdown-toggle aria-haspopup="true" aria-expanded="false" aria-label="Notifikasi">
                <i data-lucide="bell" class="h-4.5 w-4.5"></i>
                <span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-amber-500 ring-2 ring-white"></span>
            </button>

            <div class="dropdown-menu w-72 sm:w-80">
                <div class="dropdown-head flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-extrabold text-ink">Notifikasi</p>
                        <p class="text-[10px] font-semibold text-slate-400">3 pembaruan terbaru</p>
                    </div>
                    <span class="badge badge-mint">Baru</span>
                </div>
                <div class="p-1">
                    @foreach ($current['notifications'] as $notification)
                        <a href="{{ route($current['notification_route']) }}" class="dropdown-item items-start">
                            <span class="icon-tile icon-tile-{{ $notification['color'] }} h-8 w-8 shrink-0">
                                <i data-lucide="{{ $notification['icon'] }}" class="h-3.5 w-3.5"></i>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-[11px] font-extrabold text-ink">{{ $notification['title'] }}</span>
                                <span class="mt-0.5 block text-[10px] font-medium leading-4 text-slate-400">{{ $notification['copy'] }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
                <div class="border-t border-slate-100 p-1">
                    <a href="{{ route($current['notification_route']) }}" class="dropdown-item justify-center text-primary-700">
                        Lihat semua aktivitas
                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="dropdown" data-dropdown>
            <button type="button" class="flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white/70 p-1.5 pr-2.5 transition hover:border-primary-200 hover:bg-white" data-dropdown-toggle aria-haspopup="true" aria-expanded="false">
                <x-avatar :initials="$current['initials']" :name="$current['name']" :color="$current['color']" size="sm" />
                <span class="hidden text-left sm:block">
                    <span class="block text-[11px] font-extrabold leading-tight text-ink">{{ $current['name'] }}</span>
                    <span class="block text-[9px] font-semibold text-slate-400">{{ $role === 'admin' ? 'Administrator' : ($role === 'staff' ? 'Senior Groomer' : 'Pelanggan') }}</span>
                </span>
                <i data-lucide="chevron-down" class="hidden h-3.5 w-3.5 text-slate-400 sm:block"></i>
            </button>

            <div class="dropdown-menu">
                <div class="dropdown-head">
                    <p class="text-[11px] font-extrabold text-ink">{{ $current['name'] }}</p>
                    <p class="mt-0.5 truncate text-[10px] font-semibold text-slate-400">
                        {{ $role === 'admin' ? 'admin@petcare.id' : ($role === 'staff' ? 'nadia.groomer@petcare.id' : 'rina.pratama@email.com') }}
                    </p>
                </div>
                <div class="p-1">
                    <a href="{{ route($current['profile']) }}" class="dropdown-item">
                        <i data-lucide="user-round" class="h-4 w-4"></i>
                        Profil saya
                    </a>
                    @if ($role === 'admin')
                        <a href="{{ route('admin.settings') }}" class="dropdown-item">
                            <i data-lucide="settings" class="h-4 w-4"></i>
                            Pengaturan
                        </a>
                    @endif
                    <a href="{{ route('home') }}" class="dropdown-item">
                        <i data-lucide="home" class="h-4 w-4"></i>
                        Kembali ke situs
                    </a>
                </div>
                <div class="border-t border-slate-100 p-1">
                    <a href="{{ route('home') }}" class="dropdown-item text-rose-600 hover:bg-rose-50 hover:text-rose-700">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Keluar dari demo
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
