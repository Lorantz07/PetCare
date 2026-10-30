@extends('layouts.dashboard')

@section('title', 'Jadwal Saya')

@section('content')
    @php
        $weekBookings = collect($assigned)->filter(function ($booking) use ($week) {
            return collect($week)->contains(fn ($day) => str_starts_with($booking['date'], $day['date'].' '));
        });
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Jadwal Saya</h2>
            <p class="page-copy">Lihat agenda perawatan Anda untuk tujuh hari ke depan.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-print><i data-lucide="printer" class="h-3.5 w-3.5"></i> Cetak Jadwal</button>
            <a href="{{ route('staff.bookings') }}" class="btn btn-primary btn-sm"><i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i> Booking Saya</a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Hari Ini" :value="(string) count($todayBookings ?? [])" trend="Terjadwal" caption="30 Okt 2026" icon="calendar-check" accent="mint" />
        <x-stat-card label="Minggu Ini" :value="(string) $weekBookings->count()" trend="7 hari" caption="agenda perawatan" icon="calendar-days" accent="sky" />
        <x-stat-card label="Selesai" value="2" trend="100%" caption="dari jadwal hari ini" icon="circle-check" accent="violet" />
        <x-stat-card label="Jam Kerja" value="08–16" trend="Sen–Sab" caption="WIB · Nadia Groomer" icon="clock-3" accent="amber" />
    </div>

    <div class="panel panel-pad mt-4">
        <div class="panel-header">
            <div>
                <p class="panel-title">Minggu Ini</p>
                <p class="panel-subtitle">30 Oktober – 5 November 2026.</p>
            </div>
            <span class="badge badge-mint"><span class="badge-dot"></span>{{ $weekBookings->count() }} booking</span>
        </div>

        <div class="mt-4 grid grid-cols-4 gap-2 sm:grid-cols-7">
            @foreach ($week as $day)
                @php
                    $count = collect($assigned)->filter(fn ($booking) => str_starts_with($booking['date'], $day['date'].' '))->count();
                @endphp
                <div class="rounded-xl border p-2 text-center {{ $day['today'] ? 'border-primary-200 bg-primary-50/80' : 'border-slate-100 bg-white/55' }}">
                    <p class="text-[9px] font-extrabold uppercase tracking-wider {{ $day['today'] ? 'text-primary-700' : 'text-slate-400' }}">{{ $day['label'] }}</p>
                    <p class="mt-1 text-sm font-extrabold {{ $day['today'] ? 'text-primary-700' : 'text-ink' }}">{{ explode(' ', $day['date'])[0] }}</p>
                    <p class="mt-0.5 text-[8px] font-bold {{ $day['today'] ? 'text-primary-500' : 'text-slate-400' }}">{{ $count }} booking</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4 space-y-4">
        @foreach ($week as $day)
            @php
                $dayBookings = collect($assigned)->filter(fn ($booking) => str_starts_with($booking['date'], $day['date'].' '))->sortBy('time');
            @endphp
            <div class="panel panel-pad">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 flex-col items-center justify-center rounded-xl {{ $day['today'] ? 'bg-primary-600 text-white' : 'bg-primary-50 text-primary-700' }}">
                            <span class="text-[8px] font-extrabold uppercase">{{ $day['label'] }}</span>
                            <span class="text-sm font-extrabold">{{ explode(' ', $day['date'])[0] }}</span>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-ink">{{ $day['full'] }}</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-slate-400">{{ $day['today'] ? 'Hari ini' : ($dayBookings->count() ? $dayBookings->count().' jadwal perawatan' : 'Tidak ada jadwal') }}</p>
                        </div>
                    </div>
                    @if ($day['today'])
                        <span class="badge badge-mint"><span class="badge-dot"></span>Hari ini</span>
                    @endif
                </div>

                <div class="mt-3 space-y-2">
                    @forelse ($dayBookings as $booking)
                        <a href="{{ route('staff.bookings.show', $booking['code']) }}" class="flex flex-col gap-2 rounded-xl border border-slate-100 bg-white/55 p-3 transition hover:border-primary-200 hover:bg-white sm:flex-row sm:items-center">
                            <div class="flex items-center gap-2.5 sm:w-36">
                                <span class="rounded-lg bg-primary-50 px-2 py-1 text-[10px] font-extrabold text-primary-700">{{ $booking['time'] }} WIB</span>
                                <span class="text-[9px] font-bold text-slate-400">{{ $booking['code'] }}</span>
                            </div>
                            <div class="flex min-w-0 flex-1 items-center gap-2.5">
                                <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="xs" />
                                <div class="min-w-0">
                                    <p class="truncate text-[10px] font-extrabold text-ink">{{ $booking['pet'] }} · {{ $booking['service'] }}</p>
                                    <p class="mt-0.5 text-[9px] font-semibold text-slate-400">{{ $booking['customer'] }}</p>
                                </div>
                            </div>
                            <x-status-badge :status="$booking['status']" class="shrink-0" />
                        </a>
                    @empty
                        <div class="flex items-center gap-2 rounded-xl border border-dashed border-slate-200 bg-slate-50/50 px-3 py-3">
                            <i data-lucide="clock-3" class="h-4 w-4 text-slate-300"></i>
                            <p class="text-[10px] font-semibold text-slate-400">Tidak ada booking pada tanggal ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
@endsection
