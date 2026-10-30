@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    @php
        $customer = $customer ?? [
            'name' => 'Rina Pratama', 'initials' => 'RP', 'email' => 'rina.pratama@email.com',
            'phone' => '0812-3456-7801', 'address' => 'Kemang, Jakarta Selatan',
            'joined' => '12 Jan 2025', 'bookings' => 8, 'spent' => 1250000, 'color' => 'mint',
        ];
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Profil Saya</h2>
            <p class="page-copy">Kelola informasi akun, keamanan, dan preferensi komunikasi Anda.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.pets') }}" class="btn btn-secondary btn-sm"><i data-lucide="paw-print" class="h-3.5 w-3.5"></i> Kelola Hewan</a>
            <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm"><i data-lucide="plus" class="h-3.5 w-3.5"></i> Booking Baru</a>
        </div>
    </div>

    <div class="panel panel-pad relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-r from-primary-600/12 via-primary-100/30 to-amber-100/30" aria-hidden="true"></div>
        <div class="relative z-10 flex flex-col gap-4 pt-6 sm:flex-row sm:items-end">
            <x-avatar :initials="$customer['initials']" :name="$customer['name']" size="xl" color="mint" ring />
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-xl font-extrabold tracking-tight text-ink sm:text-2xl">{{ $customer['name'] }}</h3>
                    <span class="badge badge-amber"><i data-lucide="star" class="h-3 w-3 fill-current"></i> Gold Member</span>
                </div>
                <p class="mt-1 text-[11px] font-semibold text-slate-500">Member sejak {{ $customer['joined'] }} · {{ $customer['email'] }}</p>
                <div class="mt-2 flex flex-wrap items-center gap-3 text-[10px] font-bold text-slate-500">
                    <span class="flex items-center gap-1"><i data-lucide="paw-print" class="h-3.5 w-3.5 text-primary-500"></i>{{ count($myPets) }} hewan</span>
                    <span class="flex items-center gap-1"><i data-lucide="calendar-check" class="h-3.5 w-3.5 text-primary-500"></i>{{ $customer['bookings'] }} booking</span>
                    <span class="flex items-center gap-1"><i data-lucide="sparkles" class="h-3.5 w-3.5 fill-current text-amber-400"></i>1.250 poin</span>
                </div>
            </div>
            <label class="btn btn-secondary btn-sm cursor-pointer self-start sm:self-auto">
                <input type="file" class="sr-only" accept="image/*" data-file-name="#customerPhotoName">
                <i data-lucide="camera" class="h-3.5 w-3.5"></i> Ubah Foto
            </label>
        </div>
        <p id="customerPhotoName" class="relative z-10 mt-2 text-[9px] font-semibold text-slate-400">JPG atau PNG, maksimal 2 MB.</p>
    </div>

    <div class="mt-4 grid items-start gap-4 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="panel panel-pad" data-tabs>
            <div class="tab-list w-full sm:w-fit">
                <button type="button" class="tab-btn is-active" data-tab-target="profil">Profil</button>
                <button type="button" class="tab-btn" data-tab-target="keamanan">Keamanan</button>
                <button type="button" class="tab-btn" data-tab-target="notifikasi">Notifikasi</button>
            </div>

            <div class="tab-panel is-active mt-5" data-tab-panel="profil">
                <form class="space-y-3" data-demo-form data-success-message="Profil Anda berhasil diperbarui (mode demo).">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="profileName">Nama lengkap</label>
                            <input id="profileName" name="name" type="text" class="input" value="{{ $customer['name'] }}" required>
                        </div>
                        <div>
                            <label class="label" for="profileEmail">Email</label>
                            <input id="profileEmail" name="email" type="email" class="input" value="{{ $customer['email'] }}" required>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="profilePhone">Nomor telepon</label>
                            <input id="profilePhone" name="phone" type="tel" class="input" value="{{ $customer['phone'] }}" required>
                        </div>
                        <div>
                            <label class="label" for="profileBirth">Tanggal lahir</label>
                            <input id="profileBirth" name="birth_date" type="date" class="input" value="1994-08-17">
                        </div>
                    </div>
                    <div>
                        <label class="label" for="profileAddress">Alamat</label>
                        <textarea id="profileAddress" name="address" class="textarea min-h-20">{{ $customer['address'] }}</textarea>
                    </div>
                    <div class="rounded-xl border border-sky-100 bg-sky-50/60 p-3">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="circle-help" class="mt-0.5 h-4 w-4 shrink-0 text-sky-600"></i>
                            <p class="text-[10px] font-medium leading-5 text-sky-900/75">Alamat digunakan untuk pengingat kunjungan dan layanan antar-jemput (jika tersedia).</p>
                        </div>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Profil</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel mt-5" data-tab-panel="keamanan">
                <form class="space-y-3" data-demo-form data-success-message="Kata sandi berhasil diperbarui (mode demo).">
                    <div class="rounded-xl border border-amber-100 bg-amber-50/65 p-3">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="shield-check" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"></i>
                            <p class="text-[10px] font-medium leading-5 text-amber-900/75">Gunakan kombinasi huruf, angka, dan simbol. Jangan gunakan kata sandi yang sama dengan akun lain.</p>
                        </div>
                    </div>
                    <div>
                        <label class="label" for="profileCurrentPassword">Kata sandi saat ini</label>
                        <input id="profileCurrentPassword" name="current_password" type="password" class="input" placeholder="••••••••">
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="label" for="profileNewPassword">Kata sandi baru</label>
                            <input id="profileNewPassword" name="password" type="password" class="input" placeholder="Minimal 8 karakter">
                        </div>
                        <div>
                            <label class="label" for="profileConfirmPassword">Konfirmasi kata sandi</label>
                            <input id="profileConfirmPassword" name="password_confirmation" type="password" class="input" placeholder="Ulangi kata sandi">
                        </div>
                    </div>
                    <div class="check-row">
                        <div>
                            <p class="text-[11px] font-extrabold text-ink">Verifikasi dua langkah</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Minta kode tambahan saat masuk dari perangkat baru.</p>
                        </div>
                        <label class="toggle"><input type="checkbox" name="two_factor"></label>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="lock-keyhole" class="h-3.5 w-3.5"></i> Perbarui Keamanan</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel mt-5" data-tab-panel="notifikasi">
                <form class="space-y-3" data-demo-form data-success-message="Preferensi notifikasi berhasil diperbarui (mode demo).">
                    <div>
                        <label class="label" for="profileWhatsapp">Nomor WhatsApp</label>
                        <input id="profileWhatsapp" name="whatsapp" type="tel" class="input" value="{{ $customer['phone'] }}">
                    </div>
                    @php
                        $preferences = [
                            ['name' => 'booking_reminder', 'title' => 'Pengingat booking', 'copy' => 'Kirim pengingat H-1 dan 2 jam sebelum jadwal.', 'checked' => true],
                            ['name' => 'status_update', 'title' => 'Update perawatan', 'copy' => 'Beri tahu ketika hewan mulai dan selesai dirawat.', 'checked' => true],
                            ['name' => 'promo', 'title' => 'Promo & poin', 'copy' => 'Informasi penawaran khusus dan cara menukar poin.', 'checked' => false],
                            ['name' => 'newsletter', 'title' => 'Tips perawatan', 'copy' => 'Artikel singkat tentang kesehatan hewan setiap bulan.', 'checked' => false],
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
                    <div class="check-row">
                        <div>
                            <p class="text-[11px] font-extrabold text-ink">Kanal WhatsApp</p>
                            <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Pilih WhatsApp sebagai kanal utama.</p>
                        </div>
                        <label class="toggle"><input type="checkbox" name="whatsapp_channel" checked></label>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 pt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Notifikasi</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Hewan Saya</p>
                        <p class="panel-subtitle">Profil yang terhubung.</p>
                    </div>
                    <a href="{{ route('customer.pets') }}" class="text-[10px] font-extrabold text-primary-700">Kelola</a>
                </div>
                <div class="mt-3 space-y-2">
                    @foreach ($myPets as $pet)
                        <a href="{{ route('customer.pets') }}" class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white/55 p-2.5 transition hover:border-primary-200 hover:bg-white">
                            <x-avatar :photo="$pet['photo']" :name="$pet['name']" size="md" />
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-extrabold text-ink">{{ $pet['name'] }}</p>
                                <p class="mt-0.5 truncate text-[9px] font-semibold text-slate-400">{{ $pet['breed'] }} · {{ $pet['age'] }}</p>
                            </div>
                            <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="panel overflow-hidden">
                <div class="bg-gradient-to-br from-primary-700 to-primary-900 p-5 text-white">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p class="text-[9px] font-extrabold uppercase tracking-[0.14em] text-emerald-100/60">Poin PetCare</p>
                            <p class="mt-1 text-2xl font-extrabold tracking-tight">1.250</p>
                        </div>
                        <span class="grid h-10 w-10 place-items-center rounded-xl border border-white/15 bg-white/10"><i data-lucide="sparkles" class="h-5 w-5 text-amber-300"></i></span>
                    </div>
                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-white/15">
                        <div class="h-full w-[62%] rounded-full bg-gradient-to-r from-emerald-300 to-amber-300"></div>
                    </div>
                    <p class="mt-2 text-[9px] font-semibold text-emerald-50/60">750 poin lagi menuju grooming gratis.</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="font-semibold text-slate-400">Total transaksi</span>
                        <span class="font-extrabold text-ink">Rp {{ number_format($customer['spent'], 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-1.5 flex items-center justify-between text-[10px]">
                        <span class="font-semibold text-slate-400">Status member</span>
                        <span class="badge badge-amber py-0.5"><i data-lucide="star" class="h-2.5 w-2.5 fill-current"></i> Gold</span>
                    </div>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Butuh bantuan?</p>
                <p class="panel-subtitle">Tim PetCare siap membantu Anda.</p>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-3 w-full justify-start">
                    <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Chat via WhatsApp
                </a>
            </div>
        </div>
    </div>
@endsection
