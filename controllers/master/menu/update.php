<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_menu = $_POST['id_menu'];
    $id_resto = $_POST['id_resto'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];

    $sql = "UPDATE menu SET id_resto = ?, nama_menu = ?, harga = ? WHERE id_menu = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_resto, $nama_menu, $harga, $id_menu]);

    header("Location: ../../../views/master/menu/index.php?id_resto=" . $id_resto);
    exit();
}
?>