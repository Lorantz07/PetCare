@extends('layouts.dashboard')

@section('title', 'Booking Saya')

@section('content')
    @php
        $open = collect($assigned)->whereIn('status', ['menunggu', 'dikonfirmasi', 'dikerjakan']);
        $done = collect($assigned)->where('status', 'selesai');
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Booking Saya</h2>
            <p class="page-copy">Semua perawatan yang ditugaskan kepada Anda, {{ $today_short }}.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#staffBookingsTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <a href="{{ route('staff.schedule') }}" class="btn btn-primary btn-sm"><i data-lucide="calendar-days" class="h-3.5 w-3.5"></i> Lihat Jadwal</a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Booking Aktif" :value="(string) $open->count()" trend="Perlu ditangani" caption="menunggu & berjalan" icon="clipboard-list" accent="mint" />
        <x-stat-card label="Hari Ini" :value="(string) count($todayBookings ?? [])" trend="Terjadwal" caption="30 Okt 2026" icon="calendar-check" accent="sky" />
        <x-stat-card label="Selesai" :value="(string) $done->count()" trend="Bulan ini" caption="dari data demo" icon="circle-check" accent="violet" />
        <x-stat-card label="Rating" value="4,9" trend="128 ulasan" caption="rata-rata pelanggan" icon="star" accent="amber" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="7">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Daftar Booking</p>
                <p class="panel-subtitle">Hanya booking dengan karyawan Nadia Groomer.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari pelanggan atau hewan..." data-table-search aria-label="Cari booking">
                </div>
                <select class="select w-full sm:w-40" data-table-filter data-filter-key="status" aria-label="Filter status booking">
                    <option value="">Semua status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="dikonfirmasi">Dikonfirmasi</option>
                    <option value="dikerjakan">Dikerjakan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="staffBookingsTable">
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Hewan & Pemilik</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assigned as $booking)
                        <tr data-row data-status="{{ $booking['status'] }}"
                            data-search="{{ strtolower($booking['code'].' '.$booking['customer'].' '.$booking['pet'].' '.$booking['service']) }}">
                            <td data-label="Booking">
                                <p class="cell-main">{{ $booking['code'] }}</p>
                                <p class="cell-sub">Rp {{ number_format($booking['price'], 0, ',', '.') }}</p>
                            </td>
                            <td data-label="Hewan & Pemilik">
                                <div class="cell-user">
                                    <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="sm" />
                                    <div class="text-left">
                                        <p class="cell-main">{{ $booking['pet'] }}</p>
                                        <p class="cell-sub">{{ $booking['customer'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Layanan"><span class="font-semibold text-slate-500">{{ $booking['service'] }}</span></td>
                            <td data-label="Jadwal">
                                <p class="cell-main">{{ $booking['date'] }}</p>
                                <p class="cell-sub">{{ $booking['time'] }} WIB</p>
                            </td>
                            <td data-label="Status"><x-status-badge :status="$booking['status']" /></td>
                            <td data-label="Pembayaran"><x-status-badge :status="$booking['payment']" type="payment" /></td>
                            <td data-label="">
                                <a href="{{ route('staff.bookings.show', $booking['code']) }}" class="btn-icon h-8 w-8" aria-label="Detail {{ $booking['code'] }}">
                                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-bar">
            <p data-table-info>Menampilkan data booking</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <div class="panel panel-pad mt-4">
        <div class="flex items-start gap-3">
            <span class="icon-tile icon-tile-amber h-10 w-10 shrink-0"><i data-lucide="circle-help" class="h-4.5 w-4.5"></i></span>
            <div>
                <p class="panel-title">Butuh perubahan jadwal?</p>
                <p class="panel-subtitle">Hubungi admin agar jadwal dan penugasan dapat disesuaikan tanpa bentrok dengan booking lain.</p>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-2">
                    <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
@endsection
