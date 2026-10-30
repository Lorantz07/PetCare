@extends('layouts.dashboard')

@section('title', 'Booking Baru')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Booking Baru</h2>
            <p class="page-copy">Pilih layanan, jadwal, dan hewan. Prosesnya sekitar dua menit.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('customer.bookings') }}" class="btn btn-secondary btn-sm"><i data-lucide="calendar-check" class="h-3.5 w-3.5"></i> Booking Saya</a>
        </div>
    </div>

    <div id="bookingWizard" data-success-url="{{ route('customer.booking.success') }}"
         data-preselected-service="{{ $preselectedService }}" data-preselected-pet="{{ $preselectedPet }}">
        <div class="booking-steps">
            @foreach ([1 => 'Layanan', 2 => 'Jadwal', 3 => 'Hewan', 4 => 'Konfirmasi'] as $number => $label)
                <div class="booking-step {{ $number === 1 ? 'is-active' : '' }}" data-booking-step="{{ $number }}">
                    <span class="booking-step-number">{{ $number }}</span>
                    <span>{{ $label }}</span>
                    @if ($number < 4)
                        <i data-lucide="chevron-right" class="ml-auto hidden h-3.5 w-3.5 text-slate-300 sm:block"></i>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4 grid items-start gap-4 xl:grid-cols-[1.45fr_0.55fr]">
            <div>
                <div class="mb-3 hidden items-start gap-2.5 rounded-xl border border-rose-100 bg-rose-50/80 px-3.5 py-3" data-booking-error role="alert">
                    <i data-lucide="circle-alert" class="mt-0.5 h-4 w-4 shrink-0 text-rose-500"></i>
                    <p class="text-[11px] font-semibold leading-5 text-rose-700"></p>
                </div>

                {{-- Step 1: service --}}
                <div class="booking-panel is-active" data-booking-panel="1">
                    <div class="panel panel-pad">
                        <div class="panel-header">
                            <div>
                                <p class="panel-title">Pilih layanan</p>
                                <p class="panel-subtitle">Apa yang dibutuhkan si kecil hari ini?</p>
                            </div>
                            <span class="badge badge-mint"><span class="badge-dot"></span>6 tersedia</span>
                        </div>

                        <div class="mt-4 grid gap-2.5 sm:grid-cols-2">
                            @foreach ($services as $service)
                                <label class="choice-card flex items-center gap-3">
                                    <input type="radio" name="service" value="{{ $service['slug'] }}"
                                           data-service-name="{{ $service['name'] }}"
                                           data-service-price="{{ $service['price'] }}"
                                           data-service-unit="{{ $service['unit'] }}">
                                    <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}" class="h-14 w-14 shrink-0 rounded-xl object-cover" loading="lazy">
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center gap-1.5">
                                            <span class="text-[11px] font-extrabold text-ink">{{ $service['name'] }}</span>
                                            @if ($service['popular'])
                                                <span class="rounded-full bg-amber-100 px-1.5 py-0.5 text-[7px] font-extrabold uppercase tracking-wider text-amber-700">Populer</span>
                                            @endif
                                        </span>
                                        <span class="mt-0.5 block text-[9px] font-semibold text-slate-400">{{ $service['duration'] }} · {{ $service['category'] }}</span>
                                        <span class="mt-1 block text-[10px] font-extrabold text-primary-700">Rp {{ number_format($service['price'], 0, ',', '.') }} <span class="font-semibold text-slate-400">/ {{ $service['unit'] }}</span></span>
                                    </span>
                                    <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full border border-slate-200 bg-white text-transparent">
                                        <i data-lucide="check" class="h-3 w-3"></i>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                            <p class="text-[9px] font-semibold text-slate-400">Harga sudah termasuk alat dan produk perawatan.</p>
                            <button type="button" class="btn btn-primary" data-booking-next>Lanjut ke Jadwal <i data-lucide="arrow-right" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                </div>

                {{-- Step 2: schedule --}}
                <div class="booking-panel" data-booking-panel="2">
                    <div class="panel panel-pad">
                        <div class="panel-header">
                            <div>
                                <p class="panel-title">Pilih tanggal & jam</p>
                                <p class="panel-subtitle">Slot akan dikunci setelah booking dikonfirmasi.</p>
                            </div>
                            <span class="badge badge-slate"><i data-lucide="calendar-days" class="h-3 w-3"></i>7 hari ke depan</span>
                        </div>

                        <p class="mt-4 text-[9px] font-extrabold uppercase tracking-[0.1em] text-slate-400">Tanggal kunjungan</p>
                        <div class="mt-2 flex gap-2 overflow-x-auto pb-1">
                            @foreach ($bookingDays as $day)
                                <button type="button" class="day-card {{ $day['disabled'] ? 'is-disabled' : '' }}"
                                        data-day="{{ $day['value'] }}" data-day-label="{{ $day['full'] }}"
                                        @disabled($day['disabled'])>
                                    <small>{{ $day['label'] }}</small>
                                    <strong>{{ explode(' ', $day['date'])[0] }}</strong>
                                    <span class="text-[8px] font-semibold opacity-60">{{ explode(' ', $day['date'])[1] }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-5 flex items-center justify-between gap-2">
                            <p class="text-[9px] font-extrabold uppercase tracking-[0.1em] text-slate-400">Jam tersedia</p>
                            <p class="text-[8px] font-semibold text-slate-400"><span class="mr-1 inline-block h-2 w-2 rounded-full bg-primary-500 align-middle"></span>WIB</p>
                        </div>
                        <div class="mt-2 grid grid-cols-4 gap-2">
                            @foreach ($timeSlots as $slot)
                                <button type="button" class="time-chip" data-time="{{ $slot['time'] }}" @disabled(! $slot['available'])>
                                    {{ $slot['time'] }}
                                </button>
                            @endforeach
                        </div>
                        <p class="mt-2 flex items-center gap-1.5 text-[9px] font-semibold text-slate-400"><i data-lucide="circle-help" class="h-3 w-3"></i>Jam yang dicoret sudah tidak tersedia. Datang 10 menit sebelum jadwal.</p>

                        <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                            <button type="button" class="btn btn-secondary btn-sm" data-booking-prev><i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Kembali</button>
                            <button type="button" class="btn btn-primary" data-booking-next>Lanjut ke Hewan <i data-lucide="arrow-right" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                </div>

                {{-- Step 3: pet --}}
                <div class="booking-panel" data-booking-panel="3">
                    <div class="panel panel-pad">
                        <div class="panel-header">
                            <div>
                                <p class="panel-title">Hewan siapa yang akan dirawat?</p>
                                <p class="panel-subtitle">Pilih salah satu profil hewan Anda.</p>
                            </div>
                            <a href="{{ route('customer.pets') }}" class="text-[10px] font-extrabold text-primary-700">Kelola hewan</a>
                        </div>

                        <div class="mt-4 grid gap-2.5 sm:grid-cols-2">
                            @foreach ($myPets as $pet)
                                <label class="choice-card flex items-center gap-3">
                                    <input type="radio" name="pet" value="{{ $pet['name'] }}">
                                    <img src="{{ asset($pet['photo']) }}" alt="{{ $pet['name'] }}" class="h-14 w-14 shrink-0 rounded-xl object-cover" loading="lazy">
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-[11px] font-extrabold text-ink">{{ $pet['name'] }}</span>
                                        <span class="mt-0.5 block text-[9px] font-semibold text-slate-400">{{ $pet['breed'] }} · {{ $pet['age'] }}</span>
                                        <span class="mt-1 block text-[9px] font-bold text-primary-600">Terakhir: {{ $pet['last_visit'] }}</span>
                                    </span>
                                    <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full border border-slate-200 bg-white text-transparent">
                                        <i data-lucide="check" class="h-3 w-3"></i>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4 rounded-xl border border-sky-100 bg-sky-50/65 p-3">
                            <div class="flex items-start gap-2.5">
                                <i data-lucide="circle-help" class="mt-0.5 h-4 w-4 shrink-0 text-sky-600"></i>
                                <p class="text-[10px] font-medium leading-5 text-sky-900/75">Catatan khusus hewan akan otomatis diteruskan ke groomer. Pastikan profil sudah diperbarui.</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                            <button type="button" class="btn btn-secondary btn-sm" data-booking-prev><i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Kembali</button>
                            <button type="button" class="btn btn-primary" data-booking-next>Lanjut ke Konfirmasi <i data-lucide="arrow-right" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                </div>

                {{-- Step 4: confirm --}}
                <div class="booking-panel" data-booking-panel="4">
                    <div class="panel panel-pad">
                        <div class="panel-header">
                            <div>
                                <p class="panel-title">Konfirmasi booking</p>
                                <p class="panel-subtitle">Periksa kembali detail sebelum melanjutkan.</p>
                            </div>
                            <span class="badge badge-mint"><span class="badge-dot"></span>Langkah terakhir</span>
                        </div>

                        <div class="mt-4 rounded-2xl border border-slate-100 bg-white/55 p-4">
                            <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                <div>
                                    <p class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400">Ringkasan</p>
                                    <p class="mt-1 text-sm font-extrabold text-ink" data-summary-service>Belum dipilih</p>
                                </div>
                                <p class="text-sm font-extrabold text-primary-700" data-summary-total>Rp 0</p>
                            </div>
                            <div class="mt-2 space-y-0.5">
                                <div class="summary-row"><span>Tanggal</span><strong data-summary-date>Belum dipilih</strong></div>
                                <div class="summary-row"><span>Jam</span><strong data-summary-time>Belum dipilih</strong></div>
                                <div class="summary-row"><span>Hewan</span><strong data-summary-pet>Belum dipilih</strong></div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="label">Metode pembayaran</p>
                            <div class="grid gap-2 sm:grid-cols-3">
                                <label class="choice-card flex items-center gap-2.5 p-3">
                                    <input type="radio" name="payment_method" value="transfer" data-method-label="Transfer Bank BCA">
                                    <span class="icon-tile icon-tile-mint h-8 w-8 shrink-0"><i data-lucide="building-2" class="h-3.5 w-3.5"></i></span>
                                    <span>
                                        <span class="block text-[10px] font-extrabold text-ink">Transfer BCA</span>
                                        <span class="mt-0.5 block text-[8px] font-semibold text-slate-400">Verifikasi manual</span>
                                    </span>
                                </label>
                                <label class="choice-card flex items-center gap-2.5 p-3">
                                    <input type="radio" name="payment_method" value="qris" data-method-label="QRIS">
                                    <span class="icon-tile icon-tile-sky h-8 w-8 shrink-0"><i data-lucide="qr-code" class="h-3.5 w-3.5"></i></span>
                                    <span>
                                        <span class="block text-[10px] font-extrabold text-ink">QRIS</span>
                                        <span class="mt-0.5 block text-[8px] font-semibold text-slate-400">Semua e-wallet</span>
                                    </span>
                                </label>
                                <label class="choice-card flex items-center gap-2.5 p-3">
                                    <input type="radio" name="payment_method" value="cash" data-method-label="Tunai di kasir">
                                    <span class="icon-tile icon-tile-amber h-8 w-8 shrink-0"><i data-lucide="banknote" class="h-3.5 w-3.5"></i></span>
                                    <span>
                                        <span class="block text-[10px] font-extrabold text-ink">Tunai</span>
                                        <span class="mt-0.5 block text-[8px] font-semibold text-slate-400">Bayar di kasir</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="label" for="bookingNotes">Catatan untuk tim (opsional)</label>
                            <textarea id="bookingNotes" class="textarea min-h-20" data-booking-notes placeholder="Contoh: Milo cukup aktif, mohon gunakan sampo hypoallergenic."></textarea>
                        </div>

                        <label class="mt-3 flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-100 bg-white/50 p-3">
                            <input type="checkbox" name="terms" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-300">
                            <span class="text-[10px] font-medium leading-5 text-slate-500">Saya menyetujui syarat dan ketentuan PetCare serta memahami bahwa booking akan dikonfirmasi oleh tim melalui WhatsApp.</span>
                        </label>

                        <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                            <button type="button" class="btn btn-secondary btn-sm" data-booking-prev><i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Kembali</button>
                            <button type="button" class="btn btn-primary" data-booking-confirm>Konfirmasi Booking <i data-lucide="check" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="xl:sticky xl:top-24">
                <div class="panel panel-pad">
                    <div class="flex items-start gap-2.5">
                        <span class="icon-tile icon-tile-mint h-9 w-9 shrink-0"><i data-lucide="receipt-text" class="h-4 w-4"></i></span>
                        <div>
                            <p class="panel-title">Ringkasan Booking</p>
                            <p class="panel-subtitle">Diperbarui otomatis.</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl bg-primary-50/70 p-3">
                        <p class="text-[8px] font-extrabold uppercase tracking-wider text-primary-600/70">Layanan dipilih</p>
                        <p class="mt-1 text-[11px] font-extrabold text-primary-900" data-summary-service>Belum dipilih</p>
                        <p class="mt-0.5 text-[9px] font-semibold text-primary-800/60" data-summary-service-price>—</p>
                    </div>

                    <div class="mt-3 space-y-0.5">
                        <div class="summary-row"><span>Tanggal</span><strong data-summary-date>Belum dipilih</strong></div>
                        <div class="summary-row"><span>Jam</span><strong data-summary-time>Belum dipilih</strong></div>
                        <div class="summary-row"><span>Hewan</span><strong data-summary-pet>Belum dipilih</strong></div>
                        <div class="summary-row"><span>Pembayaran</span><strong data-summary-method>Belum dipilih</strong></div>
                    </div>

                    <div class="mt-2 flex items-end justify-between gap-2 border-t border-slate-100 pt-3">
                        <div>
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Total estimasi</p>
                            <p class="mt-0.5 text-lg font-extrabold tracking-tight text-ink" data-summary-total>Rp 0</p>
                        </div>
                        <span class="text-[8px] font-semibold text-slate-400">/ <span data-summary-unit>sesi</span></span>
                    </div>

                    <div class="mt-3 space-y-2 border-t border-slate-100 pt-3">
                        <div class="flex items-center gap-2"><i data-lucide="shield-check" class="h-3.5 w-3.5 text-primary-500"></i><p class="text-[9px] font-semibold text-slate-500">Data hewan aman & privat</p></div>
                        <div class="flex items-center gap-2"><i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-500"></i><p class="text-[9px] font-semibold text-slate-500">Konfirmasi via WhatsApp</p></div>
                        <div class="flex items-center gap-2"><i data-lucide="refresh-cw" class="h-3.5 w-3.5 text-primary-500"></i><p class="text-[9px] font-semibold text-slate-500">Reschedule gratis H-1</p></div>
                    </div>
                </div>

                <div class="panel panel-pad mt-3">
                    <p class="text-[10px] font-extrabold text-ink">Lokasi PetCare</p>
                    <p class="mt-1 text-[9px] font-semibold leading-4 text-slate-500">{{ $brand['address'] }}</p>
                    <a href="https://maps.google.com/?q=Jl.+Kemang+Raya+No.+88,+Jakarta+Selatan" target="_blank" rel="noreferrer" class="mt-2 inline-flex items-center gap-1 text-[9px] font-extrabold text-primary-700">Buka Maps <i data-lucide="arrow-right" class="h-3 w-3"></i></a>
                </div>
            </aside>
        </div>
    </div>
@endsection
