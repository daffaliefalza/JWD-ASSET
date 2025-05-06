<?php
include "../config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM produk WHERE id_produk = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
                alert('Data telah dihapus!');
                window.location.href = 'index.php';
              </script>";
        exit;
    } else {
        echo "Gagal menghapus produk.";
    }
} else {
    echo "ID tidak ditemukan.";
}

?>

<?php
// ini versi lebih kompleks
// include "../config.php";

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];

//     // Ambil nama gambar dulu biar bisa dihapus dari folder juga
//     $querySelect = "SELECT gambar FROM produk WHERE id_produk = $id";
//     $resultSelect = mysqli_query($conn, $querySelect);
//     $row = mysqli_fetch_assoc($resultSelect);

//     // Hapus gambar dari folder (jika ada)
//     if ($row && file_exists("uploads/" . $row['gambar'])) {
//         unlink("uploads/" . $row['gambar']);
//     }

//     // Hapus dari database
//     $query = "DELETE FROM produk WHERE id_produk = $id";
//     $result = mysqli_query($conn, $query);

//     if ($result) {
//         header("Location: index.php");
//         exit;
//     } else {
//         echo "Gagal menghapus produk.";
//     }
// } else {
//     echo "ID tidak ditemukan.";
// }
?>