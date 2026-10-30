<footer class="footer">
    <div class="section-shell py-12 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_0.7fr_0.9fr_1fr]">
            <div>
                <a href="{{ route('home') }}" class="brand" aria-label="PetCare — Beranda">
                    <span class="grid h-11 w-11 place-items-center rounded-xl border border-white/15 bg-white/10 text-white">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="4" r="2"></circle>
                            <circle cx="18" cy="8" r="2"></circle>
                            <circle cx="20" cy="16" r="2"></circle>
                            <path d="M9 10c-2 0-3.5 1.5-3.5 3.5 0 1.5.8 2.5 2 3.1 1.2.6 2.2 1.4 3.5 1.4s2.3-.8 3.5-1.4c1.2-.6 2-1.6 2-3.1C16.5 11.5 15 10 13 10c-.7 0-1.4.2-2 .6-.6-.4-1.3-.6-2-.6Z"></path>
                        </svg>
                    </span>
                    <span class="brand-name text-white">PetCare</span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-7 text-emerald-50/65">
                    Ruang hangat untuk hewan kesayangan. Perawatan, kesehatan, dan penitipan dalam satu tempat yang bisa Anda percaya.
                </p>
                <div class="mt-5 flex gap-2">
                    <a href="mailto:{{ $brand['email'] }}" class="btn-icon border-white/15 bg-white/10 text-white hover:border-white/25 hover:bg-white/15 hover:text-white" aria-label="Kirim email">
                        <i data-lucide="mail" class="h-4 w-4"></i>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn-icon border-white/15 bg-white/10 text-white hover:border-white/25 hover:bg-white/15 hover:text-white" aria-label="WhatsApp PetCare">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                    </a>
                    <a href="{{ route('home') }}#kontak" class="btn-icon border-white/15 bg-white/10 text-white hover:border-white/25 hover:bg-white/15 hover:text-white" aria-label="Lokasi PetCare">
                        <i data-lucide="map-pin" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-emerald-200/60">Navigasi</p>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('services.index') }}" class="footer-link">Layanan</a>
                    <a href="{{ route('home') }}#tentang" class="footer-link">Tentang Kami</a>
                    <a href="{{ route('home') }}#cara-kerja" class="footer-link">Cara Kerja</a>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-emerald-200/60">Layanan</p>
                <div class="mt-4">
                    @foreach (array_slice($services, 0, 4) as $footerService)
                        <a href="{{ route('services.show', $footerService['slug']) }}" class="footer-link">{{ $footerService['name'] }}</a>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-emerald-200/60">Hubungi Kami</p>
                <div class="mt-4 space-y-3 text-sm text-emerald-50/65">
                    <p class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300"></i>
                        <span>{{ $brand['address'] }}</span>
                    </p>
                    <a href="tel:+62215550198" class="flex items-start gap-2.5 transition hover:text-white">
                        <i data-lucide="phone" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300"></i>
                        <span>{{ $brand['phone'] }}</span>
                    </a>
                    <a href="mailto:{{ $brand['email'] }}" class="flex items-start gap-2.5 transition hover:text-white">
                        <i data-lucide="mail" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300"></i>
                        <span>{{ $brand['email'] }}</span>
                    </a>
                    <p class="flex items-start gap-2.5">
                        <i data-lucide="clock-3" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300"></i>
                        <span>{{ $brand['hours'] }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-white/10 pt-6">
            <div class="flex flex-col gap-3 text-[11px] font-medium text-emerald-50/45 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} PetCare. Dibuat dengan hangat untuk hewan kesayangan.</p>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-emerald-50/35">Pratinjau dashboard:</span>
                    <a href="{{ route('admin.dashboard') }}" class="font-bold text-emerald-100/80 transition hover:text-white">Admin</a>
                    <span class="divider-dot bg-emerald-100/30"></span>
                    <a href="{{ route('staff.dashboard') }}" class="font-bold text-emerald-100/80 transition hover:text-white">Karyawan</a>
                    <span class="divider-dot bg-emerald-100/30"></span>
                    <a href="{{ route('customer.dashboard') }}" class="font-bold text-emerald-100/80 transition hover:text-white">Pelanggan</a>
                </div>
            </div>
        </div>
    </div>
</footer>
