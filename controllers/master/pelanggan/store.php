<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    $sql = "INSERT INTO pelanggan (nama, alamat, no_hp, email) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $alamat, $no_hp, $email]);

    header("Location: ../../../views/master/pelanggan/index.php");
    exit();
}
?>