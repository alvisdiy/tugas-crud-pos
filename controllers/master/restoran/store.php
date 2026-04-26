<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_resto = $_POST['nama_resto'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO restoran (nama_resto, alamat) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_resto, $alamat]);

    header("Location: ../../../views/master/restoran/index.php");
    exit();
}
?>