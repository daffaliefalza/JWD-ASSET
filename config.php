<?php


$servername = "localhost";
$username = "root";
$password = "";
$database = "foodie";

$conn = mysqli_connect($servername, $username, $password, $database, 3307);

if (!$conn) {
    die("Gagal Bos") . mysqli_connect_error();
}
