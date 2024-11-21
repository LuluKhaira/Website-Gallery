<?php
session_start();
include '../config/connection.php';

$fotoid = mysqli_real_escape_string($conn, $_POST['fotoid']);
$userid = mysqli_real_escape_string($conn, $_POST['userid']);
$isikomentar = mysqli_real_escape_string($conn, $_POST['isikomentar']);

$query = "
    INSERT INTO komentarfoto (fotoid, userid, isikomentar, tanggalkomentar) 
    VALUES ('$fotoid', '$userid', '$isikomentar', NOW())
";

if (mysqli_query($conn, $query)) {
    header("Location: ../user/photo_detail.php?fotoid=$fotoid");
} else {
    die("Error: " . mysqli_error($conn));
}