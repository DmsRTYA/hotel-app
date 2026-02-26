<?php
// ============================================================
// FILE: index.php
// FUNGSI: Halaman utama — Form Pemesanan & Daftar Pemesanan
// ============================================================
// ⚠️  Pastikan file koneksi.php ada di folder yang sama!
// ============================================================

require_once 'koneksi.php'; // ⚠️ Hubungkan ke file koneksi.php

// ---- Ambil semua data pemesanan dari database ----
$query  = "SELECT * FROM pemesanan ORDER BY created_at DESC";
$result = mysqli_query($koneksi, $query);

// ---- Pesan sukses / error dari proses lain ----
$pesan = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah_sukses')   $pesan = ['tipe' => 'sukses', 'teks' => '✅ Pemesanan berhasil ditambahkan!'];
    if ($_GET['status'] == 'edit_sukses')     $pesan = ['tipe' => 'sukses', 'teks' => '✅ Data pemesanan berhasil diperbarui!'];
    if ($_GET['status'] == 'hapus_sukses')    $pesan = ['tipe' => 'sukses', 'teks' => '🗑️ Data pemesanan berhasil dihapus!'];
    if ($_GET['status'] == 'gagal')           $pesan = ['tipe' => 'error',  'teks' => '❌ Terjadi kesalahan. Silakan coba lagi.'];
}

// ---- Harga per malam per jenis kamar ----
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
    <title>The Grand Arcadia — Reservasi Hotel</title>

    <!-- Google Fonts: Playfair Display + Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        /* =====================================================
           CSS VARIABLES — ubah warna di sini jika diperlukan
           ===================================================== */
        :root {
            --gold:       #C9A84C;
            --gold-light: #E8C97A;
            --gold-dim:   #a8893d;
            --navy:       #0D1B2A;
            --navy-mid:   #162233;
            --navy-soft:  #1E3050;
            --cream:      #F5F0E8;
            --cream-dark: #E8E0D0;
            --white:      #FFFFFF;
            --text-light: #B0A898;
            --green:      #2ecc71;
            --red:        #e74c3c;
            --shadow:     0 8px 40px rgba(0,0,0,0.35);
            --radius:     12px;
        }

        /* =====================================================
           RESET & BASE
           ===================================================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--navy);
            color: var(--cream);
            min-height: 100vh;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(201,168,76,0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.04) 0%, transparent 50%);
        }

        /* =====================================================
           HEADER / HERO
           ===================================================== */
        .site-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%);
            border-bottom: 1px solid rgba(201,168,76,0.3);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 30px rgba(0,0,0,0.4);
        }

        .header-inner {
            max-width: 1300px;
            margin: 0 auto;
            padding: 18px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }
        .logo-main {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 2px;
        }
        .logo-sub {
            font-size: 0.65rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--text-light);
            margin-top: 2px;
        }

        .nav-links {
            display: flex;
            gap: 8px;
        }
        .nav-btn {
            background: transparent;
            border: 1px solid rgba(201,168,76,0.4);
            color: var(--gold-light);
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Lato', sans-serif;
            font-size: 0.82rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.25s;
            text-decoration: none;
        }
        .nav-btn:hover, .nav-btn.active {
            background: var(--gold);
            color: var(--navy);
            border-color: var(--gold);
        }

        /* =====================================================
           HERO BANNER
           ===================================================== */
        .hero {
            background: linear-gradient(160deg, var(--navy-soft) 0%, var(--navy-mid) 60%, var(--navy) 100%);
            padding: 70px 32px 50px;
            text-align: center;
            border-bottom: 1px solid rgba(201,168,76,0.15);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 1;
        }
        .hero-eyebrow {
            font-size: 0.7rem;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 14px;
        }
        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 700;
            color: var(--cream);
            line-height: 1.2;
        }
        .hero h1 em {
            color: var(--gold);
            font-style: italic;
        }
        .hero-desc {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-top: 14px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        .gold-divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 20px auto;
        }

        /* =====================================================
           MAIN CONTAINER
           ===================================================== */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 32px 60px;
        }

        /* =====================================================
           ALERT / NOTIFIKASI
           ===================================================== */
        .alert {
            padding: 14px 20px;
            border-radius: var(--radius);
            margin-bottom: 28px;
            font-size: 0.92rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.4s ease;
        }
        @keyframes slideDown {
            from { opacity:0; transform:translateY(-12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .alert-sukses {
            background: rgba(46,204,113,0.12);
            border: 1px solid rgba(46,204,113,0.35);
            color: #a8f0c6;
        }
        .alert-error {
            background: rgba(231,76,60,0.12);
            border: 1px solid rgba(231,76,60,0.35);
            color: #f5b7b1;
        }

        /* =====================================================
           SECTION TITLE
           ===================================================== */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--gold);
            margin-bottom: 6px;
        }
        .section-sub {
            font-size: 0.82rem;
            color: var(--text-light);
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        /* =====================================================
           CARD
           ===================================================== */
        .card {
            background: var(--navy-mid);
            border: 1px solid rgba(201,168,76,0.18);
            border-radius: var(--radius);
            padding: 36px;
            box-shadow: var(--shadow);
        }

        /* =====================================================
           FORM GRID
           ===================================================== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }
        .form-group.full { grid-column: 1 / -1; }

        label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gold-light);
            font-weight: 700;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(201,168,76,0.25);
            border-radius: 8px;
            color: var(--cream);
            padding: 12px 16px;
            font-family: 'Lato', sans-serif;
            font-size: 0.92rem;
            transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
            outline: none;
            width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--gold);
            background: rgba(201,168,76,0.08);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        input::placeholder, textarea::placeholder { color: rgba(176,168,152,0.5); }
        select option { background: var(--navy-mid); color: var(--cream); }
        textarea { resize: vertical; min-height: 90px; }

        .input-hint {
            font-size: 0.72rem;
            color: var(--text-light);
            margin-top: 3px;
        }

        /* ===== Harga estimasi ===== */
        .price-preview {
            background: linear-gradient(135deg, rgba(201,168,76,0.12), rgba(201,168,76,0.05));
            border: 1px solid rgba(201,168,76,0.35);
            border-radius: 10px;
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
        }
        .price-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-light);
        }
        .price-amount {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--gold);
            font-weight: 600;
        }

        /* ===== Submit button ===== */
        .btn-submit {
            background: linear-gradient(135deg, var(--gold), var(--gold-dim));
            color: var(--navy);
            border: none;
            border-radius: 8px;
            padding: 14px 36px;
            font-family: 'Lato', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 4px 20px rgba(201,168,76,0.3);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(201,168,76,0.45);
        }
        .btn-submit:active { transform: translateY(0); }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid rgba(201,168,76,0.15);
        }

        /* =====================================================
           KAMAR INFO CARDS
           ===================================================== */
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 28px;
        }
        .room-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(201,168,76,0.15);
            border-radius: 10px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.25s;
            text-align: center;
        }
        .room-card:hover {
            border-color: var(--gold);
            background: rgba(201,168,76,0.07);
        }
        .room-card.selected {
            border-color: var(--gold);
            background: rgba(201,168,76,0.12);
            box-shadow: 0 0 0 2px rgba(201,168,76,0.25);
        }
        .room-name { font-size: 0.85rem; font-weight: 700; color: var(--cream); }
        .room-price { font-size: 0.75rem; color: var(--gold); margin-top: 4px; }

        /* =====================================================
           TABEL DATA PEMESANAN
           ===================================================== */
        .table-wrap { overflow-x: auto; border-radius: var(--radius); }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }
        thead tr {
            background: linear-gradient(90deg, rgba(201,168,76,0.15), rgba(201,168,76,0.08));
            border-bottom: 2px solid rgba(201,168,76,0.3);
        }
        th {
            padding: 14px 16px;
            text-align: left;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold);
            white-space: nowrap;
        }
        td {
            padding: 13px 16px;
            color: var(--cream-dark);
            vertical-align: middle;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        tbody tr { transition: background 0.2s; }
        tbody tr:hover { background: rgba(201,168,76,0.05); }

        /* Status badge */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .badge-menunggu    { background: rgba(241,196,15,0.15); color: #f1c40f; border:1px solid rgba(241,196,15,0.3); }
        .badge-dikonfirmasi{ background: rgba(52,152,219,0.15); color: #5dade2; border:1px solid rgba(52,152,219,0.3); }
        .badge-checkin     { background: rgba(46,204,113,0.15); color: #2ecc71; border:1px solid rgba(46,204,113,0.3); }
        .badge-checkout    { background: rgba(149,165,166,0.15);color: #95a5a6; border:1px solid rgba(149,165,166,0.3);}
        .badge-dibatalkan  { background: rgba(231,76,60,0.15);  color: #e74c3c; border:1px solid rgba(231,76,60,0.3); }

        /* Action buttons */
        .btn-edit, .btn-hapus {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            letter-spacing: 0.5px;
        }
        .btn-edit {
            background: rgba(93,173,226,0.15);
            color: #5dade2;
            border: 1px solid rgba(93,173,226,0.3);
        }
        .btn-edit:hover  { background: rgba(93,173,226,0.25); }
        .btn-hapus {
            background: rgba(231,76,60,0.12);
            color: #e74c3c;
            border: 1px solid rgba(231,76,60,0.3);
        }
        .btn-hapus:hover { background: rgba(231,76,60,0.22); }

        .actions { display: flex; gap: 6px; }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-light);
        }
        .empty-state .icon { font-size: 2.5rem; margin-bottom: 12px; }
        .empty-state p { font-size: 0.9rem; }

        /* =====================================================
           STATS BAR
           ===================================================== */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 36px;
        }
        .stat-item {
            background: var(--navy-mid);
            border: 1px solid rgba(201,168,76,0.18);
            border-radius: 10px;
            padding: 18px 22px;
            text-align: center;
        }
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--gold);
            font-weight: 700;
        }
        .stat-label {
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-light);
            margin-top: 4px;
        }

        /* =====================================================
           SEPARATOR
           ===================================================== */
        .section-gap { margin-top: 50px; }

        /* =====================================================
           FOOTER
           ===================================================== */
        footer {
            text-align: center;
            padding: 28px;
            color: var(--text-light);
            font-size: 0.78rem;
            border-top: 1px solid rgba(201,168,76,0.15);
            letter-spacing: 1px;
        }
        footer span { color: var(--gold); }

        /* =====================================================
           MODAL KONFIRMASI HAPUS
           ===================================================== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 999;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: var(--navy-mid);
            border: 1px solid rgba(231,76,60,0.4);
            border-radius: var(--radius);
            padding: 36px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            animation: popIn 0.3s ease;
        }
        @keyframes popIn {
            from { opacity:0; transform:scale(0.9); }
            to   { opacity:1; transform:scale(1); }
        }
        .modal-icon { font-size: 2.5rem; margin-bottom: 14px; }
        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: var(--cream);
            margin-bottom: 8px;
        }
        .modal-desc { font-size: 0.88rem; color: var(--text-light); margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 12px; justify-content: center; }
        .btn-cancel {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: var(--text-light);
            padding: 10px 24px;
            border-radius: 7px;
            cursor: pointer;
            font-family: 'Lato', sans-serif;
            font-size: 0.88rem;
            transition: all 0.2s;
        }
        .btn-cancel:hover { border-color: var(--cream); color: var(--cream); }
        .btn-confirm-delete {
            background: var(--red);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 7px;
            cursor: pointer;
            font-family: 'Lato', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            transition: all 0.2s;
        }
        .btn-confirm-delete:hover { background: #c0392b; }

        /* Responsive */
        @media (max-width: 768px) {
            .header-inner { padding: 14px 18px; }
            .container    { padding: 24px 18px 48px; }
            .hero         { padding: 50px 18px 36px; }
            .card         { padding: 22px 18px; }
            .logo-main    { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

<!-- ===================== HEADER ===================== -->
<header class="site-header">
    <div class="header-inner">
        <div class="logo">
            <span class="logo-main">✦ THE GRAND ARCADIA</span>
            <span class="logo-sub">Luxury Hotel &amp; Resort</span>
        </div>
        <nav class="nav-links">
            <a href="#form-pesan" class="nav-btn active">Reservasi</a>
            <a href="#daftar-pesan" class="nav-btn">Data Tamu</a>
        </nav>
    </div>
</header>

<!-- ===================== HERO ===================== -->
<section class="hero">
    <p class="hero-eyebrow">✦ Sistem Reservasi Online ✦</p>
    <h1>Selamat Datang di <em>The Grand Arcadia</em></h1>
    <div class="gold-divider"></div>
    <p class="hero-desc">Lakukan pemesanan kamar dengan mudah, cepat, dan aman. Pengalaman menginap terbaik menanti Anda.</p>
</section>

<!-- ===================== KONTEN UTAMA ===================== -->
<main class="container">

    <!-- NOTIFIKASI -->
    <?php if (!empty($pesan)): ?>
    <div class="alert alert-<?= $pesan['tipe'] ?>">
        <?= $pesan['teks'] ?>
    </div>
    <?php endif; ?>

    <!-- STATISTIK -->
    <?php
    // ---- Hitung statistik dari database ----
    $total_pesan     = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM pemesanan"));
    $total_checkin   = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM pemesanan WHERE status='Check-in'"));
    $total_menunggu  = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM pemesanan WHERE status='Booking'"));
    $total_revenue_r = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total FROM pemesanan WHERE status != 'Dibatalkan'");
    $total_revenue   = mysqli_fetch_assoc($total_revenue_r)['total'] ?? 0;
    ?>
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-number"><?= $total_pesan ?></div>
            <div class="stat-label">Total Reservasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?= $total_checkin ?></div>
            <div class="stat-label">Tamu Check-in</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?= $total_menunggu ?></div>
            <div class="stat-label">Booking</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>

    <!-- ==================== FORM PEMESANAN ==================== -->
    <section id="form-pesan">
        <h2 class="section-title">✦ Formulir Reservasi</h2>
        <p class="section-sub">LENGKAPI DATA BERIKUT UNTUK MELAKUKAN PEMESANAN</p>

        <div class="card">
            <!-- Pilih Kamar Visual -->
            <div class="rooms-grid" id="rooms-grid">
                <?php foreach ($harga_kamar as $jenis => $harga): ?>
                <div class="room-card" onclick="pilihKamar(this, '<?= $jenis ?>', <?= $harga ?>)">
                    <div class="room-name"><?= $jenis ?></div>
                    <div class="room-price">Rp <?= number_format($harga, 0, ',', '.') ?>/malam</div>
                </div>
                <?php endforeach; ?>
            </div>

            <!--
                ⚠️  ACTION pada form ini mengarah ke tambah.php
                    Pastikan file tambah.php ada di folder yang sama!
            -->
            <form action="tambah.php" method="POST" id="formPemesanan">

                <div class="form-grid">

                    <!-- ===== IDENTITAS TAMU ===== -->
                    <div class="form-group">
                        <label for="nama_tamu">Nama Lengkap Tamu *</label>
                        <input type="text" id="nama_tamu" name="nama_tamu"
                               placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email *</label>
                        <input type="email" id="email" name="email"
                               placeholder="contoh@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon">Nomor Telepon / WA *</label>
                        <input type="text" id="no_telepon" name="no_telepon"
                               placeholder="+62 8xx-xxxx-xxxx" required>
                    </div>

                    <div class="form-group">
                        <label for="no_identitas">No. KTP / Paspor *</label>
                        <input type="text" id="no_identitas" name="no_identitas"
                               placeholder="Nomor identitas resmi" required>
                        <span class="input-hint">Diperlukan untuk proses check-in</span>
                    </div>

                    <!-- ===== DETAIL KAMAR ===== -->
                    <div class="form-group">
                        <label for="jenis_kamar">Jenis Kamar *</label>
                        <select id="jenis_kamar" name="jenis_kamar" required
                                onchange="updateHarga()">
                            <option value="">-- Pilih Jenis Kamar --</option>
                            <?php foreach ($harga_kamar as $jenis => $harga): ?>
                            <option value="<?= $jenis ?>" data-harga="<?= $harga ?>">
                                <?= $jenis ?> — Rp <?= number_format($harga, 0, ',', '.') ?>/malam
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_kamar">Jumlah Kamar *</label>
                        <input type="number" id="jumlah_kamar" name="jumlah_kamar"
                               value="1" min="1" max="10" required
                               oninput="updateHarga()">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Check-in *</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                               required oninput="updateHarga()">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_keluar">Tanggal Check-out *</label>
                        <input type="date" id="tanggal_keluar" name="tanggal_keluar"
                               required oninput="updateHarga()">
                    </div>

                    <div class="form-group">
                        <label for="jumlah_tamu">Jumlah Tamu *</label>
                        <input type="number" id="jumlah_tamu" name="jumlah_tamu"
                               value="1" min="1" max="20" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status Pemesanan</label>
                        <select id="status" name="status">
                            <option value="Menunggu">Booking</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Check-in">Check-in</option>
                            <option value="Check-out">Check-out</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label for="permintaan">Permintaan Khusus</label>
                        <textarea id="permintaan" name="permintaan"
                                  placeholder="Misalnya: kamar di lantai tinggi, lantai jauh dari lift, kebutuhan khusus, dll."></textarea>
                    </div>

                    <!-- ESTIMASI HARGA -->
                    <div class="form-group full">
                        <div class="price-preview">
                            <div>
                                <div class="price-label">Estimasi Total Biaya</div>
                                <div style="font-size:0.78rem;color:var(--text-light);margin-top:3px;"
                                     id="detail-harga">Pilih kamar dan tanggal terlebih dahulu</div>
                            </div>
                            <div class="price-amount" id="total-harga">Rp 0</div>
                        </div>
                        <!-- Field tersembunyi untuk menyimpan total harga -->
                        <input type="hidden" name="total_harga" id="total_harga_input" value="0">
                    </div>

                </div><!-- /form-grid -->

                <div class="form-actions">
                    <button type="reset" class="btn-cancel" onclick="resetForm()">✕ Reset</button>
                    <button type="submit" class="btn-submit">✦ Konfirmasi Pemesanan</button>
                </div>

            </form>
        </div><!-- /card -->
    </section>

    <!-- ==================== DAFTAR PEMESANAN ==================== -->
    <section id="daftar-pesan" class="section-gap">
        <h2 class="section-title">✦ Data Pemesanan</h2>
        <p class="section-sub">KELOLA SELURUH DATA RESERVASI TAMU</p>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Tamu</th>
                            <th>Kontak</th>
                            <th>No. Identitas</th>
                            <th>Kamar</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Tamu</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($result) == 0): ?>
                        <tr>
                            <td colspan="11">
                                <div class="empty-state">
                                    <div class="icon">🏨</div>
                                    <p>Belum ada data pemesanan.<br>Lakukan reservasi pertama Anda!</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color:var(--cream)"><?= htmlspecialchars($row['nama_tamu']) ?></strong>
                                <br><span style="font-size:0.75rem;color:var(--text-light)"><?= htmlspecialchars($row['email']) ?></span>
                            </td>
                            <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                            <td><?= htmlspecialchars($row['no_identitas']) ?></td>
                            <td>
                                <?= htmlspecialchars($row['jenis_kamar']) ?>
                                <br><span style="font-size:0.75rem;color:var(--text-light)"><?= $row['jumlah_kamar'] ?> kamar</span>
                            </td>
                            <td><?= date('d M Y', strtotime($row['tanggal_masuk'])) ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal_keluar'])) ?></td>
                            <td><?= $row['jumlah_tamu'] ?> orang</td>
                            <td style="color:var(--gold);font-weight:700;">
                                Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </td>
                            <td>
                                <?php
                                $badge_map = [
                                    'Booking'     => 'badge-menunggu',
                                    'Dikonfirmasi' => 'badge-dikonfirmasi',
                                    'Check-in'     => 'badge-checkin',
                                    'Check-out'    => 'badge-checkout',
                                    'Dibatalkan'   => 'badge-dibatalkan',
                                ];
                                $badge_class = $badge_map[$row['status']] ?? 'badge-menunggu';
                                ?>
                                <span class="badge <?= $badge_class ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <!--
                                        ⚠️  Link edit mengarah ke edit.php
                                            Pastikan file edit.php ada!
                                    -->
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏️ Edit</a>

                                    <!--
                                        ⚠️  Tombol hapus memanggil modal konfirmasi
                                            yang kemudian mengarah ke hapus.php
                                    -->
                                    <button class="btn-hapus"
                                            onclick="konfirmasiHapus(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['nama_tamu'])) ?>')">
                                        🗑️ Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div><!-- /table-wrap -->
        </div><!-- /card -->
    </section>

</main>

<!-- ===================== FOOTER ===================== -->
<footer>
    &copy; <?= date('Y') ?> <span>The Grand Arcadia Hotel</span> — Sistem Reservasi Online
</footer>

<!-- ===================== MODAL HAPUS ===================== -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box">
        <div class="modal-icon">🗑️</div>
        <div class="modal-title">Hapus Data Pemesanan?</div>
        <div class="modal-desc" id="modal-nama-tamu">Data ini akan dihapus secara permanen.</div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="tutupModal()">Batal</button>
            <!--
                ⚠️  Tombol ini mengarah ke hapus.php
                    Pastikan file hapus.php ada!
            -->
            <a href="hapus.php" id="btn-konfirm-hapus" class="btn-confirm-delete">Ya, Hapus</a>
        </div>
    </div>
</div>

<!-- ===================== JAVASCRIPT ===================== -->
<script>
    // =====================================================
    // Data harga kamar (sinkron dengan PHP)
    // =====================================================
    const hargaKamar = <?= json_encode($harga_kamar) ?>;

    // =====================================================
    // Pilih kamar dari kartu visual
    // =====================================================
    function pilihKamar(el, jenis, harga) {
        document.querySelectorAll('.room-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        const sel = document.getElementById('jenis_kamar');
        sel.value = jenis;
        updateHarga();
    }

    // =====================================================
    // Update estimasi harga secara real-time
    // =====================================================
    function updateHarga() {
        const kamar    = document.getElementById('jenis_kamar');
        const jumlah   = parseInt(document.getElementById('jumlah_kamar').value) || 0;
        const masuk    = document.getElementById('tanggal_masuk').value;
        const keluar   = document.getElementById('tanggal_keluar').value;

        if (!kamar.value || !masuk || !keluar) {
            document.getElementById('total-harga').textContent = 'Rp 0';
            document.getElementById('detail-harga').textContent = 'Pilih kamar dan tanggal terlebih dahulu';
            document.getElementById('total_harga_input').value = 0;
            return;
        }

        const d1    = new Date(masuk);
        const d2    = new Date(keluar);
        const malam = Math.max(0, Math.round((d2 - d1) / (1000 * 60 * 60 * 24)));
        const harga = hargaKamar[kamar.value] || 0;
        const total = harga * jumlah * malam;

        // Sinkronisasi highlight kartu kamar
        document.querySelectorAll('.room-card').forEach(c => {
            c.classList.toggle('selected', c.querySelector('.room-name').textContent === kamar.value);
        });

        document.getElementById('total-harga').textContent =
            'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('detail-harga').textContent =
            kamar.value + ' × ' + jumlah + ' kamar × ' + malam + ' malam';
        document.getElementById('total_harga_input').value = total;
    }

    // =====================================================
    // Validasi: tanggal keluar harus setelah masuk
    // =====================================================
    document.getElementById('tanggal_masuk').addEventListener('change', function() {
        const masuk = this.value;
        document.getElementById('tanggal_keluar').min = masuk;
        updateHarga();
    });

    // Tanggal minimum = hari ini
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_masuk').min  = today;
    document.getElementById('tanggal_keluar').min = today;

    // =====================================================
    // Reset form
    // =====================================================
    function resetForm() {
        document.querySelectorAll('.room-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('total-harga').textContent = 'Rp 0';
        document.getElementById('detail-harga').textContent = 'Pilih kamar dan tanggal terlebih dahulu';
        document.getElementById('total_harga_input').value = 0;
    }

    // =====================================================
    // Modal konfirmasi hapus
    // =====================================================
    function konfirmasiHapus(id, nama) {
        document.getElementById('modal-nama-tamu').textContent =
            'Anda akan menghapus data pemesanan atas nama: "' + nama + '". Tindakan ini tidak dapat dibatalkan.';
        // ⚠️ URL hapus.php dengan parameter id
        document.getElementById('btn-konfirm-hapus').href = 'hapus.php?id=' + id;
        document.getElementById('modalHapus').classList.add('active');
    }

    function tutupModal() {
        document.getElementById('modalHapus').classList.remove('active');
    }

    // Tutup modal jika klik di luar
    document.getElementById('modalHapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });
</script>

</body>
</html>
