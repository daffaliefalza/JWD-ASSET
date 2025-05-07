<?php
session_start();
include "config.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

$id_pesanan = (int)$_GET['id'];

// Ambil data pesanan
$query_pesanan = mysqli_query($conn, "
    SELECT * FROM pesanan 
    WHERE id_pesanan = $id_pesanan 
    AND id_user = {$_SESSION['user_id']}
");
$pesanan = mysqli_fetch_assoc($query_pesanan);

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}

// Ambil item pesanan
$query_items = mysqli_query($conn, "
    SELECT detail_pesanan.*, produk.nama_produk, produk.gambar
    FROM detail_pesanan
    JOIN produk ON detail_pesanan.id_produk = produk.id_produk
    WHERE detail_pesanan.id_pesanan = $id_pesanan
");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .bukti-transfer {
            max-width: 300px;
            margin-top: 10px;
        }

        .status-pending {
            color: #e67e22;
        }

        .status-diproses {
            color: #3498db;
        }

        .status-dikirim {
            color: #2ecc71;
        }

        .status-selesai {
            color: #27ae60;
        }
    </style>
</head>

<body>
    <h1>Detail Pesanan #<?= $pesanan['id_pesanan'] ?></h1>

    <div class="info-section">
        <h3>Informasi Pesanan</h3>
        <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></p>
        <p><strong>Status:</strong>
            <span class="status-<?= str_replace('_', '-', $pesanan['status']) ?>">
                <?php
                $status = [
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'diproses' => 'Diproses',
                    'dikirim' => 'Dikirim',
                    'selesai' => 'Selesai'
                ];
                echo $status[$pesanan['status']] ?? $pesanan['status'];
                ?>
            </span>
        </p>
        <p><strong>Total:</strong> Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></p>
        <p><strong>Alamat Pengiriman:</strong><br><?= nl2br(htmlspecialchars($pesanan['alamat'])) ?></p>
    </div>

    <div class="info-section">
        <h3>Item Pesanan</h3>
        <table>
            <tr>
                <th>Produk</th>
                <th>Gambar</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
            <?php while ($item = mysqli_fetch_assoc($query_items)): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                    <td><img src="admin/uploads/<?= $item['gambar'] ?>" width="50"></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a href="index.php">&laquo; Kembali ke Beranda</a>
</body>

</html>