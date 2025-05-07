<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || !isset($_GET['id_pesanan'])) {
    header("Location: index.php");
    exit;
}

$id_pesanan = (int)$_GET['id_pesanan'];
$query = mysqli_query($conn, "
    SELECT * FROM pesanan 
    WHERE id_pesanan = $id_pesanan 
    AND id_user = {$_SESSION['user_id']}
");
$pesanan = mysqli_fetch_assoc($query);

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Konfirmasi Pesanan</title>
</head>

<body>
    <h2>Pesanan Berhasil Dibuat!</h2>
    <p>ID Pesanan: <?php echo $pesanan['id_pesanan']; ?></p>
    <p>Total: Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></p>
    <p>Status: <?php echo ucfirst(str_replace('_', ' ', $pesanan['status'])); ?></p>
    <p>Metode Pembayaran: <?php echo strtoupper($pesanan['metode_pembayaran']); ?></p>

    <?php if ($pesanan['metode_pembayaran'] == 'transfer_bank'): ?>
        <div style="border: 1px solid #ccc; padding: 15px; margin-top: 20px;">
            <h3>Instruksi Pembayaran</h3>
            <p>Transfer ke: BANK ABC (1234567890)</p>
            <p>Jumlah: Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></p>
            <p>Kode Referensi: ORDER-<?php echo $pesanan['id_pesanan']; ?></p>
        </div>
    <?php endif; ?>

    <a href="index.php" style="display: inline-block; margin-top: 20px;">Kembali ke Beranda</a>
</body>

</html>