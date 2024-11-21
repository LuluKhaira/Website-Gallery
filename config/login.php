<?php
include 'link.php';
include '../navbar/nav_login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Lulu</title>
</head>

<body>
    <!-- LOGIN -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="text-center">
                            <h5>LOGIN</h5>
                        </div>
                        <form action="login_function.php" method="POST">
                            <label class="form-label">USERNAME</label>
                            <input type="text" name="username" class="form-control" required>

                            <label class="form-label">PASSWORD</label>
                            <input type="password" name="password" class="form-control" required>

                            <div class="d-grid mt-2">
                                <button class="btn btn-primary" type="submit" name="submit">LOGIN</button>
                            </div>
                        </form>
                        <hr>
                        <p>Belum Punya Akun? <a href="register.php">Login disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>