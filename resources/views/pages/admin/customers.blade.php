@extends('layouts.dashboard')

@section('title', 'Kelola Pelanggan')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Pelanggan</h2>
            <p class="page-copy">Kelola data pemilik hewan, kontak, dan riwayat kunjungan mereka.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#customersTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="customerModal" data-modal-reset="true" data-modal-title-text="Tambah Pelanggan">
                <i data-lucide="user-plus" class="h-3.5 w-3.5"></i>
                Tambah Pelanggan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Pelanggan" value="86" trend="+8,2%" caption="bulan ini" icon="users-round" accent="mint" />
        <x-stat-card label="Pelanggan Aktif" value="84" trend="97,7%" caption="tingkat aktif" icon="badge-check" accent="sky" />
        <x-stat-card label="Pelanggan Baru" value="12" trend="+4" caption="7 hari terakhir" icon="user-plus" accent="violet" />
        <x-stat-card label="Rata-rata Booking" value="4,2" trend="+0,6" caption="per pelanggan" icon="calendar-check" accent="amber" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="6">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Daftar Pelanggan</p>
                <p class="panel-subtitle">Semua pelanggan yang terdaftar di PetCare.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari nama, email, atau hewan..." data-table-search aria-label="Cari pelanggan">
                </div>
                <select class="select w-full sm:w-36" data-table-filter data-filter-key="status" aria-label="Filter status pelanggan">
                    <option value="">Semua status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="customersTable">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Hewan</th>
                        <th>Booking</th>
                        <th>Total Belanja</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr data-row data-status="{{ strtolower($customer['status']) }}"
                            data-search="{{ strtolower($customer['name'].' '.$customer['email'].' '.$customer['phone'].' '.$customer['address']) }}">
                            <td data-label="Pelanggan">
                                <div class="cell-user">
                                    <x-avatar :initials="$customer['initials']" :name="$customer['name']" :color="$customer['color']" size="sm" />
                                    <div class="text-left">
                                        <p class="cell-main">{{ $customer['name'] }}</p>
                                        <p class="cell-sub">Bergabung {{ $customer['joined'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Kontak">
                                <p class="cell-main">{{ $customer['phone'] }}</p>
                                <p class="cell-sub">{{ $customer['email'] }}</p>
                            </td>
                            <td data-label="Alamat"><span class="font-semibold text-slate-500">{{ $customer['address'] }}</span></td>
                            <td data-label="Hewan">
                                <span class="badge badge-slate">{{ $customer['pets_count'] }} hewan</span>
                            </td>
                            <td data-label="Booking"><span class="font-extrabold text-ink">{{ $customer['bookings'] }}×</span></td>
                            <td data-label="Total Belanja"><span class="font-extrabold text-ink">Rp {{ number_format($customer['spent'], 0, ',', '.') }}</span></td>
                            <td data-label="Status">
                                <span class="badge {{ $customer['status'] === 'Aktif' ? 'badge-mint' : 'badge-slate' }}">
                                    <span class="badge-dot"></span>{{ $customer['status'] }}
                                </span>
                            </td>
                            <td data-label="">
                                <div class="cell-actions">
                                    <button type="button" class="btn-icon h-8 w-8" aria-label="Edit {{ $customer['name'] }}"
                                            data-edit-record data-edit-modal="customerModal" data-edit-title="Edit Pelanggan"
                                            data-name="{{ $customer['name'] }}" data-email="{{ $customer['email'] }}"
                                            data-phone="{{ $customer['phone'] }}" data-address="{{ $customer['address'] }}"
                                            data-status="{{ strtolower($customer['status']) }}">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                    </button>
                                    <button type="button" class="btn-icon h-8 w-8 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus {{ $customer['name'] }}"
                                            data-delete-trigger data-name="{{ $customer['name'] }}">
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
            <p data-table-info>Menampilkan data pelanggan</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <x-modal id="customerModal" title="Tambah Pelanggan" subtitle="Lengkapi informasi pemilik hewan. Data ini akan digunakan untuk kebutuhan perawatan." title-attribute>
        <form class="space-y-3" data-demo-form data-success-message="Data pelanggan berhasil disimpan (mode demo).">
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="customerName">Nama lengkap</label>
                    <input id="customerName" name="name" type="text" class="input" placeholder="Contoh: Rina Pratama" required>
                </div>
                <div>
                    <label class="label" for="customerPhone">Nomor telepon</label>
                    <input id="customerPhone" name="phone" type="tel" class="input" placeholder="0812-xxxx-xxxx" required>
                </div>
            </div>
            <div>
                <label class="label" for="customerEmail">Email</label>
                <input id="customerEmail" name="email" type="email" class="input" placeholder="nama@email.com" required>
            </div>
            <div>
                <label class="label" for="customerAddress">Alamat</label>
                <textarea id="customerAddress" name="address" class="textarea min-h-20" placeholder="Alamat lengkap pelanggan" required></textarea>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="customerStatus">Status</label>
                    <select id="customerStatus" name="status" class="select">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="customerNotes">Catatan</label>
                    <input id="customerNotes" name="notes" type="text" class="input" placeholder="Catatan opsional">
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Pelanggan</button>
            </div>
        </form>
    </x-modal>

@endsection
