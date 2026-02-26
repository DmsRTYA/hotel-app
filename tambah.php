<?php
// ============================================================
// FILE: proses.php
// FUNGSI: Memproses input form dan menyimpan ke database
// ============================================================
// ⚠️  Pastikan file ini ada di folder yang sama dengan index.php
// ============================================================

require_once 'koneksi.php'; // ⚠️ Hubungkan ke file koneksi.php

// Hanya menerima request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// ---- Ambil dan sanitasi data dari form ----
// ⚠️  Nama field harus sesuai dengan atribut 'name' pada form di index.php

$nama_tamu      = trim(mysqli_real_escape_string($koneksi, $_POST['nama_tamu']));
$email          = trim(mysqli_real_escape_string($koneksi, $_POST['email']));
$no_telepon     = trim(mysqli_real_escape_string($koneksi, $_POST['no_telepon']));
$no_identitas   = trim(mysqli_real_escape_string($koneksi, $_POST['no_identitas']));
$jenis_kamar    = trim(mysqli_real_escape_string($koneksi, $_POST['jenis_kamar']));
$jumlah_kamar   = (int) $_POST['jumlah_kamar'];
$tanggal_masuk  = $_POST['tanggal_masuk'];
$tanggal_keluar = $_POST['tanggal_keluar'];
$jumlah_tamu    = (int) $_POST['jumlah_tamu'];
$permintaan     = trim(mysqli_real_escape_string($koneksi, $_POST['permintaan'] ?? ''));
$status         = trim(mysqli_real_escape_string($koneksi, $_POST['status']));
$total_harga    = (float) $_POST['total_harga'];

// ---- Validasi dasar ----
if (
    empty($nama_tamu) || empty($email) || empty($no_telepon) ||
    empty($no_identitas) || empty($jenis_kamar) ||
    empty($tanggal_masuk) || empty($tanggal_keluar)
) {
    header("Location: index.php?status=gagal");
    exit;
}

// Pastikan tanggal keluar setelah tanggal masuk
if (strtotime($tanggal_keluar) <= strtotime($tanggal_masuk)) {
    header("Location: index.php?status=gagal");
    exit;
}

// ---- Query INSERT ke database ----
// ⚠️  Nama tabel = 'pemesanan', sesuaikan jika berbeda
$sql = "INSERT INTO pemesanan 
            (nama_tamu, email, no_telepon, no_identitas, jenis_kamar, 
             jumlah_kamar, tanggal_masuk, tanggal_keluar, jumlah_tamu, 
             permintaan, status, total_harga) 
        VALUES 
            ('$nama_tamu', '$email', '$no_telepon', '$no_identitas', '$jenis_kamar',
             '$jumlah_kamar', '$tanggal_masuk', '$tanggal_keluar', '$jumlah_tamu',
             '$permintaan', '$status', '$total_harga')";

if (mysqli_query($koneksi, $sql)) {
    // Berhasil → redirect dengan pesan sukses
    header("Location: index.php?status=tambah_sukses");
} else {
    // Gagal → redirect dengan pesan error
    header("Location: index.php?status=gagal");
}

mysqli_close($koneksi);
exit;
?>
