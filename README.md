# PetCare

Website layanan perawatan hewan peliharaan dengan antarmuka **Glassmorphism 2.0** yang modern, hangat, dan profesional. Proyek ini dibangun menggunakan Laravel 12, Blade, Tailwind CSS 4, dan JavaScript tanpa framework frontend tambahan.

> **Status: Batch 1 — Frontend UI selesai.**
> Autentikasi dan backend belum diimplementasikan. Seluruh halaman saat ini menggunakan data demo dari `config/demo.php`. Halaman `/masuk` dan `/daftar` masih berupa placeholder dengan tautan langsung ke dashboard demo.

## Fitur

### Halaman Publik
- Landing page dengan hero, layanan unggulan, alur pemesanan, testimoni, dan CTA.
- Katalog layanan dan enam halaman detail layanan.
- Navigasi responsif, footer, dan halaman autentikasi placeholder.

### Dashboard Admin
- Ringkasan operasional, grafik pendapatan, dan aktivitas terbaru.
- Manajemen pelanggan, karyawan, hewan, layanan, dan booking.
- Detail booking, pembayaran, laporan, serta pengaturan.
- Pencarian, filter, pagination, modal tambah/edit, dan konfirmasi hapus.

### Dashboard Karyawan
- Ringkasan tugas harian dan jadwal kerja.
- Jadwal, daftar booking, detail booking, riwayat pekerjaan, dan profil.

### Dashboard Pelanggan
- Ringkasan hewan, booking aktif, dan poin membership.
- Manajemen hewan peliharaan.
- Katalog layanan dan detail layanan.
- Wizard booking empat langkah dengan pemilihan hewan, jadwal, dan metode pembayaran.
- Halaman konfirmasi booking, riwayat booking, pembayaran, ulasan, dan profil.

### Pengalaman Responsif
- Sidebar berubah menjadi drawer pada perangkat kecil.
- Bottom navigation khusus dashboard pelanggan.
- Tabel berubah menjadi kartu pada layar kecil.
- Form booking tersusun vertikal dan navbar bebas overflow.

## Teknologi

- **Backend:** Laravel 12, PHP 8.2+
- **Database:** MySQL 5.7+
- **Templating:** Blade
- **Styling:** Tailwind CSS 4, Vite 6
- **Interaksi:** JavaScript (vanilla)
- **Visualisasi:** Chart.js
- **Ikon:** Lucide
- **Font:** Plus Jakarta Sans

## Akses Demo

Autentikasi belum aktif. Gunakan tautan berikut untuk melihat setiap dashboard:

| Peran | URL | Identitas Demo |
| --- | --- | --- |
| Admin | `/admin/dashboard` | Admin PetCare |
| Karyawan | `/staff/dashboard` | Nadia Groomer |
| Pelanggan | `/customer/dashboard` | Rina Pratama |

## Instalasi

### Prasyarat
- PHP 8.2 atau lebih baru
- Composer
- Node.js 18+ dan npm
- MySQL 5.7+

### Langkah

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database pada `.env`, lalu buat database `petcare`:

```bash
php artisan migrate
npm install
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`.

Untuk pengembangan frontend dengan hot reload:

```bash
npm run dev
```

## Struktur Penting

```text
app/Http/Controllers/DemoController.php   # Data dan logika seluruh halaman demo
config/demo.php                           # Sumber data dummy terpusat
routes/web.php                            # Peta route publik, admin, staff, customer
resources/views/pages/                    # Halaman per peran
resources/views/layouts/                  # Layout publik dan dashboard
resources/css/app.css                     # Design system dan aturan responsif
resources/js/ui.js                        # Modal, filter, tabel, dan interaksi umum
resources/js/booking.js                   # State dan validasi wizard booking
public/images/                            # Aset gambar lokal
```

## Catatan Pengembangan

- Data demo bersifat terpusat dan belum disimpan ke database.
- Belum ada integrasi payment gateway; pembayaran masih berupa alur demo.
- Seluruh gambar disimpan lokal di `public/images`.
- Build produksi berada di `public/build` dan tidak di-commit (lihat `.gitignore`).

## Rencana Berikutnya

- [ ] UI login dan registrasi
- [ ] Autentikasi serta otorisasi berbasis peran
- [ ] Backend dan persistensi database
- [ ] Integrasi pembayaran
- [ ] Pengujian menyeluruh

---

© 2026 PetCare.
