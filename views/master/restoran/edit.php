<?php
require_once '../../../config/database.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM restoran WHERE id_resto = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    die("Data tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Restoran</title>
</head>
<body>
    <h2>Edit Data Restoran</h2>
    <form action="../../../controllers/master/restoran/update.php" method="POST">
        <input type="hidden" name="id_resto" value="<?= $data['id_resto'] ?>">
        
        <label for="nama_resto">Nama Restoran:</label><br>
        <input type="text" id="nama_resto" name="nama_resto" value="<?= htmlspecialchars($data['nama_resto']) ?>" required><br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        <br><br>
        <button type="submit">Update Data</button>
    </form>
    <br>
    <a href="index.php">Batal & Kembali</a>
</body>
</html>