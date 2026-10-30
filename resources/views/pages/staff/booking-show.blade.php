@extends('layouts.dashboard')

@section('title', 'Detail Tugas '.$booking['code'])

@section('content')
    @php
        $customer = collect($customers)->firstWhere('name', $booking['customer']);
        $pet = collect($pets)->firstWhere('name', $booking['pet']);
        $rankMap = ['menunggu' => 0, 'dikonfirmasi' => 1, 'dikerjakan' => 2, 'selesai' => 3, 'dibatalkan' => -1];
        $rank = $rankMap[$booking['status']] ?? 0;
        $timeline = [
            ['step' => 0, 'title' => 'Booking dibuat', 'copy' => 'Jadwal diterima dari pelanggan.', 'time' => '08.00'],
            ['step' => 1, 'title' => 'Dikonfirmasi', 'copy' => 'Admin menetapkan Anda sebagai groomer.', 'time' => '08.10'],
            ['step' => 2, 'title' => 'Perawatan dimulai', 'copy' => 'Mulai tangani hewan dengan lembut.', 'time' => $booking['time'].' WIB'],
            ['step' => 3, 'title' => 'Selesai', 'copy' => 'Perawatan selesai dan siap dijemput.', 'time' => 'Setelah sesi'],
        ];
    @endphp

    <div class="page-head">
        <div>
            <a href="{{ route('staff.bookings') }}" class="mb-2 inline-flex items-center gap-1.5 text-[10px] font-extrabold text-slate-400 transition hover:text-primary-700">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Kembali ke booking saya
            </a>
            <h2 class="page-title">Detail Tugas</h2>
            <p class="page-copy">{{ $booking['code'] }} · {{ $booking['date'] }} · {{ $booking['time'] }} WIB.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-print><i data-lucide="printer" class="h-3.5 w-3.5"></i> Cetak</button>
            <a href="{{ route('staff.schedule') }}" class="btn btn-secondary btn-sm"><i data-lucide="calendar-days" class="h-3.5 w-3.5"></i> Jadwal</a>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-[1.5fr_0.9fr]">
        <div class="space-y-4">
            <div class="panel panel-pad">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-center gap-3">
                        <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="lg" ring />
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Tugas perawatan</p>
                            <h3 class="mt-0.5 text-xl font-extrabold tracking-tight text-ink">{{ $booking['pet'] }}</h3>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">{{ $pet['breed'] ?? 'Hewan peliharaan' }} · {{ $pet['age'] ?? '' }} · {{ $pet['weight'] ?? '' }}</p>
                        </div>
                    </div>
                    <x-status-badge :status="$booking['status']" data-booking-status class="self-start" />
                </div>

                <div class="mt-5 grid gap-2.5 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-white/55 p-3.5">
                        <div class="flex items-center gap-2 text-slate-400"><i data-lucide="scissors" class="h-3.5 w-3.5"></i><p class="text-[9px] font-extrabold uppercase tracking-wider">Layanan</p></div>
                        <p class="mt-1.5 text-sm font-extrabold text-ink">{{ $booking['service'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">{{ $booking['date'] }} · {{ $booking['time'] }} WIB</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white/55 p-3.5">
                        <div class="flex items-center gap-2 text-slate-400"><i data-lucide="user-round" class="h-3.5 w-3.5"></i><p class="text-[9px] font-extrabold uppercase tracking-wider">Pemilik</p></div>
                        <p class="mt-1.5 text-sm font-extrabold text-ink">{{ $booking['customer'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">{{ $customer['phone'] ?? '0812-3456-7801' }}</p>
                    </div>
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Catatan dari Pelanggan</p>
                        <p class="panel-subtitle">Perhatikan kebutuhan khusus hewan.</p>
                    </div>
                    <span class="icon-tile icon-tile-amber h-9 w-9"><i data-lucide="file-text" class="h-4 w-4"></i></span>
                </div>
                <p class="mt-3 rounded-xl border border-amber-100 bg-amber-50/65 p-3.5 text-[11px] font-medium leading-5 text-amber-900/80">{{ $booking['notes'] }}</p>
                <div class="mt-3 grid gap-2 sm:grid-cols-2">
                    <div class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2">
                        <i data-lucide="heart" class="h-3.5 w-3.5 text-rose-400"></i>
                        <p class="text-[9px] font-semibold text-slate-500">{{ $pet['notes'] ?? 'Tidak ada catatan tambahan.' }}</p>
                    </div>
                    <div class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2">
                        <i data-lucide="shield-check" class="h-3.5 w-3.5 text-primary-500"></i>
                        <p class="text-[9px] font-semibold text-slate-500">Gunakan penanganan lembut dan aman.</p>
                    </div>
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Progres Perawatan</p>
                        <p class="panel-subtitle">Perbarui status saat Anda memulai dan menyelesaikan sesi.</p>
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

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Checklist Persiapan</p>
                        <p class="panel-subtitle">Pastikan semua siap sebelum memulai.</p>
                    </div>
                </div>
                <div class="mt-3 grid gap-2 sm:grid-cols-2">
                    @foreach (['Sampo sesuai jenis bulu', 'Handuk bersih & kering', 'Alat grooming steril', 'Area perawatan siap'] as $item)
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-slate-100 bg-white/55 px-3 py-2.5">
                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-300" checked>
                            <span class="text-[10px] font-bold text-slate-600">{{ $item }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <p class="panel-title">Perbarui Status</p>
                <p class="panel-subtitle">Tandai progres tugas Anda.</p>
                <div class="mt-3 space-y-2">
                    <button type="button" class="btn btn-primary w-full justify-start" data-booking-action="confirm" @disabled($booking['status'] !== 'menunggu')>
                        <i data-lucide="check" class="h-4 w-4"></i> Konfirmasi Kehadiran
                    </button>
                    <button type="button" class="btn btn-secondary w-full justify-start" data-booking-action="start" @disabled($booking['status'] !== 'dikonfirmasi')>
                        <i data-lucide="activity" class="h-4 w-4 text-primary-600"></i> Mulai Perawatan
                    </button>
                    <button type="button" class="btn btn-secondary w-full justify-start" data-booking-action="finish" @disabled($booking['status'] !== 'dikerjakan')>
                        <i data-lucide="circle-check" class="h-4 w-4 text-primary-600"></i> Tandai Selesai
                    </button>
                    <button type="button" class="btn btn-danger w-full justify-start" data-booking-action="cancel" @disabled(in_array($booking['status'], ['selesai', 'dibatalkan']))>
                        <i data-lucide="circle-x" class="h-4 w-4"></i> Batalkan Tugas
                    </button>
                </div>
                <p class="mt-2.5 text-[9px] font-semibold leading-4 text-slate-400">Perubahan hanya pada tampilan demo. Status sebenarnya akan tersimpan saat backend aktif.</p>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Kontak Pelanggan</p>
                <div class="mt-3 flex items-center gap-2.5">
                    <x-avatar :initials="$booking['initials']" :name="$booking['customer']" size="md" />
                    <div>
                        <p class="text-[11px] font-extrabold text-ink">{{ $booking['customer'] }}</p>
                        <p class="text-[9px] font-semibold text-slate-400">{{ $customer['phone'] ?? '0812-3456-7801' }}</p>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="https://wa.me/6281234567801" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm flex-1"><i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> WhatsApp</a>
                    <a href="tel:+6281234567801" class="btn btn-secondary btn-sm flex-1"><i data-lucide="phone" class="h-3.5 w-3.5 text-primary-600"></i> Telepon</a>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Pembayaran</p>
                <div class="mt-3 flex items-center justify-between gap-2">
                    <span class="text-[10px] font-semibold text-slate-400">Status</span>
                    <x-status-badge :status="$booking['payment']" type="payment" />
                </div>
                <div class="mt-2 flex items-center justify-between gap-2">
                    <span class="text-[10px] font-semibold text-slate-400">Total</span>
                    <span class="text-sm font-extrabold text-primary-700">Rp {{ number_format($booking['price'], 0, ',', '.') }}</span>
                </div>
                <div class="mt-2 flex items-center justify-between gap-2">
                    <span class="text-[10px] font-semibold text-slate-400">Metode</span>
                    <span class="text-[10px] font-bold text-ink">{{ $booking['method'] }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
