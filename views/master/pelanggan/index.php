<?php
require_once '../../../config/database.php';

$search = $_GET['search'] ?? '';

if ($search) {
    $sql = "SELECT * FROM pelanggan 
            WHERE nama LIKE ? 
            OR alamat LIKE ? 
            OR no_hp LIKE ? 
            ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $keyword = "%$search%";
    $stmt->execute([$keyword, $keyword, $keyword]);
} else {
    $stmt = $pdo->query("SELECT * FROM pelanggan ORDER BY created_at DESC");
}
$pelanggan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
</head>
<body>
    <h2>Daftar Pelanggan</h2>
    <a href="../../../index.php">Kembali ke Lobi Utama</a> | <a href="create.php">+ Tambah Pelanggan Baru</a>
    <br><br>

    <form method="GET" action="index.php" style="margin-bottom: 15px; padding: 10px; background: #eee; border: 1px solid #ccc; display: inline-block;">
        <label><b>Pencarian:</b></label>
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari...">
        <button type="submit">Cari</button>
        <?php if($search): ?>
            <a href="index.php">Reset </a>
        <?php endif; ?>
    </form>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="background: #ddd;">
                <th>ID</th><th>Nama</th><th>Alamat</th><th>No. HP</th><th>Email</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($pelanggan) > 0): ?>
                <?php foreach ($pelanggan as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id_pelanggan'] ?>">Edit</a> | 
                        <a href="../../../controllers/master/pelanggan/delete.php?id=<?= $row['id_pelanggan'] ?>" onclick="return confirm('Yakin?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>