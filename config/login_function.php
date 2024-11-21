<?php
session_start();
include 'connection.php';

$u = $_POST['username'];
$p = $_POST['password'];

// Query to fetch user based on username
$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$u'");

$result = mysqli_num_rows($sql);

if ($result > 0) {
    $row = mysqli_fetch_assoc($sql);

    // Cek apakah password cocok
    if (password_verify($p, $row['password'])) {  // Gunakan password_verify jika password di-hash
        // Set session variables
        $_SESSION['username'] = $row['username'];
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['namalengkap'] = $row['namalengkap'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['status'] = 'login';

        if ($row['level'] == 'admin') {
            echo "<script>
            alert('You are logged in as Admin');
            location.href = '../admin/index.php';
            </script>";
        } else {
            echo "<script>
            alert('Login Successfully');
            location.href = '../user/index.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('Incorrect password');
        location.href = '../config/login.php';
        </script>";
    }
} else {
    echo "<script>
    alert('User not found');
    location.href = '../config/login.php';
    </script>";
}
?>
