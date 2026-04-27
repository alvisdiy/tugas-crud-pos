<?php
require_once '../../../config/database.php';

$id_pesanan = $_GET['id_pesanan'] ?? die("Akses Ditolak: ID Pesanan hilang!");
// Ambil info Struk Induk sekalian nama restoran dan pelanggan
$stmt = $pdo->prepare("SELECT p.*, r.nama_resto, r.id_resto, pl.nama AS nama_pelanggan 
                       FROM pesanan p 
                       JOIN restoran r ON p.id_resto = r.id_resto 
                       JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                       WHERE p.id_pesanan = ?");
$stmt->execute([$id_pesanan]);
$nota = $stmt->fetch();

if (!$nota) die("Nota tidak ditemukan!");
// Ambil hanya menu yang dimiliki oleh restoran di nota ini
$stmtMenu = $pdo->prepare("SELECT * FROM menu WHERE id_resto = ? ORDER BY nama_menu ASC");
$stmtMenu->execute([$nota['id_resto']]);
$daftarMenu = $stmtMenu->fetchAll();

// Ambil isi keranjang (detail_pesanan) saat ini
$stmtDetail = $pdo->prepare("SELECT dp.*, m.nama_menu, m.harga 
                             FROM detail_pesanan dp 
                             JOIN menu m ON dp.id_menu = m.id_menu 
                             WHERE dp.id_pesanan = ?");
$stmtDetail->execute([$id_pesanan]);
$rincian = $stmtDetail->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kelola Rincian Pesanan</title>
</head>

<body>
    <h2>Rincian Transaksi: #<?= $nota['id_pesanan'] ?></h2>
    <ul>
        <li>Pelanggan: <?= htmlspecialchars($nota['nama_pelanggan']) ?></li>
        <li>Restoran: <?= htmlspecialchars($nota['nama_resto']) ?></li>
        <li>Waktu: <?= htmlspecialchars($nota['waktu']) ?></li>
        <li><b>TOTAL SEMENTARA: Rp <?= number_format($nota['total'], 0, ',', '.') ?></b></li>
    </ul>
    <hr>

    <h3>Tambah Menu ke Pesanan</h3>
    <form action="../../../controllers/transaksi/detail_pesanan/store.php" method="POST">
        <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>">

        <label>Pilih Menu:</label>
        <select name="id_menu" required>
            <option value="">-- Pilih Menu --</option>
            <?php foreach ($daftarMenu as $m): ?>
                <option value="<?= $m['id_menu'] ?>">
                    <?= htmlspecialchars($m['nama_menu']) ?> (Rp <?= number_format($m['harga'], 0, ',', '.') ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="1" min="1" required>

        <button type="submit">+ Tambahkan</button>
    </form>
    <br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
        <tbody>
            <?php foreach ($rincian as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_menu']) ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>

                    <td>
                        <b><?= $row['jumlah'] ?></b>
                        <a href="../../../controllers/transaksi/detail_pesanan/reduce.php?id=<?= $row['id_detail'] ?>&id_pesanan=<?= $id_pesanan ?>"
                            style="text-decoration: none; color: white; background-color: red; padding: 2px 6px; border-radius: 4px; font-weight: bold; margin-left: 10px;"
                            title="Kurangi 1 Porsi"> - </a>
                    </td>

                    <td>Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                    <td>
                        <a href="../../../controllers/transaksi/detail_pesanan/delete.php?id=<?= $row['id_detail'] ?>&id_pesanan=<?= $id_pesanan ?>" onclick="return confirm('Batalkan seluruh menu ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </tbody>
    </table>

    <br>
    <a href="../../../views/transaksi/pesanan/index.php">Selesai & Simpan Transaksi</a>
</body>

</html>