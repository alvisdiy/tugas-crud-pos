<!DOCTYPE html>
<html>
<head>
    <title>Tambah Restoran</title>
</head>
<body>
    <h2>Tambah Data Restoran Baru</h2>
    <form action="../../../controllers/master/restoran/store.php" method="POST">
        <label for="nama_resto">Nama Restoran:</label><br>
        <input type="text" id="nama_resto" name="nama_resto" required><br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required></textarea><br><br>

        <button type="submit">Simpan Data</button>
    </form>
    <br>
    <a href="index.php">Batal & Kembali</a>
</body>
</html>