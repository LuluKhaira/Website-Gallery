<?php
session_start();
include '../config/connection.php';

// Add Photo
if (isset($_POST['add'])) {
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $albumid = $_POST['albumid'];
    $userid = $_SESSION['userid'];
    $namafile = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasifile = '../assets/img/';
    $namafoto = rand() . '-' . $namafile;

    if (move_uploaded_file($tmp, $lokasifile . $namafoto)) {
        // Insert into the database
        $sql = mysqli_query($conn, "INSERT INTO foto (judulfoto, deskripsifoto, tanggalunggah, lokasifile, albumid, userid) 
            VALUES ('$judulfoto', '$deskripsifoto', '$tanggalunggah', '$namafoto', '$albumid', '$userid')");

        if ($sql) {
            echo "<script>
            alert('Photo successfully created');
            location.href ='../admin/photo.php';
            </script>";
        } else {
            echo "<script>
            alert('Failed to create photo: " . mysqli_error($conn) . "');
            location.href ='../admin/photo.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('Failed to upload photo file');
        location.href ='../admin/photo.php';
        </script>";
    }
}

// Edit Photo
if (isset($_POST['edit'])) {
    $fotoid = $_POST['fotoid'];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $albumid = $_POST['albumid'];
    $userid = $_SESSION['userid'];
    $namafile = $_FILES['lokasifile']['nama'];
    $tmp = $_FILES['lokasifile']['tmp_nama'];
    $lokasifile = '../assets/img/';
    $namafoto = rand() . '-' . $namafile;

    if ($namafile == null) {
        // Update without changing the file
        $sql = mysqli_query($conn, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', albumid='$albumid' WHERE fotoid='$fotoid'");
    } else {
        // First, fetch the old photo data
        $query = mysqli_query($conn, "SELECT * FROM foto WHERE fotoid='$fotoid'");
        $data = mysqli_fetch_array($query);

        // Delete the old file if it exists
        if (is_file('../assets/img/' . $data['lokasifile'])) {
            unlink('../assets/img/' . $data['lokasifile']);
        }

        // Upload the new file
        move_uploaded_file($tmp, $lokasifile . $namafoto);

        // Update the database with the new file
        $sql = mysqli_query($conn, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', lokasifile='$namafoto', albumid='$albumid' WHERE fotoid='$fotoid'");
    }

    if ($sql) {
        echo "<script>
                alert('Photo successfully edited');
                location.href ='../admin/photo.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to edit photo: " . mysqli_error($conn) . "');
                location.href ='../admin/photo.php';
              </script>";
    }
}

// Delete Photo
if (isset($_POST['delete'])) {
    // Sanitize input data
    $fotoid = mysqli_real_escape_string($conn, $_POST['fotoid']);

    // Get the file location to delete the old file
    $query = mysqli_query($conn, "SELECT * FROM foto WHERE fotoid='$fotoid'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $lokasifile = $data['lokasifile'];

        // Delete the photo record from the database
        $delete_sql = mysqli_query($conn, "DELETE FROM foto WHERE fotoid='$fotoid'");

        if ($delete_sql) {
            // Check if the file exists before attempting to delete
            if (is_file('../assets/img/' . $lokasifile)) {
                unlink('../assets/img/' . $lokasifile);
            }
            echo "<script>
            alert('Photo successfully deleted');
            </script>";

            // Reset AUTO_INCREMENT for the photoid column
            $reset_auto_increment_sql = mysqli_query($conn, "ALTER TABLE foto AUTO_INCREMENT = 1");

            if (!$reset_auto_increment_sql) {
                echo "<script>
                alert('Failed to reset auto increment: " . mysqli_error($conn) . "');
                </script>";
            }

            // Redirect after deletion and reset
            echo "<script>
            location.href ='../admin/photo.php';
            </script>";
        } else {
            echo "<script>
            alert('Failed to delete photo: " . mysqli_error($conn) . "');
            location.href ='../admin/photo.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('Photo not found.');
        location.href ='../admin/photo.php';
        </script>";
    }
}
