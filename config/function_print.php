<?php
include '../config/connection.php';
include '../config/link.php';

if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];

    // Ambil data dari database berdasarkan photoid
    $query = "SELECT * FROM foto WHERE fotoid = '$fotoid'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $foto = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Photo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-4">
        <div class="row">
            <div class="col-12 text-center">
                <h1><?php echo htmlspecialchars($foto['judulfoto']); ?></h1>
                <img src="../assets/img/<?php echo htmlspecialchars($foto['lokasifile']); ?>" alt="foto"
                    class="img-thumbnail" width="300">
                <p><?php echo htmlspecialchars($foto['deskripsifoto']); ?></p>
                <p><strong>Uploaded Date:</strong> <?php echo htmlspecialchars($foto['tanggalunggah']); ?></p>
                <button class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>
</body>

</html>