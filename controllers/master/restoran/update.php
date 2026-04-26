<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_resto = $_POST['id_resto'];
    $nama_resto = $_POST['nama_resto'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE restoran SET nama_resto = ?, alamat = ? WHERE id_resto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_resto, $alamat, $id_resto]);

    header("Location: ../../../views/master/restoran/index.php");
    exit();
}
?>