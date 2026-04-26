<?php
$id_resto = $_GET['id_resto'] ?? die("Akses ditolak!");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
</head>
<body>
    <h2>Tambah Menu Baru</h2>
    <form action="../../../controllers/master/menu/store.php" method="POST">
        <input type="hidden" name="id_resto" value="<?= $id_resto ?>">
        
        <label>Nama Menu:</label><br>
        <input type="text" name="nama_menu" required><br><br>

        <label>Harga (Rp):</label><br>
        <input type="number" name="harga" required><br><br>

        <button type="submit">Simpan ke Daftar Menu</button>
    </form>
    <br>
    <a href="index.php?id_resto=<?= $id_resto ?>">Batal</a>
</body>
</html>