<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE"); // DELETE adalah standar API untuk Hapus

include_once '../config/Database.php';
include_once '../models/Pemesanan.php';

$database = new Database();
$db = $database->getConnection();
$pesanan = new Pemesanan($db);

// Menangkap JSON mentah
$data = json_decode(file_get_contents("php://input"));

// Untuk menghapus, kita hanya butuh ID
if(!empty($data->id)) {
    $pesanan->id = $data->id;

    if($pesanan->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Data reservasi berhasil dihapus via API."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal menghapus data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID Pemesanan wajib diisi untuk menghapus data."));
}
?>