<?php
require 'koneksi.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM reservasi WHERE id = :id");
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE reservasi SET nama_tamu=:nama, kontak=:kontak, no_identitas=:identitas, kamar=:kamar, 
            tgl_checkin=:checkin, tgl_checkout=:checkout, jumlah_tamu=:tamu, total_harga=:harga, status=:status WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nama' => $_POST['nama_tamu'], 'kontak' => $_POST['kontak'], 'identitas' => $_POST['no_identitas'],
        'kamar' => $_POST['kamar'], 'checkin' => $_POST['tgl_checkin'], 'checkout' => $_POST['tgl_checkout'],
        'tamu' => $_POST['jumlah_tamu'], 'harga' => $_POST['total_harga'], 'status' => $_POST['status'], 'id' => $id
    ]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Reservasi</title></head>
<body>
    <h2>Edit Reservasi Hotel</h2>
    <form method="POST">
        Nama Tamu: <input type="text" name="nama_tamu" value="<?= $data['nama_tamu']; ?>" required><br><br>
        Kontak: <input type="text" name="kontak" value="<?= $data['kontak']; ?>" required><br><br>
        No. Identitas: <input type="text" name="no_identitas" value="<?= $data['no_identitas']; ?>" required><br><br>
        Kamar: <input type="text" name="kamar" value="<?= $data['kamar']; ?>" required><br><br>
        Check-in: <input type="date" name="tgl_checkin" value="<?= $data['tgl_checkin']; ?>" required><br><br>
        Check-out: <input type="date" name="tgl_checkout" value="<?= $data['tgl_checkout']; ?>" required><br><br>
        Jumlah Tamu: <input type="number" name="jumlah_tamu" value="<?= $data['jumlah_tamu']; ?>" required><br><br>
        Total Harga: <input type="number" name="total_harga" value="<?= $data['total_harga']; ?>" required><br><br>
        Status: 
        <select name="status">
            <option value="Booking" <?= $data['status'] == 'Booking' ? 'selected' : ''; ?>>Booking</option>
            <option value="Check-in" <?= $data['status'] == 'Check-in' ? 'selected' : ''; ?>>Check-in</option>
            <option value="Check-out" <?= $data['status'] == 'Check-out' ? 'selected' : ''; ?>>Check-out</option>
        </select><br><br>
        <button type="submit">Update</button> <a href="index.php">Batal</a>
    </form>
</body>
</html>