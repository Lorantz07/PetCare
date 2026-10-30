@extends('layouts.public')

@php
    $isLogin = ($mode ?? 'login') === 'login';
@endphp

@section('title', ($isLogin ? 'Masuk' : 'Daftar').' — PetCare')

@section('content')
    <section class="auth-shell">
        <div class="section-shell grid w-full max-w-5xl items-center gap-8 lg:grid-cols-[1.02fr_0.98fr]">
            <div class="reveal">
                <span class="eyebrow"><i data-lucide="sparkles" class="h-3.5 w-3.5"></i> {{ $isLogin ? 'Selamat datang kembali' : 'Mulai perjalanan baru' }}</span>
                <h1 class="mt-4 text-balance text-4xl font-extrabold leading-[1.04] tracking-[-0.05em] text-ink sm:text-5xl">
                    {{ $isLogin ? 'Halo lagi,' : 'Kenalan yuk,' }}<br>
                    <span class="text-gradient">{{ $isLogin ? 'sahabat berbulu menanti.' : 'dengan PetCare.' }}</span>
                </h1>
                <p class="section-copy mt-4 max-w-md">
                    {{ $isLogin
                        ? 'Masuk untuk melihat jadwal, mengelola hewan, dan memantau setiap perawatan dalam satu tempat.'
                        : 'Buat akun untuk booking lebih cepat, menyimpan profil hewan, dan mendapatkan pengingat perawatan.' }}
                </p>

                <div class="mt-6 space-y-2.5">
                    @php
                        $benefits = $isLogin
                            ? [
                                ['icon' => 'calendar-check', 'title' => 'Jadwal dalam satu tampilan', 'copy' => 'Lihat booking mendatang dan riwayat kapan saja.'],
                                ['icon' => 'paw-print', 'title' => 'Profil hewan tersimpan', 'copy' => 'Catatan perawatan dan preferensi tetap rapi.'],
                            ]
                            : [
                                ['icon' => 'shield-check', 'title' => 'Data aman & privat', 'copy' => 'Informasi hewan hanya digunakan untuk perawatan.'],
                                ['icon' => 'sparkles', 'title' => 'Poin setiap kunjungan', 'copy' => 'Kumpulkan poin dan nikmati penawaran khusus.'],
                            ];
                    @endphp
                    @foreach ($benefits as $benefit)
                        <div class="flex items-start gap-3">
                            <span class="icon-tile icon-tile-mint h-9 w-9 shrink-0"><i data-lucide="{{ $benefit['icon'] }}" class="h-4 w-4"></i></span>
                            <div>
                                <p class="text-[11px] font-extrabold text-ink">{{ $benefit['title'] }}</p>
                                <p class="mt-0.5 text-[10px] font-medium text-slate-500">{{ $benefit['copy'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-pad reveal delay-1 sm:p-7">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-primary-600">{{ $isLogin ? 'Masuk ke akun' : 'Buat akun baru' }}</p>
                        <h2 class="mt-1 text-xl font-extrabold tracking-tight text-ink">{{ $isLogin ? 'Masuk ke PetCare' : 'Daftar di PetCare' }}</h2>
                    </div>
                    <span class="icon-tile icon-tile-mint h-11 w-11"><i data-lucide="{{ $isLogin ? 'lock-keyhole' : 'user-plus' }}" class="h-5 w-5"></i></span>
                </div>

                <div class="mt-5 rounded-xl border border-amber-100 bg-amber-50/70 p-3.5">
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="circle-help" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"></i>
                        <p class="text-[11px] font-semibold leading-5 text-amber-900/80">
                            Formulir autentikasi sedang disiapkan. Untuk sementara, Anda bisa menjelajahi pratinjau dashboard dengan memilih peran di bawah.
                        </p>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white/60 p-3 transition hover:border-primary-200 hover:bg-white">
                        <span class="icon-tile icon-tile-mint h-10 w-10"><i data-lucide="shield-check" class="h-4.5 w-4.5"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-extrabold text-ink">Dashboard Admin</p>
                            <p class="text-[9px] font-semibold text-slate-400">Kelola operasional PetCare</p>
                        </div>
                        <i data-lucide="arrow-right" class="h-4 w-4 text-slate-400"></i>
                    </a>
                    <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white/60 p-3 transition hover:border-primary-200 hover:bg-white">
                        <span class="icon-tile icon-tile-violet h-10 w-10"><i data-lucide="scissors" class="h-4.5 w-4.5"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-extrabold text-ink">Dashboard Karyawan</p>
                            <p class="text-[9px] font-semibold text-slate-400">Lihat jadwal dan booking</p>
                        </div>
                        <i data-lucide="arrow-right" class="h-4 w-4 text-slate-400"></i>
                    </a>
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 rounded-xl border border-primary-100 bg-primary-50/65 p-3 transition hover:border-primary-200 hover:bg-primary-50">
                        <span class="icon-tile icon-tile-amber h-10 w-10"><i data-lucide="paw-print" class="h-4.5 w-4.5"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-extrabold text-ink">Dashboard Pelanggan</p>
                            <p class="text-[9px] font-semibold text-slate-400">Booking dan pantau hewan</p>
                        </div>
                        <i data-lucide="arrow-right" class="h-4 w-4 text-slate-400"></i>
                    </a>
                </div>

                <p class="mt-4 text-center text-[10px] font-semibold text-slate-400">
                    {{ $isLogin ? 'Belum punya akun?' : 'Sudah punya akun?' }}
                    <a href="{{ $isLogin ? route('register') : route('login') }}" class="font-extrabold text-primary-700 hover:text-primary-800">
                        {{ $isLogin ? 'Daftar sekarang' : 'Masuk di sini' }}
                    </a>
                </p>
                <a href="{{ route('home') }}" class="mt-3 flex items-center justify-center gap-1.5 text-[10px] font-bold text-slate-400 transition hover:text-primary-700">
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                    Kembali ke beranda
                </a>
            </div>
        </div>
    </section>
@endsection
