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
        $query_produk = "SELECT * FROM produk";
        $result_produk = mysqli_query($conn, $query_produk);

        if (mysqli_num_rows($result_produk) > 0) :
            while ($row_produk = mysqli_fetch_assoc($result_produk)) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row_produk['nama_produk']; ?></td>
                    <td><?php echo $row_produk['kategori_produk']; ?></td>
                    <td><img src="uploads/<?php echo $row_produk['gambar']; ?>" width="50"></td>
                    <td><?php echo $row_produk['harga']; ?></td>
                    <td><?php echo $row_produk['deskripsi']; ?></td>
                    <td><?php echo $row_produk['stok']; ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?php echo $row_produk['id_produk']; ?>">Edit</a> |
                        <a href="hapus_produk.php?id=<?php echo $row_produk['id_produk']; ?>" onclick="return confirm('Yakin ingin hapus produk ini?');">Delete</a>
                    </td>
                </tr>
        <?php
            endwhile;
        else :
            echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        endif;
        ?>
    </table>


    <h2>Data User</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>username</th>
            <th>nama lengkap</th>
            <th>no telp</th>
            <th>alamat</th>
            <th>dibuat pada</th>
        </tr>

        <?php
        $no = 1;
        $query_user = "SELECT * FROM user";
        $result_user = mysqli_query($conn, $query_user);

        if (mysqli_num_rows($result_user) > 0) :
            while ($row_user = mysqli_fetch_assoc($result_user)) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row_user['username']; ?></td>
                    <td><?php echo $row_user['nama_lengkap']; ?></td>
                    <td><?php echo $row_user['no_telepon']; ?></td>
                    <td><?php echo $row_user['alamat']; ?></td>
                    <td><?php echo $row_user['created_at']; ?></td>

                </tr>
        <?php
            endwhile;
        else :
            echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        endif;
        ?>
    </table>

    <h2>Data Pesanan</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Pesanan</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query_pesanan = "SELECT pesanan.*, user.username 
                      FROM pesanan 
                      JOIN user ON pesanan.id_user = user.id_user
                      ORDER BY pesanan.created_at DESC";
        $result_pesanan = mysqli_query($conn, $query_pesanan);

        if (mysqli_num_rows($result_pesanan) > 0) :
            while ($row = mysqli_fetch_assoc($result_pesanan)) :
        ?>
                <tr>
                    <td><?= $row['id_pesanan'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    <td>
                        <form action="update_status.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" <?= ($row['status'] == 'pending') ? 'selected' : '' ?>>pending</option>
                                <option value="diproses" <?= ($row['status'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                <option value="dikirim" <?= ($row['status'] == 'dikirim') ? 'selected' : '' ?>>Dikirim</option>
                                <option value="selesai" <?= ($row['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="detail_pesanan.php?id=<?= $row['id_pesanan'] ?>">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Tidak ada pesanan.</td>
            </tr>
        <?php endif; ?>
    </table>


</body>

</html>
