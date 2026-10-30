@extends('layouts.public')

@section('title', $service['name'].' — Layanan PetCare')
@section('meta_description', $service['description'])

@section('content')
    <section class="pb-12 pt-28 sm:pt-32 lg:pt-36">
        <div class="section-shell">
            <nav class="flex flex-wrap items-center gap-1.5 text-[10px] font-bold text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-primary-700">Beranda</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <a href="{{ route('services.index') }}" class="transition hover:text-primary-700">Layanan</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-primary-700">{{ $service['name'] }}</span>
            </nav>

            <div class="mt-6 grid items-start gap-8 lg:grid-cols-[1.04fr_0.96fr] lg:gap-12">
                <div class="reveal">
                    <div class="relative overflow-hidden rounded-[2rem] border-[6px] border-white/70 shadow-soft">
                        <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }} di PetCare"
                             class="aspect-[4/3] w-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/55 to-transparent p-5 pt-16">
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-white/90 px-3 py-1 text-[9px] font-extrabold uppercase tracking-[0.12em] text-primary-700 backdrop-blur">{{ $service['category'] }}</span>
                                @if ($service['popular'])
                                    <span class="rounded-full bg-amber-400/95 px-3 py-1 text-[9px] font-extrabold uppercase tracking-[0.12em] text-amber-950">Populer</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-2.5">
                        <div class="rounded-xl border border-white/90 bg-white/65 p-3 text-center shadow-soft backdrop-blur">
                            <i data-lucide="clock-3" class="mx-auto h-4 w-4 text-primary-600"></i>
                            <p class="mt-1.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Durasi</p>
                            <p class="text-[11px] font-extrabold text-ink">{{ $service['duration'] }}</p>
                        </div>
                        <div class="rounded-xl border border-white/90 bg-white/65 p-3 text-center shadow-soft backdrop-blur">
                            <i data-lucide="paw-print" class="mx-auto h-4 w-4 text-primary-600"></i>
                            <p class="mt-1.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Untuk</p>
                            <p class="text-[11px] font-extrabold text-ink">Anjing & kucing</p>
                        </div>
                        <div class="rounded-xl border border-white/90 bg-white/65 p-3 text-center shadow-soft backdrop-blur">
                            <i data-lucide="shield-check" class="mx-auto h-4 w-4 text-primary-600"></i>
                            <p class="mt-1.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Ditangani</p>
                            <p class="text-[11px] font-extrabold text-ink">Tim ahli</p>
                        </div>
                    </div>
                </div>

                <div class="reveal delay-1">
                    <span class="eyebrow"><i data-lucide="{{ $service['icon'] }}" class="h-3.5 w-3.5"></i> {{ $service['category'] }}</span>
                    <h1 class="mt-4 text-balance text-3xl font-extrabold leading-[1.06] tracking-[-0.045em] text-ink sm:text-4xl lg:text-5xl">{{ $service['name'] }}</h1>
                    <p class="mt-2 text-sm font-bold text-primary-700">{{ $service['tagline'] }}</p>
                    <p class="section-copy mt-4">{{ $service['description'] }}</p>

                    <div class="mt-5 rounded-2xl border border-white/90 bg-white/72 p-4 shadow-soft backdrop-blur">
                        <div class="flex flex-wrap items-end justify-between gap-3">
                            <div>
                                <p class="text-[9px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Mulai dari</p>
                                <p class="mt-0.5 text-2xl font-extrabold tracking-[-0.04em] text-primary-700">
                                    Rp {{ number_format($service['price'], 0, ',', '.') }}
                                    <span class="text-[10px] font-semibold text-slate-400">/ {{ $service['unit'] }}</span>
                                </p>
                            </div>
                            <span class="badge badge-mint"><span class="badge-dot"></span>Slot tersedia</span>
                        </div>

                        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                            <a href="{{ route('customer.booking', ['service' => $service['slug']]) }}" class="btn btn-primary flex-1">
                                Booking Layanan Ini
                                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary" aria-label="Tanya via WhatsApp">
                                <i data-lucide="message-circle" class="h-4 w-4 text-primary-600"></i>
                            </a>
                        </div>
                        <p class="mt-3 flex items-center gap-1.5 text-[10px] font-semibold text-slate-400">
                            <i data-lucide="shield-check" class="h-3.5 w-3.5 text-primary-500"></i>
                            Pembayaran aman · Konfirmasi cepat · Tanpa biaya tersembunyi
                        </p>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('services.index') }}" class="btn btn-ghost btn-sm"><i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Semua layanan</a>
                        <a href="{{ route('home') }}#kontak" class="btn btn-ghost btn-sm"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i> Lokasi PetCare</a>
                    </div>
                </div>
            </div>

            <div class="mt-10 grid gap-4 lg:grid-cols-[1.15fr_0.85fr]">
                <div class="panel panel-pad reveal">
                    <div class="panel-header">
                        <div>
                            <p class="panel-title">Yang termasuk dalam layanan</p>
                            <p class="panel-subtitle">Setiap sesi dirancang agar hewan merasa nyaman dari awal sampai akhir.</p>
                        </div>
                        <span class="icon-tile icon-tile-mint h-10 w-10"><i data-lucide="sparkles" class="h-4.5 w-4.5"></i></span>
                    </div>

                    <div class="mt-5 grid gap-2.5 sm:grid-cols-2">
                        @foreach ($service['features'] as $feature)
                            <div class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white/55 px-3.5 py-3">
                                <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-primary-50 text-primary-600">
                                    <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                </span>
                                <p class="text-[11px] font-bold text-slate-600">{{ $feature }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 rounded-xl border border-amber-100 bg-amber-50/70 p-4">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="circle-help" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"></i>
                            <div>
                                <p class="text-[11px] font-extrabold text-amber-900">Catatan sebelum datang</p>
                                <p class="mt-1 text-[11px] font-medium leading-5 text-amber-800/80">{{ $service['notes'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-pad reveal delay-1">
                    <p class="panel-title">Cocok untuk siapa?</p>
                    <p class="panel-subtitle">Layanan dapat disesuaikan dengan usia, jenis bulu, dan kondisi hewan.</p>

                    <div class="mt-4 space-y-2.5">
                        @php
                            $audiences = [
                                ['icon' => 'paw-print', 'title' => 'Anjing & kucing', 'copy' => 'Segala usia, dari anak hingga senior.'],
                                ['icon' => 'heart', 'title' => 'Hewan dengan kulit sensitif', 'copy' => 'Tim memakai produk yang lebih lembut.'],
                                ['icon' => 'sparkles', 'title' => 'Perawatan rutin', 'copy' => 'Cocok untuk menjaga kebersihan dan kenyamanan.'],
                            ];
                        @endphp
                        @foreach ($audiences as $audience)
                            <div class="flex items-start gap-3 rounded-xl border border-slate-100 bg-white/55 p-3.5">
                                <span class="icon-tile icon-tile-mint h-9 w-9 shrink-0"><i data-lucide="{{ $audience['icon'] }}" class="h-4 w-4"></i></span>
                                <div>
                                    <p class="text-[11px] font-extrabold text-ink">{{ $audience['title'] }}</p>
                                    <p class="mt-0.5 text-[10px] font-medium leading-4 text-slate-500">{{ $audience['copy'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('customer.booking', ['service' => $service['slug']]) }}" class="btn btn-primary btn-sm mt-4 w-full">
                        Pilih jadwal sekarang
                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-16 sm:pb-20">
        <div class="section-shell">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Layanan Lainnya</span>
                    <h2 class="section-title mt-3">Lengkapi perawatannya.</h2>
                </div>
                <a href="{{ route('services.index') }}" class="btn btn-secondary btn-sm">Lihat semua <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></a>
            </div>

            <div class="service-grid mt-5">
                @foreach ($related as $item)
                    <article class="service-card">
                        <a href="{{ route('services.show', $item['slug']) }}" class="flex h-full flex-col">
                            <div class="service-photo">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" loading="lazy">
                                <span class="service-icon"><i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i></span>
                            </div>
                            <div class="service-body">
                                <h3 class="service-name">{{ $item['name'] }}</h3>
                                <p class="service-desc">{{ $item['tagline'] }}</p>
                                <div class="service-meta">
                                    <p class="service-price">Rp {{ number_format($item['price'], 0, ',', '.') }} <span>/ {{ $item['unit'] }}</span></p>
                                    <span class="text-[10px] font-extrabold uppercase tracking-[0.1em] text-primary-600">Detail</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
