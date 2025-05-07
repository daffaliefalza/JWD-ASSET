<?php
session_start();
include "../config.php";



$id_pesanan = (int)$_POST['id_pesanan'];
$status = mysqli_real_escape_string($conn, $_POST['status']);

mysqli_query($conn, "
    UPDATE pesanan 
    SET status = '$status' 
    WHERE id_pesanan = $id_pesanan
");

header("Location: index.php");  // Kembali ke halaman admin
