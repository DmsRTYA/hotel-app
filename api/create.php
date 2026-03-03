<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';
include_once '../models/Pemesanan.php';

$database = new Database();
$db = $database->getConnection();
$pesanan = new Pemesanan($db);

// Menangkap JSON mentah dari request API
$data = json_decode(file_get_contents("php://input"));

// Validasi minimal (pastikan field wajib tidak kosong)
if(
    !empty($data->nama_tamu) && 
    !empty($data->no_telepon) && 
    !empty($data->jenis_kamar) && 
    !empty($data->tanggal_masuk)
) {
    // Memasukkan data ke dalam properti Model
    $pesanan->nama_tamu      = $data->nama_tamu;
    $pesanan->email          = $data->email ?? ''; // Opsional jika kosong
    $pesanan->no_telepon     = $data->no_telepon;
    $pesanan->no_identitas   = $data->no_identitas ?? '-';
    $pesanan->jenis_kamar    = $data->jenis_kamar;
    $pesanan->jumlah_kamar   = $data->jumlah_kamar ?? 1;
    $pesanan->tanggal_masuk  = $data->tanggal_masuk;
    $pesanan->tanggal_keluar = $data->tanggal_keluar;
    $pesanan->jumlah_tamu    = $data->jumlah_tamu ?? 1;
    $pesanan->permintaan     = $data->permintaan ?? '';
    $pesanan->status         = $data->status ?? 'Menunggu';
    $pesanan->total_harga    = $data->total_harga ?? 0;

    // Mengeksekusi query CREATE
    if($pesanan->create()) {
        http_response_code(201); // 201 Created
        echo json_encode(array("message" => "Reservasi berhasil ditambahkan via API."));
    } else {
        http_response_code(503); // 503 Service Unavailable
        echo json_encode(array("message" => "Gagal menambahkan reservasi. Server error."));
    }
} else {
    http_response_code(400); // 400 Bad Request
    echo json_encode(array("message" => "Data tidak lengkap. Harap isi minimal Nama, Kontak, Kamar, dan Tanggal Check-in."));
}
?>