<?php
require_once '../../../config/database.php';
$id = $_GET['id'];

// 1. Ambil data pesanan lama
$stmt = $pdo->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
$stmt->execute([$id]);
$pesanan = $stmt->fetch();

if (!$pesanan) die("Data Transaksi tidak ditemukan!");

// 2. Tarik data master untuk dropdown
$daftarPelanggan = $pdo->query("SELECT id_pelanggan, nama FROM pelanggan")->fetchAll();
$daftarRestoran = $pdo->query("SELECT id_resto, nama_resto FROM restoran")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head><title>Edit Pesanan</title></head>
<body>
    <h2>Edit Transaksi Pesanan #<?= $id ?></h2>
    <form action="../../../controllers/transaksi/pesanan/update.php" method="POST">
        <input type="hidden" name="id_pesanan" value="<?= $id ?>">
        
        <label>Pelanggan:</label><br>
        <select name="id_pelanggan">
            <?php foreach($daftarPelanggan as $pl): ?>
                <option value="<?= $pl['id_pelanggan'] ?>" <?= $pl['id_pelanggan'] == $pesanan['id_pelanggan'] ? 'selected' : '' ?>>
                    <?= $pl['nama'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Restoran:</label><br>
        <select name="id_resto">
            <?php foreach($daftarRestoran as $r): ?>
                <option value="<?= $r['id_resto'] ?>" <?= $r['id_resto'] == $pesanan['id_resto'] ? 'selected' : '' ?>>
                    <?= $r['nama_resto'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Waktu:</label><br>
        <input type="datetime-local" name="waktu" value="<?= date('Y-m-d\TH:i', strtotime($pesanan['waktu'])) ?>"><br><br>

        <button type="submit">Update Header Pesanan</button>
    </form>
    <br><a href="index.php">Batal</a>
</body>
</html>