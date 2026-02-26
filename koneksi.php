<?php
// ============================================================
// FILE: koneksi.php
// FUNGSI: File koneksi ke database MySQL
// ============================================================
// ⚠️  BAGIAN INI PERLU ANDA SESUAIKAN dengan pengaturan
//     database Anda sendiri:
// ============================================================

$host = '127.0.0.1';
$dbname = 'db_hotel';
$username = 'admin-vps'; // User MariaDB Debian Anda
$password = 'dhimascinta1'; // Password MariaDB Debian Anda

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if (!$koneksi) {
    die("
    <div style='font-family:sans-serif;text-align:center;padding:40px;'>
        <h2 style='color:#c0392b;'>❌ Koneksi Database Gagal</h2>
        <p>Error: " . mysqli_connect_error() . "</p>
        <p style='color:#888;'>Pastikan pengaturan database di <strong>koneksi.php</strong> sudah benar.</p>
    </div>
    ");
}

// Mengatur charset ke UTF-8 untuk mendukung karakter khusus
mysqli_set_charset($koneksi, "utf8");

// ============================================================
// STRUKTUR TABEL (jalankan SQL ini di phpMyAdmin Anda):
// ============================================================
/*
CREATE DATABASE IF NOT EXISTS hotel_booking;
USE hotel_booking;

CREATE TABLE IF NOT EXISTS pemesanan (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nama_tamu       VARCHAR(100)    NOT NULL,
    email           VARCHAR(100)    NOT NULL,
    no_telepon      VARCHAR(20)     NOT NULL,
    no_identitas    VARCHAR(30)     NOT NULL,
    jenis_kamar     VARCHAR(50)     NOT NULL,
    jumlah_kamar    INT             NOT NULL DEFAULT 1,
    tanggal_masuk   DATE            NOT NULL,
    tanggal_keluar  DATE            NOT NULL,
    jumlah_tamu     INT             NOT NULL DEFAULT 1,
    permintaan      TEXT,
    status          ENUM('Menunggu','Dikonfirmasi','Check-in','Check-out','Dibatalkan') DEFAULT 'Menunggu',
    total_harga     DECIMAL(15,2)   DEFAULT 0,
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);
*/
?>
