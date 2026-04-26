<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_resto = $_POST['id_resto']; // Ini berupa angka/ID
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];

    $sql = "INSERT INTO menu (id_resto, nama_menu, harga) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_resto, $nama_menu, $harga]);

    // Bawa kembali variabel $id_resto ke URL!
    header("Location: ../../../views/master/menu/index.php?id_resto=" . $id_resto);
    exit();
}
