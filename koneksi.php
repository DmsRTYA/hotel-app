<?php
$host = '127.0.0.1';
$dbname = 'db_hotel';
$username = 'admin-vps'; // User MariaDB Debian Anda
$password = 'dhimascinta1'; // Password MariaDB Debian Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
