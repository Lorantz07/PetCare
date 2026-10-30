@extends('layouts.dashboard')

@section('title', 'Kelola Hewan Peliharaan')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Hewan Peliharaan</h2>
            <p class="page-copy">Data hewan yang terdaftar, lengkap dengan catatan perawatan penting.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-secondary btn-sm" data-export-csv="#petsTable">
                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                Ekspor CSV
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="petModal" data-modal-reset="true" data-modal-title-text="Tambah Hewan">
                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                Tambah Hewan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Hewan" value="104" trend="+15,4%" caption="terdaftar" icon="paw-print" accent="mint" />
        <x-stat-card label="Anjing" value="68" trend="65,4%" caption="dari total hewan" icon="dog" accent="sky" />
        <x-stat-card label="Kucing" value="36" trend="34,6%" caption="dari total hewan" icon="cat" accent="violet" />
        <x-stat-card label="Perlu Perhatian" value="12" trend="Tindak lanjut" caption="catatan medis" icon="heart-pulse" accent="amber" />
    </div>

    <div class="panel panel-pad mt-4" data-table data-page-size="6">
        <div class="table-toolbar">
            <div>
                <p class="panel-title">Daftar Hewan</p>
                <p class="panel-subtitle">Seluruh hewan beserta pemilik dan kunjungan terakhirnya.</p>
            </div>
            <div class="table-tools">
                <div class="input-icon-wrap table-search">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari nama, ras, atau pemilik..." data-table-search aria-label="Cari hewan">
                </div>
                <select class="select w-full sm:w-36" data-table-filter data-filter-key="species" aria-label="Filter spesies">
                    <option value="">Semua spesies</option>
                    <option value="anjing">Anjing</option>
                    <option value="kucing">Kucing</option>
                </select>
            </div>
        </div>

        <div class="data-table-wrap mt-3">
            <table class="data-table" id="petsTable">
                <thead>
                    <tr>
                        <th>Hewan</th>
                        <th>Spesies</th>
                        <th>Usia & Berat</th>
                        <th>Pemilik</th>
                        <th>Kunjungan Terakhir</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                        <tr data-row data-species="{{ strtolower($pet['species']) }}"
                            data-search="{{ strtolower($pet['name'].' '.$pet['breed'].' '.$pet['owner'].' '.$pet['notes']) }}">
                            <td data-label="Hewan">
                                <div class="cell-user">
                                    <x-avatar :photo="$pet['photo']" :name="$pet['name']" size="sm" />
                                    <div class="text-left">
                                        <p class="cell-main">{{ $pet['name'] }}</p>
                                        <p class="cell-sub">{{ $pet['breed'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Spesies">
                                <span class="badge {{ $pet['species'] === 'Anjing' ? 'badge-sky' : 'badge-violet' }}">{{ $pet['species'] }}</span>
                            </td>
                            <td data-label="Usia & Berat">
                                <p class="cell-main">{{ $pet['age'] }}</p>
                                <p class="cell-sub">{{ $pet['gender'] }} · {{ $pet['weight'] }}</p>
                            </td>
                            <td data-label="Pemilik">
                                <p class="cell-main">{{ $pet['owner'] }}</p>
                                <p class="cell-sub">{{ $pet['owner_email'] }}</p>
                            </td>
                            <td data-label="Kunjungan Terakhir">
                                <p class="cell-main">{{ $pet['last_visit'] }}</p>
                                <p class="cell-sub">Berikutnya {{ $pet['next_visit'] }}</p>
                            </td>
                            <td data-label="Status"><span class="badge badge-mint"><span class="badge-dot"></span>{{ $pet['status'] }}</span></td>
                            <td data-label="">
                                <div class="cell-actions">
                                    <button type="button" class="btn-icon h-8 w-8" aria-label="Edit {{ $pet['name'] }}"
                                            data-edit-record data-edit-modal="petModal" data-edit-title="Edit Hewan"
                                            data-name="{{ $pet['name'] }}" data-species="{{ $pet['species'] }}"
                                            data-breed="{{ $pet['breed'] }}" data-age="{{ $pet['age'] }}"
                                            data-gender="{{ $pet['gender'] }}" data-weight="{{ $pet['weight'] }}"
                                            data-owner="{{ $pet['owner'] }}" data-notes="{{ $pet['notes'] }}"
                                            data-status="{{ strtolower($pet['status']) }}">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                    </button>
                                    <button type="button" class="btn-icon h-8 w-8 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus {{ $pet['name'] }}"
                                            data-delete-trigger data-name="{{ $pet['name'] }}">
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
            <p data-table-info>Menampilkan data hewan</p>
            <div class="pagination" data-table-pagination></div>
        </div>
    </div>

    <x-modal id="petModal" title="Tambah Hewan" subtitle="Simpan profil hewan agar tim PetCare dapat menyesuaikan perawatan." title-attribute>
        <form class="space-y-3" data-demo-form data-success-message="Data hewan berhasil disimpan (mode demo).">
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="petName">Nama hewan</label>
                    <input id="petName" name="name" type="text" class="input" placeholder="Contoh: Milo" required>
                </div>
                <div>
                    <label class="label" for="petOwner">Nama pemilik</label>
                    <input id="petOwner" name="owner" type="text" class="input" placeholder="Contoh: Rina Pratama" required>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="petSpecies">Spesies</label>
                    <select id="petSpecies" name="species" class="select">
                        <option value="Anjing">Anjing</option>
                        <option value="Kucing">Kucing</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="petBreed">Ras</label>
                    <input id="petBreed" name="breed" type="text" class="input" placeholder="Golden Retriever">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="label" for="petAge">Usia</label>
                    <input id="petAge" name="age" type="text" class="input" placeholder="3 tahun">
                </div>
                <div>
                    <label class="label" for="petGender">Gender</label>
                    <select id="petGender" name="gender" class="select">
                        <option value="Jantan">Jantan</option>
                        <option value="Betina">Betina</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="petWeight">Berat</label>
                    <input id="petWeight" name="weight" type="text" class="input" placeholder="28 kg">
                </div>
            </div>
            <div>
                <label class="label" for="petNotes">Catatan perawatan</label>
                <textarea id="petNotes" name="notes" class="textarea min-h-20" placeholder="Alergi, kebiasaan, atau catatan penting lainnya..."></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Hewan</button>
            </div>
        </form>
    </x-modal>
@endsection
