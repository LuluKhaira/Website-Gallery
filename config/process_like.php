<?php
session_start();
include '../config/connection.php';

if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];
    $userid = $_SESSION['userid'];


    $checkLike = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");

    if (mysqli_num_rows($checkLike) > 0) {
        // JIKA USER SUDAH LIKE MAKA AKAN  DIHAPUS
        $unlike = mysqli_query($conn, "DELETE FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
        if ($unlike) {
            header("Location: ../admin/index.php?fotoid=$fotoid");
            exit();
        } else {
            echo "Error unliking the photo: " . mysqli_error($conn);
        }
    } else {
        // JIKA BELUM MAKA  AKAN DI TAMBAHKAN
        $like = mysqli_query($conn, "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')");
        if ($like) {
            header("Location: ../admin/index.php?fotoid=$fotoid");
            exit();
        } else {
            echo "Error liking the photo: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid photo ID.";
}
