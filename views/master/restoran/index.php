<?php
require_once '../../../config/database.php';
$stmt = $pdo->query("SELECT * FROM restoran ORDER BY created_at ASC");
$restoran = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Restoran</title>
</head>
<body>
    <h2>Daftar Restoran</h2>
    <a href="../../../index.php">Kembali ke Lobi Utama</a>
    <br><br>

    <a href="create.php">+ Tambah Restoran Baru</a>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID Resto</th>
                <th>Nama Restoran</th>
                <th>Alamat</th>
                <th>Aksi Utama</th>
                <th>Manajemen Resto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($restoran as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id_resto']) ?></td>
                <td><b><?= htmlspecialchars($row['nama_resto']) ?></b></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                
                <td>
                    <a href="../../../views/master/menu/index.php?id_resto=<?= $row['id_resto'] ?>" style="color: blue;">
                        <b>[+] Buka & Kelola Menu</b>
                    </a>
                </td>
                
                <td>
                    <a href="edit.php?id=<?= $row['id_resto'] ?>">Edit Info</a> | 
                    <a href="../../../controllers/master/restoran/delete.php?id=<?= $row['id_resto'] ?>" onclick="return confirm('Peringatan: Menghapus restoran akan menghapus semua menu di dalamnya. Yakin?')">Hapus Resto</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
</body>
</html>