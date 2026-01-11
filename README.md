# 📦 Sistem Inventaris Casa Market

Casa Market adalah aplikasi manajemen inventaris berbasis web yang dirancang untuk mempermudah UMKM dalam mengelola stok barang, kategori produk, serta memantau margin harga secara efisien. Proyek ini dibangun menggunakan arsitektur PHP modern dengan keamanan data sebagai prioritas utama.

# 🚀 Fitur Utama

**Autentikasi Keamanan**: Sistem Login menggunakan enkripsi password_hash() dan proteksi session di setiap halaman dashboard.
**Manajemen Inventaris (CRUD)**:
**Create**: Input barang dengan kategori, stok, harga beli, dan harga jual.
**Read**: Daftar barang dengan fitur pencarian, filter per kategori, dan pagination.
**Update**: Pembaruan data barang secara real-time.
**Delete**: Penghapusan data dengan konfirmasi.
**Dashboard Interaktif**: Indikator visual stok kritis (berwarna merah jika stok di bawah 10).
**Halaman Tim Dinamis**: Menampilkan profil pengembang yang diambil dari database dengan efek animasi staggered dan penyimpanan foto format LONGBLOB.

# 🛠️ Teknologi yang Digunakan

**Backend**: PHP 8.x (PDO MySQL Driver)
**Database**: MySQL
**Frontend**: Bootstrap 5.3, Bootstrap Icons
**Animasi**: CSS3 Custom Keyframes (Fade-up effect)

# 📁 Struktur Folder

```plaintext

casa_market/
├── dashboard/           # Halaman operasional (Index, About, Edit, Tambah)
├── layout/              # Template komponen (Header & Footer)
├── img/                 # Aset gambar statis
├── index.php            # Entry point (Sistem Redirect)
├── login.php            # Halaman Login
├── proses_login.php     # Logika keamanan autentikasi
├── logout.php           # Penghancuran session user
├── koneksi.php          # Konfigurasi database PDO
└── README.md            # Dokumentasi Proyek
```

# ⚙️ Instalasi & Konfigurasi

1. Persiapan Database
   Buat database baru bernama casa_market di phpMyAdmin, lalu jalankan query berikut:

```SQL
-- 1. Tabel Kategori
CREATE TABLE kategori (
    id_kategori INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL
);

-- 2. Tabel Produk
CREATE TABLE produk (
    id_produk INT PRIMARY KEY AUTO_INCREMENT,
    nama_barang VARCHAR(255) NOT NULL,
    id_kategori INT,
    stok INT DEFAULT 0,
    harga_beli DECIMAL(10,2),
    harga_jual DECIMAL(10,2),
    satuan VARCHAR(50),
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE SET NULL
);

-- 3. Tabel Users
CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100)
);

-- 4. Tabel Tim
CREATE TABLE tim (
    id_anggota INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    role VARCHAR(50) NOT NULL,
    foto LONGBLOB
);

-- Masukkan User Admin Default (Password: raihan)
INSERT INTO users (username, password, nama_lengkap)
VALUES ('admin', '$2y$10$wzJZUemTf2CxsYFz6korn.HAbcZ9fUkjqIF6kaSEvPmRB.QO12/yW', 'Administrator');
```

2. Konfigurasi Koneksi
   Buka file koneksi.php dan pastikan pengaturan sesuai dengan environment Anda:

```PHP
$host = 'localhost';
$db   = 'casa_market';
$user = 'root';
$pass = ''; // Sesuaikan jika ada password database
```

# 👥 Tim Pengembang

Setiap anggota memiliki peran spesifik dalam pengembangan sistem ini:
Project Manager: Mengoordinasi jadwal dan alur sistem.
Fullstack Developer: Mengembangkan logika PHP dan integrasi database.
Database Administrator: Merancang skema tabel dan relasi data.
UI/UX Designer: Merancang tampilan menggunakan Bootstrap.
Quality Assurance: Melakukan testing keamanan dan fungsionalitas.

# 🔑 Akses Login

```PHP
URL: http://localhost/casa_market/
Username: admin
Password: raihan
```

Proyek ini dikembangkan untuk memenuhi tugas mata kuliah Dasar Pemrograman - 2026.
