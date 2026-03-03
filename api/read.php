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
$num = $stmt->rowCount();

if($num > 0) {
    $pesanan_arr = array();
    
    // Looping untuk memecah seluruh baris data
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $pesanan_item = array(
            "id"             => $id,
            "nama_tamu"      => $nama_tamu,
            "email"          => $email,
            "no_telepon"     => $no_telepon,
            "no_identitas"   => $no_identitas,
            "jenis_kamar"    => $jenis_kamar,
            "jumlah_kamar"   => $jumlah_kamar,
            "tanggal_masuk"  => $tanggal_masuk,
            "tanggal_keluar" => $tanggal_keluar,
            "jumlah_tamu"    => $jumlah_tamu,
            "permintaan"     => $permintaan,
            "status"         => $status,
            "total_harga"    => $total_harga
        );
        array_push($pesanan_arr, $pesanan_item);
    }
    http_response_code(200);
    echo json_encode($pesanan_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Data reservasi tidak ditemukan."));
}
?>