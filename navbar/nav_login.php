<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <!-- Check if user is logged in -->
                    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="../config/logout_function.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disable">Welcome <?php echo $_SESSION['namalengkap']; ?></a>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="register.php">Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

</body>

</html>