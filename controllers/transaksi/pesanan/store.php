<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_resto = $_POST['id_resto'];

    // Total default 0
    $sql = "INSERT INTO pesanan (id_pelanggan, id_resto, waktu, total) VALUES (?, ?, NOW(), 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pelanggan, $id_resto]);

    //Tangkap ID yang baru saja digenerate oleh Auto Increment MySQL
    $id_pesanan_baru = $pdo->lastInsertId(); 

    // Redirect ke halaman detail (keranjang), bukan ke index!
    header("Location: ../../../views/transaksi/detail_pesanan/manage.php?id_pesanan=" . $id_pesanan_baru);
    exit();
}
?>