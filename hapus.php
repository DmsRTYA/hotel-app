<?php
// ============================================================
// FILE: hapus.php
// FUNGSI: Menghapus data pemesanan dari database
// ============================================================
// ⚠️  File ini dipanggil dari index.php melalui tombol Hapus
//     URL format: hapus.php?id=<nomor_id>
// ============================================================

require_once 'koneksi.php'; // ⚠️ Hubungkan ke file koneksi.php

// Validasi: pastikan ID ada dan berupa angka
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// Periksa apakah data dengan ID tersebut ada di database
$cek = mysqli_query($koneksi, "SELECT id FROM pemesanan WHERE id = $id");
if (mysqli_num_rows($cek) == 0) {
    // Data tidak ditemukan, kembali ke index
    header("Location: index.php");
    exit;
}

// ---- Query DELETE dari database ----
// ⚠️  Nama tabel = 'pemesanan', sesuaikan jika berbeda
$sql = "DELETE FROM pemesanan WHERE id = $id";

if (mysqli_query($koneksi, $sql)) {
    // Berhasil dihapus
    header("Location: index.php?status=hapus_sukses");
} else {
    // Gagal
    header("Location: index.php?status=gagal");
}

mysqli_close($koneksi);
exit;
?>
