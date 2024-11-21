<?php
include '../navbar/nav_user.php';
include '../config/connection.php';

// Get the photo ID from the URL
$fotoid = mysqli_real_escape_string($conn, $_GET['fotoid']);

// Query to get photo details including album name based on the photoid
$query = mysqli_query($conn, "
    SELECT f.*, a.namaalbum, u.username
    FROM foto f
    JOIN album a ON f.albumid = a.albumid
    JOIN user u ON f.userid = u.userid
    WHERE f.fotoid='$fotoid'
");

if (!$query) {
    die("Query failed: " . mysqli_error($conn));
}

$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoVista Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #f8f9fa;
            --card-background: #ffffff;
            --text-color: #343a40;
            --border-color: #dee2e6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-body {
            padding: 1.5rem;
        }

        .img-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            height: 500px;
        }

        .img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .img-container:hover .img-fluid {
            transform: scale(1.05);
        }

        .photo-info {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .img-container:hover .photo-info {
            transform: translateY(0);
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .comment-section {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 1rem;
        }

        .comment {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 0.5rem;
            }

            .img-container {
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- MENUNJUKAN FOTO -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-image me-2"></i><?php echo htmlspecialchars($data['judulfoto']); ?>
                    </div>
                    <div class="card-body">
                        <div class="img-container">
                            <img src="../assets/img/<?php echo htmlspecialchars($data['lokasifile']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($data['judulfoto']); ?>">
                            <div class="photo-info">
                                <p><i class="fas fa-user me-2"></i><strong>Uploaded by:</strong> <?php echo htmlspecialchars($data['username']); ?></p>
                                <p><i class="fas fa-folder me-2"></i><strong>Album:</strong> <?php echo htmlspecialchars($data['namaalbum']); ?></p>
                                <p><i class="fas fa-calendar-alt me-2"></i><strong>Uploaded on:</strong> <?php echo date('F j, Y', strtotime($data['tanggalunggah'])); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- FOTO DETAIL -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Details
                    </div>
                    <div class="card-body">
                        <p class="lead"><?php echo htmlspecialchars($data['deskripsifoto']); ?></p>

                        <!-- TOMBOL LIKE -->
                        <div class="d-flex align-items-center mb-3">
                            <a href="../config/process_like_user.php?fotoid=<?php echo $data['fotoid'] ?>" class="btn btn-outline-primary me-2">
                                <i class="fas fa-heart"></i> Like
                            </a>
                            <?php
                            $like = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                            $likeCount = mysqli_num_rows($like);
                            echo '<span class="fs-5">' . $likeCount . ' <i class="fas fa-heart text-danger"></i></span>';
                            ?>
                        </div>

                        <!-- Comments Section -->
                        <h4><i class="fas fa-comments me-2"></i>Comments</h4>
                        <?php
                        $commentQuery = mysqli_query($conn, "
                            SELECT c.isikomentar, c.tanggalkomentar, u.username 
                            FROM komentarfoto c
                            JOIN user u ON c.userid = u.userid
                            WHERE c.fotoid='$fotoid'
                            ORDER BY c.tanggalkomentar DESC
                        ");

                        if (!$commentQuery) {
                            die("Query failed: " . mysqli_error($conn));
                        }

                        $commentCount = mysqli_num_rows($commentQuery);
                        ?>
                        <p class="text-muted"><?php echo $commentCount; ?> Comment<?php echo $commentCount != 1 ? 's' : ''; ?></p>

                        <div class="comment-section">
                            <?php if ($commentCount > 0) { ?>
                                <?php while ($commentData = mysqli_fetch_assoc($commentQuery)) { ?>
                                    <div class="comment">
                                        <h5><i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($commentData['username']); ?></h5>
                                        <p><?php echo htmlspecialchars($commentData['isikomentar']); ?></p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i><?php echo date('F j, Y', strtotime($commentData['tanggalkomentar'])); ?>
                                        </small>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <p class="text-center text-muted">No comments yet. Be the first to comment!</p>
                            <?php } ?>
                        </div>

                        <!-- KOMENTAR -->
                        <form action="../config/comment_function_user.php" method="POST" class="mt-3">
                            <div class="mb-3">
                                <textarea class="form-control" name="isikomentar" rows="3" placeholder="Write a comment..." required></textarea>
                            </div>
                            <input type="hidden" name="fotoid" value="<?php echo $fotoid; ?>">
                            <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane me-2"></i>Submit Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 PhotoVista Gallery | Created by LULU | RPL</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>