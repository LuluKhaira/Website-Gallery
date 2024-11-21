<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lulu Khaira Yudita's Gallery</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .welcome-section {
            background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 30px;
        }

        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include '../galleryUKK/config/link.php';
    include '../galleryUKK/navbar/nav_no.php';
    include '../galleryUKK/config/connection.php';

    $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $searchQuery = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
    ?>

    <div class="welcome-section text-center">
        <div class="container">
            <h1 class="display-4">Welcome to Lulu Khaira Yudita's Gallery</h1>
            <p class="lead">XII RPL 1</p>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <form class="d-flex" action="" method="GET" role="search">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search photos..."
                        aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php
            $query = !empty($searchQuery) ?
                mysqli_query($conn, "SELECT * FROM foto WHERE judulfoto LIKE '%$searchQuery%' OR deskripsifoto LIKE '%$searchQuery%'") :
                mysqli_query($conn, "SELECT * FROM foto");

            if (!$query) {
                die("Query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($query) == 0) {
                echo '<div class="col-12 text-center"><p class="lead">No results found.</p></div>';
            } else {
                while ($data = mysqli_fetch_assoc($query)) {
                    $fotoid = $data['fotoid'];
            ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100">
                            <img src="assets/img/<?php echo htmlspecialchars($data['lokasifile']); ?>" class="card-img-top"
                                alt="<?php echo htmlspecialchars($data['judulfoto']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($data['judulfoto']); ?></h5>
                                <p class="card-text">
                                    <?php echo htmlspecialchars(substr($data['deskripsifoto'], 0, 100)) . '...'; ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <?php if ($userid): ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="../config/process_like.php?fotoid=<?php echo $fotoid; ?>"
                                            class="btn btn-outline-danger btn-sm">
                                            <i class="fa fa-heart"></i> Like
                                        </a>
                                        <a href="photo_detail.php?fotoid=<?php echo $fotoid; ?>"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-comment"></i> Comment
                                        </a>
                                    </div>
                                    <?php
                                    $like = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                    $likeCount = mysqli_num_rows($like);
                                    $comment = mysqli_query($conn, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                    $commentCount = mysqli_num_rows($comment);
                                    ?>
                                    <div class="mt-2 text-muted small">
                                        <span><?php echo $likeCount; ?> Like<?php echo $likeCount != 1 ? 's' : ''; ?></span>
                                        <span class="ms-2"><?php echo $commentCount; ?>
                                            Comment<?php echo $commentCount != 1 ? 's' : ''; ?></span>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted small text-center mb-0">
                                        <a href="../gallerylulu/config/login.php" class="text-decoration-none">Login</a> to like or
                                        comment
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    </footer>
</body>

</html>