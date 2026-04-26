<?php
require_once '../../../config/database.php';

if (isset($_GET['id']) && isset($_GET['id_pesanan'])) {
    $id_detail = $_GET['id'];
    $id_pesanan = $_GET['id_pesanan'];

    try {
        $pdo->beginTransaction();

        // 1. Ambil data jumlah saat ini dan harga satuan menu
        $stmtCek = $pdo->prepare("SELECT dp.jumlah, m.harga 
                                  FROM detail_pesanan dp 
                                  JOIN menu m ON dp.id_menu = m.id_menu 
                                  WHERE dp.id_detail = ?");
        $stmtCek->execute([$id_detail]);
        $item = $stmtCek->fetch();

        if ($item) {
            if ($item['jumlah'] > 1) {
                // JIKA JUMLAH > 1: Kurangi 1 dan update subtotal
                $jumlah_baru = $item['jumlah'] - 1;
                $subtotal_baru = $jumlah_baru * $item['harga'];

                $sqlUpdate = "UPDATE detail_pesanan SET jumlah = ?, subtotal = ? WHERE id_detail = ?";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $stmtUpdate->execute([$jumlah_baru, $subtotal_baru, $id_detail]);
            } else {
                // JIKA JUMLAH = 1: Langsung hapus dari keranjang
                $sqlDelete = "DELETE FROM detail_pesanan WHERE id_detail = ?";
                $stmtDelete = $pdo->prepare($sqlDelete);
                $stmtDelete->execute([$id_detail]);
            }

            // 2. OTOMATISASI: Kalkulasi ulang total utama pesanan
            $sqlUpdateTotal = "UPDATE pesanan SET total = (SELECT COALESCE(SUM(subtotal), 0) FROM detail_pesanan WHERE id_pesanan = ?) WHERE id_pesanan = ?";
            $stmtUpdateTotal = $pdo->prepare($sqlUpdateTotal);
            $stmtUpdateTotal->execute([$id_pesanan, $id_pesanan]);
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }

    // Lempar kembali ke layar rincian
    header("Location: ../../../views/transaksi/detail_pesanan/manage.php?id_pesanan=" . $id_pesanan);
    exit();
}
?>