
# Sistem Informasi Akademik TK Al-Ikhlas Taliwang

Sistem Informasi Akademik berbasis web untuk membantu pengelolaan data akademik di TK Al-Ikhlas Taliwang.

## Teknologi

- Laravel 12
- PHP 8.2
- MySQL
- Bootstrap
- HTML, CSS, JavaScript

## Fitur

- Pengelolaan data siswa
- Pengelolaan data guru
- Pengelolaan kelas
- Presensi harian siswa
- Pengelolaan data akademik
- Cetak laporan perkembangan siswa dalam format PDF
- Dashboard berdasarkan hak akses pengguna

## Hak Akses

- Admin
- Guru
- Kepala Sekolah

## Instalasi

1. Clone repository.
2. Install dependency:

   ```bash
   composer install
   ```

3. Salin `.env.example` menjadi `.env`.
4. Sesuaikan konfigurasi database pada `.env`.
5. Generate application key:

   ```bash
   php artisan key:generate
   ```

6. Jalankan migrasi database:

   ```bash
   php artisan migrate
   ```

7. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

## Database

Gunakan database MySQL dengan nama:

`siakad_tk_alikhlas`

Pastikan database sudah dibuat sebelum menjalankan migrasi.
