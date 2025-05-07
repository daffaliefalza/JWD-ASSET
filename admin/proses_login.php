<?php
session_start();
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        // Login sukses
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['username'] = $admin['username'];
        header("Location: index.php");
    } else {
        echo "Login gagal. Username atau password salah.";
    }
}
