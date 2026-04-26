<?php
require_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pesanan = $_POST['id_pesanan'];
    $id_menu = $_POST['id_menu'];
    $jumlah = $_POST['jumlah'];

    try {
        $pdo->beginTransaction(); 

        // 1. Cari tahu harga menu dari database
        $stmtMenu = $pdo->prepare("SELECT harga FROM menu WHERE id_menu = ?");
        $stmtMenu->execute([$id_menu]);
        $harga_satuan = $stmtMenu->fetchColumn();

        // 2. LOGIKA BARU: Cek apakah menu ini sudah ada di dalam struk/nota ini?
        $stmtCheck = $pdo->prepare("SELECT id_detail, jumlah FROM detail_pesanan WHERE id_pesanan = ? AND id_menu = ?");
        $stmtCheck->execute([$id_pesanan, $id_menu]);
        $item_sebelumnya = $stmtCheck->fetch();

        if ($item_sebelumnya) {
            // JIKA SUDAH ADA: Jangan Insert! Lakukan UPDATE dengan menambahkan jumlahnya.
            $jumlah_baru = $item_sebelumnya['jumlah'] + $jumlah;
            $subtotal_baru = $harga_satuan * $jumlah_baru;

            $sqlUpdateDetail = "UPDATE detail_pesanan SET jumlah = ?, subtotal = ? WHERE id_detail = ?";
            $stmtUpdateDetail = $pdo->prepare($sqlUpdateDetail);
            $stmtUpdateDetail->execute([$jumlah_baru, $subtotal_baru, $item_sebelumnya['id_detail']]);
        } else {
            // JIKA BELUM ADA: Lakukan INSERT seperti biasa
            $subtotal = $harga_satuan * $jumlah;
            $sqlInsert = "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([$id_pesanan, $id_menu, $jumlah, $subtotal]);
        }

        // 4. OTOMATISASI: Update kolom 'total' di tabel pesanan utama
        $sqlUpdateTotal = "UPDATE pesanan SET total = (SELECT SUM(subtotal) FROM detail_pesanan WHERE id_pesanan = ?) WHERE id_pesanan = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdateTotal);
        $stmtUpdate->execute([$id_pesanan, $id_pesanan]);

        $pdo->commit(); // Simpan permanen

    } catch (Exception $e) {
        $pdo->rollBack(); // Batalkan jika ada error
        die("Error: " . $e->getMessage());
    }

    // Kembalikan kasir ke layar rincian struk tadi
    header("Location: ../../../views/transaksi/detail_pesanan/manage.php?id_pesanan=" . $id_pesanan);
    exit();
}
?>