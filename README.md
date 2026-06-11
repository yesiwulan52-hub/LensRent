# 📷 LensRent — Sistem Penyewaan Kamera Berbasis Website

LensRent adalah platform penyewaan kamera berbasis web yang dirancang untuk mempermudah proses pemesanan kamera secara online. Sistem ini memungkinkan pelanggan melihat daftar kamera yang tersedia, memesan unit yang diinginkan, dan mengelola transaksi penyewaan tanpa harus datang langsung ke lokasi.

Selain membantu pelanggan, LensRent juga menyediakan fitur manajemen lengkap bagi admin untuk mengelola inventaris kamera, memantau stok, mengelola data penyewaan, serta mengatur ketersediaan unit secara real-time.

---

**Dibuat oleh:** Yesi Wulan Novitri Ardiyanti - 242410101036

**Program Studi Sistem Informasi — Fakultas Ilmu Komputer — Universitas Jember**

**Video Demo:** https://youtu.be/UAuHHXUdYVk

---

## 🎯 Tujuan Pengembangan

LensRent dikembangkan untuk:

- Mempermudah pelanggan dalam melakukan pemesanan kamera secara online tanpa perlu hadir langsung.
- Mengurangi risiko kesalahan pencatatan melalui sistem manajemen transaksi terpusat.
- Membantu pengelola dalam memantau stok dan ketersediaan kamera secara akurat.
- Menyediakan pencatatan transaksi yang lebih terstruktur dan mudah dikelola.
- Mendukung digitalisasi layanan penyewaan kamera agar lebih modern dan efisien.

---

## ✨ Fitur Utama

### 👤 Fitur Pengguna (Customer)

**Autentikasi**
- Registrasi akun baru
- Login dan logout
- Lupa password

**Kamera**
- Melihat daftar kamera yang tersedia beserta detail lengkap (kode, nama, kategori, harga, stok)
- Menyewa kamera dengan mengisi data penyewa, tanggal sewa & kembali, serta metode pembayaran

**Transaksi**
- Melihat daftar transaksi sewa milik sendiri
- Membatalkan transaksi yang masih aktif

**Profil**
- Melihat dan mengedit data profil akun

---

### 👨‍💼 Fitur Admin

**Autentikasi**
- Login dan logout

**Profil**
- Melihat dan mengedit data profil akun
- Menghapus akun

**Manajemen Kamera**
- Menambah kamera baru (kode, nama, kategori, jumlah stok, harga, foto)
- Mengubah data kamera
- Menghapus data kamera
- Toggle status ketersediaan kamera secara langsung
- Pencarian kamera berdasarkan nama atau kode

**Manajemen Transaksi**
- Melihat seluruh transaksi dari semua pengguna
- Membatalkan transaksi penyewaan
- Monitoring transaksi berdasarkan status

---

## 🛠️ Teknologi yang Digunakan

**Backend**
- **PHP 8.3** — Bahasa pemrograman utama untuk membangun logika bisnis aplikasi
- **Laravel 13** — Framework PHP untuk routing, middleware, autentikasi, Eloquent ORM, dan manajemen keamanan

**Frontend**
- **Blade Template Engine** — Template engine bawaan Laravel untuk tampilan dinamis
- **Tailwind CSS 3** — Framework CSS utility-first untuk tampilan yang responsif dan modern
- **Alpine.js 3** — Framework JavaScript ringan untuk interaktivitas UI

**Database**
- **SQLite** *(default)* — Database file-based bawaan, tidak perlu konfigurasi server terpisah
- **MySQL** *(opsional)* — Dapat digunakan untuk lingkungan produksi

**Tools Development**
- **Laravel Breeze** — Starter kit autentikasi (login, registrasi, reset password)
- **Vite** — Build tool frontend untuk development dan production
- **GitHub** — Repositori source code dan version control

---

## 🗄️ Struktur Database

LensRent menggunakan database relasional dengan tabel-tabel utama berikut:

| Tabel | Keterangan |
|-------|------------|
| `users` | Menyimpan data akun pengguna dan administrator |
| `kameras` | Menyimpan data inventaris kamera (kode, nama, kategori, stok, harga, foto, status) |
| `sewas` | Mencatat seluruh transaksi penyewaan kamera |
| `kamera_sewa` | Tabel pivot relasi many-to-many antara kamera dan transaksi sewa |

---

## 🔐 Akun Akses Default (Seeder)

Jalankan seeder untuk mendapatkan akun bawaan:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@lensrent.com | password |
| **Customer** | *(digenerate otomatis via Faker)* | password |

> Semua akun hasil seeder menggunakan password: `password`

---

## ⚙️ Persyaratan Sistem

| Komponen | Versi Minimum |
|----------|---------------|
| PHP | 8.3 |
| Composer | 2.x |
| Node.js | 18.x |
| NPM | 9.x |

> **Database:** Secara default menggunakan **SQLite** — tidak perlu instalasi server database terpisah.

---

## 🚀 Instalasi & Menjalankan Aplikasi

### 1. Clone Repository

```bash
git clone https://github.com/yesiwulan52-hub/LensRent.git
cd LensRent
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Salin File Konfigurasi Environment

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database

```bash
php artisan migrate
```

> Perintah ini akan membuat file database SQLite di `database/database.sqlite` secara otomatis.

### 6. Isi Data Awal (Seeder)

```bash
php artisan db:seed
```

> Akan membuat **1 akun admin**, **50 akun customer** (Faker), dan data kamera bawaan.

### 7. Install Dependensi JavaScript

```bash
npm install
```

### 8. Jalankan Aplikasi

Buka **dua terminal** secara bersamaan:

**Terminal 1 — Laravel Development Server:**
```bash
php artisan serve
```

**Terminal 2 — Vite Asset Bundler:**
```bash
npm run dev
```

Aplikasi dapat diakses di: **http://localhost:8000**

---

## 🏗️ Build untuk Production

```bash
npm run build
php artisan serve
```

---

## 🗃️ Konfigurasi Database MySQL (Opsional)

Secara default aplikasi menggunakan SQLite. Untuk beralih ke **MySQL**, ubah bagian berikut di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lensrent
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database terlebih dahulu, kemudian jalankan ulang migrasi:

```bash
php artisan migrate
```

---

## 📋 Perintah Artisan Berguna

```bash
# Melihat semua route yang terdaftar
php artisan route:list

# Membersihkan seluruh cache aplikasi
php artisan optimize:clear

# Reset dan isi ulang database dari awal
php artisan migrate:fresh --seed

# Membuka Laravel Tinker (REPL interaktif)
php artisan tinker
```

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik sebagai tugas mata kuliah di Program Studi Sistem Informasi, Universitas Jember. Penggunaan dan modifikasi diperbolehkan untuk tujuan pendidikan dengan tetap mencantumkan kredit kepada pengembang.
