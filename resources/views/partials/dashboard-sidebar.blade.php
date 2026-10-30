@php
    $role = $role ?? 'admin';

    $roleConfig = [
        'admin' => [
            'label' => 'Admin Workspace',
            'role' => 'Administrator',
            'name' => 'Admin PetCare',
            'initials' => 'AP',
            'color' => 'mint',
            'dashboard' => 'admin.dashboard',
            'profile' => 'admin.settings',
        ],
        'staff' => [
            'label' => 'Staff Workspace',
            'role' => 'Senior Groomer',
            'name' => 'Nadia Groomer',
            'initials' => 'NG',
            'color' => 'violet',
            'dashboard' => 'staff.dashboard',
            'profile' => 'staff.profile',
        ],
        'customer' => [
            'label' => 'Customer Area',
            'role' => 'Pelanggan',
            'name' => 'Rina Pratama',
            'initials' => 'RP',
            'color' => 'mint',
            'dashboard' => 'customer.dashboard',
            'profile' => 'customer.profile',
        ],
    ];

    $current = $roleConfig[$role] ?? $roleConfig['admin'];

    $pendingBookings = collect($bookings)->where('status', 'menunggu')->count();
    $pendingPayments = collect($payments)->where('status', 'verifikasi')->count();
    $staffOpen = collect($bookings)
        ->where('employee', 'Nadia Groomer')
        ->whereIn('status', ['menunggu', 'dikonfirmasi', 'dikerjakan'])
        ->count();

    $navGroups = [
        'admin' => [
            [
                'label' => 'Utama',
                'items' => [
                    ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'layout-dashboard'],
                ],
            ],
            [
                'label' => 'Manajemen',
                'items' => [
                    ['name' => 'Pelanggan', 'route' => 'admin.customers', 'active' => 'admin.customers', 'icon' => 'users-round'],
                    ['name' => 'Karyawan', 'route' => 'admin.employees', 'active' => 'admin.employees', 'icon' => 'user-cog'],
                    ['name' => 'Hewan Peliharaan', 'route' => 'admin.pets', 'active' => 'admin.pets', 'icon' => 'paw-print'],
                    ['name' => 'Layanan', 'route' => 'admin.services', 'active' => 'admin.services', 'icon' => 'scissors'],
                ],
            ],
            [
                'label' => 'Operasional',
                'items' => [
                    ['name' => 'Booking', 'route' => 'admin.bookings', 'active' => 'admin.bookings*', 'icon' => 'calendar-days', 'badge' => $pendingBookings ?: null],
                    ['name' => 'Pembayaran', 'route' => 'admin.payments', 'active' => 'admin.payments', 'icon' => 'credit-card', 'badge' => $pendingPayments ?: null],
                    ['name' => 'Laporan', 'route' => 'admin.reports', 'active' => 'admin.reports', 'icon' => 'bar-chart-3'],
                ],
            ],
            [
                'label' => 'Lainnya',
                'items' => [
                    ['name' => 'Pengaturan', 'route' => 'admin.settings', 'active' => 'admin.settings', 'icon' => 'settings'],
                ],
            ],
        ],
        'staff' => [
            [
                'label' => 'Utama',
                'items' => [
                    ['name' => 'Dashboard', 'route' => 'staff.dashboard', 'active' => 'staff.dashboard', 'icon' => 'layout-dashboard'],
                ],
            ],
            [
                'label' => 'Pekerjaan Saya',
                'items' => [
                    ['name' => 'Jadwal Saya', 'route' => 'staff.schedule', 'active' => 'staff.schedule', 'icon' => 'calendar-days'],
                    ['name' => 'Booking Saya', 'route' => 'staff.bookings', 'active' => 'staff.bookings*', 'icon' => 'clipboard-list', 'badge' => $staffOpen ?: null],
                    ['name' => 'Riwayat', 'route' => 'staff.history', 'active' => 'staff.history', 'icon' => 'history'],
                ],
            ],
            [
                'label' => 'Akun',
                'items' => [
                    ['name' => 'Profil Saya', 'route' => 'staff.profile', 'active' => 'staff.profile', 'icon' => 'user-round'],
                ],
            ],
        ],
        'customer' => [
            [
                'label' => 'Utama',
                'items' => [
                    ['name' => 'Dashboard', 'route' => 'customer.dashboard', 'active' => 'customer.dashboard', 'icon' => 'layout-dashboard'],
                    ['name' => 'Hewan Saya', 'route' => 'customer.pets', 'active' => 'customer.pets', 'icon' => 'paw-print'],
                ],
            ],
            [
                'label' => 'Layanan & Booking',
                'items' => [
                    ['name' => 'Layanan', 'route' => 'customer.services', 'active' => 'customer.services*', 'icon' => 'scissors'],
                    ['name' => 'Booking Baru', 'route' => 'customer.booking', 'active' => 'customer.booking*', 'icon' => 'plus'],
                    ['name' => 'Booking Saya', 'route' => 'customer.bookings', 'active' => 'customer.bookings', 'icon' => 'calendar-check'],
                ],
            ],
            [
                'label' => 'Aktivitas',
                'items' => [
                    ['name' => 'Pembayaran', 'route' => 'customer.payments', 'active' => 'customer.payments', 'icon' => 'credit-card'],
                    ['name' => 'Ulasan Saya', 'route' => 'customer.reviews', 'active' => 'customer.reviews', 'icon' => 'star'],
                ],
            ],
            [
                'label' => 'Akun',
                'items' => [
                    ['name' => 'Profil Saya', 'route' => 'customer.profile', 'active' => 'customer.profile', 'icon' => 'user-round'],
                ],
            ],
        ],
    ];

    $groups = $navGroups[$role] ?? $navGroups['admin'];
@endphp

<aside id="appSidebar" class="sidebar" aria-label="Navigasi dashboard">
    <div class="sidebar-brand">
        <x-logo dark :href="route($current['dashboard'])" />
    </div>

    <div class="sidebar-role">
        <i data-lucide="shield-check" class="h-3.5 w-3.5"></i>
        {{ $current['label'] }}
    </div>

    <nav class="sidebar-nav">
        @foreach ($groups as $group)
            <div>
                <p class="sidebar-section-label">{{ $group['label'] }}</p>
                <div class="space-y-1">
                    @foreach ($group['items'] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="sidebar-link {{ request()->routeIs($item['active']) ? 'is-active' : '' }}">
                            <i data-lucide="{{ $item['icon'] }}"></i>
                            <span>{{ $item['name'] }}</span>
                            @if (! empty($item['badge']))
                                <span class="sidebar-badge">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <x-avatar :initials="$current['initials']" :name="$current['name']" :color="$current['color']" size="sm" ring />
            <div class="min-w-0 flex-1">
                <p class="truncate text-[11px] font-extrabold text-white">{{ $current['name'] }}</p>
                <p class="truncate text-[9px] font-semibold text-emerald-50/55">{{ $current['role'] }}</p>
            </div>
            <a href="{{ route('home') }}" class="grid h-8 w-8 place-items-center rounded-lg text-emerald-50/55 transition hover:bg-white/10 hover:text-white"
               title="Kembali ke situs" aria-label="Kembali ke situs">
                <i data-lucide="log-out" class="h-3.5 w-3.5"></i>
            </a>
        </div>
    </div>
</aside>

<div id="sidebarOverlay" class="sidebar-overlay" aria-hidden="true"></div>
