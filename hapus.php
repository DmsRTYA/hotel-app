<?php
require 'koneksi.php';
$stmt = $pdo->prepare("DELETE FROM reservasi WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
header("Location: index.php");
exit;
?>