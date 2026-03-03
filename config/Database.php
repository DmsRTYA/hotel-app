<?php
class Database {
    private $host = "127.0.0.1";
    private $database = "db_hotel";
    private $username = "admin-vps"; // Sesuaikan user DB Debian Anda
    private $password = "dhimascinta1"; // Sesuaikan password DB Debian Anda
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";database=" . $this->database, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi API Gagal: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>