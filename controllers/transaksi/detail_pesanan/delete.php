<?php
require_once '../../../config/database.php';

if (isset($_GET['id']) && isset($_GET['id_pesanan'])) {
    $id_detail = $_GET['id'];
    $id_pesanan = $_GET['id_pesanan'];
    
    try {
        $pdo->beginTransaction();

        $sql = "DELETE FROM detail_pesanan WHERE id_detail = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_detail]);

        // Update total di tabel pesanan utama!
        // Menggunakan IFNULL / COALESCE agar jika keranjang kosong totalnya jadi 0, bukan NULL.
        $sqlUpdateTotal = "UPDATE pesanan SET total = (SELECT COALESCE(SUM(subtotal), 0) FROM detail_pesanan WHERE id_pesanan = ?) WHERE id_pesanan = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdateTotal);
        $stmtUpdate->execute([$id_pesanan, $id_pesanan]);

        $pdo->commit(); // Simpan perubahan permanen

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }

    // Redirect kembali ke layar kasir yang benar
    header("Location: ../../../views/transaksi/detail_pesanan/manage.php?id_pesanan=" . $id_pesanan);
    exit();
    
} else {
    die("Akses Ditolak: Data tidak lengkap.");
}
?>