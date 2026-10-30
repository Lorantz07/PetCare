@extends('layouts.dashboard')

@section('title', 'Booking Berhasil')

@section('content')
    @php
        $pet = collect($pets)->firstWhere('name', $confirmedBooking['pet']);
    @endphp

    <div class="mx-auto max-w-3xl">
        <div class="panel relative overflow-hidden p-5 text-center sm:p-8">
            <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-primary-100/55 to-transparent" aria-hidden="true"></div>
            <div class="pointer-events-none absolute left-6 top-10 h-2 w-2 rounded-full bg-primary-200" aria-hidden="true"></div>
            <div class="pointer-events-none absolute right-10 top-16 h-3 w-3 rounded-full bg-amber-200" aria-hidden="true"></div>
            <div class="pointer-events-none absolute bottom-24 left-12 h-2.5 w-2.5 rounded-full bg-sky-200" aria-hidden="true"></div>

            <div class="relative z-10">
                <span class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-primary-600 text-white shadow-float ring-8 ring-primary-50">
                    <i data-lucide="check" class="h-8 w-8"></i>
                </span>
                <span class="eyebrow mt-5"><span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span> Booking diterima</span>
                <h2 class="mt-3 text-2xl font-extrabold tracking-[-0.04em] text-ink sm:text-3xl">Yeay, jadwalnya sudah tercatat!</h2>
                <p class="mx-auto mt-2 max-w-md text-[11px] font-medium leading-5 text-slate-500">
                    Terima kasih sudah mempercayakan {{ $confirmedBooking['pet'] }} kepada PetCare. Tim kami akan mengonfirmasi jadwal melalui WhatsApp.
                </p>
                <div class="mt-3 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/70 px-3 py-1.5">
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Kode booking</span>
                    <span class="text-[11px] font-extrabold text-primary-700">{{ $confirmedBooking['code'] }}</span>
                </div>
            </div>

            <div class="relative z-10 mt-6 grid gap-2.5 text-left sm:grid-cols-2">
                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white/65 p-3">
                    <span class="icon-tile icon-tile-mint h-9 w-9 shrink-0"><i data-lucide="scissors" class="h-4 w-4"></i></span>
                    <div class="min-w-0">
                        <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Layanan</p>
                        <p class="mt-0.5 truncate text-[11px] font-extrabold text-ink">{{ $confirmedBooking['service']['name'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white/65 p-3">
                    <span class="icon-tile icon-tile-sky h-9 w-9 shrink-0"><i data-lucide="calendar-check" class="h-4 w-4"></i></span>
                    <div class="min-w-0">
                        <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Jadwal</p>
                        <p class="mt-0.5 truncate text-[11px] font-extrabold text-ink">{{ $confirmedBooking['date'] }}</p>
                        <p class="text-[9px] font-semibold text-slate-400">{{ $confirmedBooking['time'] }} WIB</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white/65 p-3">
                    <x-avatar :photo="$pet['photo'] ?? null" :initials="$pet['initials'] ?? 'P'" :name="$confirmedBooking['pet']" size="sm" />
                    <div class="min-w-0">
                        <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Hewan</p>
                        <p class="mt-0.5 truncate text-[11px] font-extrabold text-ink">{{ $confirmedBooking['pet'] }}</p>
                        <p class="text-[9px] font-semibold text-slate-400">{{ $pet['breed'] ?? 'Hewan peliharaan' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white/65 p-3">
                    <span class="icon-tile icon-tile-amber h-9 w-9 shrink-0"><i data-lucide="wallet" class="h-4 w-4"></i></span>
                    <div class="min-w-0">
                        <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Pembayaran</p>
                        <p class="mt-0.5 truncate text-[11px] font-extrabold text-ink">{{ $confirmedBooking['method'] }}</p>
                        <p class="text-[9px] font-semibold text-slate-400">Rp {{ number_format($confirmedBooking['total'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-5 rounded-2xl border border-primary-100 bg-primary-50/65 p-4 text-left">
                <p class="text-[10px] font-extrabold text-primary-900">Langkah selanjutnya</p>
                <div class="mt-2 space-y-2">
                    <div class="flex items-start gap-2.5">
                        <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full bg-white text-[8px] font-extrabold text-primary-700">1</span>
                        <p class="text-[10px] font-medium leading-4 text-primary-800/75">Tim PetCare mengonfirmasi jadwal dan karyawan melalui WhatsApp.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full bg-white text-[8px] font-extrabold text-primary-700">2</span>
                        <p class="text-[10px] font-medium leading-4 text-primary-800/75">Datang 10 menit sebelum jadwal. Bawa buku vaksin bila ada.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full bg-white text-[8px] font-extrabold text-primary-700">3</span>
                        <p class="text-[10px] font-medium leading-4 text-primary-800/75">Pantau status perawatan dan pembayaran melalui dashboard.</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-5 flex flex-col justify-center gap-2 sm:flex-row">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-primary">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Ke Dashboard
                </a>
                <a href="{{ route('customer.bookings') }}" class="btn btn-secondary">
                    <i data-lucide="calendar-check" class="h-4 w-4 text-primary-600"></i>
                    Lihat Booking Saya
                </a>
                <button type="button" class="btn btn-secondary" data-print>
                    <i data-lucide="printer" class="h-4 w-4 text-primary-600"></i>
                    Cetak
                </button>
            </div>

            <p class="relative z-10 mt-4 text-[9px] font-semibold text-slate-400">Mode demo · booking ini belum tersimpan permanen ke database.</p>
        </div>

        <div class="mt-4 flex flex-col items-start justify-between gap-3 rounded-2xl border border-white/90 bg-white/55 p-4 shadow-soft backdrop-blur sm:flex-row sm:items-center">
            <div class="flex items-center gap-2.5">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-primary-50 text-primary-600"><i data-lucide="map-pin" class="h-4 w-4"></i></span>
                <div>
                    <p class="text-[10px] font-extrabold text-ink">PetCare Kemang</p>
                    <p class="text-[9px] font-semibold text-slate-400">{{ $brand['address'] }}</p>
                </div>
            </div>
            <a href="https://maps.google.com/?q=Jl.+Kemang+Raya+No.+88,+Jakarta+Selatan" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm">
                <i data-lucide="map-pin" class="h-3.5 w-3.5 text-primary-600"></i>
                Buka Maps
            </a>
        </div>
    </div>
@endsection
