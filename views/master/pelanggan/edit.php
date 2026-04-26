<?php
require_once '../../../config/database.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    die("Data tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Pelanggan</title>
</head>

<body>
    <h2>Edit Data Pelanggan</h2>
    <form action="../../../controllers/master/pelanggan/update.php" method="POST">
        <input type="hidden" name="id_pelanggan" value="<?= $data['id_pelanggan'] ?>">

        <label for="nama">Nama Pelanggan:</label><br>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea><br><br>

        <label for="no_hp">No. HP:</label><br>
        <input type="text" id="no_hp" name="no_hp" value="<?= isset($data) ? htmlspecialchars($data['no_hp']) : '' ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= isset($data) ? htmlspecialchars($data['email']) : '' ?>" required><br><br>

        <button type="submit">Update Data</button>
    </form>
    <br>
    <a href="index.php">Batal & Kembali</a>
</body>

</html>