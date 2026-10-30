@extends('layouts.dashboard')

@section('title', 'Booking Saya')

@section('content')
    @php
        $activeBookings = collect($myBookings)->whereIn('status', ['menunggu', 'dikonfirmasi', 'dikerjakan'])->values();
        $historyBookings = collect($myBookings)->where('status', 'selesai')->values();
        $cancelledBookings = collect($myBookings)->where('status', 'dibatalkan')->values();
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Booking Saya</h2>
            <p class="page-copy">Semua jadwal dan riwayat perawatan Milo dan Luna.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.payments') }}" class="btn btn-secondary btn-sm"><i data-lucide="credit-card" class="h-3.5 w-3.5"></i> Pembayaran</a>
            <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm"><i data-lucide="plus" class="h-3.5 w-3.5"></i> Booking Baru</a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Booking Aktif" :value="(string) $activeBookings->count()" trend="Terjadwal" caption="menunggu & dikonfirmasi" icon="calendar-check" accent="mint" />
        <x-stat-card label="Selesai" :value="(string) $historyBookings->count()" trend="Bulan ini" caption="perawatan tuntas" icon="circle-check" accent="sky" />
        <x-stat-card label="Total Booking" :value="(string) count($myBookings)" trend="Sejak 2025" caption="bersama PetCare" icon="history" accent="violet" />
        <x-stat-card label="Poin PetCare" value="1.250" trend="+120" caption="dari booking terakhir" icon="sparkles" accent="amber" />
    </div>

    <div class="panel panel-pad mt-4" data-tabs>
        <div class="tab-list w-full sm:w-fit">
            <button type="button" class="tab-btn is-active" data-tab-target="aktif">Aktif <span class="ml-1 rounded-full bg-primary-100 px-1.5 py-0.5 text-[8px] text-primary-700">{{ $activeBookings->count() }}</span></button>
            <button type="button" class="tab-btn" data-tab-target="riwayat">Riwayat <span class="ml-1 rounded-full bg-slate-100 px-1.5 py-0.5 text-[8px] text-slate-500">{{ $historyBookings->count() }}</span></button>
            <button type="button" class="tab-btn" data-tab-target="batal">Dibatalkan <span class="ml-1 rounded-full bg-slate-100 px-1.5 py-0.5 text-[8px] text-slate-500">{{ $cancelledBookings->count() }}</span></button>
        </div>

        <div class="tab-panel is-active mt-4" data-tab-panel="aktif">
            <div class="grid gap-3 lg:grid-cols-2">
                @forelse ($activeBookings as $booking)
                    @include('pages.customer.partials.booking-card', ['booking' => $booking, 'mode' => 'active'])
                @empty
                    <div class="empty-state lg:col-span-2">
                        <span class="icon-tile icon-tile-mint h-12 w-12"><i data-lucide="calendar-check" class="h-5 w-5"></i></span>
                        <p class="mt-3 text-sm font-extrabold text-ink">Belum ada booking aktif</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">Yuk, jadwalkan perawatan untuk si kecil.</p>
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm mt-3">Booking Sekarang</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-panel mt-4" data-tab-panel="riwayat">
            <div class="grid gap-3 lg:grid-cols-2">
                @forelse ($historyBookings as $booking)
                    @include('pages.customer.partials.booking-card', ['booking' => $booking, 'mode' => 'history'])
                @empty
                    <div class="empty-state lg:col-span-2">
                        <span class="icon-tile icon-tile-mint h-12 w-12"><i data-lucide="history" class="h-5 w-5"></i></span>
                        <p class="mt-3 text-sm font-extrabold text-ink">Belum ada riwayat</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">Riwayat perawatan akan muncul di sini setelah selesai.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-panel mt-4" data-tab-panel="batal">
            <div class="grid gap-3 lg:grid-cols-2">
                @forelse ($cancelledBookings as $booking)
                    @include('pages.customer.partials.booking-card', ['booking' => $booking, 'mode' => 'cancelled'])
                @empty
                    <div class="empty-state lg:col-span-2">
                        <span class="icon-tile icon-tile-mint h-12 w-12"><i data-lucide="circle-check" class="h-5 w-5"></i></span>
                        <p class="mt-3 text-sm font-extrabold text-ink">Tidak ada booking yang dibatalkan</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">Semua jadwal berjalan sesuai rencana.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="panel panel-pad mt-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-amber h-10 w-10 shrink-0"><i data-lucide="circle-help" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">Perlu mengubah jadwal?</p>
                    <p class="panel-subtitle">Hubungi kami minimal H-1. Perubahan dapat dilakukan selama slot masih tersedia.</p>
                </div>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm shrink-0">
                <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i>
                Hubungi PetCare
            </a>
        </div>
    </div>
@endsection
