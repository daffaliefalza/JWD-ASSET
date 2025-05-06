<?php
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori_produk = $_POST['kategori_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $gambar_lama = $_POST['gambar_lama'];

    // Cek apakah gambar baru di-upload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $upload_dir = "uploads/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Hapus gambar lama jika ada
        if (file_exists($upload_dir . $gambar_lama)) {
            unlink($upload_dir . $gambar_lama);
        }

        // Pindahkan file gambar yang di-upload
        $gambar_path = $upload_dir . basename($gambar);
        move_uploaded_file($tmp_name, $gambar_path);
    } else {
        $gambar = $gambar_lama; // Jika gambar tidak diubah, pakai gambar lama
    }

    // Query untuk update produk
    $query = "UPDATE produk SET 
                nama_produk = '$nama_produk', 
                kategori_produk = '$kategori_produk', 
                gambar = '$gambar', 
                harga = '$harga', 
                deskripsi = '$deskripsi', 
                stok = '$stok' 
              WHERE id_produk = $id_produk";

    if (mysqli_query($conn, $query)) {
        echo "Produk berhasil diupdate!";
        header("Location: index.php"); // Redirect kembali ke halaman index setelah update
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
