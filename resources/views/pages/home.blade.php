@extends('layouts.public')

@section('title', 'PetCare — Perawatan Hangat untuk Hewan Kesayangan')
@section('meta_description', 'PetCare merawat hewan kesayangan dengan grooming, konsultasi dokter hewan, dan pet hotel. Booking mudah, tim berpengalaman, dan suasana yang hangat.')

@section('content')
    {{-- Hero --}}
    <section class="hero">
        <div class="section-shell">
            <div class="hero-grid">
                <div class="reveal">
                    <span class="eyebrow">
                        <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
                        Perawatan hangat untuk sahabat berbulu
                    </span>

                    <h1 class="hero-title">
                        Hari yang lebih baik untuk
                        <span class="text-gradient">hewan kesayangan</span>
                        Anda.
                    </h1>

                    <p class="hero-copy mt-5">
                        Dari grooming yang lembut sampai konsultasi dokter hewan, semua kebutuhan si kecil ada di satu tempat yang tenang, bersih, dan penuh perhatian.
                    </p>

                    <div class="mt-7 flex flex-col gap-2.5 sm:flex-row">
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary">
                            Booking Sekarang
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">
                            <i data-lucide="scissors" class="h-4 w-4 text-primary-600"></i>
                            Kenali Layanan
                        </a>
                    </div>

                    <div class="mt-7 flex flex-wrap items-center gap-3">
                        <div class="avatar-stack">
                            @foreach (array_slice($testimonials, 0, 3) as $person)
                                <x-avatar :initials="$person['initials']" :name="$person['name']" :color="$person['color']" size="sm" />
                            @endforeach
                            <span class="avatar avatar-sm avatar-slate border border-white/80 bg-white text-[9px] text-slate-500">+1k</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-1 text-amber-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i>
                                @endfor
                                <span class="ml-1 text-[11px] font-extrabold text-ink">4,9/5</span>
                            </div>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">Dipercaya 1.200+ pemilik hewan di Jakarta</p>
                        </div>
                    </div>
                </div>

                <div class="hero-visual reveal delay-1">
                    <div class="hero-halo" aria-hidden="true"></div>

                    <figure class="hero-photo hero-photo-main">
                        <img src="{{ asset('images/pets/dog-cat.webp') }}"
                             alt="Anjing dan kucing berbulu lebat beristirahat bersama di taman" fetchpriority="high">
                    </figure>

                    <figure class="hero-photo hero-photo-secondary">
                        <img src="{{ asset('images/pets/cat-luna.webp') }}"
                             alt="Kucing berbulu panjang dengan ekspresi tenang">
                    </figure>

                    <div class="floating-note left-0 top-[15%]">
                        <span class="icon-tile icon-tile-amber h-9 w-9">
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                        </span>
                        <div>
                            <strong>Rating 4,9/5</strong>
                            <span>dari 128 ulasan pelanggan</span>
                        </div>
                    </div>

                    <div class="floating-note bottom-[8%] right-0">
                        <span class="icon-tile icon-tile-mint h-9 w-9">
                            <i data-lucide="calendar-check" class="h-4 w-4"></i>
                        </span>
                        <div>
                            <strong>Booking berikutnya</strong>
                            <span>Milo · Grooming, 09.00</span>
                        </div>
                    </div>

                    <div class="absolute right-[10%] top-[4%] hidden animate-[float-soft_6s_ease-in-out_infinite] sm:block">
                        <span class="grid h-11 w-11 place-items-center rounded-full border border-white/90 bg-white/80 text-primary-600 shadow-soft backdrop-blur">
                            <i data-lucide="paw-print" class="h-5 w-5"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="hero-stat-strip reveal delay-2">
                @php
                    $heroStats = [
                        ['icon' => 'paw-print', 'value' => '1.200+', 'label' => 'hewan telah dirawat', 'color' => 'mint'],
                        ['icon' => 'star', 'value' => '4,9/5', 'label' => 'rating pelanggan', 'color' => 'amber'],
                        ['icon' => 'scissors', 'value' => '6 layanan', 'label' => 'perawatan terpadu', 'color' => 'sky'],
                        ['icon' => 'clock-3', 'value' => '08.00–20.00', 'label' => 'buka setiap hari', 'color' => 'violet'],
                    ];
                @endphp

                @foreach ($heroStats as $stat)
                    <div class="hero-stat">
                        <span class="icon-tile icon-tile-{{ $stat['color'] }} h-10 w-10">
                            <i data-lucide="{{ $stat['icon'] }}" class="h-4.5 w-4.5"></i>
                        </span>
                        <div>
                            <p class="text-sm font-extrabold tracking-tight text-ink">{{ $stat['value'] }}</p>
                            <p class="text-[10px] font-semibold text-slate-500">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section id="layanan" class="section">
        <div class="section-shell">
            <div class="section-head reveal">
                <div class="section-head-copy">
                    <span class="eyebrow">Layanan PetCare</span>
                    <h2 class="section-title mt-4">Semua yang dibutuhkan,<br class="hidden sm:block"> dalam satu tempat.</h2>
                    <p class="section-copy mt-3">Pilih perawatan yang tepat untuk sahabat berbulu. Setiap layanan ditangani dengan lembut oleh tim yang berpengalaman.</p>
                </div>
                <a href="{{ route('services.index') }}" class="btn btn-secondary shrink-0">
                    Semua Layanan
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="service-grid">
                @foreach (array_slice($services, 0, 6) as $service)
                    <article class="service-card reveal">
                        <a href="{{ route('services.show', $service['slug']) }}" class="flex h-full flex-col">
                            <div class="service-photo">
                                <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }} di PetCare" loading="lazy">
                                @if ($service['popular'])
                                    <span class="service-badge">Populer</span>
                                @endif
                                <span class="service-icon">
                                    <i data-lucide="{{ $service['icon'] }}" class="h-5 w-5"></i>
                                </span>
                            </div>
                            <div class="service-body">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="service-name">{{ $service['name'] }}</h3>
                                    <span class="btn-icon h-7 w-7 shrink-0">
                                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                    </span>
                                </div>
                                <p class="service-desc">{{ $service['tagline'] }}</p>
                                <div class="service-meta">
                                    <div>
                                        <p class="service-price">Rp {{ number_format($service['price'], 0, ',', '.') }} <span>/ {{ $service['unit'] }}</span></p>
                                        <p class="service-duration">
                                            <i data-lucide="clock-3" class="h-3 w-3"></i>
                                            {{ $service['duration'] }}
                                        </p>
                                    </div>
                                    <span class="text-[10px] font-extrabold uppercase tracking-[0.1em] text-primary-600">Detail</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="tentang" class="section pt-4 sm:pt-8 lg:pt-10">
        <div class="section-shell">
            <div class="grid items-center gap-10 lg:grid-cols-[0.92fr_1.08fr] lg:gap-16">
                <div class="relative mx-auto w-full max-w-[500px] reveal">
                    <div class="overflow-hidden rounded-[2.2rem] border-[6px] border-white/70 shadow-soft">
                        <img src="{{ asset('images/pets/grooming.webp') }}" alt="Anak anjing golden retriever berjalan di taman"
                             class="aspect-[4/5] w-full object-cover" loading="lazy">
                    </div>

                    <div class="absolute -bottom-5 -right-2 w-[46%] overflow-hidden rounded-2xl border-[5px] border-white/80 shadow-float sm:-right-6">
                        <img src="{{ asset('images/pets/cat-green.webp') }}" alt="Kucing hitam putih yang tenang"
                             class="aspect-square w-full object-cover" loading="lazy">
                    </div>

                    <div class="absolute -left-3 top-5 rounded-2xl border border-white/90 bg-white/90 px-4 py-3 shadow-soft backdrop-blur sm:-left-5">
                        <p class="text-[9px] font-extrabold uppercase tracking-[0.14em] text-primary-600">Sejak 2018</p>
                        <p class="mt-0.5 text-sm font-extrabold text-ink">8+ tahun<br><span class="text-[10px] font-semibold text-slate-500">merawat dengan hati</span></p>
                    </div>

                    <div class="absolute bottom-10 left-3 hidden w-[62%] rounded-2xl border border-white/90 bg-white/88 p-3.5 shadow-soft backdrop-blur sm:block">
                        <div class="flex items-center gap-2">
                            <span class="grid h-8 w-8 place-items-center rounded-lg bg-primary-50 text-primary-600">
                                <i data-lucide="heart" class="h-4 w-4 fill-current"></i>
                            </span>
                            <p class="text-[10px] font-extrabold leading-4 text-ink">Setiap hewan diperlakukan<br>seperti keluarga.</p>
                        </div>
                    </div>
                </div>

                <div class="reveal delay-1">
                    <span class="eyebrow">Tentang PetCare</span>
                    <h2 class="section-title mt-4">Bukan sekadar perawatan,<br class="hidden sm:block"> tapi rasa tenang.</h2>
                    <p class="section-copy mt-3">
                        Kami tahu menitipkan hewan kesayangan bukan hal kecil. Karena itu, PetCare dirancang sebagai ruang yang hangat, terang, dan tenang—tempat hewan bisa merasa aman dan Anda bisa merasa yakin.
                    </p>

                    <div class="feature-grid mt-6">
                        @php
                            $features = [
                                ['icon' => 'stethoscope', 'color' => 'mint', 'title' => 'Tim berpengalaman', 'copy' => 'Groomer dan dokter hewan yang terlatih menangani berbagai karakter hewan.'],
                                ['icon' => 'shield-check', 'color' => 'sky', 'title' => 'Produk yang aman', 'copy' => 'Kami memilih produk lembut untuk kulit sensitif dan bulu hewan.'],
                                ['icon' => 'message-circle', 'color' => 'amber', 'title' => 'Update yang jelas', 'copy' => 'Anda mendapat kabar perkembangan selama hewan dirawat di PetCare.'],
                                ['icon' => 'sparkles', 'color' => 'violet', 'title' => 'Ruang yang nyaman', 'copy' => 'Area tunggu bersih, terang, dan tenang agar hewan tidak mudah stres.'],
                            ];
                        @endphp

                        @foreach ($features as $feature)
                            <div class="feature-card">
                                <span class="icon-tile icon-tile-{{ $feature['color'] }} h-9 w-9">
                                    <i data-lucide="{{ $feature['icon'] }}" class="h-4 w-4"></i>
                                </span>
                                <h3 class="mt-3 text-xs font-extrabold text-ink">{{ $feature['title'] }}</h3>
                                <p class="mt-1 text-[11px] font-medium leading-5 text-slate-500">{{ $feature['copy'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-4 border-t border-slate-200/70 pt-5">
                        <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm">
                            Mulai dari layanan
                            <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                        </a>
                        <p class="text-[11px] font-semibold leading-5 text-slate-500">Belum yakin layanan mana yang cocok?<br>Tim kami siap membantu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section id="cara-kerja" class="section">
        <div class="section-shell">
            <div class="rounded-[2rem] border border-white/85 bg-gradient-to-br from-primary-50/80 via-white/60 to-sky-50/60 p-4 shadow-soft backdrop-blur sm:p-6 lg:p-8">
                <div class="section-head reveal">
                    <div class="section-head-copy">
                        <span class="eyebrow">Cara Kerja</span>
                        <h2 class="section-title mt-4">Semudah empat langkah.</h2>
                        <p class="section-copy mt-2">Dari memilih layanan sampai hewan pulang dengan senyum, semuanya dibuat sederhana.</p>
                    </div>
                    <a href="{{ route('customer.booking') }}" class="btn btn-primary shrink-0">
                        Coba Booking
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>

                <div class="steps-grid">
                    @php
                        $steps = [
                            ['icon' => 'scissors', 'title' => 'Pilih layanan', 'copy' => 'Tentukan perawatan yang paling sesuai dengan kebutuhan hewan Anda.', 'color' => 'mint'],
                            ['icon' => 'calendar-days', 'title' => 'Tentukan jadwal', 'copy' => 'Pilih tanggal dan jam yang nyaman. Slot tersedia secara real-time.', 'color' => 'sky'],
                            ['icon' => 'paw-print', 'title' => 'Datang & serahkan', 'copy' => 'Tim kami menyambut dengan lembut dan memulai perawatan dengan hati-hati.', 'color' => 'amber'],
                            ['icon' => 'heart-pulse', 'title' => 'Pantau hasilnya', 'copy' => 'Dapatkan update, lalu jemput hewan dalam kondisi bersih dan bahagia.', 'color' => 'violet'],
                        ];
                    @endphp

                    @foreach ($steps as $index => $step)
                        <div class="step-card reveal">
                            <span class="step-number">0{{ $index + 1 }}</span>
                            <span class="icon-tile icon-tile-{{ $step['color'] }}">
                                <i data-lucide="{{ $step['icon'] }}" class="h-5 w-5"></i>
                            </span>
                            <h3 class="mt-3 text-sm font-extrabold text-ink">{{ $step['title'] }}</h3>
                            <p class="mt-1.5 text-[11px] font-medium leading-5 text-slate-500">{{ $step['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section id="ulasan" class="section pt-2 sm:pt-4">
        <div class="section-shell">
            <div class="section-head reveal">
                <div class="section-head-copy">
                    <span class="eyebrow">Cerita Pelanggan</span>
                    <h2 class="section-title mt-4">Ekor bergoyang, hati tenang.</h2>
                    <p class="section-copy mt-2">Cerita kecil dari pemilik yang sudah mempercayakan sahabat berbulunya kepada PetCare.</p>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-white/90 bg-white/65 px-4 py-3 shadow-soft backdrop-blur">
                    <span class="text-3xl font-extrabold tracking-[-0.04em] text-ink">4,9</span>
                    <div>
                        <div class="rating-stars">
                            @for ($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="fill-current"></i>
                            @endfor
                        </div>
                        <p class="mt-1 text-[10px] font-semibold text-slate-500">128 ulasan terverifikasi</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-grid">
                @foreach ($testimonials as $testimonial)
                    <article class="testimonial-card reveal">
                        <div class="flex items-start gap-3">
                            <x-avatar :initials="$testimonial['initials']" :name="$testimonial['name']" :color="$testimonial['color']" size="md" />
                            <div class="min-w-0">
                                <p class="text-sm font-extrabold text-ink">{{ $testimonial['name'] }}</p>
                                <p class="mt-0.5 text-[10px] font-semibold text-slate-400">Pemilik {{ $testimonial['pet'] }}</p>
                            </div>
                            <span class="rating-stars ml-auto">
                                @for ($i = 0; $i < $testimonial['rating']; $i++)
                                    <i data-lucide="star" class="fill-current"></i>
                                @endfor
                            </span>
                        </div>
                        <p class="mt-4 flex-1 text-xs font-medium leading-6 text-slate-600">“{{ $testimonial['text'] }}”</p>
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 text-[10px] font-bold text-primary-600">
                            <i data-lucide="badge-check" class="h-3.5 w-3.5"></i>
                            Pelanggan terverifikasi
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="section pt-2 sm:pt-4">
        <div class="section-shell">
            <div class="grid gap-8 lg:grid-cols-[0.82fr_1.18fr] lg:gap-14">
                <div class="reveal">
                    <span class="eyebrow">Pertanyaan Umum</span>
                    <h2 class="section-title mt-4">Hal yang sering<br class="hidden sm:block"> ditanyakan.</h2>
                    <p class="section-copy mt-3">Belum menemukan jawaban? Hubungi kami lewat WhatsApp, kami senang membantu.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-5">
                        <i data-lucide="message-circle" class="h-4 w-4 text-primary-600"></i>
                        Tanya lewat WhatsApp
                    </a>
                </div>

                <div class="space-y-2.5 reveal delay-1">
                    @php
                        $faqs = [
                            ['q' => 'Apakah saya perlu booking terlebih dahulu?', 'a' => 'Sangat disarankan. Booking membantu kami menyiapkan jadwal, groomer, dan ruang perawatan yang sesuai sehingga waktu tunggu lebih singkat.'],
                            ['q' => 'Bagaimana jika hewan saya mudah cemas?', 'a' => 'Sampaikan kondisi ini saat booking atau kepada tim kami saat datang. Kami akan menyesuaikan pendekatan, menggunakan gerakan lembut, dan memberi waktu adaptasi.'],
                            ['q' => 'Apakah bisa memilih groomer tertentu?', 'a' => 'Bisa. Saat booking, Anda dapat memilih groomer yang tersedia. Jika belum ada preferensi, kami akan menyesuaikan dengan jadwal terbaik.'],
                            ['q' => 'Metode pembayaran apa yang diterima?', 'a' => 'Kami menerima transfer bank, QRIS, dan tunai di kasir. Untuk transfer, cukup unggah bukti pembayaran melalui halaman pembayaran pelanggan.'],
                            ['q' => 'Berapa lama hasil grooming bisa bertahan?', 'a' => 'Tergantung jenis bulu, aktivitas, dan perawatan di rumah. Umumnya 3–6 minggu. Groomer kami dapat memberi saran perawatan lanjutan.'],
                        ];
                    @endphp

                    @foreach ($faqs as $faq)
                        <details class="faq-item group rounded-2xl border border-white/90 bg-white/68 px-4 py-3.5 shadow-[0_18px_40px_-36px_rgba(15,23,42,0.3)] backdrop-blur">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-xs font-extrabold text-ink sm:text-sm">
                                {{ $faq['q'] }}
                                <span class="faq-plus grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary-50 text-primary-600">
                                    <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                </span>
                            </summary>
                            <p class="mt-3 pr-8 text-[11px] font-medium leading-6 text-slate-500 sm:text-xs">{{ $faq['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="kontak" class="section pt-2 sm:pt-4">
        <div class="section-shell">
            <div class="cta-panel reveal">
                <div class="grid items-center gap-8 lg:grid-cols-[1.05fr_0.95fr]">
                    <div>
                        <span class="eyebrow">Mampir, Yuk</span>
                        <h2 class="section-title mt-4">Kami tunggu kamu<br class="hidden sm:block"> dan si kecil.</h2>
                        <p class="section-copy mt-3 max-w-lg">Ruang tunggu kami terang dan nyaman, dengan tempat duduk yang lega dan area terpisah untuk hewan yang butuh ketenangan.</p>

                        <div class="mt-6 grid gap-2.5 sm:grid-cols-2">
                            <div class="flex items-start gap-3 rounded-xl border border-white/90 bg-white/70 p-3.5">
                                <span class="icon-tile icon-tile-mint h-9 w-9 shrink-0"><i data-lucide="map-pin" class="h-4 w-4"></i></span>
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Alamat</p>
                                    <p class="mt-0.5 text-[11px] font-bold leading-5 text-ink">{{ $brand['address'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 rounded-xl border border-white/90 bg-white/70 p-3.5">
                                <span class="icon-tile icon-tile-amber h-9 w-9 shrink-0"><i data-lucide="clock-3" class="h-4 w-4"></i></span>
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Jam Buka</p>
                                    <p class="mt-0.5 text-[11px] font-bold leading-5 text-ink">{{ $brand['hours'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2.5">
                            <a href="{{ route('customer.booking') }}" class="btn btn-primary">Booking Kunjungan <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
                            <a href="tel:+62215550198" class="btn btn-secondary"><i data-lucide="phone" class="h-4 w-4 text-primary-600"></i> {{ $brand['phone'] }}</a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="overflow-hidden rounded-[1.8rem] border-[5px] border-white/70 shadow-soft">
                            <img src="{{ asset('images/pets/cat-green.webp') }}" alt="Kucing nyaman berada di ruang PetCare"
                                 class="aspect-[4/3] w-full object-cover" loading="lazy">
                        </div>
                        <div class="absolute -bottom-4 left-4 right-4 rounded-2xl border border-white/90 bg-white/92 p-3.5 shadow-float backdrop-blur sm:left-auto sm:w-[78%]">
                            <div class="flex items-center gap-2.5">
                                <span class="grid h-9 w-9 place-items-center rounded-xl bg-primary-50 text-primary-600">
                                    <i data-lucide="paw-print" class="h-4 w-4"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-extrabold text-ink">PetCare Kemang</p>
                                    <p class="truncate text-[9px] font-semibold text-slate-500">Parkir tersedia · 5 menit dari Kemang Village</p>
                                </div>
                                <a href="https://maps.google.com/?q=Jl.+Kemang+Raya+No.+88,+Jakarta+Selatan" target="_blank" rel="noreferrer"
                                   class="ml-auto grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-primary-600 text-white transition hover:bg-primary-700" aria-label="Buka lokasi di Google Maps">
                                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Closing CTA --}}
    <section class="pb-16 sm:pb-20">
        <div class="section-shell">
            <div class="flex flex-col items-start justify-between gap-5 rounded-[1.8rem] border border-white/90 bg-primary-900 px-5 py-6 text-white shadow-soft sm:flex-row sm:items-center sm:px-7">
                <div class="flex items-center gap-3.5">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl border border-white/15 bg-white/10">
                        <i data-lucide="heart" class="h-5 w-5 fill-current text-emerald-200"></i>
                    </span>
                    <div>
                        <p class="text-sm font-extrabold">Siap membuat ekor bergoyang lebih sering?</p>
                        <p class="mt-0.5 text-[11px] font-medium text-emerald-50/65">Booking dalam 2 menit. Pilih layanan, tanggal, dan jam favoritmu.</p>
                    </div>
                </div>
                <a href="{{ route('customer.booking') }}" class="btn btn-primary shrink-0">
                    Booking Sekarang
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
