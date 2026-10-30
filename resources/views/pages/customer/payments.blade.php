@extends('layouts.dashboard')

@section('title', 'Pembayaran Saya')

@section('content')
    @php
        $paidTotal = collect($myPayments)->where('status', 'dibayar')->sum('amount');
        $unpaidTotal = collect($myPayments)->whereIn('status', ['belum', 'verifikasi'])->sum('amount');
        $paidCount = collect($myPayments)->where('status', 'dibayar')->count();
        $pendingCount = collect($myPayments)->whereIn('status', ['belum', 'verifikasi'])->count();
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Pembayaran</h2>
            <p class="page-copy">Kelola tagihan, unggah bukti bayar, dan lihat riwayat transaksi.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.bookings') }}" class="btn btn-secondary btn-sm"><i data-lucide="calendar-check" class="h-3.5 w-3.5"></i> Booking Saya</a>
            <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm"><i data-lucide="plus" class="h-3.5 w-3.5"></i> Booking Baru</a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Dibayar" :value="'Rp '.number_format($paidTotal, 0, ',', '.')" trend="Lunas" :caption="$paidCount.' transaksi'" icon="circle-check" accent="mint" />
        <x-stat-card label="Perlu Dibayar" :value="'Rp '.number_format($unpaidTotal, 0, ',', '.')" :trend="$pendingCount.' tagihan'" caption="termasuk verifikasi" icon="clock-3" accent="amber" />
        <x-stat-card label="Total Transaksi" :value="(string) count($myPayments)" trend="Sejak 2025" caption="bersama PetCare" icon="receipt-text" accent="sky" />
        <x-stat-card label="Poin dari Transaksi" value="1.250" trend="+120" caption="dari pembayaran terakhir" icon="sparkles" accent="violet" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="6">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Riwayat Pembayaran</p>
                <p class="panel-subtitle">Semua invoice untuk booking Milo dan Luna.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari invoice atau layanan..." data-table-search aria-label="Cari pembayaran">
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
            <table class="data-table" id="myPaymentsTable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Booking</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myPayments as $payment)
                        <tr data-row data-payment="{{ $payment['status'] }}"
                            data-search="{{ strtolower($payment['invoice'].' '.$payment['booking'].' '.$payment['method']) }}">
                            <td data-label="Invoice"><span class="cell-main">{{ $payment['invoice'] }}</span></td>
                            <td data-label="Booking"><span class="font-extrabold text-primary-700">{{ $payment['booking'] }}</span></td>
                            <td data-label="Jumlah"><span class="font-extrabold text-ink">Rp {{ number_format($payment['amount'], 0, ',', '.') }}</span></td>
                            <td data-label="Metode">
                                <p class="cell-main">{{ $payment['method'] }}</p>
                                <p class="cell-sub">{{ $payment['proof'] }}</p>
                            </td>
                            <td data-label="Tanggal"><span class="font-semibold text-slate-500">{{ $payment['date'] }}</span></td>
                            <td data-label="Status"><x-status-badge :status="$payment['status']" type="payment" /></td>
                            <td data-label="">
                                @if ($payment['status'] === 'belum')
                                    <button type="button" class="btn btn-primary btn-sm"
                                            data-edit-record data-edit-modal="paymentModal" data-edit-title="Unggah Bukti Pembayaran"
                                            data-invoice="{{ $payment['invoice'] }}" data-total="{{ number_format($payment['amount'], 0, ',', '.') }}">
                                        <i data-lucide="upload" class="h-3.5 w-3.5"></i> Unggah Bukti
                                    </button>
                                @elseif ($payment['status'] === 'verifikasi')
                                    <span class="text-[10px] font-bold text-sky-600">Sedang ditinjau</span>
                                @elseif ($payment['status'] === 'dibayar')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600"><i data-lucide="badge-check" class="h-3.5 w-3.5"></i> Lunas</span>
                                @else
                                    <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="text-[10px] font-bold text-rose-600">Hubungi Admin</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-bar">
            <p data-table-info>Menampilkan pembayaran Anda</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <div class="content-grid-2 mt-4">
        <div class="panel panel-pad">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-mint h-10 w-10 shrink-0"><i data-lucide="building-2" class="h-4.5 w-4.5"></i></span>
                <div class="min-w-0 flex-1">
                    <p class="panel-title">Transfer Bank BCA</p>
                    <p class="panel-subtitle">a.n. PetCare Indonesia</p>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <span class="rounded-lg bg-slate-50 px-3 py-2 text-sm font-extrabold tracking-[0.08em] text-ink">8820 1145 9901</span>
                        <button type="button" class="btn-icon h-8 w-8" data-copy="882011459901" aria-label="Salin nomor rekening">
                            <i data-lucide="copy" class="h-3.5 w-3.5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-pad">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-sky h-10 w-10 shrink-0"><i data-lucide="qr-code" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">QRIS atau Tunai</p>
                    <p class="panel-subtitle">Scan QRIS di kasir atau bayar tunai saat datang. Bukti bayar dapat diunggah agar status invoice diperbarui.</p>
                </div>
            </div>
            <div class="mt-2 flex items-center gap-2 rounded-lg bg-sky-50/70 px-3 py-2">
                <i data-lucide="circle-help" class="h-3.5 w-3.5 text-sky-600"></i>
                <p class="text-[9px] font-semibold text-sky-800/75">Cantumkan kode invoice pada berita transfer.</p>
            </div>
        </div>
    </div>

    <x-modal id="paymentModal" title="Unggah Bukti Pembayaran" subtitle="Pastikan nominal dan kode invoice sesuai sebelum mengirim." title-attribute>
        <form class="space-y-3" data-demo-form data-success-message="Bukti pembayaran berhasil diunggah (mode demo).">
            <div class="rounded-xl border border-primary-100 bg-primary-50/65 p-3.5">
                <p class="text-[9px] font-extrabold uppercase tracking-wider text-primary-600/70">Transfer ke</p>
                <p class="mt-1 text-sm font-extrabold text-primary-900">BCA · 8820 1145 9901</p>
                <p class="text-[9px] font-semibold text-primary-800/65">a.n. PetCare Indonesia</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="paymentInvoice">Kode invoice</label>
                    <input id="paymentInvoice" name="invoice" type="text" class="input" readonly placeholder="INV-xxxx">
                </div>
                <div>
                    <label class="label" for="paymentTotal">Nominal</label>
                    <div class="input-icon-wrap">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-extrabold text-slate-400">Rp</span>
                        <input id="paymentTotal" name="total" type="text" class="input pl-8" readonly placeholder="0">
                    </div>
                </div>
            </div>
            <label class="upload-zone cursor-pointer">
                <input type="file" class="sr-only" accept="image/*,.pdf" data-file-name="#paymentProofName">
                <span class="mx-auto grid h-10 w-10 place-items-center rounded-xl bg-primary-50 text-primary-600"><i data-lucide="upload" class="h-5 w-5"></i></span>
                <p class="mt-2 text-[11px] font-extrabold text-ink">Pilih foto bukti transfer</p>
                <p id="paymentProofName" class="mt-1 text-[9px] font-semibold text-slate-400">JPG, PNG, atau PDF · maksimal 2 MB</p>
            </label>
            <div>
                <label class="label" for="paymentNote">Catatan (opsional)</label>
                <textarea id="paymentNote" name="note" class="textarea min-h-16" placeholder="Contoh: transfer dari rekening suami"></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Kirim Bukti</button>
            </div>
        </form>
    </x-modal>
@endsection
