<?php
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashedPassword')";

    if (mysqli_query($conn, $query)) {
        echo "Register berhasil. <a href='login.php'>Login sekarang</a>";
    } else {
        echo "Gagal register: " . mysqli_error($conn);
    }
}
