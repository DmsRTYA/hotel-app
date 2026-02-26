<?php
require 'koneksi.php';
$query = $pdo->query("SELECT * FROM reservasi ORDER BY id DESC");
$data = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Data Reservasi Hotel</title></head>
<body>
    <h2>Daftar Reservasi Hotel</h2>
    <a href="tambah.php">Tambah Reservasi Baru</a><br><br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th><th>Nama Tamu</th><th>Kontak</th><th>No. Identitas</th>
            <th>Kamar</th><th>Check-in</th><th>Check-out</th><th>Tamu</th>
            <th>Total Harga</th><th>Status</th><th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_tamu']); ?></td>
            <td><?= htmlspecialchars($row['kontak']); ?></td>
            <td><?= htmlspecialchars($row['no_identitas']); ?></td>
            <td><?= htmlspecialchars($row['kamar']); ?></td>
            <td><?= htmlspecialchars($row['tgl_checkin']); ?></td>
            <td><?= htmlspecialchars($row['tgl_checkout']); ?></td>
            <td><?= htmlspecialchars($row['jumlah_tamu']); ?> Orang</td>
            <td>Rp <?= number_format($row['total_harga'], 2, ',', '.'); ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>">Edit</a> | 
                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
