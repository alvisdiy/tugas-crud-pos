<?php
require_once '../../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM pelanggan WHERE id_pelanggan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: ../../../views/master/pelanggan/index.php");
exit();
?>