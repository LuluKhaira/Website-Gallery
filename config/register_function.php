<?php
include '../config/connection.php';

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses untuk menambah admin atau user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = clean_input($_POST['username']);
    $password = password_hash(clean_input($_POST['password']), PASSWORD_DEFAULT); // Gunakan password_hash
    $level = isset($_POST['level']) ? $_POST['level'] : 'user'; // Set default level sebagai 'user'
    $email = clean_input($_POST['email']);
    $namalengkap = clean_input($_POST['namalengkap']);
    $alamat = clean_input($_POST['alamat']);

    // Periksa apakah level yang dipilih adalah admin
    if ($level === 'admin') {
        // Cek apakah sudah ada admin
        $result = $conn->query("SELECT COUNT(*) as count FROM user WHERE level = 'admin'");
        $data = $result->fetch_assoc();

        if ($data['count'] > 0) {
            echo "<script>
            alert('Hanya satu admin yang diizinkan. Silakan daftar sebagai user atau hubungi administrator.');
            location.href='../config/register.php';
            </script>";
        } else {
            // Tambahkan pengguna sebagai admin
            $stmt = $conn->prepare("INSERT INTO user (username, password, email, namalengkap, alamat, level) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $email, $namalengkap, $alamat, $level);

            if ($stmt->execute()) {
                echo "<script> alert ('Admin berhasil terdaftar.');
                location.href='../config/login.php';
                </script>";
            } else {
                echo "Gagal mendaftarkan admin: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        // Proses pendaftaran sebagai user


        if ($result->num_rows > 0) {
            echo "<script>
            alert('Username sudah digunakan. Silakan pilih username lain.');
            location.href='../config/register.php';
            </script>";
        } else {
            // Siapkan statement untuk menambah user
            $stmt = $conn->prepare("INSERT INTO user (username, password, email, namalengkap, alamat, level) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $email, $namalengkap, $alamat, $level);

            // Eksekusi statement
            if ($stmt->execute()) {
                echo "<script>
                alert('Akun berhasil didaftarkan');
                location.href='../config/login.php';
                </script>";
            } else {
                echo "<script>
                alert('Gagal mendaftarkan akun: " . $stmt->error . "');
                location.href='../config/register.php';
                </script>";
            }
            $stmt->close();
        }
        $check_username->close();
    }

    // Tutup koneksi
    $conn->close();
}
?>
