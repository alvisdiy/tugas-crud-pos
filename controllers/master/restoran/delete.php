<?php
require_once '../../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM restoran WHERE id_resto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: ../../../views/master/restoran/index.php");
exit();
?>