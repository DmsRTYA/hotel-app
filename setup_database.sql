-- ============================================================
-- FILE: setup_database.sql
-- FUNGSI: Membuat database dan tabel untuk Sistem Reservasi Hotel
-- ============================================================
-- CARA PENGGUNAAN:
--   1. Buka phpMyAdmin
--   2. Klik tab "SQL"
--   3. Salin seluruh isi file ini dan klik "Go" / "Jalankan"
-- ============================================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS db_hotel
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Gunakan database hotel_booking
USE db_hotel;

-- Buat tabel pemesanan
CREATE TABLE IF NOT EXISTS pemesanan (
    id              INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ID unik pemesanan',
    nama_tamu       VARCHAR(100)    NOT NULL COMMENT 'Nama lengkap tamu',
    email           VARCHAR(100)    NOT NULL COMMENT 'Email tamu',
    no_telepon      VARCHAR(20)     NOT NULL COMMENT 'Nomor HP/WA tamu',
    no_identitas    VARCHAR(30)     NOT NULL COMMENT 'No. KTP atau Paspor',
    jenis_kamar     VARCHAR(50)     NOT NULL COMMENT 'Jenis kamar yang dipesan',
    jumlah_kamar    INT             NOT NULL DEFAULT 1 COMMENT 'Jumlah kamar',
    tanggal_masuk   DATE            NOT NULL COMMENT 'Tanggal check-in',
    tanggal_keluar  DATE            NOT NULL COMMENT 'Tanggal check-out',
    jumlah_tamu     INT             NOT NULL DEFAULT 1 COMMENT 'Jumlah tamu',
    permintaan      TEXT            COMMENT 'Permintaan atau catatan khusus',
    status          ENUM(
                        'Menunggu',
                        'Dikonfirmasi',
                        'Check-in',
                        'Check-out',
                        'Dibatalkan'
                    ) DEFAULT 'Menunggu' COMMENT 'Status pemesanan',
    total_harga     DECIMAL(15,2)   DEFAULT 0 COMMENT 'Total biaya menginap',
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu pemesanan dibuat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabel data pemesanan kamar hotel';

-- ============================================================
-- (OPSIONAL) Data contoh untuk pengujian awal
-- Hapus bagian ini jika tidak diperlukan
-- ============================================================
INSERT INTO pemesanan 
    (nama_tamu, email, no_telepon, no_identitas, jenis_kamar, 
     jumlah_kamar, tanggal_masuk, tanggal_keluar, jumlah_tamu, 
     permintaan, status, total_harga)
VALUES
    ('Budi Santoso',  'budi@email.com',  '08123456789', '3271010101980001',
     'Deluxe',       1, '2025-01-15', '2025-01-18', 2, 'Non-smoking room', 'Check-out', 2250000),

    ('Siti Rahayu',   'siti@email.com',  '08234567890', '3271010202990002',
     'Suite',         1, '2025-02-01', '2025-02-03', 3, 'Extra bed needed', 'Dikonfirmasi', 3600000),

    ('Ahmad Fauzi',   'ahmad@email.com', '08345678901', '3271010303880003',
     'Standard',      2, '2025-02-10', '2025-02-12', 4, '',                 'Menunggu',     700000);
