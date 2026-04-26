<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pesanan = $_POST['id_pesanan'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_resto = $_POST['id_resto'];
    $waktu = date('Y-m-d H:i:s', strtotime($_POST['waktu']));

    $sql = "UPDATE pesanan SET id_pelanggan = ?, id_resto = ?, waktu = ? WHERE id_pesanan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pelanggan, $id_resto, $waktu, $id_pesanan]);

    header("Location: ../../../views/transaksi/pesanan/index.php");
    exit();
}