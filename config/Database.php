<?php
class Database {
    private $host = "127.0.0.1";
    private $database = "db_hotel";
    private $username = "admin-vps";
    private $password = "dhimascinta1";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Menggunakan PDO untuk standar API yang aman
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Mencegah Error 500 dengan memberikan pesan JSON yang jelas
            http_response_code(500);
            echo json_encode(["message" => "Koneksi Database API Gagal: " . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
?>