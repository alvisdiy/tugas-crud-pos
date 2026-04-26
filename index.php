<?php
// index.php (Root)
require_once 'config/database.php';

// 1. Metrik Kartu Atas
$total_pelanggan = $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();
$total_resto = $pdo->query("SELECT COUNT(*) FROM restoran")->fetchColumn();
$total_transaksi = $pdo->query("SELECT COUNT(*) FROM pesanan")->fetchColumn();
$pendapatan = $pdo->query("SELECT SUM(total) FROM pesanan")->fetchColumn();

// 2. Data Transaksi Terakhir untuk Dashboard
$sql_recent = "SELECT p.id_pesanan, pl.nama AS nama_pelanggan, r.nama_resto, p.waktu, p.total 
               FROM pesanan p
               JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
               JOIN restoran r ON p.id_resto = r.id_resto
               ORDER BY p.waktu DESC 
               LIMIT 5";
$recent_trx = $pdo->query($sql_recent)->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Restoran</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ccc; padding: 15px; margin: 10px; display: inline-block; width: 200px; text-align: center; background-color: #f9f9f9; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
        .card h3 { font-size: 14px; color: #666; margin-bottom: 5px; }
        .card h2 { margin: 0; color: #333; font-size: 24px; }
        table { border-collapse: collapse; width: 100%; max-width: 900px; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Lobi Utama - Dashboard Sistem</h1>
    <hr>
    
    <div>
        <div class="card">
            <h3>Total Pelanggan</h3><h2><?= $total_pelanggan ?></h2>
        </div>
        <div class="card">
            <h3>Total Restoran</h3><h2><?= $total_resto ?></h2>
        </div>
        <div class="card">
            <h3>Total Transaksi</h3><h2><?= $total_transaksi ?></h2>
        </div>
        <div class="card">
            <h3>Total Pendapatan</h3><h2 style="color: #28a745;">Rp <?= number_format($pendapatan ?: 0, 0, ',', '.') ?></h2>
        </div>
    </div>

    <br>
    
    <h3>5 Transaksi Terakhir</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Waktu</th><th>Pelanggan</th><th>Restoran</th><th>Nilai Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($recent_trx) > 0): ?>
                <?php foreach($recent_trx as $trx): ?>
                <tr>
                    <td>#<?= $trx['id_pesanan'] ?></td>
                    <td><?= $trx['waktu'] ?></td>
                    <td><?= htmlspecialchars($trx['nama_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($trx['nama_resto']) ?></td>
                    <td><b>Rp <?= number_format($trx['total'], 0, ',', '.') ?></b></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center;">Belum ada transaksi.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <hr>

    <h3>Pilih Modul Sistem:</h3>
    <ul>
        <li><a href="views/master/pelanggan/index.php" style="font-size: 18px;"><b>Manajemen Pelanggan</b></a></li><br>
        <li><a href="views/master/restoran/index.php" style="font-size: 18px;"><b>Manajemen Restoran & Menu</b></a></li><br>
        <li><a href="views/transaksi/pesanan/index.php" style="font-size: 18px;"><b>Modul Kasir (Pesanan)</b></a></li>
    </ul>
</body>
</html>