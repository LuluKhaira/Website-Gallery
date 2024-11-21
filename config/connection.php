<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gallery_ukk";

// membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
