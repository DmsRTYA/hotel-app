<?php
// ============================================================
// FILE: edit.php
// FUNGSI: Halaman edit data pemesanan hotel
// ============================================================
// ⚠️  Pastikan file koneksi.php ada di folder yang sama!
// ============================================================

require_once 'koneksi.php'; // ⚠️ Hubungkan ke file koneksi.php

// Ambil ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int) $_GET['id'];

// ---- Jika form di-submit (UPDATE) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan sanitasi data
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

    // ---- Query UPDATE ke database ----
    // ⚠️  Nama tabel = 'pemesanan', sesuaikan jika berbeda
    $sql = "UPDATE pemesanan SET
                nama_tamu      = '$nama_tamu',
                email          = '$email',
                no_telepon     = '$no_telepon',
                no_identitas   = '$no_identitas',
                jenis_kamar    = '$jenis_kamar',
                jumlah_kamar   = '$jumlah_kamar',
                tanggal_masuk  = '$tanggal_masuk',
                tanggal_keluar = '$tanggal_keluar',
                jumlah_tamu    = '$jumlah_tamu',
                permintaan     = '$permintaan',
                status         = '$status',
                total_harga    = '$total_harga'
            WHERE id = $id";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php?status=edit_sukses");
    } else {
        header("Location: index.php?status=gagal");
    }
    exit;
}

// ---- Ambil data lama dari database untuk ditampilkan di form ----
$query = "SELECT * FROM pemesanan WHERE id = $id LIMIT 1";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}
$data = mysqli_fetch_assoc($result);

// Harga per kamar
$harga_kamar = [
    'Standard'      => 350000,
    'Superior'      => 500000,
    'Deluxe'        => 750000,
    'Junior Suite'  => 1100000,
    'Suite'         => 1800000,
    'Presidential'  => 3500000,
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan #<?= $id ?> — The Grand Arcadia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C; --gold-light: #E8C97A; --gold-dim: #a8893d;
            --navy: #0D1B2A; --navy-mid: #162233; --navy-soft: #1E3050;
            --cream: #F5F0E8; --cream-dark: #E8E0D0; --text-light: #B0A898;
            --shadow: 0 8px 40px rgba(0,0,0,0.35); --radius: 12px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Lato', sans-serif; background-color: var(--navy); color: var(--cream); min-height: 100vh; }

        .site-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%);
            border-bottom: 1px solid rgba(201,168,76,0.3);
            padding: 0; box-shadow: 0 4px 30px rgba(0,0,0,0.4);
        }
        .header-inner {
            max-width: 900px; margin: 0 auto; padding: 18px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .logo-main { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: var(--gold); letter-spacing: 2px; }
        .logo-sub  { font-size: 0.62rem; letter-spacing: 4px; text-transform: uppercase; color: var(--text-light); margin-top: 2px; }

        .back-btn {
            background: transparent; border: 1px solid rgba(201,168,76,0.4); color: var(--gold-light);
            padding: 8px 18px; border-radius: 6px; cursor: pointer; font-size: 0.82rem;
            letter-spacing: 1px; text-transform: uppercase; transition: all 0.25s; text-decoration: none;
        }
        .back-btn:hover { background: var(--gold); color: var(--navy); border-color: var(--gold); }

        .container { max-width: 900px; margin: 0 auto; padding: 44px 32px 60px; }

        .page-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--gold); margin-bottom: 4px; }
        .page-sub { font-size: 0.78rem; color: var(--text-light); letter-spacing: 2px; margin-bottom: 28px; }

        .badge-id {
            display: inline-block; background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.3); color: var(--gold);
            padding: 5px 14px; border-radius: 20px; font-size: 0.8rem;
            font-weight: 700; margin-bottom: 24px;
        }

        .card { background: var(--navy-mid); border: 1px solid rgba(201,168,76,0.18); border-radius: var(--radius); padding: 36px; box-shadow: var(--shadow); }

        .section-label {
            font-size: 0.68rem; letter-spacing: 3px; text-transform: uppercase;
            color: var(--gold); border-bottom: 1px solid rgba(201,168,76,0.2);
            padding-bottom: 10px; margin-bottom: 20px; margin-top: 28px;
        }
        .section-label:first-child { margin-top: 0; }

        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 7px; }
        .form-group.full { grid-column: 1 / -1; }

        label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--gold-light); font-weight: 700; }
        input[type="text"], input[type="email"], input[type="number"], input[type="date"], select, textarea {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(201,168,76,0.25); border-radius: 8px;
            color: var(--cream); padding: 12px 16px; font-family: 'Lato', sans-serif; font-size: 0.92rem;
            transition: all 0.25s; outline: none; width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--gold); background: rgba(201,168,76,0.08);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        input::placeholder, textarea::placeholder { color: rgba(176,168,152,0.5); }
        select option { background: var(--navy-mid); color: var(--cream); }
        textarea { resize: vertical; min-height: 90px; }

        .price-preview {
            background: linear-gradient(135deg, rgba(201,168,76,0.12), rgba(201,168,76,0.05));
            border: 1px solid rgba(201,168,76,0.35); border-radius: 10px; padding: 18px 22px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .price-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); }
        .price-amount { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--gold); font-weight: 600; }

        .form-actions {
            display: flex; justify-content: space-between; gap: 12px;
            margin-top: 28px; padding-top: 22px; border-top: 1px solid rgba(201,168,76,0.15);
        }
        .btn-cancel {
            background: transparent; border: 1px solid rgba(255,255,255,0.2); color: var(--text-light);
            padding: 12px 28px; border-radius: 8px; cursor: pointer; font-family: 'Lato', sans-serif;
            font-size: 0.88rem; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center;
        }
        .btn-cancel:hover { border-color: var(--cream); color: var(--cream); }
        .btn-submit {
            background: linear-gradient(135deg, var(--gold), var(--gold-dim)); color: var(--navy);
            border: none; border-radius: 8px; padding: 12px 36px; font-family: 'Lato', sans-serif;
            font-size: 0.9rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
            cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 20px rgba(201,168,76,0.3);
        }
        .btn-submit:hover { background: linear-gradient(135deg, var(--gold-light), var(--gold)); transform: translateY(-2px); }

        .input-hint { font-size: 0.72rem; color: var(--text-light); margin-top: 2px; }

        @media (max-width: 600px) {
            .container { padding: 24px 16px; }
            .card { padding: 22px 16px; }
            .form-actions { flex-direction: column-reverse; }
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <div>
            <div class="logo-main">✦ THE GRAND ARCADIA</div>
            <div class="logo-sub">Sistem Reservasi</div>
        </div>
        <a href="index.php" class="back-btn">← Kembali</a>
    </div>
</header>

<main class="container">

    <h1 class="page-title">✦ Edit Data Pemesanan</h1>
    <p class="page-sub">PERBARUI INFORMASI RESERVASI TAMU</p>
    <div class="badge-id">ID Reservasi: #<?= str_pad($id, 4, '0', STR_PAD_LEFT) ?></div>

    <div class="card">
        <!--
            ⚠️  Form ini mengirim data ke edit.php dengan method POST
                ID dikirim via URL (?id=...)
        -->
        <form action="edit.php?id=<?= $id ?>" method="POST">

            <!-- ===== IDENTITAS TAMU ===== -->
            <div class="section-label">Identitas Tamu</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_tamu">Nama Lengkap *</label>
                    <input type="text" id="nama_tamu" name="nama_tamu"
                           value="<?= htmlspecialchars($data['nama_tamu']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email *</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($data['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon *</label>
                    <input type="text" id="no_telepon" name="no_telepon"
                           value="<?= htmlspecialchars($data['no_telepon']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="no_identitas">No. KTP / Paspor *</label>
                    <input type="text" id="no_identitas" name="no_identitas"
                           value="<?= htmlspecialchars($data['no_identitas']) ?>" required>
                    <span class="input-hint">Nomor identitas resmi tamu</span>
                </div>
            </div>

            <!-- ===== DETAIL KAMAR ===== -->
            <div class="section-label">Detail Kamar & Menginap</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="jenis_kamar">Jenis Kamar *</label>
                    <select id="jenis_kamar" name="jenis_kamar" required onchange="updateHarga()">
                        <?php foreach ($harga_kamar as $jenis => $harga): ?>
                        <option value="<?= $jenis ?>"
                            data-harga="<?= $harga ?>"
                            <?= ($data['jenis_kamar'] == $jenis) ? 'selected' : '' ?>>
                            <?= $jenis ?> — Rp <?= number_format($harga, 0, ',', '.') ?>/malam
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_kamar">Jumlah Kamar *</label>
                    <input type="number" id="jumlah_kamar" name="jumlah_kamar"
                           value="<?= $data['jumlah_kamar'] ?>" min="1" max="10" required
                           oninput="updateHarga()">
                </div>
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Check-in *</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                           value="<?= $data['tanggal_masuk'] ?>" required
                           oninput="updateHarga()">
                </div>
                <div class="form-group">
                    <label for="tanggal_keluar">Tanggal Check-out *</label>
                    <input type="date" id="tanggal_keluar" name="tanggal_keluar"
                           value="<?= $data['tanggal_keluar'] ?>" required
                           oninput="updateHarga()">
                </div>
                <div class="form-group">
                    <label for="jumlah_tamu">Jumlah Tamu *</label>
                    <input type="number" id="jumlah_tamu" name="jumlah_tamu"
                           value="<?= $data['jumlah_tamu'] ?>" min="1" max="20" required>
                </div>
                <div class="form-group">
                    <label for="status">Status Pemesanan</label>
                    <select id="status" name="status">
                        <?php
                        $statuses = ['Booking','Dikonfirmasi','Check-in','Check-out','Dibatalkan'];
                        foreach ($statuses as $s):
                        ?>
                        <option value="<?= $s ?>" <?= ($data['status'] == $s) ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group full">
                    <label for="permintaan">Permintaan Khusus</label>
                    <textarea id="permintaan" name="permintaan"
                              placeholder="Permintaan atau catatan khusus..."><?= htmlspecialchars($data['permintaan']) ?></textarea>
                </div>

                <!-- ESTIMASI HARGA -->
                <div class="form-group full">
                    <div class="price-preview">
                        <div>
                            <div class="price-label">Estimasi Total Biaya</div>
                            <div style="font-size:0.78rem;color:var(--text-light);margin-top:3px;"
                                 id="detail-harga">Memuat...</div>
                        </div>
                        <div class="price-amount" id="total-harga">Rp 0</div>
                    </div>
                    <input type="hidden" name="total_harga" id="total_harga_input" value="<?= $data['total_harga'] ?>">
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-cancel">✕ Batal</a>
                <button type="submit" class="btn-submit">✦ Simpan Perubahan</button>
            </div>

        </form>
    </div>

</main>

<script>
    const hargaKamar = <?= json_encode($harga_kamar) ?>;

    function updateHarga() {
        const kamar  = document.getElementById('jenis_kamar');
        const jumlah = parseInt(document.getElementById('jumlah_kamar').value) || 0;
        const masuk  = document.getElementById('tanggal_masuk').value;
        const keluar = document.getElementById('tanggal_keluar').value;

        if (!kamar.value || !masuk || !keluar) return;

        const d1    = new Date(masuk);
        const d2    = new Date(keluar);
        const malam = Math.max(0, Math.round((d2 - d1) / (1000 * 60 * 60 * 24)));
        const harga = hargaKamar[kamar.value] || 0;
        const total = harga * jumlah * malam;

        document.getElementById('total-harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('detail-harga').textContent =
            kamar.value + ' × ' + jumlah + ' kamar × ' + malam + ' malam';
        document.getElementById('total_harga_input').value = total;
    }

    // Hitung otomatis saat halaman dimuat
    window.addEventListener('load', updateHarga);
</script>
</body>
</html>
