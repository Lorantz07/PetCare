@extends('layouts.public')

@section('title', 'Layanan PetCare — Grooming, Kesehatan & Penitipan')
@section('meta_description', 'Jelajahi layanan PetCare: grooming, konsultasi dokter hewan, pet hotel, potong kuku, pembersihan telinga, dan cek kesehatan.')

@section('content')
    <section class="pb-8 pt-28 sm:pt-32 lg:pt-36">
        <div class="section-shell">
            <nav class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-primary-700">Beranda</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-primary-700">Layanan</span>
            </nav>

            <div class="mt-6 grid items-end gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="reveal">
                    <span class="eyebrow"><i data-lucide="scissors" class="h-3.5 w-3.5"></i> Layanan PetCare</span>
                    <h1 class="mt-4 text-balance text-4xl font-extrabold leading-[1.04] tracking-[-0.05em] text-ink sm:text-5xl lg:text-[3.6rem]">
                        Perawatan yang tepat untuk <span class="text-gradient">setiap karakter</span>.
                    </h1>
                    <p class="section-copy mt-4 max-w-2xl">
                        Ada hewan yang suka bersantai, ada juga yang penuh energi. Pilih layanan yang paling sesuai—tim kami akan menyesuaikan pendekatan dengan kebutuhan si kecil.
                    </p>
                </div>

                <div class="grid gap-2.5 sm:grid-cols-3 lg:grid-cols-1">
                    @php
                        $serviceTrust = [
                            ['icon' => 'shield-check', 'title' => 'Aman & lembut', 'copy' => 'Produk ramah kulit', 'color' => 'mint'],
                            ['icon' => 'user-round', 'title' => 'Tim ahli', 'copy' => 'Groomer berpengalaman', 'color' => 'sky'],
                            ['icon' => 'clock-3', 'title' => 'Fleksibel', 'copy' => 'Slot mudah dipilih', 'color' => 'amber'],
                        ];
                    @endphp
                    @foreach ($serviceTrust as $trust)
                        <div class="flex items-center gap-3 rounded-xl border border-white/90 bg-white/60 px-3.5 py-3 shadow-soft backdrop-blur">
                            <span class="icon-tile icon-tile-{{ $trust['color'] }} h-9 w-9 shrink-0"><i data-lucide="{{ $trust['icon'] }}" class="h-4 w-4"></i></span>
                            <div>
                                <p class="text-[11px] font-extrabold text-ink">{{ $trust['title'] }}</p>
                                <p class="text-[9px] font-semibold text-slate-400">{{ $trust['copy'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="pb-16 pt-4 sm:pb-20">
        <div class="section-shell" data-service-filter-scope>
            <div class="flex flex-col gap-4 rounded-2xl border border-white/90 bg-white/62 p-3.5 shadow-soft backdrop-blur sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap gap-1.5">
                    @php
                        $categories = ['semua' => 'Semua', 'Perawatan' => 'Perawatan', 'Kesehatan' => 'Kesehatan', 'Penitipan' => 'Penitipan'];
                    @endphp
                    @foreach ($categories as $value => $label)
                        <button type="button" data-service-chip="{{ $value }}"
                                class="tab-btn {{ $loop->first ? 'is-active' : '' }}">{{ $label }}</button>
                    @endforeach
                </div>

                <div class="input-icon-wrap w-full sm:w-72">
                    <i data-lucide="search"></i>
                    <input type="search" class="input" placeholder="Cari layanan..." aria-label="Cari layanan" data-service-search>
                </div>
            </div>

            <div class="service-grid mt-4">
                @foreach ($services as $service)
                    <article class="service-card reveal" data-service-item data-category="{{ $service['category'] }}"
                             data-search="{{ strtolower($service['name'].' '.$service['category'].' '.$service['tagline'].' '.implode(' ', $service['features'])) }}">
                        <div class="service-photo">
                            <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }} di PetCare" loading="lazy">
                            @if ($service['popular'])
                                <span class="service-badge">Populer</span>
                            @endif
                            <span class="service-icon"><i data-lucide="{{ $service['icon'] }}" class="h-5 w-5"></i></span>
                        </div>
                        <div class="service-body">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[9px] font-extrabold uppercase tracking-[0.12em] text-primary-600">{{ $service['category'] }}</span>
                                <span class="flex items-center gap-1 text-[9px] font-bold text-slate-400">
                                    <i data-lucide="clock-3" class="h-3 w-3"></i>{{ $service['duration'] }}
                                </span>
                            </div>
                            <h2 class="mt-1.5 text-base font-extrabold tracking-tight text-ink">{{ $service['name'] }}</h2>
                            <p class="service-desc">{{ $service['tagline'] }}</p>

                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach (array_slice($service['features'], 0, 3) as $feature)
                                    <span class="rounded-full bg-slate-50 px-2 py-1 text-[9px] font-bold text-slate-500">{{ $feature }}</span>
                                @endforeach
                            </div>

                            <div class="service-meta mt-auto">
                                <p class="service-price">Rp {{ number_format($service['price'], 0, ',', '.') }} <span>/ {{ $service['unit'] }}</span></p>
                                <a href="{{ route('services.show', $service['slug']) }}" class="btn btn-secondary btn-sm">
                                    Detail
                                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="empty-state mt-4 hidden" data-service-empty>
                <span class="icon-tile icon-tile-mint h-12 w-12"><i data-lucide="search" class="h-5 w-5"></i></span>
                <p class="mt-3 text-sm font-extrabold text-ink">Layanan belum ditemukan</p>
                <p class="mt-1 text-xs font-medium text-slate-500">Coba kata kunci lain atau pilih kategori “Semua”.</p>
            </div>

            <div class="mt-8 flex flex-col items-start justify-between gap-4 rounded-2xl border border-white/90 bg-gradient-to-r from-primary-50/85 to-white/60 p-5 shadow-soft backdrop-blur sm:flex-row sm:items-center">
                <div class="flex items-center gap-3">
                    <span class="icon-tile icon-tile-mint h-11 w-11"><i data-lucide="circle-help" class="h-5 w-5"></i></span>
                    <div>
                        <p class="text-sm font-extrabold text-ink">Masih bingung memilih layanan?</p>
                        <p class="mt-0.5 text-[11px] font-medium text-slate-500">Ceritakan kondisi hewan Anda, kami bantu menemukan yang paling pas.</p>
                    </div>
                </div>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-primary btn-sm shrink-0">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Tanya Tim PetCare
                </a>
            </div>
        </div>
    </section>
@endsection
