<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once '../config/Database.php';
include_once '../models/Pemesanan.php';

$database = new Database();
$db = $database->getConnection();
$pesanan = new Pemesanan($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $pesanan->id             = $data->id;
    $pesanan->nama_tamu      = $data->nama_tamu;
    $pesanan->email          = $data->email;
    $pesanan->no_telepon     = $data->no_telepon;
    $pesanan->no_identitas   = $data->no_identitas;
    $pesanan->jenis_kamar    = $data->jenis_kamar;
    $pesanan->jumlah_kamar   = $data->jumlah_kamar;
    $pesanan->tanggal_masuk  = $data->tanggal_masuk;
    $pesanan->tanggal_keluar = $data->tanggal_keluar;
    $pesanan->jumlah_tamu    = $data->jumlah_tamu;
    $pesanan->permintaan     = $data->permintaan;
    $pesanan->status         = $data->status;
    $pesanan->total_harga    = $data->total_harga;

    if ($pesanan->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Data berhasil diperbarui."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal memperbarui data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID Pemesanan wajib diisi."));
}
?>