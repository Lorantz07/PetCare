@extends('layouts.dashboard')

@section('title', $service['name'].' · PetCare')

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('customer.services') }}" class="mb-2 inline-flex items-center gap-1.5 text-[10px] font-extrabold text-slate-400 transition hover:text-primary-700">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Kembali ke layanan
            </a>
            <h2 class="page-title">{{ $service['name'] }}</h2>
            <p class="page-copy">{{ $service['category'] }} · {{ $service['tagline'] }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.booking', ['service' => $service['slug']]) }}" class="btn btn-primary btn-sm"><i data-lucide="calendar-check" class="h-3.5 w-3.5"></i> Booking Layanan</a>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-[1.4fr_0.6fr]">
        <div class="space-y-4">
            <div class="panel overflow-hidden">
                <div class="relative h-64 overflow-hidden sm:h-80">
                    <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/55 via-transparent to-transparent"></div>
                    <div class="absolute inset-x-5 bottom-5 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-white/90 px-3 py-1 text-[9px] font-extrabold uppercase tracking-[0.12em] text-primary-700 backdrop-blur">{{ $service['category'] }}</span>
                        @if ($service['popular'])
                            <span class="rounded-full bg-amber-400/95 px-3 py-1 text-[9px] font-extrabold uppercase tracking-[0.12em] text-amber-950">Populer</span>
                        @endif
                    </div>
                </div>
                <div class="p-5 sm:p-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="icon-tile icon-tile-mint h-9 w-9"><i data-lucide="{{ $service['icon'] }}" class="h-4 w-4"></i></span>
                        <span class="badge badge-mint"><span class="badge-dot"></span>Slot tersedia</span>
                        <span class="badge badge-slate"><i data-lucide="clock-3" class="h-3 w-3"></i>{{ $service['duration'] }}</span>
                    </div>
                    <h3 class="mt-3 text-xl font-extrabold tracking-tight text-ink">Tentang layanan ini</h3>
                    <p class="mt-2 text-xs font-medium leading-6 text-slate-600">{{ $service['description'] }}</p>

                    <div class="mt-4 grid gap-2 sm:grid-cols-2">
                        @foreach ($service['features'] as $feature)
                            <div class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white/55 px-3.5 py-2.5">
                                <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary-50 text-primary-600"><i data-lucide="check" class="h-3 w-3"></i></span>
                                <p class="text-[10px] font-bold text-slate-600">{{ $feature }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="content-grid-2 mt-0">
                <div class="panel panel-pad">
                    <p class="panel-title">Cocok untuk</p>
                    <div class="mt-3 space-y-2">
                        @foreach (['Anjing & kucing segala usia', 'Hewan dengan kulit sensitif', 'Perawatan rutin bulanan'] as $item)
                            <div class="flex items-center gap-2.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span>
                                <p class="text-[10px] font-semibold text-slate-500">{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel panel-pad">
                    <p class="panel-title">Catatan penting</p>
                    <p class="mt-2 text-[10px] font-medium leading-5 text-slate-500">{{ $service['notes'] }}</p>
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Layanan lain untuk si kecil</p>
                        <p class="panel-subtitle">Bisa ditambahkan pada kunjungan yang sama.</p>
                    </div>
                    <a href="{{ route('customer.services') }}" class="text-[10px] font-extrabold text-primary-700">Semua</a>
                </div>
                <div class="mt-3 grid gap-2.5 sm:grid-cols-2">
                    @foreach ($related as $item)
                        <a href="{{ route('customer.services.show', $item['slug']) }}" class="group flex items-center gap-3 rounded-xl border border-slate-100 bg-white/55 p-2.5 transition hover:border-primary-200 hover:bg-white">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="h-14 w-14 rounded-lg object-cover" loading="lazy">
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-extrabold text-ink">{{ $item['name'] }}</p>
                                <p class="mt-0.5 text-[9px] font-semibold text-slate-400">Rp {{ number_format($item['price'], 0, ',', '.') }} · {{ $item['duration'] }}</p>
                                <p class="mt-1 text-[9px] font-extrabold text-primary-600">Lihat detail</p>
                            </div>
                            <i data-lucide="arrow-right" class="h-3.5 w-3.5 text-slate-300"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <p class="text-[9px] font-extrabold uppercase tracking-[0.14em] text-slate-400">Harga layanan</p>
                <p class="mt-1 text-3xl font-extrabold tracking-[-0.04em] text-primary-700">
                    Rp {{ number_format($service['price'], 0, ',', '.') }}
                    <span class="text-[10px] font-semibold text-slate-400">/ {{ $service['unit'] }}</span>
                </p>
                <p class="mt-1 text-[10px] font-semibold text-slate-500">Durasi {{ $service['duration'] }} · termasuk konsultasi singkat.</p>

                <a href="{{ route('customer.booking', ['service' => $service['slug']]) }}" class="btn btn-primary mt-4 w-full">Pilih Jadwal <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-2 w-full"><i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Tanya dulu</a>

                <div class="mt-4 space-y-2 border-t border-slate-100 pt-3">
                    <div class="flex items-center gap-2"><i data-lucide="shield-check" class="h-3.5 w-3.5 text-primary-500"></i><p class="text-[9px] font-semibold text-slate-500">Ditangani tim berpengalaman</p></div>
                    <div class="flex items-center gap-2"><i data-lucide="check" class="h-3.5 w-3.5 text-primary-500"></i><p class="text-[9px] font-semibold text-slate-500">Konfirmasi cepat via WhatsApp</p></div>
                    <div class="flex items-center gap-2"><i data-lucide="wallet" class="h-3.5 w-3.5 text-primary-500"></i><p class="text-[9px] font-semibold text-slate-500">Bayar setelah booking dikonfirmasi</p></div>
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="flex items-start gap-3">
                    <span class="icon-tile icon-tile-amber h-10 w-10 shrink-0"><i data-lucide="map-pin" class="h-4.5 w-4.5"></i></span>
                    <div>
                        <p class="panel-title">Lokasi PetCare</p>
                        <p class="panel-subtitle">{{ $brand['address'] }}</p>
                        <a href="https://maps.google.com/?q=Jl.+Kemang+Raya+No.+88,+Jakarta+Selatan" target="_blank" rel="noreferrer" class="mt-2 inline-flex items-center gap-1 text-[9px] font-extrabold text-primary-700">Buka di Maps <i data-lucide="arrow-right" class="h-3 w-3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
