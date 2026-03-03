<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';
include_once '../models/Pemesanan.php';

$database = new Database();
$db = $database->getConnection();
$pesanan = new Pemesanan($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_tamu) && !empty($data->jenis_kamar)) {
    $pesanan->nama_tamu      = $data->nama_tamu;
    $pesanan->email          = $data->email ?? '-';
    $pesanan->no_telepon     = $data->no_telepon ?? '-';
    $pesanan->no_identitas   = $data->no_identitas ?? '-';
    $pesanan->jenis_kamar    = $data->jenis_kamar;
    $pesanan->jumlah_kamar   = $data->jumlah_kamar ?? 1;
    $pesanan->tanggal_masuk  = $data->tanggal_masuk ?? date('Y-m-d');
    $pesanan->tanggal_keluar = $data->tanggal_keluar ?? date('Y-m-d');
    $pesanan->jumlah_tamu    = $data->jumlah_tamu ?? 1;
    $pesanan->permintaan     = $data->permintaan ?? '';
    $pesanan->status         = $data->status ?? 'Booking';
    $pesanan->total_harga    = $data->total_harga ?? 0;

    if ($pesanan->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Data berhasil ditambahkan."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal menambahkan data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Data tidak lengkap."));
}
?>