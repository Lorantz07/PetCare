@extends('layouts.dashboard')

@section('title', 'Kelola Booking')

@section('content')
    @php
        $todayCount = collect($bookings)->where('date', $today_short)->count();
        $waitingCount = collect($bookings)->where('status', 'menunggu')->count();
        $workingCount = collect($bookings)->where('status', 'dikerjakan')->count();
        $doneCount = collect($bookings)->where('status', 'selesai')->count();
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Booking</h2>
            <p class="page-copy">Pantau jadwal, status perawatan, dan pembayaran seluruh booking.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#bookingsTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="bookingModal" data-modal-reset="true">
                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                Buat Booking
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Booking Hari Ini" :value="(string) $todayCount" trend="Terjadwal" caption="30 Okt 2026" icon="calendar-days" accent="mint" />
        <x-stat-card label="Menunggu Konfirmasi" :value="(string) $waitingCount" trend="Perlu tindakan" caption="segera tinjau" icon="clock-3" accent="amber" />
        <x-stat-card label="Sedang Dikerjakan" :value="(string) $workingCount" trend="Berjalan" caption="di ruang perawatan" icon="activity" accent="sky" />
        <x-stat-card label="Selesai" :value="(string) $doneCount" trend="Bulan ini" caption="128 total booking" icon="circle-check" accent="violet" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="8">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Semua Booking</p>
                <p class="panel-subtitle">Data booking terbaru dari seluruh pelanggan.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari kode, pelanggan, hewan..." data-table-search aria-label="Cari booking">
                </div>
                <select class="select w-full sm:w-36" data-table-filter data-filter-key="status" aria-label="Filter status booking">
                    <option value="">Semua status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="dikonfirmasi">Dikonfirmasi</option>
                    <option value="dikerjakan">Dikerjakan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                <select class="select w-full sm:w-36" data-table-filter data-filter-key="payment" aria-label="Filter pembayaran">
                    <option value="">Semua bayar</option>
                    <option value="belum">Belum bayar</option>
                    <option value="verifikasi">Verifikasi</option>
                    <option value="dibayar">Dibayar</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Karyawan</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr data-row data-status="{{ $booking['status'] }}" data-payment="{{ $booking['payment'] }}"
                            data-search="{{ strtolower($booking['code'].' '.$booking['customer'].' '.$booking['pet'].' '.$booking['service'].' '.$booking['employee']) }}">
                            <td data-label="Booking">
                                <p class="cell-main">{{ $booking['code'] }}</p>
                                <p class="cell-sub">Rp {{ number_format($booking['price'], 0, ',', '.') }}</p>
                            </td>
                            <td data-label="Pelanggan">
                                <div class="cell-user">
                                    <x-avatar :initials="$booking['initials']" :name="$booking['customer']" size="sm" />
                                    <div class="text-left">
                                        <p class="cell-main">{{ $booking['customer'] }}</p>
                                        <p class="cell-sub">{{ $booking['pet'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Layanan"><span class="font-semibold text-slate-500">{{ $booking['service'] }}</span></td>
                            <td data-label="Jadwal">
                                <p class="cell-main">{{ $booking['date'] }}</p>
                                <p class="cell-sub">{{ $booking['time'] }} WIB</p>
                            </td>
                            <td data-label="Karyawan"><span class="font-semibold text-slate-500">{{ $booking['employee'] }}</span></td>
                            <td data-label="Status"><x-status-badge :status="$booking['status']" /></td>
                            <td data-label="Pembayaran"><x-status-badge :status="$booking['payment']" type="payment" /></td>
                            <td data-label="">
                                <div class="cell-actions">
                                    <a href="{{ route('admin.bookings.show', $booking['code']) }}" class="btn-icon h-8 w-8" aria-label="Detail {{ $booking['code'] }}">
                                        <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                    </a>
                                    <button type="button" class="btn-icon h-8 w-8 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus {{ $booking['code'] }}"
                                            data-delete-trigger data-name="{{ $booking['code'] }}">
                                        <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                    </button>
                                </div>
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

    <x-modal id="bookingModal" title="Buat Booking Baru" subtitle="Buat jadwal untuk pelanggan yang datang langsung atau via telepon." size="lg">
        <form class="space-y-3" data-demo-form data-success-message="Booking baru berhasil dibuat (mode demo).">
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="bookingCustomer">Pelanggan</label>
                    <select id="bookingCustomer" name="customer" class="select">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer['name'] }}">{{ $customer['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label" for="bookingPet">Hewan</label>
                    <select id="bookingPet" name="pet" class="select">
                        @foreach ($pets as $pet)
                            <option value="{{ $pet['name'] }}">{{ $pet['name'] }} · {{ $pet['owner'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="bookingService">Layanan</label>
                    <select id="bookingService" name="service" class="select">
                        @foreach ($services as $service)
                            <option value="{{ $service['name'] }}">{{ $service['name'] }} · Rp {{ number_format($service['price'], 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label" for="bookingEmployee">Karyawan</label>
                    <select id="bookingEmployee" name="employee" class="select">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee['name'] }}">{{ $employee['name'] }} · {{ $employee['role'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="label" for="bookingDate">Tanggal</label>
                    <input id="bookingDate" name="date" type="date" class="input" required>
                </div>
                <div>
                    <label class="label" for="bookingTime">Jam</label>
                    <select id="bookingTime" name="time" class="select">
                        @foreach ($time_slots as $slot)
                            <option value="{{ $slot }}">{{ $slot }} WIB</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="label" for="bookingNotes">Catatan</label>
                <textarea id="bookingNotes" name="notes" class="textarea min-h-20" placeholder="Kebutuhan khusus atau catatan untuk tim..."></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="calendar-check" class="h-3.5 w-3.5"></i> Simpan Booking</button>
            </div>
        </form>
    </x-modal>
@endsection
