<?php
session_start();
include '../config/connection.php';

// Add Album
if (isset($_POST['add'])) {
    // Prepare and sanitize input data
    $namaalbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];
    $tanggaldibuat = date('Y-m-d');
    $userid = $_SESSION['userid'];

    // Use a prepared statement for insertion
    $stmt = $conn->prepare("INSERT INTO album (namaalbum, deskripsi, tanggaldibuat, userid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $namaalbum, $deskripsi, $tanggaldibuat, $userid);

    if ($stmt->execute()) {
        echo "<script>
        alert('Album successfully created');
        location.href ='../admin/album.php';
        </script>";
    } else {
        echo "<script>
        alert('Failed to create album: " . mysqli_error($conn) . "');
        location.href ='../admin/album.php';
        </script>";
    }
    $stmt->close();
}

// Edit Album
if (isset($_POST['edit'])) {
    $albumid = $_POST['albumid'];
    $namaalbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];
    $tanggaldibuat = date('Y-m-d');

    // Use a prepared statement for updating
    $stmt = $conn->prepare("UPDATE album SET namaalbum, deskripsi, tanggaldibuat WHERE albumid");
    $stmt->bind_param("sssi", $namaalbum, $deskripsi, $tanggaldibuat, $albumid);

    if ($stmt->execute()) {
        echo "<script>
        alert('Album successfully updated');
        location.href ='../user/album.php';
        </script>";
    } else {
        echo "<script>
        alert('Failed to update album: " . mysqli_error($conn) . "');
        location.href ='../admin/album.php';
        </script>";
    }
    $stmt->close();
}

// Delete Album and Reset Auto-Increment
if (isset($_POST['delete'])) {
    $albumid = $_POST['albumid'];

    // Use a prepared statement for deletion
    $stmt = $conn->prepare("DELETE FROM album WHERE albumid=?");
    $stmt->bind_param("i", $albumid);

    if ($stmt->execute()) {
        // Optionally reset auto-increment
        mysqli_query($conn, "ALTER TABLE album AUTO_INCREMENT = 1");

        echo "<script>
        alert('Album successfully deleted');
        location.href ='../admin/album.php';
        </script>";
    } else {
        echo "<script>
        alert('Failed to delete album: " . mysqli_error($conn) . "');
        location.href ='../admin/album.php';
        </script>";
    }
    $stmt->close();
}
