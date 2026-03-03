<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once '../config/Database.php';
include_once '../models/Pemesanan.php';

$database = new Database();
$db = $database->getConnection();
$pesanan = new Pemesanan($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $pesanan->id = $data->id;
    if ($pesanan->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Data berhasil dihapus."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal menghapus data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID wajib diisi."));
}
?>