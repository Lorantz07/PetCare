@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    @php
        $todayBookings = collect($bookings)->where('date', $today_short)->values();
        $recentBookings = collect($bookings)->take(6);
        $chartConfig = [
            'type' => 'line',
            'defaultRange' => '7',
            'ranges' => [
                '7' => [
                    'labels' => $chart_7['labels'],
                    'datasets' => [
                        ['label' => 'Booking', 'data' => $chart_7['bookings'], 'variant' => 'primary'],
                    ],
                ],
                '30' => [
                    'labels' => $chart_30['labels'],
                    'datasets' => [
                        ['label' => 'Booking', 'data' => $chart_30['bookings'], 'variant' => 'primary'],
                    ],
                ],
            ],
        ];
        $popularityConfig = [
            'type' => 'doughnut',
            'labels' => array_column($service_popularity, 'label'),
            'data' => array_column($service_popularity, 'value'),
            'colors' => array_column($service_popularity, 'color'),
            'cutout' => '72%',
        ];
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Dashboard</h2>
            <p class="page-copy">Selamat datang kembali. Ini ringkasan PetCare untuk {{ strtolower($today) }}.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.bookings') }}" class="btn btn-secondary btn-sm">
                <i data-lucide="calendar-days" class="h-3.5 w-3.5"></i>
                Kelola Booking
            </a>
            <a href="{{ route('admin.reports') }}" class="btn btn-primary btn-sm">
                <i data-lucide="bar-chart-3" class="h-3.5 w-3.5"></i>
                Lihat Laporan
            </a>
        </div>
    </div>

    <div class="stat-grid">
        @foreach ($admin_stats as $stat)
            <x-stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :trend="$stat['trend']"
                :caption="$stat['caption']"
                :icon="$stat['icon']"
                :accent="$stat['accent']"
                :up="$stat['trend_up']"
            />
        @endforeach
    </div>

    <div class="content-grid">
        <div class="panel panel-pad" data-chart-card>
            <div class="panel-header">
                <div>
                    <p class="panel-title">Tren Booking</p>
                    <p class="panel-subtitle">Jumlah booking masuk berdasarkan periode.</p>
                </div>
                <div class="tab-list">
                    <button type="button" class="tab-btn is-active" data-chart-range="7">7 Hari</button>
                    <button type="button" class="tab-btn" data-chart-range="30">30 Hari</button>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-end gap-4">
                <div>
                    <p class="text-2xl font-extrabold tracking-[-0.04em] text-ink">128</p>
                    <p class="mt-0.5 text-[10px] font-bold text-slate-400">total booking bulan ini</p>
                </div>
                <span class="badge badge-mint"><i data-lucide="trending-up" class="h-3 w-3"></i> +12,5%</span>
                <span class="ml-auto flex items-center gap-1.5 text-[10px] font-bold text-slate-400">
                    <span class="h-2 w-2 rounded-full bg-primary-500"></span> Booking
                </span>
            </div>

            <div class="chart-wrap mt-3">
                <canvas id="adminBookingsChart" data-chart="adminBookingsChart" aria-label="Grafik tren booking" role="img"></canvas>
            </div>
            <script type="application/json" data-chart-config="adminBookingsChart">{!! json_encode($chartConfig) !!}</script>
        </div>

        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Jadwal Hari Ini</p>
                    <p class="panel-subtitle">{{ $todayBookings->count() }} booking terjadwal.</p>
                </div>
                <a href="{{ route('admin.bookings') }}" class="text-[10px] font-extrabold text-primary-700 hover:text-primary-800">Lihat semua</a>
            </div>

            <div class="mt-4 space-y-2.5">
                @forelse ($todayBookings->take(4) as $booking)
                    <a href="{{ route('admin.bookings.show', $booking['code']) }}" class="appointment">
                        <div class="appointment-time">
                            <strong>{{ $booking['time'] }}</strong>
                            <span>WIB</span>
                        </div>
                        <div class="flex min-w-0 flex-1 items-center gap-2.5">
                            <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="sm" />
                            <div class="min-w-0">
                                <p class="truncate text-[11px] font-extrabold text-ink">{{ $booking['pet'] }} · {{ $booking['service'] }}</p>
                                <p class="mt-0.5 truncate text-[9px] font-semibold text-slate-400">{{ $booking['customer'] }} · {{ $booking['employee'] }}</p>
                            </div>
                        </div>
                        <x-status-badge :status="$booking['status']" class="shrink-0" />
                    </a>
                @empty
                    <div class="empty-state">
                        <i data-lucide="calendar-x" class="h-8 w-8 text-slate-300"></i>
                        <p class="mt-2 text-xs font-bold text-slate-500">Tidak ada jadwal hari ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 rounded-xl bg-primary-50/75 p-3.5">
                <div class="flex items-start gap-2.5">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-white text-primary-600">
                        <i data-lucide="sparkles" class="h-4 w-4"></i>
                    </span>
                    <div>
                        <p class="text-[10px] font-extrabold text-primary-900">Tips hari ini</p>
                        <p class="mt-0.5 text-[10px] font-medium leading-4 text-primary-800/70">Konfirmasi booking yang masih menunggu sebelum pukul 12.00 agar jadwal tim tetap rapi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Booking Terbaru</p>
                    <p class="panel-subtitle">Aktivitas booking terakhir di PetCare.</p>
                </div>
                <a href="{{ route('admin.bookings') }}" class="btn btn-secondary btn-sm">Semua booking <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></a>
            </div>

            <div class="data-table-wrap mt-3">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBookings as $booking)
                            <tr data-row>
                                <td data-label="Pelanggan">
                                    <div class="cell-user">
                                        <x-avatar :initials="$booking['initials']" :name="$booking['customer']" size="sm" color="mint" />
                                        <div class="text-left">
                                            <p class="cell-main">{{ $booking['customer'] }}</p>
                                            <p class="cell-sub">{{ $booking['code'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Layanan">
                                    <div>
                                        <p class="cell-main">{{ $booking['service'] }}</p>
                                        <p class="cell-sub">{{ $booking['pet'] }}</p>
                                    </div>
                                </td>
                                <td data-label="Jadwal">
                                    <div>
                                        <p class="cell-main">{{ $booking['date'] }}</p>
                                        <p class="cell-sub">{{ $booking['time'] }} WIB</p>
                                    </div>
                                </td>
                                <td data-label="Status"><x-status-badge :status="$booking['status']" /></td>
                                <td data-label="">
                                    <a href="{{ route('admin.bookings.show', $booking['code']) }}" class="btn-icon h-8 w-8" aria-label="Lihat booking {{ $booking['code'] }}">
                                        <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Layanan Populer</p>
                        <p class="panel-subtitle">Distribusi booking bulan ini.</p>
                    </div>
                    <span class="icon-tile icon-tile-mint h-9 w-9"><i data-lucide="bar-chart-3" class="h-4 w-4"></i></span>
                </div>

                <div class="relative mx-auto mt-3 h-44 w-44">
                    <canvas id="popularityChart" data-chart="popularityChart" aria-label="Grafik layanan populer" role="img"></canvas>
                    <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                        <p class="text-xl font-extrabold tracking-tight text-ink">128</p>
                        <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">booking</p>
                    </div>
                </div>
                <script type="application/json" data-chart-config="popularityChart">{!! json_encode($popularityConfig) !!}</script>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    @foreach ($service_popularity as $item)
                        <div class="flex items-center gap-2 rounded-lg bg-white/55 px-2.5 py-2">
                            <span class="h-2 w-2 shrink-0 rounded-full" style="background: {{ $item['color'] }}"></span>
                            <span class="truncate text-[10px] font-bold text-slate-500">{{ $item['label'] }}</span>
                            <span class="ml-auto text-[10px] font-extrabold text-ink">{{ $item['value'] }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Aksi Cepat</p>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    @php
                        $quickActions = [
                            ['label' => 'Pelanggan', 'route' => 'admin.customers', 'icon' => 'users-round', 'color' => 'mint'],
                            ['label' => 'Layanan', 'route' => 'admin.services', 'icon' => 'scissors', 'color' => 'sky'],
                            ['label' => 'Pembayaran', 'route' => 'admin.payments', 'icon' => 'credit-card', 'color' => 'amber'],
                            ['label' => 'Laporan', 'route' => 'admin.reports', 'icon' => 'file-text', 'color' => 'violet'],
                        ];
                    @endphp
                    @foreach ($quickActions as $action)
                        <a href="{{ route($action['route']) }}" class="flex items-center gap-2 rounded-xl border border-slate-100 bg-white/55 p-2.5 transition hover:border-primary-200 hover:bg-white">
                            <span class="icon-tile icon-tile-{{ $action['color'] }} h-8 w-8 shrink-0"><i data-lucide="{{ $action['icon'] }}" class="h-3.5 w-3.5"></i></span>
                            <span class="text-[10px] font-extrabold text-slate-600">{{ $action['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
