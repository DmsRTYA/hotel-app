<?php
require 'koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO reservasi (nama_tamu, kontak, no_identitas, kamar, tgl_checkin, tgl_checkout, jumlah_tamu, total_harga, status) 
            VALUES (:nama, :kontak, :identitas, :kamar, :checkin, :checkout, :tamu, :harga, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nama' => $_POST['nama_tamu'], 'kontak' => $_POST['kontak'], 'identitas' => $_POST['no_identitas'],
        'kamar' => $_POST['kamar'], 'checkin' => $_POST['tgl_checkin'], 'checkout' => $_POST['tgl_checkout'],
        'tamu' => $_POST['jumlah_tamu'], 'harga' => $_POST['total_harga'], 'status' => $_POST['status']
    ]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Reservasi</title></head>
<body>
    <h2>Tambah Reservasi Hotel</h2>
    <form method="POST">
        Nama Tamu: <input type="text" name="nama_tamu" required><br><br>
        Kontak: <input type="text" name="kontak" required><br><br>
        No. Identitas: <input type="text" name="no_identitas" required><br><br>
        Kamar: <input type="text" name="kamar" required><br><br>
        Check-in: <input type="date" name="tgl_checkin" required><br><br>
        Check-out: <input type="date" name="tgl_checkout" required><br><br>
        Jumlah Tamu: <input type="number" name="jumlah_tamu" required><br><br>
        Total Harga: <input type="number" name="total_harga" required><br><br>
        Status: 
        <select name="status">
            <option value="Booking">Booking</option>
            <option value="Check-in">Check-in</option>
            <option value="Check-out">Check-out</option>
        </select><br><br>
        <button type="submit">Simpan</button> <a href="index.php">Batal</a>
    </form>
</body>
</html>