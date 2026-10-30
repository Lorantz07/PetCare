@extends('layouts.dashboard')

@section('title', 'Riwayat Perawatan')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Riwayat</h2>
            <p class="page-copy">Perawatan yang telah Anda selesaikan dan catatan performanya.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#historyTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <a href="{{ route('staff.bookings') }}" class="btn btn-primary btn-sm"><i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i> Booking Saya</a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Selesai" value="38" trend="+9,1%" caption="bulan ini" icon="circle-check" accent="mint" />
        <x-stat-card label="Rating Rata-rata" value="4,9" trend="128 ulasan" caption="dari pelanggan" icon="star" accent="amber" />
        <x-stat-card label="Total Perawatan" value="214" trend="Sejak 2024" caption="selama bergabung" icon="award" accent="sky" />
        <x-stat-card label="Penyelesaian" value="96%" trend="+2,4%" caption="tepat waktu" icon="trending-up" accent="violet" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="7">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Riwayat Perawatan</p>
                <p class="panel-subtitle">Perawatan selesai dan dibatalkan.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari hewan atau pelanggan..." data-table-search aria-label="Cari riwayat">
                </div>
                <select class="select w-full sm:w-40" data-table-filter data-filter-key="status" aria-label="Filter status">
                    <option value="">Semua status</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="historyTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Hewan</th>
                        <th>Layanan</th>
                        <th>Pelanggan</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Rating</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $booking)
                        <tr data-row data-status="{{ $booking['status'] }}"
                            data-search="{{ strtolower($booking['code'].' '.$booking['customer'].' '.$booking['pet'].' '.$booking['service']) }}">
                            <td data-label="Tanggal">
                                <p class="cell-main">{{ $booking['date'] }}</p>
                                <p class="cell-sub">{{ $booking['time'] }} WIB</p>
                            </td>
                            <td data-label="Hewan">
                                <div class="cell-user">
                                    <x-avatar :photo="$booking['pet_photo']" :name="$booking['pet']" size="sm" />
                                    <span class="cell-main">{{ $booking['pet'] }}</span>
                                </div>
                            </td>
                            <td data-label="Layanan"><span class="font-semibold text-slate-500">{{ $booking['service'] }}</span></td>
                            <td data-label="Pelanggan"><span class="font-semibold text-slate-500">{{ $booking['customer'] }}</span></td>
                            <td data-label="Nilai"><span class="font-extrabold text-ink">Rp {{ number_format($booking['price'], 0, ',', '.') }}</span></td>
                            <td data-label="Status"><x-status-badge :status="$booking['status']" /></td>
                            <td data-label="Rating">
                                @if ($booking['status'] === 'selesai')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-amber-600">
                                        <i data-lucide="star" class="h-3 w-3 fill-current"></i> {{ $booking['code'] === 'BK-2910-005' ? '4,0' : '5,0' }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-semibold text-slate-300">—</span>
                                @endif
                            </td>
                            <td data-label="">
                                <a href="{{ route('staff.bookings.show', $booking['code']) }}" class="btn-icon h-8 w-8" aria-label="Detail {{ $booking['code'] }}">
                                    <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr data-row>
                            <td colspan="8" class="py-6 text-center text-xs font-semibold text-slate-400">Belum ada riwayat perawatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-bar">
            <p data-table-info>Menampilkan riwayat perawatan</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <div class="content-grid-2 mt-4">
        <div class="panel panel-pad">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-amber h-10 w-10 shrink-0"><i data-lucide="award" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">Pencapaian terbaru</p>
                    <p class="panel-subtitle">Anda menyelesaikan 38 perawatan bulan ini dengan rating 4,9.</p>
                </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-1.5">
                <span class="badge badge-amber"><i data-lucide="star" class="h-3 w-3 fill-current"></i> Top Groomer Oktober</span>
                <span class="badge badge-mint"><i data-lucide="badge-check" class="h-3 w-3"></i> 100% checklist</span>
            </div>
        </div>
        <div class="panel panel-pad">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-sky h-10 w-10 shrink-0"><i data-lucide="message-circle" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">Umpan balik pelanggan</p>
                    <p class="panel-subtitle">“Groomer-nya sabar dan menjelaskan setiap prosesnya.”</p>
                </div>
            </div>
            <p class="mt-3 text-[10px] font-semibold text-slate-400">— Rina Pratama, 28 Okt 2026</p>
        </div>
    </div>
@endsection
