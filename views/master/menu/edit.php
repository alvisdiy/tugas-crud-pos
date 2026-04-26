<?php
require_once '../../../config/database.php';

$id = $_GET['id'];

// 1. Ambil data menu yang mau diedit
$stmt = $pdo->prepare("SELECT * FROM menu WHERE id_menu = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch();

if (!$menu) {
    die("Menu tidak ditemukan!");
}

// 2. Ambil daftar semua restoran untuk dropdown
$stmtResto = $pdo->query("SELECT id_resto, nama_resto FROM restoran ORDER BY nama_resto ASC");
$daftarRestoran = $stmtResto->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
</head>
<body>
    <h2>Edit Data Menu</h2>
    <form action="../../../controllers/master/menu/update.php" method="POST">
        <input type="hidden" name="id_menu" value="<?= $menu['id_menu'] ?>">
        
        <label for="id_resto">Pilih Restoran:</label><br>
        <select name="id_resto" id="id_resto" required>
            <option value="">-- Pilih Restoran --</option>
            <?php foreach ($daftarRestoran as $resto): ?>
                <option value="<?= $resto['id_resto'] ?>" <?= ($resto['id_resto'] == $menu['id_resto']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($resto['nama_resto']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="nama_menu">Nama Menu:</label><br>
        <input type="text" id="nama_menu" name="nama_menu" value="<?= htmlspecialchars($menu['nama_menu']) ?>" required><br><br>

        <label for="harga">Harga (Rp):</label><br>
        <input type="number" id="harga" name="harga" min="0" value="<?= $menu['harga'] ?>" required><br><br>

        <button type="submit">Update Menu</button>
    </form>
    <br>
    <a href="index.php">Batal & Kembali</a>
</body>
</html>