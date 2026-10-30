@extends('layouts.dashboard')

@section('title', 'Kelola Pembayaran')

@section('content')
    @php
        $paid = collect($payments)->where('status', 'dibayar');
        $verify = collect($payments)->where('status', 'verifikasi');
        $unpaid = collect($payments)->where('status', 'belum');
        $rejected = collect($payments)->where('status', 'ditolak');
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Pembayaran</h2>
            <p class="page-copy">Verifikasi bukti bayar dan pantau status transaksi pelanggan.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#paymentsTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <a href="{{ route('admin.reports') }}" class="btn btn-primary btn-sm">
                <i data-lucide="bar-chart-3" class="h-3.5 w-3.5"></i>
                Lihat Laporan
            </a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Pendapatan Bulan Ini" value="Rp 12,45 jt" trend="+18,3%" caption="dibanding bulan lalu" icon="wallet" accent="mint" />
        <x-stat-card label="Menunggu Verifikasi" :value="(string) $verify->count()" trend="Perlu tindakan" caption="bukti pembayaran" icon="clock-3" accent="amber" />
        <x-stat-card label="Sudah Dibayar" :value="(string) $paid->count()" trend="Dari data demo" caption="transaksi terverifikasi" icon="circle-check" accent="sky" />
        <x-stat-card label="Belum Dibayar" :value="(string) $unpaid->count()" trend="Pengingat" caption="menunggu pelanggan" icon="credit-card" accent="violet" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="7">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Riwayat Transaksi</p>
                <p class="panel-subtitle">Seluruh invoice dari booking PetCare.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari invoice atau pelanggan..." data-table-search aria-label="Cari pembayaran">
                </div>
                <select class="select w-full sm:w-40" data-table-filter data-filter-key="payment" aria-label="Filter status pembayaran">
                    <option value="">Semua status</option>
                    <option value="belum">Belum dibayar</option>
                    <option value="verifikasi">Menunggu verifikasi</option>
                    <option value="dibayar">Dibayar</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="paymentsTable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Booking</th>
                        <th>Jumlah</th>
                        <th>Metode & Bukti</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr data-row data-payment="{{ $payment['status'] }}"
                            data-search="{{ strtolower($payment['invoice'].' '.$payment['booking'].' '.$payment['customer'].' '.$payment['method']) }}">
                            <td data-label="Invoice"><span class="cell-main">{{ $payment['invoice'] }}</span></td>
                            <td data-label="Pelanggan">
                                <div class="cell-user">
                                    <x-avatar :initials="$payment['initials']" :name="$payment['customer']" size="sm" />
                                    <span class="cell-main">{{ $payment['customer'] }}</span>
                                </div>
                            </td>
                            <td data-label="Booking">
                                <a href="{{ route('admin.bookings.show', $payment['booking']) }}" class="font-extrabold text-primary-700 hover:text-primary-800">{{ $payment['booking'] }}</a>
                            </td>
                            <td data-label="Jumlah"><span class="font-extrabold text-ink">Rp {{ number_format($payment['amount'], 0, ',', '.') }}</span></td>
                            <td data-label="Metode & Bukti">
                                <p class="cell-main">{{ $payment['method'] }}</p>
                                <p class="cell-sub">{{ $payment['proof'] }}</p>
                            </td>
                            <td data-label="Tanggal"><span class="font-semibold text-slate-500">{{ $payment['date'] }}</span></td>
                            <td data-label="Status">
                                <x-status-badge :status="$payment['status']" type="payment" data-payment-badge />
                            </td>
                            <td data-label="">
                                @if ($payment['status'] === 'verifikasi')
                                    <div class="cell-actions" data-payment-actions>
                                        <button type="button" class="btn-icon h-8 w-8 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600" data-payment-action="verify" aria-label="Verifikasi {{ $payment['invoice'] }}" title="Verifikasi">
                                            <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                        </button>
                                        <button type="button" class="btn-icon h-8 w-8 hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600" data-payment-action="reject" aria-label="Tolak {{ $payment['invoice'] }}" title="Tolak">
                                            <i data-lucide="x" class="h-3.5 w-3.5"></i>
                                        </button>
                                    </div>
                                @elseif ($payment['status'] === 'belum')
                                    <span class="text-[10px] font-bold text-amber-600" data-payment-actions>Menunggu pelanggan</span>
                                @elseif ($payment['status'] === 'dibayar')
                                    <span class="text-[10px] font-bold text-emerald-600" data-payment-actions>Terverifikasi</span>
                                @else
                                    <span class="text-[10px] font-bold text-rose-600" data-payment-actions>Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-bar">
            <p data-table-info>Menampilkan data pembayaran</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <div class="content-grid-2 mt-4">
        <div class="panel panel-pad">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-mint h-10 w-10 shrink-0"><i data-lucide="shield-check" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">Verifikasi dengan teliti</p>
                    <p class="panel-subtitle">Cocokkan nominal, nama pengirim, dan kode invoice sebelum menekan verifikasi.</p>
                </div>
            </div>
            <div class="mt-3 rounded-xl border border-emerald-100 bg-emerald-50/60 p-3">
                <p class="text-[10px] font-semibold leading-5 text-emerald-800/80">Transaksi yang sudah diverifikasi akan otomatis memperbarui status booking terkait pada tahap backend.</p>
            </div>
        </div>
        <div class="panel panel-pad">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-amber h-10 w-10 shrink-0"><i data-lucide="circle-help" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">Butuh bantuan?</p>
                    <p class="panel-subtitle">Jika bukti bayar tidak terbaca, hubungi pelanggan melalui WhatsApp.</p>
                </div>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-3">
                <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i>
                Hubungi Tim Keuangan
            </a>
        </div>
    </div>
@endsection
