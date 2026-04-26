<!DOCTYPE html>
<html>

<head>
    <title>Tambah Pelanggan</title>
</head>

<body>
    <h2>Tambah Data Pelanggan Baru</h2>
    <form action="../../../controllers/master/pelanggan/store.php" method="POST">
        <label for="nama">Nama Pelanggan:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required></textarea><br><br>

        <label for="no_hp">No. HP:</label><br>
        <input type="text" id="no_hp" name="no_hp" value="<?= isset($data) ? htmlspecialchars($data['no_hp']) : '' ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= isset($data) ? htmlspecialchars($data['email']) : '' ?>" required><br><br>

        <button type="submit">Simpan Data</button>
    </form>
    <br>
    <a href="index.php">Batal & Kembali</a>
</body>

</html>