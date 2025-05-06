<?php
session_start();
include "../config.php";



if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


// Proses saat form disubmit
if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $kategori_produk = $_POST['kategori_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $gambar_path = $upload_dir . basename($gambar);

    if (move_uploaded_file($tmp_name, $gambar_path)) {
        $query = "INSERT INTO produk (nama_produk, kategori_produk, gambar, harga, deskripsi, stok) 
                  VALUES ('$nama_produk', '$kategori_produk', '$gambar', '$harga', '$deskripsi', '$stok')";

        if (mysqli_query($conn, $query)) {
            echo "Produk berhasil ditambahkan!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk</title>
</head>

<body>

    <h1>Ini adalah halaman admin</h1>
    <h2>Admin Data produk</h2>
    <h3>Halo admin <?php echo $_SESSION['username'] ?></h3>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama_produk" required><br><br>

        <label>Kategori Produk:</label><br>
        <select name="kategori_produk" required>
            <option value="Elektronik">Elektronik</option>
            <option value="Pakaian">Pakaian</option>
            <option value="Makanan">Makanan</option>
            <option value="Aksesoris">Aksesoris</option>
        </select><br><br>


        <label>Gambar:</label><br>
        <input type="file" name="gambar" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br><br>

        <button type="submit" name="submit">Tambah Produk</button>
    </form>


    <h2>Data Produk</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $query = "SELECT * FROM produk";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_assoc($result)) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_produk']; ?></td>
                    <td><?php echo $row['kategori_produk']; ?></td>
                    <td><img src="uploads/<?php echo $row['gambar']; ?>" width="50"></td>
                    <td><?php echo $row['harga']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>">Edit</a> |
                        <a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" onclick="return confirm('Yakin ingin hapus produk ini?');">Delete</a>
                    </td>
                </tr>
        <?php
            endwhile;
        else :
            echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        endif;
        ?>
    </table>


</body>

</html>