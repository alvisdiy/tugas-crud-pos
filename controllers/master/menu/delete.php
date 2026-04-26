<?php
require_once '../../../config/database.php';

if (isset($_GET['id']) && isset($_GET['id_resto'])) { // Tangkap juga id_resto dari URL
    $id = $_GET['id'];
    $id_resto = $_GET['id_resto'];
    
    $sql = "DELETE FROM menu WHERE id_menu = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    // Redirect dengan membawa id_resto
    header("Location: ../../../views/master/menu/index.php?id_resto=" . $id_resto);
    exit();
}
// Jika gagal/tidak ada parameter, lempar kembali ke daftar restoran
header("Location: ../../../views/master/restoran/index.php");
exit();
?>