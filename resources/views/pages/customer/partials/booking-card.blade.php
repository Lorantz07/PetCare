@php
    $invoice = str_replace('BK-', 'INV-', $booking['code']);
    $isHistory = ($mode ?? 'active') === 'history';
    $isCancelled = ($mode ?? 'active') === 'cancelled';
@endphp

<article id="{{ $booking['code'] }}" class="panel overflow-hidden scroll-mt-28" data-row>
    <div class="p-4">
        <div class="flex items-start gap-3">
            <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl {{ $isCancelled ? 'bg-slate-100 text-slate-500' : 'bg-primary-50 text-primary-700' }}">
                <span class="text-[8px] font-extrabold uppercase tracking-wider">{{ explode(' ', $booking['date'])[1] }}</span>
                <span class="text-base font-extrabold leading-none">{{ explode(' ', $booking['date'])[0] }}</span>
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-1.5">
                    <span class="text-[9px] font-bold text-slate-400">{{ $booking['code'] }}</span>
                    <x-status-badge :status="$booking['status']" />
                </div>
                <h3 class="mt-1 truncate text-sm font-extrabold tracking-tight text-ink">{{ $booking['service'] }} · {{ $booking['pet'] }}</h3>
                <p class="mt-0.5 text-[10px] font-semibold text-slate-400">{{ $booking['date'] }} · {{ $booking['time'] }} WIB</p>
            </div>
            <img src="{{ asset($booking['pet_photo']) }}" alt="{{ $booking['pet'] }}" class="h-11 w-11 shrink-0 rounded-xl object-cover" loading="lazy">
        </div>

        <div class="mt-3 grid grid-cols-3 gap-1.5">
            <div class="rounded-lg bg-slate-50/90 px-2 py-2">
                <p class="text-[7px] font-extrabold uppercase tracking-wider text-slate-400">Hewan</p>
                <p class="mt-0.5 truncate text-[9px] font-extrabold text-ink">{{ $booking['pet'] }}</p>
            </div>
            <div class="rounded-lg bg-slate-50/90 px-2 py-2">
                <p class="text-[7px] font-extrabold uppercase tracking-wider text-slate-400">Karyawan</p>
                <p class="mt-0.5 truncate text-[9px] font-extrabold text-ink">{{ $booking['employee'] }}</p>
            </div>
            <div class="rounded-lg bg-slate-50/90 px-2 py-2">
                <p class="text-[7px] font-extrabold uppercase tracking-wider text-slate-400">Total</p>
                <p class="mt-0.5 truncate text-[9px] font-extrabold text-ink">Rp {{ number_format($booking['price'], 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-2 flex items-center justify-between gap-2">
            <x-status-badge :status="$booking['payment']" type="payment" />
            <span class="text-[9px] font-semibold text-slate-400">{{ $booking['method'] }}</span>
        </div>

        <details class="booking-details mt-3 border-t border-slate-100 pt-3">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-2 text-[10px] font-extrabold text-primary-700">
                Lihat detail booking
                <i data-lucide="chevron-down" class="h-3.5 w-3.5 transition-transform"></i>
            </summary>
            <div class="mt-3 space-y-2.5">
                <div class="rounded-xl border border-amber-100 bg-amber-50/60 p-2.5">
                    <div class="flex items-start gap-2">
                        <i data-lucide="file-text" class="mt-0.5 h-3 w-3 shrink-0 text-amber-600"></i>
                        <p class="text-[9px] font-medium leading-4 text-amber-900/75">{{ $booking['notes'] }}</p>
                    </div>
                </div>

                <div class="space-y-1.5 text-[9px]">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-semibold text-slate-400">Invoice</span>
                        <span class="font-extrabold text-ink">{{ $invoice }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-semibold text-slate-400">Metode bayar</span>
                        <span class="font-extrabold text-ink">{{ $booking['method'] }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-semibold text-slate-400">Lokasi</span>
                        <span class="font-extrabold text-ink">PetCare Kemang</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-1.5">
                    @if ($isHistory)
                        <a href="{{ route('customer.reviews') }}" class="btn btn-primary btn-sm"><i data-lucide="star" class="h-3.5 w-3.5"></i> Beri Ulasan</a>
                        <a href="{{ route('customer.booking', ['service' => $booking['service_slug']]) }}" class="btn btn-secondary btn-sm"><i data-lucide="refresh-cw" class="h-3.5 w-3.5 text-primary-600"></i> Booking Lagi</a>
                    @elseif ($isCancelled)
                        <a href="{{ route('customer.booking', ['service' => $booking['service_slug']]) }}" class="btn btn-primary btn-sm"><i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i> Booking Ulang</a>
                    @else
                        @if ($booking['payment'] !== 'dibayar')
                            <a href="{{ route('customer.payments') }}" class="btn btn-primary btn-sm"><i data-lucide="credit-card" class="h-3.5 w-3.5"></i> Kelola Pembayaran</a>
                        @else
                            <a href="{{ route('customer.payments') }}" class="btn btn-secondary btn-sm"><i data-lucide="receipt-text" class="h-3.5 w-3.5 text-primary-600"></i> Lihat Pembayaran</a>
                        @endif
                    @endif
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm"><i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i> Hubungi</a>
                </div>
            </div>
        </details>
    </div>
</article>
