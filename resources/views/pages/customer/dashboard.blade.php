@extends('layouts.dashboard')

@section('title', 'Dashboard Pelanggan')

@section('content')
    @php
        $activeBookings = collect($myBookings)->whereIn('status', ['menunggu', 'dikonfirmasi', 'dikerjakan'])->values();
        $historyBookings = collect($myBookings)->whereIn('status', ['selesai', 'dibatalkan'])->values();
        $visitConfig = [
            'type' => 'bar',
            'labels' => ['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
            'datasets' => [
                ['label' => 'Kunjungan', 'data' => [1, 1, 2, 1, 2, 1], 'variant' => 'primary', 'barThickness' => 18],
            ],
        ];
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Dashboard</h2>
            <p class="page-copy">Semoga hari Anda menyenangkan. Ini ringkasan untuk Milo dan Luna.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.bookings') }}" class="btn btn-secondary btn-sm"><i data-lucide="calendar-check" class="h-3.5 w-3.5"></i> Booking Saya</a>
            <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm"><i data-lucide="plus" class="h-3.5 w-3.5"></i> Booking Baru</a>
        </div>
    </div>

    <div class="stat-grid">
        @foreach ($customer_stats as $stat)
            <x-stat-card :label="$stat['label']" :value="$stat['value']" :trend="$stat['trend']" :caption="$stat['caption']"
                         :icon="$stat['icon']" :accent="$stat['accent']" :up="$stat['trend_up']" />
        @endforeach
    </div>

    <div class="content-grid">
        <div class="space-y-4">
            @if ($nextBooking)
                <div class="panel relative overflow-hidden p-5 sm:p-6">
                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-primary-100/50 blur-2xl" aria-hidden="true"></div>
                    <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-2xl bg-primary-600 text-white shadow-float">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-100/80">{{ explode(' ', $nextBooking['date'])[1] }}</span>
                            <span class="text-3xl font-extrabold leading-none">{{ explode(' ', $nextBooking['date'])[0] }}</span>
                            <span class="mt-0.5 text-[8px] font-bold text-emerald-100/70">2026</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="eyebrow py-1 text-[9px]"><span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span> Booking berikutnya</span>
                                <x-status-badge :status="$nextBooking['status']" />
                            </div>
                            <h3 class="mt-2 text-lg font-extrabold tracking-tight text-ink">{{ $nextBooking['service'] }} untuk {{ $nextBooking['pet'] }}</h3>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">{{ $nextBooking['date'] }} · {{ $nextBooking['time'] }} WIB · {{ $nextBooking['employee'] }}</p>
                        </div>
                        <div class="flex shrink-0 gap-2">
                            <a href="{{ route('customer.bookings') }}#{{ $nextBooking['code'] }}" class="btn btn-primary btn-sm">Lihat Booking</a>
                        </div>
                    </div>
                    <div class="relative z-10 mt-4 grid grid-cols-3 gap-2 border-t border-slate-100 pt-3">
                        <div class="text-center">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Hewan</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-ink">{{ $nextBooking['pet'] }}</p>
                        </div>
                        <div class="border-x border-slate-100 text-center">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Lokasi</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-ink">PetCare Kemang</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Estimasi</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-ink">60 menit</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Booking Terbaru</p>
                        <p class="panel-subtitle">Pantau jadwal dan status perawatan.</p>
                    </div>
                    <a href="{{ route('customer.bookings') }}" class="text-[10px] font-extrabold text-primary-700">Lihat semua</a>
                </div>

                <div class="mt-3 space-y-2.5">
                    @foreach (collect($myBookings)->take(3) as $booking)
                        <a href="{{ route('customer.bookings') }}#{{ $booking['code'] }}" class="appointment">
                            <div class="appointment-time">
                                <strong>{{ $booking['time'] }}</strong>
                                <span>{{ explode(' ', $booking['date'])[1] }}</span>
                            </div>
                            <div class="flex min-w-0 flex-1 items-center gap-2.5">
                                <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="sm" />
                                <div class="min-w-0">
                                    <p class="truncate text-[11px] font-extrabold text-ink">{{ $booking['service'] }} · {{ $booking['pet'] }}</p>
                                    <p class="mt-0.5 truncate text-[9px] font-semibold text-slate-400">{{ $booking['date'] }} · {{ $booking['employee'] }}</p>
                                </div>
                            </div>
                            <x-status-badge :status="$booking['status']" class="shrink-0" />
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Kunjungan ke PetCare</p>
                        <p class="panel-subtitle">Enam bulan terakhir.</p>
                    </div>
                    <span class="badge badge-sky">8 total kunjungan</span>
                </div>
                <div class="chart-wrap chart-wrap-sm mt-3">
                    <canvas id="visitChart" data-chart="visitChart" aria-label="Grafik kunjungan" role="img"></canvas>
                </div>
                <script type="application/json" data-chart-config="visitChart">{!! json_encode($visitConfig) !!}</script>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Hewan Saya</p>
                        <p class="panel-subtitle">Profil si kecil.</p>
                    </div>
                    <a href="{{ route('customer.pets') }}" class="text-[10px] font-extrabold text-primary-700">Kelola</a>
                </div>

                <div class="mt-3 space-y-2">
                    @foreach ($myPets as $pet)
                        <a href="{{ route('customer.pets') }}" class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white/55 p-2.5 transition hover:border-primary-200 hover:bg-white">
                            <x-avatar :photo="$pet['photo']" :name="$pet['name']" size="md" />
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-extrabold text-ink">{{ $pet['name'] }}</p>
                                <p class="mt-0.5 truncate text-[9px] font-semibold text-slate-400">{{ $pet['breed'] }} · {{ $pet['age'] }}</p>
                                <p class="mt-0.5 text-[9px] font-bold text-primary-600">Kunjungan {{ $pet['next_visit'] }}</p>
                            </div>
                            <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300"></i>
                        </a>
                    @endforeach
                </div>

                <a href="{{ route('customer.pets') }}" class="btn btn-secondary btn-sm mt-3 w-full"><i data-lucide="plus" class="h-3.5 w-3.5"></i> Tambah Hewan</a>
            </div>

            <div class="panel overflow-hidden">
                <div class="bg-gradient-to-br from-primary-700 to-primary-900 p-5 text-white">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p class="text-[9px] font-extrabold uppercase tracking-[0.14em] text-emerald-100/60">Poin PetCare</p>
                            <p class="mt-1 text-2xl font-extrabold tracking-tight">1.250</p>
                        </div>
                        <span class="grid h-10 w-10 place-items-center rounded-xl border border-white/15 bg-white/10"><i data-lucide="sparkles" class="h-5 w-5 text-amber-300"></i></span>
                    </div>
                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-white/15">
                        <div class="h-full w-[62%] rounded-full bg-gradient-to-r from-emerald-300 to-amber-300"></div>
                    </div>
                    <p class="mt-2 text-[9px] font-semibold text-emerald-50/60">750 poin lagi menuju grooming gratis.</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="font-semibold text-slate-400">Member sejak</span>
                        <span class="font-extrabold text-ink">Januari 2025</span>
                    </div>
                    <div class="mt-1.5 flex items-center justify-between text-[10px]">
                        <span class="font-semibold text-slate-400">Status</span>
                        <span class="badge badge-amber py-0.5"><i data-lucide="star" class="h-2.5 w-2.5 fill-current"></i> Gold Member</span>
                    </div>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Butuh bantuan?</p>
                <p class="panel-subtitle">Tim PetCare siap membantu.</p>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-3 w-full justify-start">
                    <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Chat via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <div class="panel panel-pad mt-4">
        <div class="panel-header">
            <div>
                <p class="panel-title">Layanan untuk Milo & Luna</p>
                <p class="panel-subtitle">Rekomendasi berdasarkan perawatan terakhir.</p>
            </div>
            <a href="{{ route('customer.services') }}" class="btn btn-secondary btn-sm">Semua layanan <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></a>
        </div>

        <div class="mt-3 grid gap-2.5 sm:grid-cols-3">
            @foreach (array_slice($services, 0, 3) as $service)
                <a href="{{ route('customer.services.show', $service['slug']) }}" class="group flex items-center gap-3 rounded-xl border border-slate-100 bg-white/55 p-2.5 transition hover:border-primary-200 hover:bg-white">
                    <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}" class="h-14 w-14 rounded-lg object-cover" loading="lazy">
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-extrabold text-ink">{{ $service['name'] }}</p>
                        <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Rp {{ number_format($service['price'], 0, ',', '.') }} · {{ $service['duration'] }}</p>
                        <p class="mt-1 flex items-center gap-1 text-[9px] font-extrabold text-primary-600">Lihat layanan <i data-lucide="arrow-right" class="h-3 w-3"></i></p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
