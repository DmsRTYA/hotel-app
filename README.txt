====================================================================
  THE GRAND ARCADIA — SISTEM RESERVASI HOTEL
  README & PANDUAN INSTALASI
====================================================================

DAFTAR FILE:
  ├── index.php           → Halaman utama (form + daftar pemesanan)
  ├── proses.php          → Memproses input form (INSERT ke DB)
  ├── edit.php            → Halaman edit data pemesanan (UPDATE)
  ├── hapus.php           → Menghapus data pemesanan (DELETE)
  ├── koneksi.php         → Koneksi ke database MySQL
  ├── setup_database.sql  → Script SQL untuk membuat database & tabel
  └── README.txt          → File ini

====================================================================
LANGKAH INSTALASI
====================================================================

LANGKAH 1 — Siapkan Database
  1. Buka phpMyAdmin (http://localhost/phpmyadmin)
  2. Klik tab "SQL"
  3. Salin semua isi file "setup_database.sql"
  4. Klik "Go" / "Jalankan"
  → Database "hotel_booking" dan tabel "pemesanan" akan dibuat otomatis.

LANGKAH 2 — Sesuaikan koneksi.php
  Buka file koneksi.php dan ubah baris berikut:
  
    $host     = "localhost";      ← biasanya tidak perlu diubah
    $username = "root";           ← username MySQL Anda
    $password = "";               ← password MySQL Anda
    $database = "hotel_booking";  ← nama database (sesuai langkah 1)

LANGKAH 3 — Letakkan di Web Server
  Copy seluruh folder ke:
    XAMPP  → C:/xampp/htdocs/hotel_booking/
    WAMP   → C:/wamp/www/hotel_booking/
    LAMP   → /var/www/html/hotel_booking/

LANGKAH 4 — Akses di Browser
  Buka browser dan ketik:
    http://localhost/hotel_booking/index.php

====================================================================
FITUR YANG TERSEDIA
====================================================================
  ✅ Formulir pemesanan lengkap (nama, email, HP, identitas, dll.)
  ✅ Pilih jenis kamar dengan kartu visual interaktif
  ✅ Kalkulasi harga otomatis (real-time di browser)
  ✅ Simpan data ke database secara langsung (real-time)
  ✅ Tabel daftar seluruh pemesanan
  ✅ Edit data pemesanan (termasuk recalculate harga)
  ✅ Hapus data dengan modal konfirmasi
  ✅ Badge status pemesanan berwarna
  ✅ Statistik ringkas (total reservasi, check-in, pendapatan)
  ✅ Notifikasi sukses/gagal setelah setiap aksi
  ✅ Desain responsif (mobile-friendly)

====================================================================
JENIS KAMAR & HARGA DEFAULT
====================================================================
  Standard      → Rp 350.000/malam
  Superior      → Rp 500.000/malam
  Deluxe        → Rp 750.000/malam
  Junior Suite  → Rp 1.100.000/malam
  Suite         → Rp 1.800.000/malam
  Presidential  → Rp 3.500.000/malam

  ⚠️  Untuk mengubah harga, edit array $harga_kamar di:
      - index.php (baris ~17)
      - edit.php  (baris ~67)

====================================================================
KEBUTUHAN SISTEM
====================================================================
  - PHP versi 7.0 atau lebih baru
  - MySQL / MariaDB
  - Web server: Apache (XAMPP/WAMP) atau Nginx
  - Browser modern (Chrome, Firefox, Edge, Safari)
  - Koneksi internet (untuk memuat Google Fonts)

====================================================================
