# Alumnet (Alumni Network)

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**Alumnet** adalah platform Sistem Informasi Jejaring Alumni yang komprehensif, dirancang untuk menghubungkan kembali alumni dengan universitas, memfasilitasi pengembangan karir, dan menyediakan data Tracer Study yang akurat.

---

## 📋 Analisis & Studi Kasus (Problem Solving)

Project ini dibangun untuk menyelesaikan permasalahan utama dalam manajemen alumni:

### 1. Kehilangan Jejak Alumni (Tracer Study)
*   **Masalah**: Universitas kesulitan melacak status karir alumni terbaru, mengakibatkan data akreditasi yang tidak valid.
*   **Solusi**: **Digital Tracer Study** dengan akses publik (via NIM) dan privat. Data tersentralisasi dan dapat diekspor ke Excel untuk pelaporan.
*   **Flow**: Alumni mengisi kuesioner `FormQ1` -> Data disimpan di `respon_kuesioner` -> Validasi NIM & Tahun Lulus (2015-2020) -> Admin mengekspor data.

### 2. Sentralisasi Event & Karir
*   **Masalah**: Informasi event reuni, seminar, atau lowongan kerja seringkali tersebar tidak merata di media sosial.
*   **Solusi**: **Event Management System** dengan integrasi pembayaran.
*   **Flow**: Admin post event (Loker/Seminar) -> Alumni register -> Pembayaran via Midtrans (jika berbayar) -> QR Code Ticket digenerate -> Check-in event.

### 3. Engagement & Networking
*   **Masalah**: Kurangnya wadah komunikasi real-time antar alumni lintas angkatan.
*   **Solusi**: **Group Chat** dengan fitur media share dan mentions (@user), serta direktori alumni.

---

## 🚀 Fitur Utama & Logika Bisnis

### 1. Manajemen Event & Tiket (Payment Gateway)
Fitur unggulan dengan integrasi **Midtrans Snap**.
*   **Pendaftaran**: User mendaftar event -> Sistem mengecek `harga_daftar`.
    *   *Gratis*: Status langsung `berhasil`.
    *   *Berbayar*: Status `menunggu`, sistem membuat invoice di `pembayaran_event`.
*   **Pembayaran**: Menggunakan pop-up Snap Midtrans. Webhook (`MidtransNotificationController`) menangani status callback:
    *   `capture`/`settlement` -> Update status pendaftaran jadi `berhasil`.
    *   `expire`/`deny`/`cancel` -> Update status pendaftaran jadi `gagal`.
*   **QR Code**: Setiap event memiliki link unik yang digenerate menjadi QR Code menggunakan `simplesoftwareio/simple-qrcode`.

### 2. Tracer Study (Kuesioner)
*   **Public Access**: Alumni dapat mengisi kuesioner tanpa login dengan validasi NIM dan Tahun Lulus (2015-2020).
*   **Private Access**: Alumni login dapat mengisi dan melihat riwayat kuesioner.
*   **Reporting**: Dashboard Admin menampilkan statistik partisipasi per tahun dan per jurusan, serta rasio responden.

### 3. Group Chat System
*   **Real-time Messaging**: Mendukung pesan teks dan upload media (Gambar/Video).
*   **Mentions**: Mendukung tagging user menggunakan format `@username` yang diproses via Regex di backend.
*   **Search Users**: Endpoint API untuk autocomplete nama user saat mengetik mention.

### 4. Role-Based Access Control (RBAC)
*   **Admin**: Full akses ke Dashboard, Manajemen User (Approval), Event CRUD, Export Data.
*   **Alumni**: Akses ke Profil, Event (View/Register), Tracer Study, Group Chat.
*   **Status Approval**: User baru mendaftar dengan status `pending` dan harus di-`approve` oleh Admin sebelum bisa login sepenuhnya.

---

## 📂 Struktur Folder Proyek

Struktur folder utama yang relevan dengan pengembangan:

```
Alumni-Network/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/               # Login (Google/Local), Register
│   │   │   ├── Dashboard/          # DashboardController, EventController, UserSettingController
│   │   │   ├── EventUserController.php # Logika pendaftaran event sisi user
│   │   │   ├── FormQ1Controllers.php   # Logika kuesioner tracer study
│   │   │   ├── GroupChatController.php # Logika chat & media handling
│   │   │   ├── MidtransNotificationController.php # Callback pembayaran
│   │   │   └── ...
│   ├── Models/                     # User, ProfilAlumni, Event, ResponKuesioner, Message
│   └── ...
├── database/
│   ├── migrations/                 # Definisi skema database lengkap
├── resources/
│   ├── views/
│   │   ├── pages/                  # Halaman frontend (Home, Chat, Kuesioner)
│   │   ├── event/                  # Views terkait event (index, order, bayar)
│   │   └── dashboard/              # Views admin dashboard
├── routes/
│   └── web.php                     # Definisi seluruh rute aplikasi
└── storage/
    └── app/public/images/          # Penyimpanan upload (Event headers, Chat media)
```

---

## 💾 Skema Database (Database Schema)

Berikut adalah tabel-tabel utama dalam database:

### Users & Profiles
*   **`users`**: `id`, `nama`, `email`, `password`, `role` (admin/alumni), `status` (pending/approved), `foto`.
*   **`profil_alumni`**: `user_id`, `nim`, `jurusan`, `tahun_masuk`, `tahun_lulus`, `ipk`, `linkedin`, `no_telepon`.
*   **`profil_admin`**: `user_id`, `jabatan`, `no_telepon`.

### Event & Transactions
*   **`event_pengembangan_karir`**: `id`, `judul`, `deskripsi`, `harga_daftar`, `kuota`, `tipe` (loker/event), `foto`, `link` (QR).
*   **`pendaftaran_event`**: `id`, `event_id`, `user_id`, `status` (menunggu/berhasil), `timestamps`.
*   **`pembayaran_event`**: `id`, `pendaftaran_event_id`, `midtrans_transaction_id`, `jumlah`, `status_pembayaran`, `waktu_pembayaran`.

### Tracer Study
*   **`event_kuesioner`**: `id`, `judul`, `tahun_lulusan`.
*   **`respon_kuesioner`**: `id`, `event_kuesioner_id`, `user_id`, `jawaban` (JSON).

### Communication
*   **`messages`**: `id`, `user_id`, `message`, `media_path`, `mentioned_user_id`.

---

## 🔌 Dokumentasi Endpoint (Routes)

Seluruh rute didefinisikan di `routes/web.php`. Berikut adalah endpoint kuncinya:

### 🌍 Public & Auth
| Method | URL | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/` | Homepage |
| `GET` | `/login` | Form Login |
| `GET` | `/login/google` | Login dengan Google OAuth |
| `POST` | `/register` | Registrasi Akun |

### 🎓 Tracer Study
| Method | URL | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/pengisian-tracer-study` | Portal Tracer Study |
| `GET` | `/search-by-nim/{nim}` | API Pencarian Alumni by NIM |
| `POST` | `/pengisian-tracer-study/...` | Submit Kuesioner |

### � Event System (User)
| Method | URL | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/event-user` | List Event & Karir |
| `POST` | `/event-user/daftar/{id}` | Daftar Event (Create Invoice) |
| `GET` | `/event-user/order/{id}` | Halaman Order/Bayar |
| `POST` | `/midtrans/notification` | Webhook Midtrans (No Auth) |

### � Group Chat
| Method | URL | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/group-chat` | Halaman Chat |
| `POST` | `/group-chat/store` | Kirim Pesan/Media |
| `GET` | `/group-chat/messages` | Load Messages (JSON) |
| `GET` | `/users/search` | Search User for Mention |

### � Dashboard (Admin)
| Method | URL | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/dashboard` | Dashboard Statistik |
| `RESOURCE` | `/dashboard/member/alumni` | Manajemen Alumni |
| `RESOURCE` | `/dashboard/member/users` | Manajemen User Approval |
| `RESOURCE` | `/dashboard/events` | Manajemen Event (CRUD) |
| `GET` | `/dashboard/alumni-career-status` | API Statistik Karir |

---

## 💻 Instalasi & Setup

### Persyaratan Sistem
*   PHP ^8.2
*   Composer
*   Node.js & NPM
*   MySQL

### Langkah Instalasi

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/Start-Z/Alumniset.git
    cd Alumniset/Alumni-Network
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file contoh `.env` dan sesuaikan konfigurasinya:
    ```bash
    cp .env.example .env
    ```
    Atur variabel berikut di `.env`:
    ```env
    DB_DATABASE=alumnet_db
    DB_USERNAME=root
    DB_PASSWORD=

    # Midtrans Configuration
    MIDTRANS_SERVER_KEY=your-server-key
    MIDTRANS_CLIENT_KEY=your-client-key
    MIDTRANS_IS_PRODUCTION=false

    # Google OAuth
    GOOGLE_CLIENT_ID=your-google-client-id
    GOOGLE_CLIENT_SECRET=your-google-client-secret
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database**
    ```bash
    php artisan migrate
    ```

6.  **Build Frontend**
    ```bash
    npm run build
    ```

7.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di: `http://localhost:8000`

---

## 🤝 Kontribusi & Lisensi

Dikembangkan oleh **Afwan Gibran Muhammad Algiffari**.
Code dilisensikan di bawah **MIT License**.
