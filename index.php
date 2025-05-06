<?php
include "config.php";


// untuk nampilin produk
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);


// untuk search produk
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
    // mencari berdasarkan nama_produk atau kategori_produk
    $query .= " WHERE nama_produk LIKE '%$keyword%' OR kategori_produk LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <h1>Ini adalah home customer</h1>

    <h2>Daftar Produk</h2>
    <form method="GET" action="">
        <input type="text" name="keyword" placeholder="Cari produk atau kategori..." value="<?php echo htmlspecialchars($keyword); ?>">
        <button type="submit">Cari</button>
    </form>

    <br>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div style="margin-bottom: 30px; border: 1px solid black; width: 200px;">
                <img src="admin/uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_produk']; ?>" width="150">
                <h3><?php echo $row['nama_produk']; ?></h3>
                <p>Kategori: <?php echo $row['kategori_produk']; ?></p>
                <p>Harga: Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                <p>Deskripsi: <?php echo $row['deskripsi']; ?></p>
                <p>Stok: <?php echo $row['stok']; ?></p>
                <button>Add to cart</button>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Tidak ada produk tersedia.</p>
    <?php } ?>





</body>

</html>