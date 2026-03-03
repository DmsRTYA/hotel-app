<?php
class Pemesanan {
    private $conn;
    private $table_name = "pemesanan";

    // Mendaftarkan seluruh kolom database sebagai properti
    public $id;
    public $nama_tamu;
    public $email;
    public $no_telepon;
    public $no_identitas;
    public $jenis_kamar;
    public $jumlah_kamar;
    public $tanggal_masuk;
    public $tanggal_keluar;
    public $jumlah_tamu;
    public $permintaan;
    public $status;
    public $total_harga;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi READ (Menarik semua data)
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Fungsi CREATE (Menyuntikkan semua data dari API ke Database)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 (nama_tamu, email, no_telepon, no_identitas, jenis_kamar, jumlah_kamar, tanggal_masuk, tanggal_keluar, jumlah_tamu, permintaan, status, total_harga) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Memasukkan array data secara berurutan sesuai parameter (?)
        if ($stmt->execute([
            $this->nama_tamu, $this->email, $this->no_telepon, $this->no_identitas, 
            $this->jenis_kamar, $this->jumlah_kamar, $this->tanggal_masuk, 
            $this->tanggal_keluar, $this->jumlah_tamu, $this->permintaan, 
            $this->status, $this->total_harga
        ])) {
            return true;
        }
        return false;
    }

    // Fungsi UPDATE (Mengubah data via API)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_tamu = ?, email = ?, no_telepon = ?, no_identitas = ?, 
                      jenis_kamar = ?, jumlah_kamar = ?, tanggal_masuk = ?, 
                      tanggal_keluar = ?, jumlah_tamu = ?, permintaan = ?, 
                      status = ?, total_harga = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        if ($stmt->execute([
            $this->nama_tamu, $this->email, $this->no_telepon, $this->no_identitas, 
            $this->jenis_kamar, $this->jumlah_kamar, $this->tanggal_masuk, 
            $this->tanggal_keluar, $this->jumlah_tamu, $this->permintaan, 
            $this->status, $this->total_harga, $this->id
        ])) {
            return true;
        }
        return false;
    }

    // Fungsi DELETE (Menghapus data via API)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}
?>