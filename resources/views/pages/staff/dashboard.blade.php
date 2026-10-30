@extends('layouts.dashboard')

@section('title', 'Dashboard Karyawan')

@section('content')
    @php
        $nextBooking = collect($todayBookings)->firstWhere('status', 'dikonfirmasi') ?? collect($todayBookings)->first();
        $upcoming = collect($assigned)->whereIn('status', ['menunggu', 'dikonfirmasi'])->take(4);
        $workloadConfig = [
            'type' => 'bar',
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'datasets' => [
                ['label' => 'Booking', 'data' => [3, 4, 2, 5, 3, 4, 1], 'variant' => 'primary', 'barThickness' => 20],
            ],
        ];
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Dashboard</h2>
            <p class="page-copy">Jadwal dan pekerjaan Anda hari ini, {{ strtolower($today) }}.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('staff.schedule') }}" class="btn btn-secondary btn-sm"><i data-lucide="calendar-days" class="h-3.5 w-3.5"></i> Jadwal Saya</a>
            <a href="{{ route('staff.bookings') }}" class="btn btn-primary btn-sm"><i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i> Booking Saya</a>
        </div>
    </div>

    <div class="stat-grid">
        @foreach ($staff_stats as $stat)
            <x-stat-card :label="$stat['label']" :value="$stat['value']" :trend="$stat['trend']" :caption="$stat['caption']"
                         :icon="$stat['icon']" :accent="$stat['accent']" :up="$stat['trend_up']" />
        @endforeach
    </div>

    <div class="content-grid">
        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Jadwal Hari Ini</p>
                    <p class="panel-subtitle">{{ count($todayBookings) }} hewan akan Anda rawat.</p>
                </div>
                <span class="badge badge-mint"><span class="badge-dot"></span>{{ count($todayBookings) }} terjadwal</span>
            </div>

            <div class="mt-4 space-y-2.5">
                @forelse ($todayBookings as $booking)
                    <a href="{{ route('staff.bookings.show', $booking['code']) }}" class="appointment">
                        <div class="appointment-time">
                            <strong>{{ $booking['time'] }}</strong>
                            <span>WIB</span>
                        </div>
                        <div class="flex min-w-0 flex-1 items-center gap-2.5">
                            <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="sm" />
                            <div class="min-w-0">
                                <p class="truncate text-[11px] font-extrabold text-ink">{{ $booking['pet'] }} · {{ $booking['service'] }}</p>
                                <p class="mt-0.5 truncate text-[9px] font-semibold text-slate-400">{{ $booking['customer'] }} · {{ $booking['code'] }}</p>
                            </div>
                        </div>
                        <x-status-badge :status="$booking['status']" class="shrink-0" />
                    </a>
                @empty
                    <div class="empty-state">
                        <i data-lucide="calendar-check" class="h-8 w-8 text-slate-300"></i>
                        <p class="mt-2 text-xs font-bold text-slate-500">Tidak ada jadwal hari ini.</p>
                    </div>
                @endforelse
            </div>

            @if ($nextBooking)
                <div class="mt-4 flex items-center justify-between gap-3 rounded-xl bg-primary-50/75 p-3.5">
                    <div class="flex items-center gap-2.5">
                        <span class="grid h-9 w-9 place-items-center rounded-lg bg-white text-primary-600"><i data-lucide="clock-3" class="h-4 w-4"></i></span>
                        <div>
                            <p class="text-[10px] font-extrabold text-primary-900">Berikutnya · {{ $nextBooking['time'] }} WIB</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-primary-800/65">{{ $nextBooking['pet'] }} · {{ $nextBooking['service'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route('staff.bookings.show', $nextBooking['code']) }}" class="btn btn-primary btn-sm">Buka</a>
                </div>
            @endif
        </div>

        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Fokus Anda</p>
                    <p class="panel-subtitle">Hal yang perlu disiapkan.</p>
                </div>
            </div>

            <div class="mt-3 space-y-2">
                @php
                    $focusItems = [
                        ['icon' => 'bath', 'title' => 'Siapkan sampo hypoallergenic', 'copy' => 'Milo memiliki kulit sensitif.', 'color' => 'mint'],
                        ['icon' => 'message-circle', 'title' => 'Konfirmasi kedatangan Luna', 'copy' => 'Luna mudah cemas saat perjalanan.', 'color' => 'sky'],
                        ['icon' => 'clock-3', 'title' => 'Cek jeda antar sesi', 'copy' => 'Jeda 15 menit sebelum booking berikutnya.', 'color' => 'amber'],
                    ];
                @endphp
                @foreach ($focusItems as $item)
                    <div class="flex items-start gap-2.5 rounded-xl border border-slate-100 bg-white/55 p-3">
                        <span class="icon-tile icon-tile-{{ $item['color'] }} h-8 w-8 shrink-0"><i data-lucide="{{ $item['icon'] }}" class="h-3.5 w-3.5"></i></span>
                        <div>
                            <p class="text-[10px] font-extrabold text-ink">{{ $item['title'] }}</p>
                            <p class="mt-0.5 text-[9px] font-medium leading-4 text-slate-400">{{ $item['copy'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 rounded-xl border border-amber-100 bg-amber-50/65 p-3">
                <div class="flex items-start gap-2.5">
                    <i data-lucide="sparkles" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"></i>
                    <p class="text-[10px] font-medium leading-4 text-amber-900/75">Pelanggan menghargai update singkat. Kirim kabar setelah sesi selesai.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Beban Kerja Mingguan</p>
                    <p class="panel-subtitle">Jumlah booking yang ditugaskan kepada Anda.</p>
                </div>
                <span class="badge badge-sky">Minggu ini</span>
            </div>
            <div class="chart-wrap mt-4">
                <canvas id="staffWorkloadChart" data-chart="staffWorkloadChart" aria-label="Grafik beban kerja mingguan" role="img"></canvas>
            </div>
            <script type="application/json" data-chart-config="staffWorkloadChart">{!! json_encode($workloadConfig) !!}</script>
        </div>

        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Booking Berikutnya</p>
                    <p class="panel-subtitle">Yang menanti dalam beberapa hari ke depan.</p>
                </div>
                <a href="{{ route('staff.bookings') }}" class="text-[10px] font-extrabold text-primary-700">Lihat semua</a>
            </div>

            <div class="mt-4 space-y-2">
                @foreach ($upcoming as $booking)
                    <a href="{{ route('staff.bookings.show', $booking['code']) }}" class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white/55 p-2.5 transition hover:bg-white">
                        <div class="flex h-10 w-10 shrink-0 flex-col items-center justify-center rounded-lg bg-primary-50 text-center">
                            <span class="text-[9px] font-extrabold uppercase text-primary-600">{{ explode(' ', $booking['date'])[0] }}</span>
                            <span class="text-[8px] font-bold text-primary-500">{{ explode(' ', $booking['date'])[1] }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-[10px] font-extrabold text-ink">{{ $booking['pet'] }} · {{ $booking['service'] }}</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-slate-400">{{ $booking['time'] }} WIB · {{ $booking['customer'] }}</p>
                        </div>
                        <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 text-slate-300"></i>
                    </a>
                @endforeach
            </div>

            <div class="mt-4 rounded-xl bg-slate-50 p-3">
                <div class="flex items-center justify-between gap-2">
                    <p class="text-[10px] font-extrabold text-ink">Performa bulan ini</p>
                    <span class="text-[10px] font-extrabold text-primary-700">92%</span>
                </div>
                <div class="progress-track mt-2"><div class="progress-fill" style="width: 92%"></div></div>
                <p class="mt-1.5 text-[9px] font-semibold text-slate-400">38 dari 41 target perawatan selesai.</p>
            </div>
        </div>
    </div>
@endsection
