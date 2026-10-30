@extends('layouts.dashboard')

@section('title', 'Ulasan Saya')

@section('content')
    @php
        $averageRating = count($myReviews) ? collect($myReviews)->avg('rating') : 5;
        $completedServices = collect($myBookings)->unique('service')->values();
    @endphp

    <div class="page-head">
        <div>
            <h2 class="page-title">Ulasan Saya</h2>
            <p class="page-copy">Bagikan pengalaman Anda dan bantu pemilik hewan lain menemukan perawatan terbaik.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="reviewModal">
                <i data-lucide="star" class="h-3.5 w-3.5"></i>
                Tulis Ulasan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Rating Diberikan" :value="number_format($averageRating, 1, ',', '.')" trend="Dari 5" caption="rata-rata ulasan Anda" icon="star" accent="amber" />
        <x-stat-card label="Total Ulasan" :value="(string) count($myReviews)" trend="Terverifikasi" caption="dari booking selesai" icon="message-circle" accent="mint" />
        <x-stat-card label="Poin Ulasan" value="+150" trend="Bulan ini" caption="dari ulasan terakhir" icon="sparkles" accent="violet" />
        <x-stat-card label="Kontribusi" value="Top 10%" trend="Pelanggan aktif" caption="di komunitas PetCare" icon="award" accent="sky" />
    </div>

    <div class="grid items-start gap-4 xl:grid-cols-[1.4fr_0.6fr]">
        <div class="panel panel-pad">
            <div class="panel-header">
                <div>
                    <p class="panel-title">Ulasan yang Anda Tulis</p>
                    <p class="panel-subtitle">Ulasan hanya dapat ditulis untuk booking yang sudah selesai.</p>
                </div>
                <span class="badge badge-mint"><i data-lucide="badge-check" class="h-3 w-3"></i> Terverifikasi</span>
            </div>

            <div id="reviewList" class="mt-4 space-y-3">
                @forelse ($myReviews as $review)
                    <article class="testimonial-card" data-row>
                        <div class="flex items-start gap-3">
                            <x-avatar :initials="$review['initials']" :name="$review['customer']" size="md" color="mint" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-extrabold text-ink">{{ $review['customer'] }}</p>
                                <p class="mt-0.5 text-[10px] font-semibold text-slate-400">{{ $review['service'] }} · {{ $review['date'] }}</p>
                            </div>
                            <div class="rating-stars shrink-0">
                                @for ($i = 0; $i < $review['rating']; $i++)
                                    <i data-lucide="star" class="fill-current"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-3 text-xs font-medium leading-6 text-slate-600">“{{ $review['text'] }}”</p>
                        <div class="mt-3 flex items-center justify-between gap-2 border-t border-slate-100 pt-3">
                            <span class="flex items-center gap-1.5 text-[9px] font-bold text-primary-600"><i data-lucide="badge-check" class="h-3.5 w-3.5"></i> Untuk {{ $review['pet'] }}</span>
                            <button type="button" class="btn-icon h-7 w-7 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus ulasan {{ $review['service'] }}"
                                    data-delete-trigger data-name="Ulasan {{ $review['service'] }}">
                                <i data-lucide="trash-2" class="h-3 w-3"></i>
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <span class="icon-tile icon-tile-amber h-12 w-12"><i data-lucide="star" class="h-5 w-5"></i></span>
                        <p class="mt-3 text-sm font-extrabold text-ink">Belum ada ulasan</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">Setelah perawatan selesai, bagikan pengalaman Anda di sini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 rounded-xl bg-primary-50/70 p-3.5">
                <div class="flex items-start gap-2.5">
                    <i data-lucide="sparkles" class="mt-0.5 h-4 w-4 shrink-0 text-primary-600"></i>
                    <div>
                        <p class="text-[10px] font-extrabold text-primary-900">Dapatkan 50 poin per ulasan</p>
                        <p class="mt-0.5 text-[9px] font-medium leading-4 text-primary-800/70">Ulasan yang jujur membantu tim PetCare meningkatkan layanan dan memberi Anda poin tambahan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel panel-pad">
                <p class="panel-title">Ringkasan Rating</p>
                <p class="panel-subtitle">Penilaian yang Anda berikan.</p>
                <div class="mt-4 flex items-end gap-3">
                    <p class="text-4xl font-extrabold tracking-[-0.05em] text-ink">{{ number_format($averageRating, 1, ',', '.') }}</p>
                    <div class="pb-1.5">
                        <div class="rating-stars">
                            @for ($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="fill-current"></i>
                            @endfor
                        </div>
                        <p class="mt-0.5 text-[9px] font-semibold text-slate-400">dari {{ count($myReviews) }} ulasan</p>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    @foreach ([5 => 1, 4 => 0, 3 => 0, 2 => 0, 1 => 0] as $star => $count)
                        <div class="flex items-center gap-2">
                            <span class="flex w-7 items-center gap-0.5 text-[9px] font-bold text-slate-500">{{ $star }}<i data-lucide="star" class="h-2.5 w-2.5 fill-current text-amber-400"></i></span>
                            <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-amber-400" style="width: {{ count($myReviews) ? ($count / count($myReviews)) * 100 : 0 }}%"></div>
                            </div>
                            <span class="w-3 text-right text-[9px] font-bold text-slate-400">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-pad">
                <div class="flex items-start gap-3">
                    <span class="icon-tile icon-tile-mint h-10 w-10 shrink-0"><i data-lucide="heart" class="h-4.5 w-4.5"></i></span>
                    <div>
                        <p class="panel-title">Terima kasih!</p>
                        <p class="panel-subtitle">Ulasan Anda membantu kami merawat lebih dari 1.200 hewan dengan lebih baik.</p>
                    </div>
                </div>
            </div>

            <div class="panel panel-pad">
                <p class="panel-title">Punya masukan privat?</p>
                <p class="panel-subtitle">Sampaikan langsung kepada tim kami jika ada hal yang perlu diperbaiki.</p>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noreferrer" class="btn btn-secondary btn-sm mt-3 w-full justify-start">
                    <i data-lucide="message-circle" class="h-3.5 w-3.5 text-primary-600"></i>
                    Hubungi PetCare
                </a>
            </div>
        </div>
    </div>

    <x-modal id="reviewModal" title="Tulis Ulasan" subtitle="Ceritakan pengalaman Anda selama merawat hewan di PetCare.">
        <form class="space-y-3" data-review-form data-today="{{ $today_short }}">
            <div>
                <label class="label" for="reviewService">Layanan</label>
                <select id="reviewService" name="service" class="select">
                    @forelse ($completedServices as $booking)
                        <option value="{{ $booking['service'] }}">{{ $booking['service'] }} · {{ $booking['pet'] }} ({{ $booking['date'] }})</option>
                    @empty
                        <option value="Grooming">Grooming</option>
                    @endforelse
                </select>
            </div>

            <div>
                <span class="label">Rating</span>
                <div class="flex items-center gap-1 rounded-xl border border-slate-200 bg-white/70 px-3 py-2.5" data-star-rating>
                    <input type="hidden" name="rating" value="5">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" data-star-value="{{ $i }}" aria-label="{{ $i }} bintang" aria-pressed="{{ $i === 5 ? 'true' : 'false' }}" class="rounded p-0.5 text-slate-300 transition hover:scale-110">
                            <i data-lucide="star" class="h-6 w-6"></i>
                        </button>
                    @endfor
                    <span class="ml-2 text-[10px] font-bold text-slate-400">Pilih bintang</span>
                </div>
            </div>

            <div>
                <label class="label" for="reviewText">Ulasan Anda</label>
                <textarea id="reviewText" name="review" class="textarea min-h-28" placeholder="Apa yang membuat Anda puas? Bagaimana pengalaman hewan Anda?"></textarea>
                <p class="mt-1 text-[9px] font-semibold text-slate-400">Mohon hindari informasi pribadi yang sensitif.</p>
            </div>

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="send" class="h-3.5 w-3.5"></i> Kirim Ulasan</button>
            </div>
        </form>
    </x-modal>
@endsection
