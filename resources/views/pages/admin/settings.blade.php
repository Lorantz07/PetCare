@extends('layouts.dashboard')

@section('title', 'Pengaturan PetCare')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Pengaturan</h2>
            <p class="page-copy">Kelola identitas bisnis, jam operasional, dan preferensi notifikasi.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('home') }}" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm">
                <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                Lihat Situs Publik
            </a>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="panel panel-pad" data-tabs>
            <div class="tab-list w-full sm:w-fit">
                <button type="button" class="tab-btn is-active" data-tab-target="bisnis">Profil Bisnis</button>
                <button type="button" class="tab-btn" data-tab-target="jam">Jam Operasional</button>
                <button type="button" class="tab-btn" data-tab-target="notifikasi">Notifikasi</button>
            </div>

            <div class="tab-panel is-active mt-5" data-tab-panel="bisnis">
                <form class="space-y-4" data-demo-form data-success-message="Profil bisnis berhasil diperbarui (mode demo).">
                    <div class="flex flex-col gap-4 rounded-2xl border border-slate-100 bg-white/50 p-4 sm:flex-row sm:items-center">
                        <div class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-primary-600 text-white shadow-float">
                            <i data-lucide="paw-print" class="h-7 w-7"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-[11px] font-extrabold text-ink">Logo PetCare</p>
                            <p class="mt-0.5 text-[10px] font-semibold text-slate-400">Gunakan gambar persegi minimal 256×256 px.</p>
                            <label class="upload-zone mt-2 cursor-pointer py-3">
                                <input type="file" class="sr-only" accept="image/*" data-file-name="#logoFileName">
                                <span class="flex items-center gap-2 text-[10px] font-extrabold text-primary-700"><i data-lucide="upload" class="h-3.5 w-3.5"></i> Unggah logo baru</span>
                                <span id="logoFileName" class="mt-1 text-[9px] font-semibold text-slate-400">Belum ada file dipilih</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="settingsName">Nama bisnis</label>
                            <input id="settingsName" name="name" type="text" class="input" value="{{ $brand['name'] }}" required>
                        </div>
                        <div>
                            <label class="label" for="settingsTagline">Tagline</label>
                            <input id="settingsTagline" name="tagline" type="text" class="input" value="{{ $brand['tagline'] }}">
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="settingsEmail">Email</label>
                            <input id="settingsEmail" name="email" type="email" class="input" value="{{ $brand['email'] }}" required>
                        </div>
                        <div>
                            <label class="label" for="settingsPhone">Telepon</label>
                            <input id="settingsPhone" name="phone" type="tel" class="input" value="{{ $brand['phone'] }}" required>
                        </div>
                    </div>
                    <div>
                        <label class="label" for="settingsAddress">Alamat</label>
                        <textarea id="settingsAddress" name="address" class="textarea min-h-20">{{ $brand['address'] }}</textarea>
                    </div>
                    <div>
                        <label class="label" for="settingsDescription">Tentang bisnis</label>
                        <textarea id="settingsDescription" name="description" class="textarea min-h-24">Ruang hangat untuk hewan kesayangan. Perawatan, kesehatan, dan penitipan dalam satu tempat yang bisa Anda percaya.</textarea>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Profil</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel mt-5" data-tab-panel="jam">
                <form class="space-y-3" data-demo-form data-success-message="Jam operasional berhasil diperbarui (mode demo).">
                    @php
                        $schedule = [
                            ['day' => 'Senin', 'open' => '08.00', 'close' => '20.00', 'active' => true],
                            ['day' => 'Selasa', 'open' => '08.00', 'close' => '20.00', 'active' => true],
                            ['day' => 'Rabu', 'open' => '08.00', 'close' => '20.00', 'active' => true],
                            ['day' => 'Kamis', 'open' => '08.00', 'close' => '20.00', 'active' => true],
                            ['day' => 'Jumat', 'open' => '08.00', 'close' => '20.00', 'active' => true],
                            ['day' => 'Sabtu', 'open' => '08.00', 'close' => '20.00', 'active' => true],
                            ['day' => 'Minggu', 'open' => '09.00', 'close' => '18.00', 'active' => true],
                        ];
                    @endphp

                    <div class="rounded-xl border border-sky-100 bg-sky-50/60 p-3">
                        <p class="text-[10px] font-semibold leading-5 text-sky-800/80">Booking hanya dapat dilakukan pada jam operasional. Slot yang tidak tersedia akan otomatis dinonaktifkan di halaman pelanggan.</p>
                    </div>

                    @foreach ($schedule as $row)
                        <div class="check-row">
                            <div class="flex items-center gap-3">
                                <label class="toggle">
                                    <input type="checkbox" name="day_{{ strtolower($row['day']) }}" @checked($row['active'])>
                                </label>
                                <span class="w-16 text-[11px] font-extrabold text-ink">{{ $row['day'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" name="open_{{ strtolower($row['day']) }}" class="input w-20 px-2 py-1.5 text-center text-[11px]" value="{{ $row['open'] }}" aria-label="Jam buka {{ $row['day'] }}">
                                <span class="text-[10px] font-bold text-slate-400">s/d</span>
                                <input type="text" name="close_{{ strtolower($row['day']) }}" class="input w-20 px-2 py-1.5 text-center text-[11px]" value="{{ $row['close'] }}" aria-label="Jam tutup {{ $row['day'] }}">
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Jam</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel mt-5" data-tab-panel="notifikasi">
                <form class="space-y-3" data-demo-form data-success-message="Preferensi notifikasi berhasil diperbarui (mode demo).">
                    <div>
                        <label class="label" for="notificationEmail">Email penerima notifikasi</label>
                        <input id="notificationEmail" name="notification_email" type="email" class="input" value="admin@petcare.id">
                    </div>

                    @php
                        $notifications = [
                            ['name' => 'booking_baru', 'title' => 'Booking baru', 'copy' => 'Kirim email saat pelanggan membuat booking.', 'checked' => true],
                            ['name' => 'pembayaran', 'title' => 'Pembayaran masuk', 'copy' => 'Beri tahu ketika bukti bayar perlu diverifikasi.', 'checked' => true],
                            ['name' => 'ulasan', 'title' => 'Ulasan pelanggan', 'copy' => 'Dapatkan ringkasan ulasan baru setiap hari.', 'checked' => false],
                            ['name' => 'pengingat', 'title' => 'Pengingat jadwal', 'copy' => 'Ingatkan tim tentang booking yang belum dikonfirmasi.', 'checked' => true],
                        ];
                    @endphp

                    @foreach ($notifications as $notification)
                        <div class="check-row">
                            <div>
                                <p class="text-[11px] font-extrabold text-ink">{{ $notification['title'] }}</p>
                                <p class="mt-0.5 text-[9px] font-semibold leading-4 text-slate-400">{{ $notification['copy'] }}</p>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="{{ $notification['name'] }}" @checked($notification['checked'])>
                            </label>
                        </div>
                    @endforeach

                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Notifikasi</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <div class="flex flex-col items-center text-center">
                    <span class="grid h-16 w-16 place-items-center rounded-2xl bg-primary-600 text-white shadow-float">
                        <i data-lucide="paw-print" class="h-7 w-7"></i>
                    </span>
                    <p class="mt-3 text-base font-extrabold text-ink">PetCare Kemang</p>
                    <p class="mt-0.5 text-[10px] font-semibold text-slate-400">Bergabung sejak Januari 2018</p>
                    <span class="badge badge-mint mt-2"><span class="badge-dot"></span>Akun terverifikasi</span>
                </div>

                <div class="mt-4 space-y-2.5 text-[10px]">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="h-3.5 w-3.5 text-primary-600"></i>
                        <span class="font-semibold text-slate-500">{{ $brand['email'] }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="h-3.5 w-3.5 text-primary-600"></i>
                        <span class="font-semibold text-slate-500">{{ $brand['phone'] }}</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="mt-0.5 h-3.5 w-3.5 text-primary-600"></i>
                        <span class="font-semibold leading-4 text-slate-500">{{ $brand['address'] }}</span>
                    </div>
                </div>

                <div class="mt-4 rounded-xl bg-primary-50/75 p-3">
                    <p class="text-[9px] font-extrabold uppercase tracking-wider text-primary-700">Paket saat ini</p>
                    <p class="mt-1 text-sm font-extrabold text-primary-900">PetCare Complete</p>
                    <p class="mt-0.5 text-[10px] font-medium text-primary-800/70">Semua fitur manajemen aktif.</p>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Mode Pratinjau</p>
                <p class="panel-subtitle">Perubahan pada halaman ini belum tersimpan ke database.</p>
                <div class="mt-3 rounded-xl border border-amber-100 bg-amber-50/65 p-3">
                    <p class="text-[10px] font-semibold leading-5 text-amber-900/80">Data demo digunakan untuk meninjau tampilan. Integrasi penyimpanan akan diaktifkan pada tahap backend.</p>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Pintasan</p>
                <div class="mt-3 space-y-1.5">
                    <a href="{{ route('admin.reports') }}" class="dropdown-item"><i data-lucide="bar-chart-3" class="h-4 w-4"></i> Lihat laporan</a>
                    <a href="{{ route('admin.employees') }}" class="dropdown-item"><i data-lucide="user-cog" class="h-4 w-4"></i> Kelola karyawan</a>
                    <a href="{{ route('home') }}" class="dropdown-item"><i data-lucide="home" class="h-4 w-4"></i> Kembali ke situs</a>
                </div>
            </div>
        </div>
    </div>
@endsection
