<?php
require_once '../../../config/database.php';

// 1. Tarik data Pelanggan
$stmtPelanggan = $pdo->query("SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama ASC");
$daftarPelanggan = $stmtPelanggan->fetchAll();

// 2. Tarik data Restoran
$stmtResto = $pdo->query("SELECT id_resto, nama_resto FROM restoran ORDER BY nama_resto ASC");
$daftarRestoran = $stmtResto->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Pesanan</title>
</head>
<body>
    <h2>Buat Transaksi Pesanan Baru</h2>
    <form action="../../../controllers/transaksi/pesanan/store.php" method="POST">
        
        <label for="id_pelanggan">Pilih Pelanggan:</label><br>
        <select name="id_pelanggan" id="id_pelanggan" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php foreach ($daftarPelanggan as $pl): ?>
                <option value="<?= $pl['id_pelanggan'] ?>"><?= htmlspecialchars($pl['nama']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="id_resto">Pilih Restoran:</label><br>
        <select name="id_resto" id="id_resto" required>
            <option value="">-- Pilih Restoran --</option>
            <?php foreach ($daftarRestoran as $r): ?>
                <option value="<?= $r['id_resto'] ?>"><?= htmlspecialchars($r['nama_resto']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="total">Total Awal (Rp):</label><br>
        <input type="number" id="total" name="total" value="0" min="0" required><br><br>

        <button type="submit">Simpan Pesanan</button>
    </form>
    <br>
    <a href="index.php">Batal & Kembali</a>
</body>
</html>