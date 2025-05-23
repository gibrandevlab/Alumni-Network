## ⚠️ Disclaimer

This project is licensed under the MIT License for educational and personal use only. Unauthorized use for academic assignments (e.g., copying for university final projects) or any form of copying, distribution, or modification without written permission from the developer is strictly prohibited.

# Alumni Network

Aplikasi web Alumni Network adalah platform berbasis Laravel yang digunakan untuk mengelola data alumni, event, kuesioner, dan pengembangan karir. Aplikasi ini mendukung pengelolaan event, pembayaran, pengisian kuesioner, serta komunikasi antara alumni dan admin.

## Fitur Utama
- Manajemen data alumni
- Pengelolaan event dan pendaftaran
- Pembayaran event
- Kuesioner tracer study
- Pengembangan karir alumni
- Sistem autentikasi dan otorisasi
- Dashboard admin dan alumni

## Teknologi yang Digunakan
- Laravel (Backend)
- Vite (Frontend build tool)
- Tailwind CSS (Styling)
- PHP
- MySQL/SQLite
- npm (Node Package Manager)

## Instalasi
1. Clone repository ini:
   ```bash
   git clone <repository-url>
   cd Alumni-Network
   ```
2. Install dependency PHP:
   ```bash
   composer install
   ```
3. Install dependency JavaScript:
   ```bash
   npm install
   ```
4. Salin file environment:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```

## Menjalankan Aplikasi
- Jalankan server Laravel:
  ```bash
  php artisan serve
  ```
- Jalankan Vite dev server:
  ```bash
  npm run dev
  ```

Akses aplikasi di `http://localhost:8000`.

## Struktur Direktori
- `app/` - Kode utama aplikasi (model, controller, middleware)
- `routes/` - File routing aplikasi
- `resources/views/` - Blade template
- `public/` - Public assets
- `database/` - Migrasi, seeder, dan file database

## Testing
Jalankan unit test dengan:
```bash
php artisan test
```

## Kontribusi
Pull request dan issue sangat diterima untuk pengembangan lebih lanjut.

## Lisensi
Aplikasi ini menggunakan lisensi MIT.

## Kontak
Pengembang: Afwan Gibran Muhammad Algiffari
Email: @afwangibran19@gmail.com
