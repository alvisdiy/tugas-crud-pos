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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Restoran</title>
    <style>
        :root {
            --bg: #f4f7ff;
            --panel: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --primary: #4f46e5;
            --success: #16a34a;
            --shadow: 0 10px 30px rgba(79, 70, 229, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Segoe UI, Roboto, Arial, sans-serif;
            background: linear-gradient(160deg, #eef2ff 0%, #f8fafc 45%, #f5f3ff 100%);
            color: var(--text);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 20px 50px;
        }

        .hero {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .hero h1 { margin: 0 0 6px; font-size: 30px; }
        .hero p { margin: 0; color: var(--muted); }

        .module-list {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }

        .module-link {
            display: block;
            background: #f8faff;
            border: 1px solid #dbe4ff;
            color: #1e293b;
            text-decoration: none;
            border-radius: 12px;
            padding: 14px 16px;
            font-weight: 600;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .module-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(30, 64, 175, 0.15);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px;
            box-shadow: var(--shadow);
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
        }

        .card h2 { margin: 0; font-size: 30px; }

        .table-wrap {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
        }

        .table-head h3 { margin: 0; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #334155;
            font-weight: 600;
        }

        tr:hover td { background: #fafbff; }
        .money { color: var(--success); font-weight: 700; }
        .empty { text-align: center; color: var(--muted); }
    </style>
</head>
<body>
    <main class="container">
        <section class="hero">
            <h1>Lobi Utama</h1>
            <p>Dashboard ringkas untuk manajemen pelanggan, restoran, dan transaksi kasir.</p>
            <div class="module-list">
                <a class="module-link" href="views/master/pelanggan/index.php">Manajemen Pelanggan</a>
                <a class="module-link" href="views/master/restoran/index.php">Manajemen Restoran &amp; Menu</a>
                <a class="module-link" href="views/transaksi/pesanan/index.php">Modul Kasir (Pesanan)</a>
            </div>
        </section>

        <section class="stats">
            <div class="card">
                <h3>Total Pelanggan</h3>
                <h2><?= $total_pelanggan ?></h2>
            </div>
            <div class="card">
                <h3>Total Restoran</h3>
                <h2><?= $total_resto ?></h2>
            </div>
            <div class="card">
                <h3>Total Transaksi</h3>
                <h2><?= $total_transaksi ?></h2>
            </div>
            <div class="card">
                <h3>Total Pendapatan</h3>
                <h2 class="money">Rp <?= number_format($pendapatan ?: 0, 0, ',', '.') ?></h2>
            </div>
        </section>

        <section class="table-wrap">
            <div class="table-head">
                <h3>5 Transaksi Terakhir</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Waktu</th>
                        <th>Pelanggan</th>
                        <th>Restoran</th>
                        <th>Nilai Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($recent_trx) > 0): ?>
                        <?php foreach ($recent_trx as $trx): ?>
                        <tr>
                            <td>#<?= $trx['id_pesanan'] ?></td>
                            <td><?= $trx['waktu'] ?></td>
                            <td><?= htmlspecialchars($trx['nama_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($trx['nama_resto']) ?></td>
                            <td><span class="money">Rp <?= number_format($trx['total'], 0, ',', '.') ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="empty">Belum ada transaksi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
