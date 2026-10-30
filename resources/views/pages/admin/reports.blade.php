@extends('layouts.dashboard')

@section('title', 'Laporan PetCare')

@section('content')
    @php
        $revenueTotal = array_sum($report_months['revenue']);
        $bookingsTotal = array_sum($report_months['bookings']);
        $avgRevenue = $bookingsTotal > 0 ? $revenueTotal / $bookingsTotal : 0;
        $revenueChart = [
            'type' => 'bar',
            'labels' => $report_months['labels'],
            'tickSuffix' => ' jt',
            'datasets' => [
                [
                    'type' => 'bar',
                    'label' => 'Pendapatan (juta)',
                    'data' => array_map(fn ($value) => round($value / 1000000, 2), $report_months['revenue']),
                    'variant' => 'primary',
                    'barThickness' => 22,
                ],
            ],
        ];
        $bookingChart = [
            'type' => 'line',
            'labels' => $report_months['labels'],
            'datasets' => [
                ['label' => 'Booking', 'data' => $report_months['bookings'], 'variant' => 'sky'],
            ],
        ];
        $popularityConfig = [
            'type' => 'doughnut',
            'labels' => array_column($service_popularity, 'label'),
            'data' => array_column($service_popularity, 'value'),
            'colors' => array_column($service_popularity, 'color'),
            'cutout' => '72%',
        ];
        $statusColors = ['#F59E0B', '#38BDF8', '#8B5CF6', '#0F9B81', '#F43F5E'];
        $statusConfig = [
            'type' => 'doughnut',
            'labels' => array_column($booking_status_counts, 'label'),
            'data' => array_column($booking_status_counts, 'value'),
            'colors' => $statusColors,
            'cutout' => '72%',
        ];
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Laporan</h2>
            <p class="page-copy">Ringkasan performa PetCare selama enam bulan terakhir.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#reportTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-print>
                <i data-lucide="printer" class="h-3.5 w-3.5"></i>
                Cetak Laporan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Pendapatan" :value="'Rp '.number_format($revenueTotal / 1000000, 2, ',', '.') . ' jt'" trend="+18,0%" caption="6 bulan terakhir" icon="wallet" accent="mint" />
        <x-stat-card label="Total Booking" :value="number_format($bookingsTotal, 0, ',', '.')" trend="+12,5%" caption="dibanding periode lalu" icon="calendar-days" accent="sky" />
        <x-stat-card label="Rata-rata / Booking" :value="'Rp '.number_format($avgRevenue, 0, ',', '.')" trend="+6,2%" caption="nilai transaksi" icon="trending-up" accent="violet" />
        <x-stat-card label="Tingkat Pembatalan" value="1,1%" trend="-0,4%" caption="lebih baik dari bulan lalu" icon="circle-x" accent="amber" :up="false" />
    </div>

    <div class="content-grid-2">
        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Pendapatan Bulanan</p>
                    <p class="panel-subtitle">Dalam juta rupiah, Mei–Okt 2026.</p>
                </div>
                <span class="icon-tile icon-tile-mint h-9 w-9"><i data-lucide="bar-chart-3" class="h-4 w-4"></i></span>
            </div>
            <div class="chart-wrap mt-4">
                <canvas id="revenueChart" data-chart="revenueChart" aria-label="Grafik pendapatan bulanan" role="img"></canvas>
            </div>
            <script type="application/json" data-chart-config="revenueChart">{!! json_encode($revenueChart) !!}</script>
        </div>

        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Volume Booking</p>
                    <p class="panel-subtitle">Jumlah booking per bulan.</p>
                </div>
                <span class="icon-tile icon-tile-sky h-9 w-9"><i data-lucide="calendar-check" class="h-4 w-4"></i></span>
            </div>
            <div class="chart-wrap mt-4">
                <canvas id="bookingChart" data-chart="bookingChart" aria-label="Grafik booking bulanan" role="img"></canvas>
            </div>
            <script type="application/json" data-chart-config="bookingChart">{!! json_encode($bookingChart) !!}</script>
        </div>
    </div>

    <div class="content-grid-3">
        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Layanan Populer</p>
                    <p class="panel-subtitle">Distribusi booking.</p>
                </div>
            </div>
            <div class="relative mx-auto mt-2 h-40 w-40">
                <canvas id="reportPopularityChart" data-chart="reportPopularityChart" aria-label="Grafik layanan populer" role="img"></canvas>
                <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                    <p class="text-lg font-extrabold text-ink">128</p>
                    <p class="text-[8px] font-bold uppercase tracking-wider text-slate-400">booking</p>
                </div>
            </div>
            <script type="application/json" data-chart-config="reportPopularityChart">{!! json_encode($popularityConfig) !!}</script>
            <div class="mt-3 grid grid-cols-2 gap-1.5">
                @foreach ($service_popularity as $item)
                    <div class="flex items-center gap-1.5 rounded-md bg-slate-50 px-2 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full" style="background: {{ $item['color'] }}"></span>
                        <span class="truncate text-[9px] font-bold text-slate-500">{{ $item['label'] }}</span>
                        <span class="ml-auto text-[9px] font-extrabold text-ink">{{ $item['value'] }}%</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Status Booking</p>
                    <p class="panel-subtitle">Kondisi seluruh booking.</p>
                </div>
            </div>
            <div class="relative mx-auto mt-2 h-40 w-40">
                <canvas id="statusChart" data-chart="statusChart" aria-label="Grafik status booking" role="img"></canvas>
                <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                    <p class="text-lg font-extrabold text-ink">{{ array_sum(array_column($booking_status_counts, 'value')) }}</p>
                    <p class="text-[8px] font-bold uppercase tracking-wider text-slate-400">total</p>
                </div>
            </div>
            <script type="application/json" data-chart-config="statusChart">{!! json_encode($statusConfig) !!}</script>
            <div class="mt-3 space-y-1.5">
                @foreach ($booking_status_counts as $index => $item)
                    <div class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full" style="background: {{ $statusColors[$index] }}"></span>
                        <span class="text-[9px] font-bold text-slate-500">{{ $item['label'] }}</span>
                        <span class="ml-auto text-[9px] font-extrabold text-ink">{{ $item['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel panel-pad">
            <p class="panel-title">Insight Singkat</p>
            <p class="panel-subtitle">Hal yang perlu diperhatikan.</p>
            <div class="mt-3 space-y-2">
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-3">
                    <p class="text-[10px] font-extrabold text-emerald-900">Grooming masih juara</p>
                    <p class="mt-0.5 text-[10px] font-medium leading-4 text-emerald-800/70">46% booking berasal dari layanan grooming. Pertimbangkan paket bundling.</p>
                </div>
                <div class="rounded-xl border border-amber-100 bg-amber-50/65 p-3">
                    <p class="text-[10px] font-extrabold text-amber-900">Sabtu paling ramai</p>
                    <p class="mt-0.5 text-[10px] font-medium leading-4 text-amber-800/70">Tambahkan slot sore untuk mengurangi daftar tunggu akhir pekan.</p>
                </div>
                <div class="rounded-xl border border-sky-100 bg-sky-50/65 p-3">
                    <p class="text-[10px] font-extrabold text-sky-900">Pendapatan naik</p>
                    <p class="mt-0.5 text-[10px] font-medium leading-4 text-sky-800/70">Kenaikan 18% dibanding periode sebelumnya. Pertahankan kualitas layanan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-pad mt-4">
        <div class="panel-header">
            <div>
                <p class="panel-title">Ringkasan Bulanan</p>
                <p class="panel-subtitle">Data pendapatan dan booking per bulan.</p>
            </div>
            <span class="badge badge-slate">Mei–Okt 2026</span>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="reportTable">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Booking</th>
                        <th>Pendapatan</th>
                        <th>Rata-rata / Booking</th>
                        <th>Pertumbuhan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report_months['labels'] as $index => $month)
                        @php
                            $monthRevenue = $report_months['revenue'][$index];
                            $monthBookings = $report_months['bookings'][$index];
                            $growth = $index === 0 ? null : (($monthBookings - $report_months['bookings'][$index - 1]) / max($report_months['bookings'][$index - 1], 1)) * 100;
                        @endphp
                        <tr data-row>
                            <td data-label="Bulan"><span class="cell-main">{{ $month }} 2026</span></td>
                            <td data-label="Booking"><span class="font-extrabold text-ink">{{ $monthBookings }}</span></td>
                            <td data-label="Pendapatan"><span class="font-extrabold text-ink">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</span></td>
                            <td data-label="Rata-rata / Booking"><span class="font-semibold text-slate-500">Rp {{ number_format($monthRevenue / max($monthBookings, 1), 0, ',', '.') }}</span></td>
                            <td data-label="Pertumbuhan">
                                @if ($growth === null)
                                    <span class="badge badge-slate">Baseline</span>
                                @elseif ($growth >= 0)
                                    <span class="badge badge-mint"><i data-lucide="trending-up" class="h-3 w-3"></i> +{{ number_format($growth, 1, ',', '.') }}%</span>
                                @else
                                    <span class="badge badge-rose"><i data-lucide="trending-down" class="h-3 w-3"></i> {{ number_format($growth, 1, ',', '.') }}%</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
