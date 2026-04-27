<?php
require_once '../../../config/database.php';

if (isset($_GET['id']) && isset($_GET['id_resto'])) {
    $id = $_GET['id'];
    $id_resto = $_GET['id_resto'];
    
    $sql = "DELETE FROM menu WHERE id_menu = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    header("Location: ../../../views/master/menu/index.php?id_resto=" . $id_resto);
    exit();
}

header("Location: ../../../views/master/restoran/index.php");
exit();
?>