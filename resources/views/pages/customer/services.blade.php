@extends('layouts.dashboard')

@section('title', 'Layanan PetCare')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Layanan</h2>
            <p class="page-copy">Pilih perawatan yang paling sesuai untuk Milo dan Luna.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm"><i data-lucide="plus" class="h-3.5 w-3.5"></i> Booking Baru</a>
        </div>
    </div>

    <div class="relative overflow-hidden rounded-3xl border border-white/85 bg-gradient-to-r from-primary-50/85 via-white/60 to-amber-50/55 p-5 shadow-soft backdrop-blur sm:p-6">
        <div class="absolute -right-10 -top-16 h-44 w-44 rounded-full bg-primary-200/25 blur-3xl" aria-hidden="true"></div>
        <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="eyebrow"><i data-lucide="sparkles" class="h-3.5 w-3.5"></i> Direkomendasikan</span>
                <h3 class="mt-2 text-lg font-extrabold tracking-tight text-ink">Grooming rutin untuk Milo</h3>
                <p class="mt-1 max-w-lg text-[11px] font-medium leading-5 text-slate-500">Kunjungan terakhir Milo 20 Oktober. Jadwalkan grooming berikutnya agar bulu tetap sehat dan nyaman.</p>
            </div>
            <a href="{{ route('customer.services.show', 'grooming') }}" class="btn btn-primary btn-sm shrink-0">Lihat Grooming <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></a>
        </div>
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
                <article class="service-card" data-service-item data-category="{{ $service['category'] }}"
                         data-search="{{ strtolower($service['name'].' '.$service['category'].' '.$service['tagline']) }}">
                    <div class="service-photo">
                        <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}" loading="lazy">
                        @if ($service['popular'])
                            <span class="service-badge">Populer</span>
                        @endif
                        <span class="service-icon"><i data-lucide="{{ $service['icon'] }}" class="h-5 w-5"></i></span>
                    </div>
                    <div class="service-body">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[9px] font-extrabold uppercase tracking-[0.12em] text-primary-600">{{ $service['category'] }}</span>
                            <span class="flex items-center gap-1 text-[9px] font-bold text-slate-400"><i data-lucide="clock-3" class="h-3 w-3"></i>{{ $service['duration'] }}</span>
                        </div>
                        <h3 class="mt-1 text-base font-extrabold tracking-tight text-ink">{{ $service['name'] }}</h3>
                        <p class="service-desc">{{ $service['tagline'] }}</p>
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach (array_slice($service['features'], 0, 2) as $feature)
                                <span class="rounded-full bg-slate-50 px-2 py-1 text-[9px] font-bold text-slate-500">{{ $feature }}</span>
                            @endforeach
                        </div>
                        <div class="service-meta mt-auto">
                            <p class="service-price">Rp {{ number_format($service['price'], 0, ',', '.') }} <span>/ {{ $service['unit'] }}</span></p>
                            <a href="{{ route('customer.services.show', $service['slug']) }}" class="btn btn-secondary btn-sm">Detail <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></a>
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

    <div class="panel panel-pad mt-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="icon-tile icon-tile-mint h-10 w-10 shrink-0"><i data-lucide="circle-help" class="h-4.5 w-4.5"></i></span>
                <div>
                    <p class="panel-title">Belum tahu layanan yang tepat?</p>
                    <p class="panel-subtitle">Ceritakan kondisi Milo atau Luna, tim kami akan membantu memilih.</p>
                </div>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm shrink-0"><i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Tanya Tim PetCare</a>
        </div>
    </div>
@endsection
