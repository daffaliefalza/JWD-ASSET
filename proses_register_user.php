<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];

    $cek = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO user (username, password, nama_lengkap, no_telepon, alamat) 
                  VALUES ('$username', '$password', '$nama_lengkap', '$no_telepon', '$alamat')";
        if (mysqli_query($conn, $query)) {
            echo "Registrasi berhasil! <a href='login_user.php'>Login di sini</a>.";
        } else {
            echo "Registrasi gagal!";
        }
    }
}
