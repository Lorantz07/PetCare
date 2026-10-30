@extends('layouts.dashboard')

@section('title', 'Detail Booking '.$booking['code'])

@section('content')
    @php
        $rankMap = ['menunggu' => 0, 'dikonfirmasi' => 1, 'dikerjakan' => 2, 'selesai' => 3, 'dibatalkan' => -1];
        $rank = $rankMap[$booking['status']] ?? 0;
        $invoice = str_replace('BK-', 'INV-', $booking['code']);
        $timeline = [
            ['step' => 0, 'title' => 'Booking dibuat', 'copy' => 'Pesanan diterima oleh sistem PetCare.', 'time' => 'Hari ini · 08.00'],
            ['step' => 1, 'title' => 'Dikonfirmasi', 'copy' => 'Jadwal dan karyawan telah ditetapkan.', 'time' => 'Hari ini · 08.10'],
            ['step' => 2, 'title' => 'Perawatan dimulai', 'copy' => 'Hewan mulai ditangani oleh tim PetCare.', 'time' => $booking['time'].' WIB'],
            ['step' => 3, 'title' => 'Selesai', 'copy' => 'Perawatan selesai dan hewan siap dijemput.', 'time' => 'Setelah perawatan'],
        ];
    @endphp

    <div class="page-head">
        <div>
            <a href="{{ route('admin.bookings') }}" class="mb-2 inline-flex items-center gap-1.5 text-[10px] font-extrabold text-slate-400 transition hover:text-primary-700">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                Kembali ke booking
            </a>
            <h2 class="page-title">Detail Booking</h2>
            <p class="page-copy">{{ $booking['code'] }} · dibuat untuk {{ $booking['customer'] }}.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-print>
                <i data-lucide="printer" class="h-3.5 w-3.5"></i>
                Cetak
            </button>
            <a href="{{ route('admin.bookings') }}" class="btn btn-secondary btn-sm">
                <i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>
                Semua Booking
            </a>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-[1.5fr_0.9fr]">
        <div class="space-y-4">
            <div class="panel panel-pad">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-center gap-3">
                        <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="lg" ring />
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Booking untuk</p>
                            <h3 class="mt-0.5 text-xl font-extrabold tracking-tight text-ink">{{ $booking['pet'] }}</h3>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">{{ $booking['service'] }} · {{ $booking['customer'] }}</p>
                        </div>
                    </div>
                    <x-status-badge :status="$booking['status']" data-booking-status class="self-start" />
                </div>

                <div class="mt-5 grid gap-2.5 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-white/55 p-3.5">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i data-lucide="calendar-days" class="h-3.5 w-3.5"></i>
                            <p class="text-[9px] font-extrabold uppercase tracking-wider">Jadwal</p>
                        </div>
                        <p class="mt-1.5 text-sm font-extrabold text-ink">{{ $booking['date'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">{{ $booking['time'] }} WIB · {{ $booking['service'] }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white/55 p-3.5">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i data-lucide="user-cog" class="h-3.5 w-3.5"></i>
                            <p class="text-[9px] font-extrabold uppercase tracking-wider">Karyawan</p>
                        </div>
                        <p class="mt-1.5 text-sm font-extrabold text-ink">{{ $booking['employee'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">Petugas yang bertanggung jawab</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white/55 p-3.5">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i data-lucide="wallet" class="h-3.5 w-3.5"></i>
                            <p class="text-[9px] font-extrabold uppercase tracking-wider">Total</p>
                        </div>
                        <p class="mt-1.5 text-sm font-extrabold text-ink">Rp {{ number_format($booking['price'], 0, ',', '.') }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">{{ $booking['method'] }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white/55 p-3.5">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i data-lucide="receipt-text" class="h-3.5 w-3.5"></i>
                            <p class="text-[9px] font-extrabold uppercase tracking-wider">Invoice</p>
                        </div>
                        <p class="mt-1.5 text-sm font-extrabold text-ink">{{ $invoice }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">{{ $booking['code'] }}</p>
                    </div>
                </div>
            </div>

            <div class="content-grid-2 mt-0">
                <div class="panel panel-pad">
                    <div class="panel-header">
                        <div>
                            <p class="panel-title">Informasi Pelanggan</p>
                            <p class="panel-subtitle">Kontak yang bisa dihubungi.</p>
                        </div>
                        <x-avatar :initials="$booking['initials']" :name="$booking['customer']" size="md" />
                    </div>
                    <div class="mt-4 space-y-2.5 text-[11px]">
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="user-round" class="h-3.5 w-3.5 text-primary-600"></i>
                            <span class="font-bold text-ink">{{ $booking['customer'] }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="h-3.5 w-3.5 text-primary-600"></i>
                            <span class="font-semibold text-slate-500">0812-3456-7801</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="mail" class="h-3.5 w-3.5 text-primary-600"></i>
                            <span class="font-semibold text-slate-500">rina.pratama@email.com</span>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="https://wa.me/6281234567801" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm flex-1">
                            <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> WhatsApp
                        </a>
                        <a href="tel:+6281234567801" class="btn btn-secondary btn-sm flex-1">
                            <i data-lucide="phone" class="h-3.5 w-3.5 text-primary-600"></i> Telepon
                        </a>
                    </div>
                </div>

                <div class="panel panel-pad">
                    <div class="panel-header">
                        <div>
                            <p class="panel-title">Catatan Perawatan</p>
                            <p class="panel-subtitle">Informasi dari pelanggan.</p>
                        </div>
                        <span class="icon-tile icon-tile-amber h-9 w-9"><i data-lucide="file-text" class="h-4 w-4"></i></span>
                    </div>
                    <p class="mt-3 rounded-xl border border-amber-100 bg-amber-50/65 p-3 text-[11px] font-medium leading-5 text-amber-900/80">{{ $booking['notes'] }}</p>
                    <div class="mt-3 flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2">
                        <i data-lucide="shield-check" class="h-3.5 w-3.5 text-primary-600"></i>
                        <p class="text-[9px] font-semibold text-slate-500">Catatan hanya dapat dilihat oleh tim PetCare.</p>
                    </div>
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Perjalanan Booking</p>
                        <p class="panel-subtitle">Status terbaru dari proses perawatan.</p>
                    </div>
                    <span class="badge badge-slate">{{ $booking['code'] }}</span>
                </div>

                <div class="timeline mt-4">
                    @foreach ($timeline as $item)
                        <div class="timeline-item {{ $rank >= $item['step'] ? 'is-done' : '' }} {{ $rank === $item['step'] ? 'is-current' : '' }}"
                             data-timeline-step="{{ $item['step'] }}">
                            <span class="timeline-dot"></span>
                            <div class="flex flex-col justify-between gap-1 sm:flex-row sm:items-start">
                                <div>
                                    <p class="text-[11px] font-extrabold text-ink">{{ $item['title'] }}</p>
                                    <p class="mt-0.5 text-[10px] font-medium text-slate-500">{{ $item['copy'] }}</p>
                                </div>
                                <span class="shrink-0 text-[9px] font-bold text-slate-400">{{ $item['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <p class="panel-title">Kelola Status</p>
                <p class="panel-subtitle">Perbarui status perawatan booking ini.</p>

                <div class="mt-3 space-y-2">
                    <button type="button" class="btn btn-primary w-full justify-start" data-booking-action="confirm"
                            @disabled($booking['status'] !== 'menunggu')>
                        <i data-lucide="check" class="h-4 w-4"></i> Konfirmasi Booking
                    </button>
                    <button type="button" class="btn btn-secondary w-full justify-start" data-booking-action="start"
                            @disabled($booking['status'] !== 'dikonfirmasi')>
                        <i data-lucide="activity" class="h-4 w-4 text-primary-600"></i> Mulai Perawatan
                    </button>
                    <button type="button" class="btn btn-secondary w-full justify-start" data-booking-action="finish"
                            @disabled($booking['status'] !== 'dikerjakan')>
                        <i data-lucide="circle-check" class="h-4 w-4 text-primary-600"></i> Tandai Selesai
                    </button>
                    <button type="button" class="btn btn-danger w-full justify-start" data-booking-action="cancel"
                            @disabled(in_array($booking['status'], ['selesai', 'dibatalkan']))>
                        <i data-lucide="circle-x" class="h-4 w-4"></i> Batalkan Booking
                    </button>
                </div>
                <p class="mt-2.5 text-[9px] font-semibold leading-4 text-slate-400">Perubahan status pada mode demo hanya mengubah tampilan, belum tersimpan ke database.</p>
            </div>

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Pembayaran</p>
                        <p class="panel-subtitle">Ringkasan tagihan booking.</p>
                    </div>
                    <x-status-badge :status="$booking['payment']" type="payment" />
                </div>

                <div class="receipt mt-4">
                    <div class="receipt-line">
                        <span class="font-semibold text-slate-400">Invoice</span>
                        <span class="font-extrabold text-ink">{{ $invoice }}</span>
                    </div>
                    <div class="receipt-line">
                        <span class="font-semibold text-slate-400">{{ $booking['service'] }}</span>
                        <span class="font-bold text-ink">Rp {{ number_format($booking['price'], 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-line">
                        <span class="font-semibold text-slate-400">Metode</span>
                        <span class="font-bold text-ink">{{ $booking['method'] }}</span>
                    </div>
                    <div class="receipt-line">
                        <span class="font-semibold text-slate-400">Total</span>
                        <span class="text-sm font-extrabold text-primary-700">Rp {{ number_format($booking['price'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('admin.payments') }}" class="btn btn-secondary btn-sm mt-3 w-full">
                    <i data-lucide="credit-card" class="h-3.5 w-3.5"></i>
                    Lihat Semua Pembayaran
                </a>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Butuh bantuan?</p>
                <p class="panel-subtitle">Hubungi pelanggan atau tim terkait.</p>
                <div class="mt-3 space-y-2">
                    <a href="https://wa.me/6281234567801" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm w-full justify-start">
                        <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Chat pelanggan
                    </a>
                    <a href="tel:+6281234567801" class="btn btn-secondary btn-sm w-full justify-start">
                        <i data-lucide="phone" class="h-3.5 w-3.5 text-primary-600"></i> Telepon pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
