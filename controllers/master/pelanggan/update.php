<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    $sql = "UPDATE pelanggan SET nama = ?, alamat = ?, no_hp = ?, email = ? WHERE id_pelanggan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $alamat, $no_hp, $email, $id_pelanggan]);

    header("Location: ../../../views/master/pelanggan/index.php");
    exit();
}
?>