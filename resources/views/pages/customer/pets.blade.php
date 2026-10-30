@extends('layouts.dashboard')

@section('title', 'Hewan Saya')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Hewan Saya</h2>
            <p class="page-copy">Profil lengkap Milo dan Luna agar perawatan selalu tepat.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn-primary btn-sm" data-modal-open="petModal" data-modal-reset="true" data-modal-title-text="Tambah Hewan">
                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                Tambah Hewan
            </button>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Hewan Terdaftar" :value="(string) count($myPets)" trend="Aktif" caption="Milo & Luna" icon="paw-print" accent="mint" />
        <x-stat-card label="Kunjungan Berikutnya" value="31 Okt" trend="10.00 WIB" caption="Grooming Luna" icon="calendar-check" accent="sky" />
        <x-stat-card label="Total Kunjungan" value="8" trend="+2" caption="bulan ini" icon="history" accent="violet" />
        <x-stat-card label="Poin Terkumpul" value="1.250" trend="+120" caption="dari booking terakhir" icon="sparkles" accent="amber" />
    </div>

    <div class="mt-4 grid gap-4 md:grid-cols-2">
        @foreach ($myPets as $pet)
            <article class="panel overflow-hidden" data-row>
                <div class="relative h-52 overflow-hidden sm:h-60">
                    <img src="{{ asset($pet['photo']) }}" alt="{{ $pet['name'] }}" class="h-full w-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/5 to-transparent"></div>
                    <span class="absolute left-4 top-4 badge {{ $pet['species'] === 'Anjing' ? 'badge-sky' : 'badge-violet' }} bg-white/90 backdrop-blur">{{ $pet['species'] }}</span>
                    <div class="absolute inset-x-4 bottom-4 flex items-end justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-extrabold tracking-tight text-white">{{ $pet['name'] }}</h3>
                            <p class="mt-0.5 text-[10px] font-semibold text-white/70">{{ $pet['breed'] }} · {{ $pet['age'] }}</p>
                        </div>
                        <span class="badge badge-mint bg-white/90"><span class="badge-dot"></span>{{ $pet['status'] }}</span>
                    </div>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Gender</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-ink">{{ $pet['gender'] }}</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Berat</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-ink">{{ $pet['weight'] }}</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-slate-400">Usia</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-ink">{{ $pet['age'] }}</p>
                        </div>
                    </div>

                    <div class="mt-3 rounded-xl border border-amber-100 bg-amber-50/60 p-3">
                        <div class="flex items-start gap-2">
                            <i data-lucide="heart" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-amber-600"></i>
                            <p class="text-[10px] font-medium leading-4 text-amber-900/75">{{ $pet['notes'] }}</p>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="rounded-lg bg-primary-50/65 px-2.5 py-2">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-primary-600/65">Kunjungan terakhir</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-primary-900">{{ $pet['last_visit'] }}</p>
                        </div>
                        <div class="rounded-lg bg-sky-50/70 px-2.5 py-2">
                            <p class="text-[8px] font-extrabold uppercase tracking-wider text-sky-600/65">Berikutnya</p>
                            <p class="mt-0.5 text-[10px] font-extrabold text-sky-900">{{ $pet['next_visit'] }}</p>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap items-center gap-1.5 border-t border-slate-100 pt-3">
                        <a href="{{ route('customer.booking', ['pet' => $pet['name']]) }}" class="btn btn-primary btn-sm">
                            <i data-lucide="calendar-check" class="h-3.5 w-3.5"></i> Booking
                        </a>
                        <button type="button" class="btn-icon h-8 w-8" aria-label="Edit {{ $pet['name'] }}"
                                data-edit-record data-edit-modal="petModal" data-edit-title="Edit Hewan"
                                data-name="{{ $pet['name'] }}" data-species="{{ $pet['species'] }}"
                                data-breed="{{ $pet['breed'] }}" data-age="{{ $pet['age'] }}"
                                data-gender="{{ $pet['gender'] }}" data-weight="{{ $pet['weight'] }}"
                                data-notes="{{ $pet['notes'] }}">
                            <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                        </button>
                        <button type="button" class="btn-icon ml-auto h-8 w-8 hover:border-rose-200 hover:text-rose-600" aria-label="Hapus {{ $pet['name'] }}"
                                data-delete-trigger data-name="{{ $pet['name'] }}">
                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                        </button>
                    </div>
                </div>
            </article>
        @endforeach

        <button type="button" class="group flex min-h-64 flex-col items-center justify-center rounded-3xl border-2 border-dashed border-primary-200 bg-white/35 p-6 text-center transition hover:border-primary-400 hover:bg-primary-50/40"
                data-modal-open="petModal" data-modal-reset="true" data-modal-title-text="Tambah Hewan">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-primary-50 text-primary-600 transition group-hover:scale-105">
                <i data-lucide="plus" class="h-6 w-6"></i>
            </span>
            <p class="mt-3 text-sm font-extrabold text-ink">Tambah hewan baru</p>
            <p class="mt-1 max-w-xs text-[10px] font-medium leading-5 text-slate-500">Simpan profil hewan agar tim PetCare bisa menyiapkan perawatan yang paling sesuai.</p>
        </button>
    </div>

    <div class="panel panel-pad mt-4">
        <div class="flex items-start gap-3">
            <span class="icon-tile icon-tile-mint h-10 w-10 shrink-0"><i data-lucide="circle-help" class="h-4.5 w-4.5"></i></span>
            <div>
                <p class="panel-title">Kenapa profil hewan penting?</p>
                <p class="panel-subtitle">Catatan alergi, kebiasaan, dan kondisi khusus membantu groomer dan dokter hewan memberikan penanganan yang lebih aman dan personal.</p>
            </div>
        </div>
    </div>

    <x-modal id="petModal" title="Tambah Hewan" subtitle="Lengkapi profil hewan kesayangan Anda." title-attribute>
        <form class="space-y-3" data-demo-form data-success-message="Profil hewan berhasil disimpan (mode demo).">
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="myPetName">Nama hewan</label>
                    <input id="myPetName" name="name" type="text" class="input" placeholder="Contoh: Milo" required>
                </div>
                <div>
                    <label class="label" for="myPetSpecies">Spesies</label>
                    <select id="myPetSpecies" name="species" class="select">
                        <option value="Anjing">Anjing</option>
                        <option value="Kucing">Kucing</option>
                    </select>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="myPetBreed">Ras</label>
                    <input id="myPetBreed" name="breed" type="text" class="input" placeholder="Golden Retriever">
                </div>
                <div>
                    <label class="label" for="myPetAge">Usia</label>
                    <input id="myPetAge" name="age" type="text" class="input" placeholder="3 tahun">
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="label" for="myPetGender">Gender</label>
                    <select id="myPetGender" name="gender" class="select">
                        <option value="Jantan">Jantan</option>
                        <option value="Betina">Betina</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="myPetWeight">Berat</label>
                    <input id="myPetWeight" name="weight" type="text" class="input" placeholder="28 kg">
                </div>
            </div>
            <div>
                <label class="label" for="myPetNotes">Catatan khusus</label>
                <textarea id="myPetNotes" name="notes" class="textarea min-h-20" placeholder="Alergi, kebiasaan, atau kondisi khusus..."></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check" class="h-3.5 w-3.5"></i> Simpan Hewan</button>
            </div>
        </form>
    </x-modal>
@endsection
