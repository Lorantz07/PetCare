@extends('layouts.dashboard')

@section('title', 'Kelola Karyawan')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Karyawan</h2>
            <p class="page-copy">Atur tim dokter hewan, groomer, dan pet care specialist PetCare.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#employeesTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="employeeModal" data-modal-reset="true" data-modal-title-text="Tambah Karyawan">
                <i data-lucide="user-plus" class="h-3.5 w-3.5"></i>
                Tambah Karyawan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Karyawan" value="12" trend="+2" caption="tahun ini" icon="users" accent="mint" />
        <x-stat-card label="Dokter Hewan" value="2" trend="Aktif" caption="siap konsultasi" icon="stethoscope" accent="sky" />
        <x-stat-card label="Groomer" value="6" trend="4,8" caption="rating rata-rata" icon="scissors" accent="violet" />
        <x-stat-card label="Perawatan Selesai" value="830" trend="+9,1%" caption="bulan ini" icon="award" accent="amber" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="6">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Tim PetCare</p>
                <p class="panel-subtitle">Data karyawan aktif dan jadwal kerja mereka.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari nama atau peran..." data-table-search aria-label="Cari karyawan">
                </div>
                <select class="select w-full sm:w-40" data-table-filter data-filter-key="specialty" aria-label="Filter spesialisasi">
                    <option value="">Semua spesialisasi</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="grooming">Grooming</option>
                    <option value="perawatan">Perawatan</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="employeesTable">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Peran</th>
                        <th>Kontak</th>
                        <th>Jadwal</th>
                        <th>Rating</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr data-row data-specialty="{{ strtolower($employee['specialty']) }}"
                            data-search="{{ strtolower($employee['name'].' '.$employee['role'].' '.$employee['specialty'].' '.$employee['email']) }}">
                            <td data-label="Karyawan">
                                <div class="cell-user">
                                    <x-avatar :initials="$employee['initials']" :name="$employee['name']" :color="$employee['color']" size="sm" />
                                    <div class="text-left">
                                        <p class="cell-main">{{ $employee['name'] }}</p>
                                        <p class="cell-sub">ID · EMP-00{{ $employee['id'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Peran">
                                <p class="cell-main">{{ $employee['role'] }}</p>
                                <p class="cell-sub">{{ $employee['specialty'] }}</p>
                            </td>
                            <td data-label="Kontak">
                                <p class="cell-main">{{ $employee['phone'] }}</p>
                                <p class="cell-sub">{{ $employee['email'] }}</p>
                            </td>
                            <td data-label="Jadwal"><span class="font-semibold text-slate-500">{{ $employee['schedule'] }}</span></td>
                            <td data-label="Rating">
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-[10px] font-extrabold text-amber-700">
                                    <i data-lucide="star" class="h-3 w-3 fill-current"></i>{{ number_format($employee['rating'], 1, ',', '.') }}
                                </span>
                            </td>
                            <td data-label="Selesai"><span class="font-extrabold text-ink">{{ $employee['completed'] }}</span></td>
                            <td data-label="Status"><span class="badge badge-mint"><span class="badge-dot"></span>{{ $employee['status'] }}</span></td>
                            <td data-label="">
                                <div class="cell-actions">
                                    <button type="button" class="btn-icon h-8 w-8" aria-label="Edit {{ $employee['name'] }}"
                                            data-edit-record data-edit-modal="employeeModal" data-edit-title="Edit Karyawan"
                                            data-name="{{ $employee['name'] }}" data-email="{{ $employee['email'] }}"
                                            data-phone="{{ $employee['phone'] }}" data-role="{{ $employee['role'] }}"
                                            data-specialty="{{ $employee['specialty'] }}" data-schedule="{{ $employee['schedule'] }}"
                                            data-status="{{ strtolower($employee['status']) }}">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                    </button>
                                    <button type="button" class="btn-icon h-8 w-8 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus {{ $employee['name'] }}"
                                            data-delete-trigger data-name="{{ $employee['name'] }}">
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
            <p data-table-info>Menampilkan data karyawan</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <x-modal id="employeeModal" title="Tambah Karyawan" subtitle="Tambahkan anggota tim baru dan atur peran serta jadwalnya." title-attribute>
        <form class="space-y-3" data-demo-form data-success-message="Data karyawan berhasil disimpan (mode demo).">
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="employeeName">Nama lengkap</label>
                    <input id="employeeName" name="name" type="text" class="input" placeholder="Contoh: Nadia Groomer" required>
                </div>
                <div>
                    <label class="label" for="employeePhone">Nomor telepon</label>
                    <input id="employeePhone" name="phone" type="tel" class="input" placeholder="0812-xxxx-xxxx" required>
                </div>
            </div>
            <div>
                <label class="label" for="employeeEmail">Email</label>
                <input id="employeeEmail" name="email" type="email" class="input" placeholder="nama@petcare.id" required>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="employeeRole">Peran</label>
                    <select id="employeeRole" name="role" class="select">
                        <option value="Dokter Hewan">Dokter Hewan</option>
                        <option value="Senior Groomer">Senior Groomer</option>
                        <option value="Groomer">Groomer</option>
                        <option value="Pet Care Specialist">Pet Care Specialist</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="employeeSpecialty">Spesialisasi</label>
                    <select id="employeeSpecialty" name="specialty" class="select">
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Grooming">Grooming</option>
                        <option value="Perawatan">Perawatan</option>
                    </select>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="employeeSchedule">Jadwal</label>
                    <input id="employeeSchedule" name="schedule" type="text" class="input" placeholder="Sen–Jum · 09.00–17.00">
                </div>
                <div>
                    <label class="label" for="employeeStatus">Status</label>
                    <select id="employeeStatus" name="status" class="select">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Karyawan</button>
            </div>
        </form>
    </x-modal>
@endsection
