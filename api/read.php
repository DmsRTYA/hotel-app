<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../config/Database.php';
include_once '../models/Pemesanan.php';

$database = new Database();
$db = $database->getConnection();
$pesanan = new Pemesanan($db);

$stmt = $pesanan->read();
if ($stmt->rowCount() > 0) {
    $pesanan_arr = array();
    // Cara memecah data yang lebih simpel dan anti-error
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($pesanan_arr, $row); 
    }
    http_response_code(200);
    echo json_encode($pesanan_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Data tidak ditemukan."));
}
?>