<?php
require_once '../../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM pesanan WHERE id_pesanan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: ../../../views/transaksi/pesanan/index.php");
exit();
?>