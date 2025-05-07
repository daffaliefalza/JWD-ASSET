<?php
session_start();
include "config.php";

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data user
$user_query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = {$_SESSION['user_id']}");
$user_data = mysqli_fetch_assoc($user_query);

// Ambil data keranjang user
$cart_query = mysqli_query($conn, "
    SELECT produk.*, keranjang.jumlah 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = {$_SESSION['user_id']}
");

// Hitung total harga
$total = 0;
$items = [];
while ($row = mysqli_fetch_assoc($cart_query)) {
    $total += $row['harga'] * $row['jumlah'];
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .bank-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }

        .btn-submit {
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn-submit:hover {
            background: #45a049;
        }

        .order-summary {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h2>Checkout</h2>

    <!-- Ringkasan Pesanan -->
    <div class="order-summary">
        <h3>Ringkasan Pesanan</h3>
        <?php foreach ($items as $item): ?>
            <p>
                <?= htmlspecialchars($item['nama_produk']) ?> (<?= $item['jumlah'] ?>x) -
                Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?>
            </p>
        <?php endforeach; ?>
        <p><strong>Total Harga: Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
    </div>

    <!-- Form Checkout -->
    <form action="proses_checkout.php" method="POST" enctype="multipart/form-data">
        <!-- Data Pengiriman -->
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user_data['nama_lengkap'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="tel" name="no_telepon" value="<?= htmlspecialchars($user_data['no_telepon'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" rows="3" required><?= htmlspecialchars($user_data['alamat'] ?? '') ?></textarea>
        </div>

        <!-- Metode Pembayaran (Hanya Transfer Bank) -->
        <input type="hidden" name="metode_pembayaran" value="transfer_bank">

        <!-- Instruksi Transfer Bank -->
        <div class="bank-info">
            <h3>Instruksi Pembayaran</h3>
            <p>Silakan transfer ke rekening berikut:</p>
            <p><strong>Bank ABC</strong></p>
            <p>Nomor Rekening: <strong>1234 5678 9012</strong></p>
            <p>Atas Nama: <strong>Nama Toko Anda</strong></p>
            <p>Jumlah: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
            <p>Kode Referensi: <strong>ORDER-<?= time() ?></strong></p>
        </div>

        <!-- Upload Bukti Transfer -->
        <div class="form-group">
            <label>Upload Bukti Transfer (Format: JPG/PNG, max 2MB)</label>
            <input type="file" name="bukti_transfer" accept="image/jpeg, image/png" required>
        </div>

        <button type="submit" class="btn-submit">Konfirmasi Pesanan</button>
    </form>
</body>

</html>