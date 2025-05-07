<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register User</title>
</head>

<body>
    <h2>Form Registrasi User</h2>
    <form action="proses_register_user.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Nama Lengkap</label><br>
        <input type="text" name="nama_lengkap" required><br><br>

        <label>No Telepon:</label><br>
        <input type="number" name="no_telepon" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" required></textarea><br><br>

        <button type="submit">Register</button>
    </form>
</body>

</html>