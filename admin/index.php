<?php
include '../navbar/nav_admin.php';
include '../config/connection.php';
$userid = $_SESSION['userid'];

// Check if a search query is present
$searchQuery = '';
if (isset($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);
}
if ($_SESSION['status'] != 'login') {
    echo "<script>alert('Anda belum Login');</script>";
    header('Location: ../config/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Photo Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #ff6b6b;
            --background-color: #f8f9fa;
            --card-background: #ffffff;
            --text-color: #333333;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            padding-bottom: 60px;
        }

        .container {
            max-width: 1400px;
            padding: 2rem;
        }

        .search-form {
            margin-bottom: 2rem;
        }

        .search-input {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: 1px solid #ced4da;
            transition: box-shadow 0.3s ease;
        }

        .search-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
            border-color: var(--primary-color);
        }

        .search-btn {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            border: none;
            color: white;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #3a7bc8;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px var(--shadow-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: var(--card-background);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .card-footer {
            background-color: transparent;
            border-top: 1px solid rgba(0, 0, 0, 0.125);
            padding: 1rem 1.5rem;
        }

        .btn-like,
        .btn-comment {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-like {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-like:hover {
            background-color: #ff4d4d;
        }

        .btn-comment {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-comment:hover {
            background-color: #3a7bc8;
        }

        .download-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            padding: 10px;
            color: var(--primary-color);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .download-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .stats {
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- FITUR SEARCH -->
    <div class="container">
        <form class="search-form d-flex" action="" method="GET" role="search">
            <input class="form-control search-input me-2" type="search" name="query" placeholder="Search photos..." aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn search-btn" type="submit">Search</button>
        </form>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
            if (!empty($searchQuery)) {
                $query = mysqli_query($conn, "
                    SELECT * FROM foto 
                    WHERE judulfoto LIKE '%$searchQuery%' 
                    OR deskripsifoto LIKE '%$searchQuery%'
                ");
                echo '<h2>Search Results for "' . htmlspecialchars($searchQuery) . '"</h2>';
            } else {
                $query = mysqli_query($conn, "SELECT * FROM foto");
            }

            if (!$query) {
                die("Query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($query) == 0) {
                echo '<p>No results found.</p>';
            } else {
                while ($data = mysqli_fetch_assoc($query)) {
                    $fotoid = $data['fotoid'];
                    $like = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    $likeCount = mysqli_num_rows($like);
                    $comment = mysqli_query($conn, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                    $commentCount = mysqli_num_rows($comment);
            ?>
                    <!-- MENGAMBIL FOTO DARI DATABASE -->
                    <div class="col">
                        <div class="card h-100">
                            <a href="../assets/img/<?php echo htmlspecialchars($data['filelocation']); ?>" download class="download-btn">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="photo_detail.php?fotoid=<?php echo $data['fotoid']; ?>">
                                <img src="../assets/img/<?php echo htmlspecialchars($data['lokasifile']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['judulfoto']); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($data['judulfoto']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars(substr($data['deskripsifoto'], 0, 100)); ?>...</p>
                            </div>
                            <!-- KOMEN DAN LIKE -->
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="../config/process_like.php?fotoid=<?php echo $data['fotoid']; ?>" class="btn btn-like">
                                        <i class="fa fa-heart"></i> Like
                                    </a>
                                    <a href="photo_detail.php?fotoid=<?php echo $data['fotoid']; ?>" class="btn btn-comment">
                                        <i class="fa fa-comment"></i> Comment
                                    </a>
                                </div>
                                <div class="stats mt-2 text-center">
                                    <span><?php echo $likeCount; ?> Like<?php echo $likeCount != 1 ? 's' : ''; ?></span>
                                    <span class="mx-2">•</span>
                                    <span><?php echo $commentCount; ?> Comment<?php echo $commentCount != 1 ? 's' : ''; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>