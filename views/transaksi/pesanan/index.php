<?php
require_once '../../../config/database.php';

// Dapur: Kita lakukan JOIN ke dua tabel master sekaligus
$sql = "SELECT 
            p.id_pesanan, 
            p.waktu, 
            p.total, 
            pl.nama AS nama_pelanggan, 
            pl.no_hp,
            r.nama_resto 
        FROM pesanan p
        JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
        JOIN restoran r ON p.id_resto = r.id_resto
        ORDER BY p.waktu DESC";

$stmt = $pdo->query($sql);
$pesanan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Pesanan</title>
</head>

<body>
    <h2>Daftar Transaksi Pesanan</h2>
    <a href="create.php">Buat Pesanan Baru</a>
    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Waktu</th>
                <th>Pelanggan</th>
                <th>No. HP</th>
                <th>Restoran</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pesanan as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_pesanan']) ?></td>
                    <td><?= htmlspecialchars($row['waktu']) ?></td>
                    <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['nama_resto']) ?></td>
                    <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    <td>
                        <a href="../detail_pesanan/manage.php?id_pesanan=<?= $row['id_pesanan'] ?>" style="color: green; font-weight: bold;">
                            Detail
                        </a> |
                        <a href="edit.php?id=<?= $row['id_pesanan'] ?>">Edit</a> |
                        <a href="../../../controllers/transaksi/pesanan/delete.php?id=<?= $row['id_pesanan'] ?>" onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="../../../index.php">Kembali ke Menu Utama</a>
</body>

</html>