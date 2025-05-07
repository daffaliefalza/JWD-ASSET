<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data keranjang
$query = mysqli_query($conn, "
    SELECT produk.nama_produk, produk.harga, keranjang.jumlah 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = {$_SESSION['user_id']}
");

$total = 0;
$item_count = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Keranjang</title>
    <script>
        function validateCheckout() {
            <?php if ($item_count == 0): ?>
                alert("Keranjang kosong! Tambahkan produk terlebih dahulu.");
                window.location.href = "index.php";
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }
    </script>
</head>

<body>
    <h2>Keranjang Belanja</h2>
    <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <div>
            <h3><?php echo $row['nama_produk']; ?></h3>
            <p>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            <p>Jumlah: <?php echo $row['jumlah']; ?></p>
        </div>
        <?php $total += $row['harga'] * $row['jumlah']; ?>
    <?php endwhile; ?>
    <h4>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></h4>


    <div style="margin-top: 20px;">
        <a href="checkout.php" onclick="return validateCheckout()" style="background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">Checkout</a>
    </div>

</body>

</html>