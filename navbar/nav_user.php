<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soft Pink Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            /* Light grey background for a modern look */
        }

        .navbar {
            background-color: #ffdee2;
            /* Soft pink for navbar */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for a floating effect */
        }

        .navbar-brand,
        .nav-link {
            color: #343a40 !important;
            /* Dark grey text for contrast */
        }

        .nav-link.active {
            background-color: #ffccd2;
            /* Slightly darker pink for active state */
            border-radius: 5px;
        }

        .navbar-toggler {
            border: none;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="../user/index.php">Home</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="../user/album.php">Album</a>
            <a class="navbar-brand" href="../user/photo.php">Photo</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Check if user is logged in -->
                    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="#" onclick="confirmLogout()">Logout</a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">Welcome, <?php echo $_SESSION['namalengkap']; ?></span>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="../galleryUKK/config/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../galleryUKK/config/register.php">Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to log out?')) {
                // Jika user memilih "Yes", redirect ke halaman logout PHP
                window.location.href = '../config/logout_function.php';
            } else {
                // Jika user memilih "No", tidak melakukan apa-apa
                return false;
            }
        }
    </script>
</body>

</html>