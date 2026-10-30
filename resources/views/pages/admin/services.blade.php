@extends('layouts.dashboard')

@section('title', 'Kelola Layanan')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Layanan</h2>
            <p class="page-copy">Atur katalog layanan, harga, durasi, dan status tampil di halaman publik.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('services.index') }}" class="btn btn-secondary btn-sm" target="_blank" rel="noreferrer">
                <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                Lihat Halaman Publik
            </a>
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="serviceModal" data-modal-reset="true" data-modal-title-text="Tambah Layanan">
                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                Tambah Layanan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Total Layanan" value="6" trend="Aktif" caption="tampil di situs" icon="scissors" accent="mint" />
        <x-stat-card label="Layanan Populer" value="3" trend="46%" caption="booking grooming" icon="star" accent="amber" />
        <x-stat-card label="Kategori" value="3" trend="Terpadu" caption="perawatan & kesehatan" icon="layout-dashboard" accent="sky" />
        <x-stat-card label="Rating Layanan" value="4,9" trend="128 ulasan" caption="rata-rata pelanggan" icon="badge-check" accent="violet" />
    </div>

    <div class="mt-4" data-service-filter-scope>
        <div class="flex flex-col gap-3 rounded-2xl border border-white/90 bg-white/60 p-3 shadow-soft backdrop-blur sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-1.5">
                @foreach (['semua' => 'Semua', 'Perawatan' => 'Perawatan', 'Kesehatan' => 'Kesehatan', 'Penitipan' => 'Penitipan'] as $value => $label)
                    <button type="button" data-service-chip="{{ $value }}" class="tab-btn {{ $loop->first ? 'is-active' : '' }}">{{ $label }}</button>
                @endforeach
            </div>
            <div class="input-icon-wrap w-full sm:w-64">
                <i data-lucide="search"></i>
                <input type="search" class="input" placeholder="Cari layanan..." aria-label="Cari layanan" data-service-search>
            </div>
        </div>

        <div class="service-grid mt-3">
            @foreach ($services as $service)
                <article class="service-card" data-row data-service-item data-category="{{ $service['category'] }}"
                         data-search="{{ strtolower($service['name'].' '.$service['category'].' '.$service['tagline']) }}">
                    <div class="service-photo">
                        <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}" loading="lazy">
                        @if ($service['popular'])
                            <span class="service-badge">Populer</span>
                        @endif
                        <span class="service-icon"><i data-lucide="{{ $service['icon'] }}" class="h-5 w-5"></i></span>
                    </div>
                    <div class="service-body">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-[9px] font-extrabold uppercase tracking-[0.12em] text-primary-600">{{ $service['category'] }}</p>
                                <h3 class="mt-1 text-base font-extrabold tracking-tight text-ink">{{ $service['name'] }}</h3>
                            </div>
                            <span class="badge badge-mint shrink-0"><span class="badge-dot"></span>Aktif</span>
                        </div>
                        <p class="service-desc">{{ $service['tagline'] }}</p>

                        <div class="mt-3 grid grid-cols-2 gap-1.5">
                            <div class="rounded-lg bg-slate-50/90 px-2.5 py-2">
                                <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Harga</p>
                                <p class="mt-0.5 text-[11px] font-extrabold text-ink">Rp {{ number_format($service['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50/90 px-2.5 py-2">
                                <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Durasi</p>
                                <p class="mt-0.5 text-[11px] font-extrabold text-ink">{{ $service['duration'] }}</p>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center gap-1.5 border-t border-slate-100 pt-3">
                            <a href="{{ route('services.show', $service['slug']) }}" target="_blank" rel="noreferrer" class="btn-icon h-8 w-8" aria-label="Lihat {{ $service['name'] }}">
                                <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                            </a>
                            <button type="button" class="btn-icon h-8 w-8" aria-label="Edit {{ $service['name'] }}"
                                    data-edit-record data-edit-modal="serviceModal" data-edit-title="Edit Layanan"
                                    data-name="{{ $service['name'] }}" data-category="{{ $service['category'] }}"
                                    data-price="{{ $service['price'] }}" data-unit="{{ $service['unit'] }}"
                                    data-duration="{{ $service['duration'] }}" data-description="{{ $service['description'] }}"
                                    data-popular="{{ $service['popular'] ? '1' : '0' }}">
                                <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                            </button>
                            <button type="button" class="btn-icon ml-auto h-8 w-8 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus {{ $service['name'] }}"
                                    data-delete-trigger data-name="{{ $service['name'] }}">
                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="empty-state mt-3 hidden" data-service-empty>
            <span class="icon-tile icon-tile-mint h-12 w-12"><i data-lucide="search" class="h-5 w-5"></i></span>
            <p class="mt-3 text-sm font-extrabold text-ink">Layanan tidak ditemukan</p>
            <p class="mt-1 text-xs font-medium text-slate-500">Coba kata kunci atau kategori lain.</p>
        </div>
    </div>

    <x-modal id="serviceModal" title="Tambah Layanan" subtitle="Atur informasi layanan yang akan tampil di situs PetCare." title-attribute size="lg">
        <form class="space-y-3" data-demo-form data-success-message="Data layanan berhasil disimpan (mode demo).">
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="serviceName">Nama layanan</label>
                    <input id="serviceName" name="name" type="text" class="input" placeholder="Contoh: Grooming" required>
                </div>
                <div>
                    <label class="label" for="serviceCategory">Kategori</label>
                    <select id="serviceCategory" name="category" class="select">
                        <option value="Perawatan">Perawatan</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Penitipan">Penitipan</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-1">
                    <label class="label" for="servicePrice">Harga</label>
                    <input id="servicePrice" name="price" type="number" min="0" class="input" placeholder="75000" required>
                </div>
                <div>
                    <label class="label" for="serviceUnit">Satuan</label>
                    <select id="serviceUnit" name="unit" class="select">
                        <option value="sesi">Sesi</option>
                        <option value="malam">Malam</option>
                        <option value="hari">Hari</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="serviceDuration">Durasi</label>
                    <input id="serviceDuration" name="duration" type="text" class="input" placeholder="60 menit">
                </div>
            </div>
            <div>
                <label class="label" for="serviceDescription">Deskripsi singkat</label>
                <textarea id="serviceDescription" name="description" class="textarea min-h-24" placeholder="Jelaskan apa yang termasuk dalam layanan ini..."></textarea>
            </div>
            <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white/60 px-4 py-3">
                <div>
                    <p class="text-[11px] font-extrabold text-ink">Tandai sebagai layanan populer</p>
                    <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Akan mendapat label “Populer” di halaman publik.</p>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="popular">
                </label>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Layanan</button>
            </div>
        </form>
    </x-modal>
@endsection
