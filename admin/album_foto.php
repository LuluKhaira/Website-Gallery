<?php
include '../navbar/nav_admin.php';
include '../config/connection.php';

// Get album ID from URL
if (isset($_GET['albumid'])) {
    $albumid = $_GET['albumid'];

    // Retrieve album details
    $albumQuery = mysqli_query($conn, "SELECT * FROM album WHERE albumid = '$albumid'");
    $album = mysqli_fetch_assoc($albumQuery);

    // Retrieve all photos in the selected album
    $photosQuery = mysqli_query($conn, "SELECT * FROM foto WHERE albumid = '$albumid'");
} else {
    die("Album not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($album['namaalbum']); ?> | Photos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- DISPLAY NAMA DAN DESKRIPSI ALBUM -->

<body class="bg-gray-100 min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8"><?php echo htmlspecialchars($album['namaalbum']); ?></h1>
        <p class="text-center text-gray-600 mb-4"><?php echo htmlspecialchars($album['deskripsi']); ?></p>

        <!-- MENGAMBIL FOTO DARI DATABASE -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (mysqli_num_rows($photosQuery) > 0) {
                while ($photo = mysqli_fetch_assoc($photosQuery)) {
                    $photoTitle = htmlspecialchars($photo['judulfoto']);
                    $photoFile = htmlspecialchars($photo['lokasifile']);
                    $photoId = $photo['fotoid'];
            ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <a href="photo_detail.php?fotoid=<?php echo $photoId; ?>">
                            <img src="../assets/img/<?php echo $photoFile; ?>"
                                alt="<?php echo $photoTitle; ?>"
                                class="w-full h-64 object-cover cursor-pointer">
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold"><?php echo $photoTitle; ?></h3>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center col-span-3'>No photos available in this album.</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>