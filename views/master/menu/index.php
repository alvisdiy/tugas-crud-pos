<?php
require_once '../../../config/database.php';

$id_resto = $_GET['id_resto'] ?? die("Error: Harus pilih restoran dulu!");

// Ambil info nama restoran untuk judul halaman
$stmtResto = $pdo->prepare("SELECT nama_resto FROM restoran WHERE id_resto = ?");
$stmtResto->execute([$id_resto]);
$nama_resto = $stmtResto->fetchColumn();

// Hanya ambil menu milik restoran ini
$sql = "SELECT * FROM menu WHERE id_resto = ? ORDER BY nama_menu ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_resto]);
$menu = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu - <?= $nama_resto ?></title>
</head>
<body>
    <h2>Daftar Menu: <?= htmlspecialchars($nama_resto) ?></h2>
    <a href="create.php?id_resto=<?= $id_resto ?>">+ Tambah Menu Baru</a>
    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menu as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_menu']) ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_menu'] ?>">Edit</a> | 
                    <a href="../../../controllers/master/menu/delete.php?id=<?= $row['id_menu'] ?>&id_resto=<?= $id_resto ?>" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="../restoran/index.php"> Kembali ke Daftar Restoran</a>
</body>
</html>