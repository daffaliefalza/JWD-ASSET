<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login User</title>
</head>

<body>


    <h2>Form Login User</h2>
    <form action="proses_login_user.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
        <p>belum punya akun? <a href="register_user.php">Register</a></p>
    </form>
</body>

</html>