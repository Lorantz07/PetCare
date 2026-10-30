@extends('layouts.dashboard')

@section('title', 'Profil Karyawan')

@section('content')
    @php
        $employee = $employee ?? [
            'name' => 'Nadia Groomer', 'initials' => 'NG', 'role' => 'Senior Groomer',
            'specialty' => 'Grooming', 'phone' => '0812-7000-2202', 'email' => 'nadia.groomer@petcare.id',
            'schedule' => 'Sen–Sab · 08.00–16.00', 'rating' => 4.9, 'completed' => 214,
        ];
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Profil Saya</h2>
            <p class="page-copy">Kelola informasi pribadi, keamanan akun, dan preferensi kerja Anda.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('staff.schedule') }}" class="btn btn-secondary btn-sm"><i data-lucide="calendar-days" class="h-3.5 w-3.5"></i> Lihat Jadwal</a>
            <a href="{{ route('staff.bookings') }}" class="btn btn-primary btn-sm"><i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i> Booking Saya</a>
        </div>
    </div>

    <div class="panel panel-pad relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-r from-primary-600/12 via-primary-100/30 to-amber-100/30" aria-hidden="true"></div>
        <div class="relative z-10 flex flex-col gap-4 pt-6 sm:flex-row sm:items-end">
            <x-avatar :initials="$employee['initials']" :name="$employee['name']" size="xl" color="violet" ring />
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-xl font-extrabold tracking-tight text-ink sm:text-2xl">{{ $employee['name'] }}</h3>
                    <span class="badge badge-mint"><i data-lucide="badge-check" class="h-3 w-3"></i> Terverifikasi</span>
                </div>
                <p class="mt-1 text-[11px] font-semibold text-slate-500">{{ $employee['role'] }} · {{ $employee['specialty'] }} · Bergabung sejak 2024</p>
                <div class="mt-2 flex flex-wrap items-center gap-3 text-[10px] font-bold text-slate-500">
                    <span class="flex items-center gap-1"><i data-lucide="star" class="h-3.5 w-3.5 fill-current text-amber-400"></i>{{ number_format($employee['rating'], 1, ',', '.') }} rating</span>
                    <span class="flex items-center gap-1"><i data-lucide="circle-check" class="h-3.5 w-3.5 text-primary-500"></i>{{ $employee['completed'] }} perawatan</span>
                    <span class="flex items-center gap-1"><i data-lucide="clock-3" class="h-3.5 w-3.5 text-primary-500"></i>{{ $employee['schedule'] }}</span>
                </div>
            </div>
            <label class="btn btn-secondary btn-sm cursor-pointer self-start sm:self-auto">
                <input type="file" class="sr-only" accept="image/*" data-file-name="#staffPhotoName">
                <i data-lucide="camera" class="h-3.5 w-3.5"></i> Ubah Foto
            </label>
        </div>
        <p id="staffPhotoName" class="relative z-10 mt-2 text-[9px] font-semibold text-slate-400">JPG atau PNG, maksimal 2 MB.</p>
    </div>

    <div class="grid gap-4 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="panel panel-pad mt-0" data-tabs>
            <div class="tab-list w-full sm:w-fit">
                <button type="button" class="tab-btn is-active" data-tab-target="profil">Profil</button>
                <button type="button" class="tab-btn" data-tab-target="keamanan">Keamanan</button>
                <button type="button" class="tab-btn" data-tab-target="preferensi">Preferensi</button>
            </div>

            <div class="tab-panel is-active mt-5" data-tab-panel="profil">
                <form class="space-y-3" data-demo-form data-success-message="Profil Anda berhasil diperbarui (mode demo).">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="staffName">Nama lengkap</label>
                            <input id="staffName" name="name" type="text" class="input" value="{{ $employee['name'] }}" required>
                        </div>
                        <div>
                            <label class="label" for="staffRole">Peran</label>
                            <input id="staffRole" name="role" type="text" class="input" value="{{ $employee['role'] }}" readonly>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="staffEmail">Email</label>
                            <input id="staffEmail" name="email" type="email" class="input" value="{{ $employee['email'] }}" required>
                        </div>
                        <div>
                            <label class="label" for="staffPhone">Telepon</label>
                            <input id="staffPhone" name="phone" type="tel" class="input" value="{{ $employee['phone'] }}" required>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="staffSpecialty">Spesialisasi</label>
                            <select id="staffSpecialty" name="specialty" class="select">
                                <option value="Grooming" @selected($employee['specialty'] === 'Grooming')>Grooming</option>
                                <option value="Kesehatan" @selected($employee['specialty'] === 'Kesehatan')>Kesehatan</option>
                                <option value="Perawatan" @selected($employee['specialty'] === 'Perawatan')>Perawatan</option>
                            </select>
                        </div>
                        <div>
                            <label class="label" for="staffSchedule">Jadwal kerja</label>
                            <input id="staffSchedule" name="schedule" type="text" class="input" value="{{ $employee['schedule'] }}">
                        </div>
                    </div>
                    <div>
                        <label class="label" for="staffBio">Tentang saya</label>
                        <textarea id="staffBio" name="bio" class="textarea min-h-24">Saya senang membuat hewan merasa nyaman selama perawatan. Fokus saya adalah grooming yang lembut, aman, dan sesuai karakter setiap hewan.</textarea>
                    </div>
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white/60 px-4 py-3">
                        <div>
                            <p class="text-[11px] font-extrabold text-ink">Tersedia untuk booking baru</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Nonaktifkan jika sedang cuti atau tidak tersedia.</p>
                        </div>
                        <label class="toggle"><input type="checkbox" name="available" checked></label>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Profil</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel mt-5" data-tab-panel="keamanan">
                <form class="space-y-3" data-demo-form data-success-message="Kata sandi berhasil diperbarui (mode demo).">
                    <div class="rounded-xl border border-sky-100 bg-sky-50/60 p-3">
                        <p class="text-[10px] font-semibold leading-5 text-sky-800/80">Gunakan kata sandi yang kuat dan unik. Jangan bagikan akses akun kepada siapa pun.</p>
                    </div>
                    <div>
                        <label class="label" for="currentPassword">Kata sandi saat ini</label>
                        <input id="currentPassword" name="current_password" type="password" class="input" placeholder="••••••••" required>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="newPassword">Kata sandi baru</label>
                            <input id="newPassword" name="password" type="password" class="input" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div>
                            <label class="label" for="confirmPassword">Konfirmasi kata sandi</label>
                            <input id="confirmPassword" name="password_confirmation" type="password" class="input" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white/60 px-4 py-3">
                        <div>
                            <p class="text-[11px] font-extrabold text-ink">Verifikasi dua langkah</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Tambahkan lapisan keamanan ekstra.</p>
                        </div>
                        <label class="toggle"><input type="checkbox" name="two_factor"></label>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="lock-keyhole" class="h-3.5 w-3.5"></i> Perbarui Keamanan</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel mt-5" data-tab-panel="preferensi">
                <form class="space-y-3" data-demo-form data-success-message="Preferensi berhasil diperbarui (mode demo).">
                    @php
                        $preferences = [
                            ['name' => 'schedule_reminder', 'title' => 'Pengingat jadwal', 'copy' => 'Ingatkan saya 30 menit sebelum booking.', 'checked' => true],
                            ['name' => 'customer_notes', 'title' => 'Catatan pelanggan', 'copy' => 'Tampilkan catatan khusus saat membuka detail tugas.', 'checked' => true],
                            ['name' => 'weekly_summary', 'title' => 'Ringkasan mingguan', 'copy' => 'Kirim rangkuman performa setiap Senin.', 'checked' => false],
                        ];
                    @endphp
                    @foreach ($preferences as $preference)
                        <div class="check-row">
                            <div>
                                <p class="text-[11px] font-extrabold text-ink">{{ $preference['title'] }}</p>
                                <p class="mt-0.5 text-[9px] font-semibold text-slate-400">{{ $preference['copy'] }}</p>
                            </div>
                            <label class="toggle"><input type="checkbox" name="{{ $preference['name'] }}" @checked($preference['checked'])></label>
                        </div>
                    @endforeach
                    <div>
                        <label class="label" for="staffLanguage">Bahasa antarmuka</label>
                        <select id="staffLanguage" name="language" class="select">
                            <option value="id">Bahasa Indonesia</option>
                            <option value="en">English (preview)</option>
                        </select>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Preferensi</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <p class="panel-title">Performa</p>
                <p class="panel-subtitle">Ringkasan penilaian pelanggan.</p>
                <div class="mt-3 flex items-end gap-3">
                    <p class="text-3xl font-extrabold tracking-[-0.04em] text-ink">{{ number_format($employee['rating'], 1, ',', '.') }}</p>
                    <div class="pb-1">
                        <div class="rating-stars">
                            @for ($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="fill-current"></i>
                            @endfor
                        </div>
                        <p class="mt-0.5 text-[9px] font-semibold text-slate-400">128 ulasan</p>
                    </div>
                </div>
                <div class="mt-3 space-y-2">
                    @foreach ([['Kualitas perawatan', 98, 'mint'], ['Ketepatan waktu', 94, 'sky'], ['Komunikasi', 96, 'amber']] as $metric)
                        <div>
                            <div class="flex items-center justify-between text-[9px] font-bold">
                                <span class="text-slate-500">{{ $metric[0] }}</span>
                                <span class="text-ink">{{ $metric[1] }}%</span>
                            </div>
                            <div class="progress-track mt-1"><div class="progress-fill" style="width: {{ $metric[1] }}%"></div></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Jadwal Kerja</p>
                <div class="mt-3 space-y-2 text-[10px]">
                    <div class="flex items-center justify-between"><span class="font-semibold text-slate-400">Senin–Jumat</span><span class="font-extrabold text-ink">08.00–16.00</span></div>
                    <div class="flex items-center justify-between"><span class="font-semibold text-slate-400">Sabtu</span><span class="font-extrabold text-ink">08.00–14.00</span></div>
                    <div class="flex items-center justify-between"><span class="font-semibold text-slate-400">Minggu</span><span class="font-extrabold text-slate-400">Libur</span></div>
                </div>
                <div class="mt-3 rounded-xl bg-primary-50/75 p-3">
                    <p class="text-[9px] font-semibold leading-4 text-primary-800/70">Ingin mengubah jadwal tetap? Ajukan ke admin minimal 7 hari sebelumnya.</p>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Butuh bantuan?</p>
                <p class="panel-subtitle">Tim admin siap membantu operasional Anda.</p>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-3 w-full justify-start">
                    <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
@endsection
