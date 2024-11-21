<?php
include '../navbar/nav_admin.php';
include '../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoKenangan Gallery</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .photo-card img {
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }

        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }

        .btn-danger:hover {
            background-color: #be2617;
            border-color: #be2617;
        }

        .btn-warning {
            background-color: #f6c23e;
            border-color: #f6c23e;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #dda20a;
            border-color: #dda20a;
            color: #fff;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            background-color: #4e73df;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .photo-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: none;
        }

        .photo-card:hover .photo-actions {
            display: block;
        }

        .photo-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">PhotoKenangan Gallery</h1>

        <div class="row">
            <!-- Create Photo Form -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add New Photo</h5>
                    </div>
                    <div class="card-body">
                        <form action="../config/photo_function.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="judulfoto" class="form-label">Photo Name</label>
                                <input type="text" class="form-control" id="judulfoto" name="judulfoto" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsifoto" class="form-label">Description</label>
                                <textarea class="form-control" id="deskripsifoto" name="deskripsifoto" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="albumid" class="form-label">Album</label>
                                <select class="form-select" id="albumid" name="albumid" required>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM album");
                                    while ($row = mysqli_fetch_array($sql)) {
                                        echo "<option value='" . $row['albumid'] . "'>" . $row['namaalbum'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lokasifile" class="form-label">File</label>
                                <input type="file" class="form-control" id="lokasifile" name="lokasifile" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="add">
                                <i class="fas fa-plus-circle me-2"></i>Add Photo
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Display Photos -->
            <div class="col-lg-8">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM foto");
                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                        <div class="col">
                            <div class="card h-100 photo-card">
                                <img src="../assets/img/<?php echo $row['lokasifile'] ?>" class="card-img-top" alt="<?php echo $row['judulfoto']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['judulfoto']; ?></h5>
                                    <p class="card-text"><?php echo $row['deskripsifoto']; ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo $row['tanggalunggah']; ?></small></p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="../config/function_print.php?fotoid=<?php echo $row['fotoid']; ?>" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-print me-2"></i>Print
                                    </a>
                                    
                                </div>
                                <div class="photo-actions">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['fotoid']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="../config/photo_function.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="fotoid" value="<?php echo $row['fotoid']; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit<?php echo $row['fotoid']; ?>" tabindex="-1" aria-labelledby="editPhotoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Photo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../config/photo_function.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="fotoid" value="<?php echo $row['fotoid']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Photo Name</label>
                                                <input type="text" name="judulfoto" class="form-control" value="<?php echo htmlspecialchars($row['judulfoto']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="deskripsifoto" required><?php echo htmlspecialchars($row['deskripsifoto']); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Album</label>
                                                <select class="form-select" name="albumid" required>
                                                    <?php
                                                    $albumQuery = mysqli_query($conn, "SELECT * FROM album");
                                                    if ($albumQuery) {
                                                        while ($album = mysqli_fetch_array($albumQuery)) { ?>
                                                            <option value="<?php echo $album['albumid']; ?>" <?php echo $row['albumid'] == $album['albumid'] ? 'selected' : ''; ?>>
                                                                <?php echo $album['namaalbum']; ?>
                                                            </option>
                                                    <?php }
                                                    } else {
                                                        echo "<option value=''>Error fetching albums</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">File</label>
                                                <input type="file" class="form-control" name="lokasifile">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="edit">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>