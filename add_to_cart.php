<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Silakan login!"]);
    exit;
}

$id_produk = (int)$_POST['id_produk'];
$id_user = (int)$_SESSION['user_id'];

// Cek apakah produk sudah ada di keranjang
$check = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = $id_user AND id_produk = $id_produk");

if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_user = $id_user AND id_produk = $id_produk");
} else {
    mysqli_query($conn, "INSERT INTO keranjang (id_user, id_produk, jumlah) VALUES ($id_user, $id_produk, 1)");
}

echo json_encode(["status" => "success", "message" => "Produk ditambahkan ke keranjang!"]);
